<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ModuleLevelController;
use App\Models\Module;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HistoryController;

class ModuleController extends Controller
{
    
    protected $module_level;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('module.management');
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
        if(!in_array("MM",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data_validator = Validator::make($request->all(),
        [
            'code' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'levels' =>'required'
        ]);
        if ($data_validator->fails()) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
        if(!Module::create(array("code"=>$request->code,"label"=>$request->label)))
        {
            return response()->json([
                'error' => "L'ajout n'est été pas executé avec succés"
            ], 422);
        }
        $this->module_level = new ModuleLevelController();
        $this->module_level->storeByArray($request);
        $history = new HistoryController();
        $history->action("Ajout d'un module du code ".$request->code,NULL,NULL);
        return json_encode("done");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        $data= (array)DB::table("modules AS m")->select("m.code","m.label","ml.code","ml.level")
        ->join("module_levels AS ml","ml.code","=","m.code")->get();
        $result = array();
        foreach ($data as $element) {
            foreach($element as $val)
            {
                if(!isset($result[$val->code]) and empty($result[$val->code]))
                    {
                        $result[$val->code]["code"] = $val->code;
                        $result[$val->code]["label"] = $val->label;
                        $result[$val->code]["level"] = array(Level::find($val->level)->label);
                    }
                    else
                        $result[$val->code]["level"][] = Level::find($val->level)->label;
            }
        }
        return json_encode(array_values($result));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MM",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(!$module->delete())
            return response()->json("undone");
        $this->store($request);
        $history = new HistoryController();
        $history->action("Modification d'un module",$module,NULL);
        return response()->json("done");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MM",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $history = new HistoryController();
        $history->action("Suppression d'un module ",NULL,$module);
        if(!$module->delete())
            return response()->json("undone");
        return response()->json("done");
    }
    
    public function findById($id)
    {
        $data= (array)DB::table("modules AS m")->select("m.code","m.label","ml.code","ml.level")
        ->join("module_levels AS ml","ml.code","=","m.code")->where("m.code","=",$id)->get();
        $result = array();
        foreach ($data as $element) {
            foreach($element as $val)
            {
                if(!isset($result[$val->code]) and empty($result[$val->code]))
                    {
                        $result[$val->code]["code"] = $val->code;
                        $result[$val->code]["label"] = $val->label;
                        $result[$val->code]["level"] = array($val->level);
                    }
                    else
                        $result[$val->code]["level"][] = $val->level;
            }
        }
        return json_encode(array_values($result)[0]);
    }
    public function GetAllModules()
    {
        return json_encode(DB::table("modules")->select('code','label')->get());
    }
}
