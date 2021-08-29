<?php

namespace App\Http\Controllers;

use App\Models\ProfModule;
use App\Models\Student;
use App\Models\User;
use App\Models\Module;
use App\Models\ModuleLevel;
use App\Models\Archive;
use App\Models\Phd;
use Illuminate\Http\Request;
use Auth;
use DB;
use Storage;

class HomewoorkController extends Controller
{
    
    
    
    
   
    public function getModules()
    {
        if(Auth::user()->phd!==NULL){
            $x=ProfModule::where('prof','=',Auth::user()->phd)
            ->join("module_levels",'prof_modules.module', '=', 'module_levels.id')
            ->join("modules",'module_levels.code', '=', 'modules.code')
            ->select('prof_modules.id','modules.label','module_levels.level')->get();
            $d=[];
            return json_encode($x);
        }
        
    }
    public function getPhd(){
        return json_encode(Auth::user()->phd);
    }
    
    public function getHomeworksProf()
    {
        if(Auth::user()->phd!==NULL){
            $x=DB::table('homewoork_porf')->where('phds','=',Auth::user()->phd)
            ->join("prof_modules",'prof_modules.id', '=', 'homewoork_porf.prof_modules')
            ->join("module_levels",'prof_modules.module', '=', 'module_levels.id')
            ->join("modules",'module_levels.code', '=', 'modules.code')
            ->select('homewoork_porf.id','modules.label','module_levels.level',"homewoork_porf.title","homewoork_porf.description")->get();
            return json_encode($x);
        }
        
    }
    public function getHomeworksProfdata($id)
    {   
        if(Auth::user()->phd!==NULL){
        $x=DB::table('homewoork_student')->where('homewoork','=',$id)
        ->join("homewoork_porf",'homewoork_porf.id', '=', 'homewoork_student.homewoork')
        ->join("prof_modules",'prof_modules.id', '=', 'homewoork_porf.prof_modules')
        ->join("module_levels",'prof_modules.module', '=', 'module_levels.id')
        ->join("modules",'module_levels.code', '=', 'modules.code')
        ->join("users",'users.cne', '=', 'homewoork_student.student')
        ->select('homewoork_student.id','modules.label','module_levels.level','homewoork_porf.title',"homewoork_student.pdf_path","homewoork_student.done","users.fname","users.lname","users.cne",)->get();
        return json_encode($x);
    }
        
    }
    public function getHomeworksStudents()
    {
        if(Auth::user()->cne!==NULL){
            $x=DB::table('homewoork_student')->where('student','=',Auth::user()->cne)
            ->join( "homewoork_porf",'homewoork_porf.id' , '=', 'homewoork_student.homewoork' )
            ->join("prof_modules",'prof_modules.id', '=', 'homewoork_porf.prof_modules')
            ->join("module_levels",'prof_modules.module', '=', 'module_levels.id')
            ->join("modules",'module_levels.code', '=', 'modules.code')
            ->select('homewoork_porf.id','modules.label',"homewoork_porf.title","homewoork_porf.description","homewoork_student.prof","homewoork_student.done")
            ->get();
            return json_encode($x);
        }
        return json_encode(false);
        
    }

    public function store(Request $request)
    {
        if(!is_null($request->id)){
            $lvlm=ProfModule::where('id','=',$request->id)->first();
            $lev=ModuleLevel::where('id','=',$lvlm->module)->first();
            $students=Student::where('level','=',$lev->level)->get();
           $id_h= DB::table('homewoork_porf')->insertGetId([
                'prof_modules'=>$request->id,
                'title'=>$request->title,
                'phds'=>Auth::user()->phd,
                'description'=>$request->description,
            ]);
            foreach ($students as $stud) {
                DB::table('homewoork_student')->insert([
                    'homewoork'=>$id_h,
                    'student'=>$stud->cne,
                    'prof'=>Auth::user()->fname.' '.Auth::user()->lname,
                ]);
            }
        
            
            return json_encode(true);
        }
        return json_encode(false);
    }

    public function destroy($id)
    {
        $x=DB::table('homewoork_porf')->where('id','=',$id)->get();
        if(count($x)>0){
            $x=$x[0];
            if($x->phds==Auth::user()->phd){
                DB::table('homewoork_student')->where('homewoork','=',$id)->delete();
                $x=DB::table('homewoork_porf')->where('id','=',$id)->delete();
                return json_encode(true);
            }
        

        }
        return json_encode(false);
    }
    public function ulpoadtStudent(Request $request){
     
       $path="";
       if(!is_null($request->pdf_path)){
        $filename=pathinfo($request->pdf_path->getClientOriginalName(),PATHINFO_FILENAME);
        $extention=pathinfo($request->pdf_path->getClientOriginalName(),PATHINFO_EXTENSION);
        $path = md5(time(). $filename).".".$extention;
        $path = request()->pdf_path->storeAs('Homewoork', $path);
    }
    if($path!=''){
        DB::table('homewoork_student')->where('homewoork','=',$request->id)->where("student","=",Auth::user()->cne)->update(['done'=>1,'pdf_path'=>$path]);
        return true;
    }
    else return false;

    }
    public function Download($id)
    { 
        $d=DB::table('homewoork_student')->where('id','=',$id)->first()->pdf_path;
        return Storage::exists($d) ? Storage::download($d) : 'file does not exit';
    }
        
}
