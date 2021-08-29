<?php

namespace App\Http\Controllers;

use App\Models\ProfModule;
use App\Models\Student;
use App\Models\User;
use App\Models\Module;
use App\Models\ModuleLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!in_array("AP",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        return view("module.profmodulemanagement");
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
        if(!in_array("AP",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(ProfModule::where("module","=",$request->module)->first()==NULL)
        {
            if(!ProfModule::create($request->all()))
                return response()->json([
                    'error' => "Le changement n'a pas été fait par succès"
                ], 422);
            return response()->json();
        }
        else
        {
            if(!ProfModule::where("module","=",$request->module)->update(["prof"=>$request->prof]))
                return response()->json([
                    'error' => "Le changement n'a pas été fait par succès"
                ], 422);
            return response()->json();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfModule  $profModule
     * @return \Illuminate\Http\Response
     */
    public function show(ProfModule $profModule)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfModule  $profModule
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfModule $profModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfModule  $profModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProfModule $profModule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfModule  $profModule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfModule $profModule)
    {
        //
    }
    
    public function findAll()
    {
        return json_encode(ProfModule::all());
    }
    
    public function findByIdModule($id)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        return ((ProfModule::where("module","=",$id)->first()!=NULL)?ProfModule::where("module","=",$id)->first()->prof:"");
    }
    
    public function findAllByLevel()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->cne==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un étudiant."
            ], 422);
       }
        $level = Student::where("cne","=",Auth::User()->cne)->first()->level;
        $modules = ModuleLevel::all()->where("level","=",$level);
        $modules_array=array();
        foreach($modules as $val)
        {
            $modules_array[]=$val->id;
        }
        $profs = ProfModule::all()->whereIn("module",$modules_array);
        foreach($profs as $prof)
        {
            $fname = User::where("phd","=",$prof->prof)->first()->fname;
            $lname = User::where("phd","=",$prof->prof)->first()->lname;
            $prof->name=$fname." ".$lname;
            $prof->module_name = Module::find(ModuleLevel::find($prof->module)->code)->label;
        }
        return json_encode($profs);
    }
    
    public function findByProf()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        $all = ProfModule::all()->where("prof",Auth::User()->phd);
        $data = array();
        foreach($all as $val)
        {
            $data[]=ModuleLevel::find($val->module);
        }
        return json_encode($data);
    }
}
