<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use File;

class Profil extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }
    
    public function index(){
                if(Auth::user()==NULL) return redirect('/login');
        if(Auth::User()->cne===NULL and Auth::User()->phd===NULL) 
        {return redirect('/Dashbord/Profil');}
        $rId =Auth::user()->role_id;
        $userId = Auth::user();
        $isstudent=($rId==1)?true:false;
        $lev=DB::table('levels')->where('shw','=',1)->get();
        $phdd=DB::table('phds')->where('id','=',Auth::user()->phd)->get()->first();
        return view('Profil.index',compact('userId','isstudent','lev','phdd'));
    }

    public function edit(Request $request){
        //return response()->json($request,200);

        $url=Auth::user()->photo_path;
        if( $request->hasFile('img')){
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
            $url="/public".$pS."/".$filename;
        }

        if( !is_null($request['CNE'])){

            $data=$request->validate([
                'fname'=> ['required'],
                'lname'=> ['required'],
                'Adress'=> ['required'],
                'Telephone'=>['required','min:10','max:14'],
            ]);
            
             DB::table('users')->where('id','=',Auth::id())->update([
                'lname'=> $request['lname'],
                'fname'=> $request['fname'],
                'adress'=> $request['Adress'],
                'telephone'=> $request['Telephone'],
                'photo_path'=>$url,
                
             ]);

        }else{

           if($request['subject']!=NULL)
            {    $data=$request->validate([
                    'fname' => ['required', 'string', 'max:255'],
                    'lname' => ['required', 'string', 'max:255'],
                    'Adress'=> ['required'],
                    'Telephone'=>['required','min:10','max:14'],
                    'subject'=>[],
                    'date_start'=>['required'],
                    'date_end'=>[],

                ]);
                if($data['date_end']==NULL){
                    DB::table('phds')->where('id','=',Auth::user()->phd)->update([
                        'subject'=> $data['subject'],
                        'date_start'=> $data['date_start'],
                    ]);}
            else
               { $data=$request->validate([
                    'fname' => ['required', 'string', 'max:255'],
                    'lname' => ['required', 'string', 'max:255'],
                    'Adress'=> ['required'],
                    'Telephone'=>['required','min:10','max:14'],
                    'subject'=>[],
                    'date_start'=>[],
                    'date_end'=>[],
                ]);
                DB::table('phds')->where('id','=',Auth::user()->phd)->update([
                    'subject'=> $data['subject'],
                    'date_start'=> $data['date_start'],
                    'date_end'=> $data['date_end'],
                ]);
            }

            
            }
            DB::table('users')->where('id','=',Auth::id())->update([
                'fname' => $data['fname'],
                'lname' => $data['lname'],
                'adress'=> $request['Adress'],
                'telephone'=> $request['Telephone'],
                'photo_path'=>$url,
    
             ]);
        
        }
       
        return response()->json(true,200);
    }

}
