<?php
/*By Hamdaoui Tayeb */
namespace App\Http\Controllers;

use App\Models\Internship;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Controllers\HistoryController;

class InternshipController extends Controller
{
    
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('internship.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('internship.create');
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
        if(!in_array("MI",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        //check if user already has an internship
        //check if cne is in the users table
        $requestData = $request->all();
        if(!empty($request->assigned_to)){
            $user = User::select('id')->where('cne', $request->assigned_to)->get();
            if($user == null || count($user) == 0){
                return response()->json([
                    "error" => "l'etudiant n'éxiste pas dans la base de donné"
                ],422);
            }else if(count(Internship::select('id')->where('assigned_to', $user->first()->id)->get()) != 0){
                return response()->json([
                    "error" => "l'etudiant est déja stagé"
                ],422);
            }else{
                //if the cne is in the user table, switch the value of assigned_to to the Id
                //of the user 
                $int =  intval($user->first()->id);
                $requestData['assigned_to'] = (int)$int;
            }

            //check if the level matches the student level
            $level = Student::select('level')->where('cne', $request->assigned_to)->get();
            if($level ==  null || count($level) == 0){
                return response()->json([
                    "error" => "cette filiére n'exite pas"
                ],422);
            }else if($level->first()->level != $request->level){
                return response()->json([
                    "error" => "l'étudiant de cne: \"".$request->assigned_to."\" n'appartient pas à cette filiére"
                ],422);
            }
        }

        
        $dataValidator = Validator::make($requestData,
         [
            'added_by' => 'required|numeric',
            'date_start' => 'required|date',
            'end_offer' =>'required|date',
            'level'=>'required|string|max:255',
            'object'=>'required|string|max:255',
            'type'=>'required|string|max:255',
            'assigned_to'=>'nullable|alpha_num|max:20',
         ]);


         if($dataValidator->fails()){
            return response()->json([
                'error' => "Les champs ne sont pas correctes\n" . $dataValidator->errors()->first()
            ], 422);
         }


         if(!($internship = Internship::create($requestData))){
            return response()->json([
                "error" => "Problème se produit dans l'insertion"
            ], 422);
         }
        $history = new HistoryController();
        $history->action("Ajout d'un offre du stage",$internship,NULL);
         return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Internship  $internship
     * @return \Illuminate\Http\Response
     */
    public function show(Internship $internship)
    {
        return view('internship.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Internship  $internship
     * @return \Illuminate\Http\Response
     */
    public function edit(Internship $internship)
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
        $user = User::select('cne')->where('id', $internship->assigned_to)->get();
        $cne = "";
        if(count($user) != 0 && $user != null){
            $cne = $user->first()->cne;
        }
        $entreprise = $internship->entreprise;
        $object = $internship->object;
        $start = $internship->date_start;
        $end = $internship->end_offer;
        $type = $internship->type;
        $added_by = $internship->added_by;
        $promo = $internship->level;
        return view('internship.edit', compact('cne', 'entreprise', 'start', 'end', 'object','promo','added_by','type'));
    }
    public function editView(){
        return view('internship.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Internship  $internship
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Internship $internship){
        $old=$internship;
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
        $requestData = $request->all();
        if(!empty($request->assigned_to)){
            $user = User::select('id')->where('cne', $request->assigned_to)->get();
            $requestData = $request->all();
            if($user == null || count($user) == 0){
                return response()->json([
                    "error" => "l'etudiant n'éxiste pas dans la base de donné"
                ],422);
            }else if(count(Internship::select('id')->where('assigned_to', $user->first()->id)->get()) > 1){
                return response()->json([
                    "error" => "l'etudiant est déja stagé"
                ],422);
            }else{
                //if the cne is in the user table, switch the value of assigned_to to the Id
                //of the user 
                $int =  intval($user->first()->id);
                $requestData['assigned_to'] = (int)$int;
            }
    
            //check if the level matches the student level
            $level = Student::select('level')->where('cne', $request->assigned_to)->get();
            if($level ==  null || count($level) == 0){
                return response()->json([
                    "error" => "cette filiére n'exite pas"
                ],422);
            }else if($level->first()->level != $request->level){
                return response()->json([
                    "error" => "l'étudiant de cne: \"".$request->assigned_to."\" n'appartient pas à cette filiére"
                ],422);
            }
        }

        $dataValidator = Validator::make($requestData,
            [
            'added_by' => 'required|numeric',
            'date_start' => 'required|date',
            'end_offer' =>'required|date',
            'level'=>'required|string|max:255',
            'object'=>'required|string|max:255',
            'type'=>'required|string|max:255',
            'assigned_to'=>'nullable|alpha_num|max:20',
            ]);


            if($dataValidator->fails()){
            return response()->json([
                'error' => "Les champs ne sont pas correctes\n" . $dataValidator->errors()->first()
            ], 422);
            }


            if(!$internship->update($requestData)){
                return response()->json([
                    "error" => "Problème se produit dans l'insertion"
                ], 422);
            }
            $history = new HistoryController();
            $history->action("Modification d'un offre du stage",$internship,$old);
         return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Internship  $internship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Internship $internship){
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
        $history->action("Suppression d'un offre du stage",NULL,$internship);
        $internship->delete();
        return response()->json();
    }

    public function dataTableJson(){
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
        $available = Internship::select('internships.id', 'assigned_to','c.label as level', 'b.lname as added_by','object','type', 'entreprise', 'date_start', 'end_offer', 'internships.created_at', 'internships.updated_at')
        ->join('users as b', function($join){
            $join->on('internships.added_by', '=', 'b.id');
        })
        ->join('levels as c', function($join){
            $join->on('internships.level', '=', 'c.id');
        })->where('assigned_to')->get();

        $unavailable = Internship::select('internships.id', 'a.cne as assigned_to','c.label as level', 'b.lname as added_by','object','type', 'entreprise', 'date_start', 'end_offer', 'internships.created_at', 'internships.updated_at')
        ->join('users as a',function($join){
            $join->on('internships.assigned_to', '=', 'a.id');
        })        
        ->join('users as b', function($join){
            $join->on('internships.added_by', '=', 'b.id');
        })
        ->join('levels as c', function($join){
            $join->on('internships.level', '=', 'c.id');
        })->get();
        
        $result = array_merge($available->toArray(), $unavailable->toArray());
        return json_encode($result);

    }

    public function getContentById(Internship $id)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        return json_encode($id);
    }
    
    public function demandeData(){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        $interns = Internship::select('internships.id','c.label as level', 'b.lname as added_by','object','type', 'entreprise', 'date_start', 'end_offer', 'internships.created_at', 'internships.updated_at')
        ->join('users as b', function($join){
            $join->on('internships.added_by', '=', 'b.id');
        })
        ->join('levels as c', function($join){
            $join->on('internships.level', '=', 'c.id');
        })->where('assigned_to')->get();
        return view("internship.demande", compact('interns'));     
    }

    public function Intershipshowdata(){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        $interns = Internship::select('internships.id','c.label as level', 'b.lname as added_by','object','type', 'entreprise', 'date_start', 'end_offer', 'internships.created_at', 'internships.updated_at')
        ->join('users as b', function($join){
            $join->on('internships.added_by', '=', 'b.id');
        })
        ->join('levels as c', function($join){
            $join->on('internships.level', '=', 'c.id');
        })->where('assigned_to')->get();
        return json_encode($interns);     
    }

}
