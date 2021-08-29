<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\User;
use App\Models\ProfModule;
use App\Models\ModuleLevel;
use App\Models\Student;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\HistoryController;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware("auth");
    }
    
    public function index()
    {
        //select phd of the prof
        $phd = User::select('phd')
        ->where('id',auth()->id())
        ->get();
        
        if(count($phd) == 0){
            return abort(404);
        }
        //select module_prof 
        $profModule = ProfModule::select('module')
        ->where('prof', $phd->first()->phd)
        ->get();
        
        if(count($profModule) == 0){
            return abort(404);
        }
        //select module label
        $module = [];
        $i= 0;
        foreach ($profModule as $key => $value) {
            if($i == 0){
                $module[0] = ModuleLevel::select('id', 'code', 'level')
            ->where('id', $value->module)->get();    
            }else{
              array_push($module, ModuleLevel::select('id', 'code', 'level')
            ->where('id', $value->module)->get());
            }
            $i++;

        }
/*foreach($module as $key => $value){
            echo "-key: ". $key."value: ".$value[0]->id.'<br>' ; 
        }*/
        return view("mark.index", compact('module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($module_level)
    {
        $data = explode('-', $module_level);
        $module = $data[0];
        $level = $data[1];
        
        //select all student who have the same level
        
       /* $student = Student::select('students.cne', 'a.fname as cne', 'b.lname as cne')
        ->join('users as a', function($join){
            $join->on('students.cne', '=', 'a.cne');})
        ->join('users as b', function($join){
            $join->on('students.cne', '=', 'b.cne');
        })->get();*/
        
        $student = Student::join('users', 'students.cne', '=', 'users.cne')
        ->select('users.fname', 'users.lname', 'students.cne')->
        where('level', $data[1])->get();
        
        return view('mark.create', compact('student', 'module'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!in_array("MMN",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $valid = Validator::make($request->all(), 
                [
                    'student'=>'alpha_num|required',
                    'mark'=>'numeric|required',
                    'module_level'=>'numeric|required'
                ]);
        
        if($valid->fails()){
            return response()->json([
                'error' => "Les champs ne sont pas correctes\n" . $valid->errors()->first()
            ], 422);            
        }
        
        //if student with same module_level exits, update, else create,
        $ifExist = Mark::select('id')->where('student', $request->student)->where('module_level', $request->module_level)->get();
        if(count($ifExist) == 0){
            if(!($mark = Mark::create($request->all()))){
                return response()->json([
                    "error" => "Problème se produit dans l'insertion"
                ], 422);            
            }
        }else{
            if(!($mark = Mark::where('student', $request->student)->where('module_level', $request->module_level)->update($request->all()))){
                return response()->json([
                    "error" => "Problème se produit dans la mise à jour"
                ], 422);            
            }
        }
        $history = new HistoryController();
        $history->action("Insertion des notes pour module_level numero : ".$request->module_level,NULL,NULL);
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function show($module_level)
    {

        
        //show specific table
        $students = Mark::join('users', 'marks.student', '=', 'users.cne')
        ->join('module_levels', 'marks.module_level', '=', 'module_levels.id')
        ->select('student', 'users.fname', 'users.lname', 'module_levels.CODE', 'marks.mark', 'module_levels.level')
        ->where("module_level", "=", $module_level)->get();
        
        if(count($students) == 0){
            return response()->json([
                "error" => "les notes pour cette matière n'ont pas encore été publiées"
                ], 422);
        }
        return view("mark.table", compact('students'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function edit(Mark $mark)
    {
        //
    }
    
    //affiche des modules de chaque etudiant
    public function affichage($user){
        $cne = User::select('cne')->where('id', $user)->get();
        if(count($cne) == 0){
             return abort(404);
        }
        $level = Student::select('level')->where('cne', $cne->first()->cne)->get();
        
        $module_levels = ModuleLevel::select('*')->where('level', $level->first()->level)->get();
        
        return view('mark.affichage', compact('module_levels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mark $mark)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mark $mark)
    {
        //
    }
      public function GetModuleForP()
    {
        //select phd of the prof
        $phd = User::select('phd')
        ->where('id',auth()->id())
        ->get();
        
        if(count($phd) == 0){
            return abort(404);
        }
        //select module_prof 
        $profModule = ProfModule::select('module')
        ->where('prof', $phd->first()->phd)
        ->get();
        
        if(count($profModule) == 0){
            return abort(404);
        }
        //select module label
        $module = [];
        $i= 0;
        foreach ($profModule as $key => $value) {
            if($i == 0){
                $module[0] = ModuleLevel::select('id', 'code', 'level')
            ->where('id', $value->module)->get();    
            }else{
              array_push($module, ModuleLevel::select('id', 'code', 'level')
            ->where('id', $value->module)->get());
            }
            $i++;

        }
/*foreach($module as $key => $value){
            echo "-key: ". $key."value: ".$value[0]->id.'<br>' ; 
        }*/
        return json_encode($module);
    }
    public function GetStudentForM($module_level)
    {
        $data = explode('-', $module_level);
        $module = $data[0];
        $level = $data[1];
        
      
        $student = Student::join('users', 'students.cne', '=', 'users.cne')
        ->select('users.fname', 'users.lname', 'students.cne')->
        where('level', $data[1])->get();
        
        return json_encode($student);
    }
      public function affichageUser(){
        $cne = User::select('cne')->where('id', Auth::user()->id)->get();
        if(count($cne) == 0){
             return json_encode(false);
        }
        $level = Student::select('level')->where('cne', $cne->first()->cne)->get();
        
        $module_levels = ModuleLevel::select('*')->where('level', $level->first()->level)->get();
        
        return json_encode($module_levels);
    }
    public function showModulenote($module_level)
    {

        
        $students = Mark::join('users', 'marks.student', '=', 'users.cne')
        ->join('module_levels', 'marks.module_level', '=', 'module_levels.id')
        ->select('student', 'users.fname', 'users.lname', 'module_levels.CODE', 'marks.mark')
        ->where("module_level", "=", $module_level)->get();
        
        if(count($students) == 0){
            return response()->json([
                "error" => "les notes pour cette matière n'ont pas encore été publiées"
                ], 422);
        }
        return json_encode($students);
    }

    
    public function getNoteTotal($cne){
        $notes = Mark::select('mark')->where('student', $cne)->get();
        
        if(count($notes) == 0){
            return response()->json(["error"=>"l'etudiant n'a aucune note dans la base de donnée"], 422);
        }
        
        $total = 0;
        foreach($notes as $note){
            $total += $note->mark;
        }
        
        return $total/count($notes);
    }
    
    
    
}











