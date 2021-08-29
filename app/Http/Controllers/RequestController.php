<?php

namespace App\Http\Controllers;

use App\Models\Requesd;
use App\Models\RequestType;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\HistoryController;

class RequestController extends Controller
{
    
    public $role = 3;
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->check()){
            if(auth()->user()->role_id == $this->role){
                return view('requests.index');        
            }
        }else {
            return redirect('/');
        }
        
    }
    
    public function getData(){      
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MRQ",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data = Requesd::join('request_types', 'requesds.type', '=', 'request_types.id')
        ->select('requesds.id', 'request_types.label', 'is_done','request_types.min_duration', 'student' ,'updated_at')->get();
        return json_encode($data);
        
    }
    
    
    public function dataStudent(){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CRQ",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(auth()->check()){
            $data = Requesd::join('request_types', 'requesds.type', '=', 'request_types.id')
            ->select('requesds.id', 'request_types.label', 'is_done','request_types.min_duration' ,'updated_at')
            ->where('student', auth()->user()->cne)
            ->get();
            
            return json_encode($data);
        }
    }
    
    
    public function demande(){
        if(auth()->check()){
            $demande = RequestType::all();
            return view('requests.table', compact('demande'));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CRQ",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }


                $dm = Requesd::select('id')->where('student', $request->student)->where('type', $request->type)->where('is_done', 0)->get();
                if(count($dm) > 0){
                    return response()->json(["error" => "Vous avez déja soumis cette demande!"], 422);
                }
                
                if(!($demande = Requesd::create($request->all()))){
                    return  response()->json(["error" => "echec d'insertion!"], 422);
                }
        $history = new HistoryController();
        $history->action("Ajout d'une demande",$demande,NULL);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Requesd $requesd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Requesd $requesd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $requesd)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MRQ",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(auth()->check()){
                Requesd::where('id', $requesd)->update(['is_done' => '1']);
                return response()->json();                
        }else{
            return response()->json(["error" => "utilisateur n'est pas connecter!"], 422);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($requesd)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MRQ",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(!Requesd::where('id', $requesd)->delete())
            return response()->json([
                'error' => "Erreur se produit dans la suppression"
            ], 422);
        return response()->json();
    }
    public function getDemandes(){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CRQ",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(auth()->check()){
            $demande = RequestType::all();
            return json_encode($demande);
        }
    }
    public function getCNE(){
        if(auth()->check()){
            $demande = RequestType::all();
            return json_encode(Auth::user()->cne);
        }
    }

}