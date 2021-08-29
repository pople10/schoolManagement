<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfModuleController;
use App\Models\Phd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PhdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Phd  $phd
     * @return \Illuminate\Http\Response
     */
    public function show(Phd $phd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Phd  $phd
     * @return \Illuminate\Http\Response
     */
    public function edit(Phd $phd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Phd  $phd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Phd $phd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phd  $phd
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phd $phd)
    {
        //
    }
    
    public function findAll($id)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        $role = 2;
        $users = (array)DB::table('users')
        ->select('id','cin','lname','fname')
        ->get();
        $result=array();
        $users=array_values($users)[0];
        foreach($users as $val)
        {
            $phd=DB::table('phds')->where('id', 'LIKE', $val->cin.'-%')->get();
            if(!empty($phd) and isset($phd) and count($phd)==1)
            {
                $result[]=array("id"=>$phd[0]->id,"name"=>$val->fname." ".$val->lname);
            }    
        }
        $prof_module=new ProfModuleController();
        return array("data"=>$result,"selected"=>($prof_module->findByIdModule($id)));
    }
}
