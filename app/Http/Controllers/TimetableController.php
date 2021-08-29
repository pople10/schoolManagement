<?php

namespace App\Http\Controllers;

use App\Models\Timetable;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('TimesTable.index');
    }

   public function GetAllP(){
        $pr=DB::table('timetables')->get();
        $a=[];
        foreach ($pr as $value) {
           $a[$value->level]=$value->pdf_path;
        }
        return response()->json($a,200);
    }
    
    public function store(Request $request){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
       }
       if(!in_array("MTT",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(!is_null($request['levels'])&&!is_null($request['data']) ){
            DB::table('timetables')->insert([
                'level'=>$request['levels'],
                'pdf_path'=> $request['data'],
                
            ]);
            return response()->json(true,200);
        }
        return response()->json(false,200);
    }
    public function update(Request $request){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
       }
       if(!in_array("MTT",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(!is_null($request['data']) ){
            DB::table('timetables')->where('level',"=",$request['levels'])->update([
                'pdf_path'=> $request['data'],
            ]);
            return response()->json(true,200);
        }
        return response()->json(false,200);
    }
}
