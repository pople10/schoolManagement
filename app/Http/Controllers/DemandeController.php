<?php

namespace App\Http\Controllers;

use App\Models\Demande;
use Illuminate\Http\Request;
use App\Models\Internship;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HistoryController;
use Illuminate\Support\Facades\Auth;

class DemandeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('demande.demande-table');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        if(!in_array("CI",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        //check if user already made a demand to the same stage
        $demand = Demande::select('id')
        ->where('user_id', '=', Auth::User()->id)
        ->where('internship_id', '=', $request->internship_id)
        ->get();
        $request->merge(['user_id' => Auth::User()->id]);
        if(count($demand) > 0){
            return response()->json(["error" => "vous avez déjà soumis la demande pour cette offre de stage"], 422);
        }

        //if the internship level is not the same as the student
        $studentlevel = Student::select('level')->where('cne', '=',Auth::User()->cne)->get();
        $internshiplevel = internship::select('level')->where('id','=' ,$request->internship_id)->get();
        
        if($internshiplevel ==  null || count($internshiplevel) == 0 || $studentlevel == null || count($studentlevel) == 0){
            return response()->json([
                "error" => "Désolé, mais ce service pour ce stage n'est pas disponible pour vous!"
            ],422);
        }else if($internshiplevel->first()->level != $studentlevel->first()->level){
            return response()->json([
                "error" => "vous n'êtes pas autorisé à soumettre une demande pour cette offre, veuillez rechercher les stages qui sont attribués à votre filiére!"
            ],422);
        }


        $dataValidator = Validator::make($request->except('level', 'cne'),
        [
            'internship_id' => 'required|numeric',
            'user_id'=>'required|alpha_num|max:20',
            'type' => 'required|string'
        ]);

        if($dataValidator->fails()){
            return response()->json([
                'error' => "Les champs ne sont pas correctes\n" . $dataValidator->errors()->first()
            ], 422);
        }


        if(!($ddd = Demande::create($request->except('cne', 'level')))){
            return response()->json([
                "error" => "Problème se produit dans l'insertion"
            ], 422);
        }
        $history = new HistoryController();
        $history->action("Ajout d'une demande de stage",$ddd,NULL);
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function show(Demande $demande)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function edit(Demande $demande)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demande $demande)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Demande  $demande
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demande $demande)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MI",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $history = new HistoryController();
        $history->action("Suppression d'une demande de stage",NULL,$demande);
        $demande->delete();
        return response()->json();
    }
    
    public function accept(Request $request){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MI",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        //get the id of the user
        $user = Demande::select('user_id')->where('id', '=', $request->id)->get();
        //get the internship id
        $internship = Demande::select('internship_id')->where('id', '=', $request->id)->get();
        
        //accepting a demand implicates the deletion of all other demandes that the student has submitted, 
        //so we have to pass two values the controller, the demand_id and the user_cne, 
         $intern = Internship::where('id', '=', $internship->first()->internship_id)->update(['assigned_to'=>$user->first()->user_id]);
        //update the internship table
        if($request->type == "demande de stage"){
           
        }
        
        $demande = Demande::where('user_id', '=', $user->first()->user_id)->where('type', '=', $request->type)->delete();
        return [$user->first()->get, $request->type, $internship];
        
        
    }    

    
    
    public function dataTableJson(){
        $demande = Demande::select('demandes.id', 'b.object as internship_id', 'demandes.type', 'a.cne as user_id', 'demandes.created_at', 'additional_input')
        ->join('internships as b', function($join){
            $join->on('demandes.internship_id', '=','b.id');
        })
        ->join('users as a', function($join){
            $join->on('demandes.user_id', '=', 'a.id');
        })->get();

        return json_encode($demande);

    }
}
