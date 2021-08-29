<?php

namespace App\Http\Controllers;

use App\Models\ModuleLevel;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ModuleLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    public function etude(){
        $levels =  Level::select('id', 'label as level', 'cycle', 'faculty')->get();
        $modules = array();
        $i = 0;
        foreach($levels as $level){
            $module = ModuleLevel::join('modules', 'module_levels.code', '=','modules.code')
                ->join('levels', 'levels.id', '=', 'module_levels.level')
                ->select('modules.label as module', 'levels.label as label', 'cycle', 'module_levels.level')->where('level', $level->id)->get();
            if($i = 0){
                if(count($module) == 0){
                    $modules[0] = $level; 
                }else{
                    $modules[0] = $module;   
                }
               
            }else{
                if(count($module) == 0){
                    array_push($modules, $level);     
                }else{
                    array_push($modules, ModuleLevel::join('modules', 'module_levels.code', '=','modules.code')
                    ->join('levels', 'levels.id', '=', 'module_levels.level')
                    ->select('modules.label as module', 'levels.label as label', 'cycle', 'module_levels.level', 'faculty')->where('level', $level->id)->get());   
                }
            }
            $i++;
            ///array_push($module, $arr);
            //return $module;
            
        }
        
        $modules = json_encode($modules);
        
        return view('etude', compact('modules'));
    } 
     
     
    public function index()
    {
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ModuleLevel  $moduleLevel
     * @return \Illuminate\Http\Response
     */
    public function show(ModuleLevel $moduleLevel)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ModuleLevel  $moduleLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(ModuleLevel $moduleLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ModuleLevel  $moduleLevel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModuleLevel $moduleLevel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ModuleLevel  $moduleLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModuleLevel $moduleLevel)
    {
        //
    }
    
    public function storeByArray(Request $request)
    {
        if(!isset($request->code))
            return json_encode("Entrer un code");
        if(!isset($request->levels) or empty($request->levels))
            return json_encode("Entrer au moins un niveau scholaire");
        foreach($request->levels as $val)
        {
            
            ModuleLevel::create(array("code"=>$request->code,"level"=>$val));
        }
    }
    
    public function findAll()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        $data = DB::table("modules AS m")->select("m.code","m.label","ml.code","l.label AS level","ml.id")
        ->join("module_levels AS ml","ml.code","=","m.code")->join("levels as l","l.id","=","ml.level")->get();
        return $data;
    }
       public function findbyLevel($l)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        $data = DB::table("module_levels")->where('level','=',$l)
        ->join("modules","modules.code","=","module_levels.code")->join("levels as l","l.id","=","module_levels.level")
        ->select("modules.label","modules.code","module_levels.id")
        ->get();
        return $data;
    }
    
    public function findbyModules($m)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        $data = DB::table("module_levels")->join("levels","levels.id","=","module_levels.level")
        ->select("module_levels.id","levels.label")->where('code','=',$m)
        ->get();
        return $data;
    }
}
