<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use File;
use DB;
use Hash;

class RegisterSecondPage extends Controller
{
    public function index(){
        if(Auth::user()->adress!=NULL) return redirect('/');
        $rId =Auth::user()->role_id;
        $isstudent=($rId==1)?true:false;
        $lev=DB::table('levels')->where('shw','=',1)->get();
        return view('auth.RSP',compact('isstudent','lev'));
    }
    public function store(Request $request){
        $rId =Auth::user()->role_id;
        $isstudent=($rId==1)?true:false;
        if($isstudent){ 
        $data=$request->validate([
            'img'=> ['required'],
            'Adress'=> ['required'],
            'CNE'=>['required'],
            'Telephone'=>['required','min:10','max:14'],
            'Sexe'=>['required'],
            'Bac_Mark'=>['required','regex:/^[0-9]+(\.[0-9][0-9]?)?$/'],
            'Bac_Type'=>['required'],
            'Level'=>['required'],
        ]);

        
            $file=$request->file('img');
            $filename="";
            $namedr=DB::table('roles')->where('id','=',Auth::user()->role_id)->first()->label;
            $pS="/storage/Users/".$namedr;
            $p= public_path($pS);
            if (!File::isDirectory($p)) {
                File::makeDirectory($p, 0777, true);
            }
            $filename=Auth::user()->cin.".".$file->getClientOriginalExtension();
            $path=$request->img->move($p,$filename);
            $url=$pS."/".$filename;
        
        DB::table('students')->insert([
            'cne'=> $data['CNE'],
            'level'=> $data['Level'],
            'bac_type'=> $data['Bac_Type'],
            'bac_mark'=> $data['Bac_Mark'],

         ]);
         DB::table('users')->where('id','=',Auth::id())->update([
            'cne'=> $data['CNE'],
            'adress'=> $data['Adress'],
            'telephone'=> $data['Telephone'],
            'sexe'=> $data['Sexe'],
            'vkey'=>md5(Auth::user()->cin.Auth::id().rand(0,100)),
            'photo_path'=>$url
         ]);
        }
        else{
            if($request['subject']!=NULL)
                $data=$request->validate([
                    'Adress'=> ['required'],
                    'Telephone'=>['required','min:10','max:14'],
                    'Sexe'=>['required'],
                    'subject'=>[],
                    'date_start'=>['required'],
                    'date_end'=>[],

                ]);
            else
                $data=$request->validate([
                    'Adress'=> ['required'],
                    'Telephone'=>['required','min:10','max:14'],
                    'Sexe'=>['required'],
                    'subject'=>[],
                    'date_start'=>[],
                    'date_end'=>[],

                ]);

            $url=NULL;
            if($request->hasFile('img')){
                $file=$request->file('img');
                $filename="";
                $namedr=DB::table('roles')->where('id','=',Auth::user()->role_id)->first()->label;
                $pS="/storage/Users/".$namedr;
                $p= public_path($pS);
                if (!File::isDirectory($p)) {
                    File::makeDirectory($p, 0777, true);
                }
                $filename=Auth::user()->cin.".".$file->getClientOriginalExtension();
                $path=$request->img->move($p,$filename);
                $url="/public".$pS."/".$filename;}
                $phfid=NULL;
                
            if($data['subject']!=NULL){
                $phfid=Auth::user()->cin.'-'.Auth::user()->lname.'_'.Auth::user()->fname;
                if($data['date_end']==NULL){
                    DB::table('phds')->insert([
                        'id'=>$phfid,
                        'subject'=> $data['subject'],
                        'date_start'=> $data['date_start'],
                    ]);
                }
                else {
                    DB::table('phds')->insert([
                        'id'=>$phfid,
                        'subject'=> $data['subject'],
                        'date_start'=> $data['date_start'],
                        'date_end'=> $data['date_end'],
                    ]);
                }
            }
             DB::table('users')->where('id','=',Auth::id())->update([
                'adress'=> $data['Adress'],
                'telephone'=> $data['Telephone'],
                'sexe'=> $data['Sexe'],
                'vkey'=>Hash::make(Auth::user()->cin.Auth::id().rand(0,100)),
                'photo_path'=>$url,
                'phd'=>$phfid
             ]);
        }
        return redirect('/'); 
     }
}
