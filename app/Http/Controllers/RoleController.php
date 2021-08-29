<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Auth;
use DB;
use File;

class RoleController extends Controller
{
    
    public function index(){

        return view('Roles.index');
    }

    public function store(Request $request){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!is_null($request['role']))
        {
            $r=DB::table('roles')->insertGetId(['label'=>$request['role']]);
            if(!is_null($request['previl'])){
                foreach ($request['previl'] as $key => $value) {
                    DB::table('role_privileges')->insert([
                        'role_id'=>$r,
                        'privilege_id'=>$value,
                    ]);
                }
            }
             return response()->json(true,200);
        }
        return response()->json(false,200);
    }
    
    public function GetAllP(){
        $pr=DB::table('privileges')->get();
        return response()->json($pr,200);
    }
     public function GetAllR_P(){
        $pr=DB::table('roles')->get();
        $data= array();
        foreach ($pr as  $value) {
            $y=[];
            $pid=DB::table('role_privileges')->where('role_id','=',$value->id)->get('privilege_id');
            foreach ($pid as $va) {
                array_push($y,$va->privilege_id);
            }
            array_push($data,['id'=>$value->id,'label'=>$value->label ,'prv'=>$y]
        );
        }
        return json_encode($data);
    }
    public function delete(Role $role){
        
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        DB::table('role_privileges')->where('role_id','=',$role->id)->delete();
        if(!$role->delete())
            return response()->json("undone");
        return response()->json("done");
    }
    public function update(Request $request,$r){
         if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!is_null($request['role']))
        {

             DB::table('roles')->where('id','=',$r)->update(['label'=>$request['role']]);
            if(!is_null($request['previl'])){
                DB::table('role_privileges')->where('role_id','=',$r)->delete();
                foreach ($request['previl'] as $key => $value) {
                    DB::table('role_privileges')->insert([
                        'privilege_id'=>$value,
                        'role_id'=>$r,
                    ]);
                }
                 return response()->json(true,200);
            }
        return response()->json(false,200);

        }
        
    }
    
    public function updateone(Request $request,$r){
         if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }

            if(!is_null($request['prv'])){
                if($request['chk']=="false"||$request['chk']==false){
                    DB::table('role_privileges')->where('role_id',"=",$r)->where('privilege_id','=',$request['prv'])->delete();
                }
                else{
                    DB::table('role_privileges')->insert([
                        'privilege_id'=>$request['prv'],
                        'role_id'=>$r,
                    ]);
                }
                 return response()->json(true,200);
            }
        return response()->json(false,200);

        }
        

 
    
    public function jsonAll()
    {
        return json_encode(DB::table("roles")->select("id","label")->get());
    }
}
