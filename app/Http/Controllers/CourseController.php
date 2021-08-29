<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Models\Level;
use App\Models\Module;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\ModuleLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\EmailController;

class CourseController extends Controller
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
    
    public function managementIndex()
    {
        return view("course.management");
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
        if(Auth::User()->phd==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un prof."
            ], 422);
        }
        if(!in_array("MC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $request->request->add(['prof' => Auth::User()->id]);
        $year=$this->getScholarYear();
        $request->request->add(['school_year' => $year]);
        $path="";
        if(!is_null($request->pdf_path)){
            $filename=pathinfo($request->pdf_path->getClientOriginalName(),PATHINFO_FILENAME);
            $extention=pathinfo($request->pdf_path->getClientOriginalName(),PATHINFO_EXTENSION);
            $path = md5(time(). $filename).".".$extention;
            $path = request()->pdf_path->storeAs('courses', $path);
        }
        $data_validator = Validator::make($request->all(),
        [
            'description' => 'required|string|max:255|min:10',
            'module' => 'required|numeric',
            'pdf_path'=>'nullable|file|mimes:pdf'
        ]);
        if ($data_validator->fails()) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
        if(!($course = Course::create($request->all())))
            return response()->json([
                'error' => "Problème se produit dans l'insertion"
            ], 422);
        if(!is_null($path)and$path!=""){
            $cours = Course::find($course->id);
            $cours->pdf_path = $path;
            $cours->save();
        }
        $module_level = ModuleLevel::find($course->module);
        $module_name_temp = Module::find($module_level->code)->label;
        $emails = $this->getEmailsFromLevel($module_level->level);
        $emailController = new EmailController();
        $msg = "<br>Le cours ".$course->description." du ".$module_name_temp." a été ajouté pour ".Level::find($module_level->level)->label."<br><a href='".url("/Dashbord/getCours/".$course->id)."'>Consulter le cours</a>";
        try{
            $emailController->sendMessageArray($msg,"Nouveau cours ajouté",$emails);
        }
        catch(Exception $e){}
        $history = new HistoryController();
        $history->action("Ajout d'un cours",$course,NULL);
        return response()->json(["sucess"=>$course,200]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $old = $course;
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->phd==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un prof."
            ], 422);
        }
        if(!in_array("MC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(Auth::User()->id!=$course->prof)
            {
            return response()->json([
                'error' => "Vous n'êtes pas le prof responsable."
            ], 422);
        }
        if($course == NULL)
            return response()->json([
                'error' => "Cours n'existe pas"
            ], 422);
        $path="";
        if(!is_null($request->pdf_path)){
            Storage::delete($course->pdf_path);
            $filename=pathinfo($request->pdf_path->getClientOriginalName(),PATHINFO_FILENAME);
            $extention=pathinfo($request->pdf_path->getClientOriginalName(),PATHINFO_EXTENSION);
            $path = md5(time(). $filename).".".$extention;
            $path = request()->pdf_path->storeAs('courses', $path);
        }
        $data_validator = Validator::make($request->all(),
        [
            'description' => 'required|string|max:255|min:10',
            'module' => 'required|numeric',
            'pdf_path'=>'nullable|file|mimes:pdf'
        ]);
        if ($data_validator->fails()) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
        if(!is_null($path)and$path!=""){
            $course->description = $request->description;
            $course->module = $request->module;
            $course->pdf_path = $path;
            if(!$course->save())
                return response()->json([
                    'error' => "Problème se produit dans la modification"
                ], 422);
        }
        $module_level = ModuleLevel::find($course->module);
        $module_name_temp = Module::find($module_level->code)->label;
        $emails = $this->getEmailsFromLevel($module_level->level);
        $emailController = new EmailController();
        $msg = "<br>Le cours ".$course->description." du ".$module_name_temp." a été modifié pour ".Level::find($module_level->level)->label."<br><a href='".url("/Dashbord/getCours/".$course->id)."'>Consulter le cours</a>";
        try{
            $emailController->sendMessageArray($msg,"Modification d'un cours",$emails);
        }
        catch(Exception $e){}
        $history = new HistoryController();
        $history->action("Modfication d'un cours",$course,$old);
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->phd==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un prof."
            ], 422);
        }
        if(!in_array("MC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(Auth::User()->id!=$course->prof)
            {
            return response()->json([
                'error' => "Vous n'êtes pas le prof responsable."
            ], 422);
        }
        Storage::delete($course->video);
        Storage::delete($course->pdf_path);
        $history = new HistoryController();
        $history->action("Suppression d'un cours",NULL,$course);
        if(!$course->delete())
            return response()->json([
                'error' => "Problème se produit dans la suppression"
            ], 422);
        return response()->json();
    }
    
    public function destroyArray( Request $request)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->phd==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un prof."
            ], 422);
        }
        if(!in_array("MC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $ids = $request->ids;
        $count=0;
        foreach($ids as $id)
        {
            $course = Course::find($id);
            if(Auth::User()->id!=$course->prof)
            {
                return response()->json([
                    'error' => "Vous n'êtes pas le prof responsable."
                ], 422);
            }
            $history = new HistoryController();
            $history->action("Suppression d'un cours",NULL,$course);
            Storage::delete($course->pdf_path);
            Storage::delete($course->video);
            if($course->delete())
                {
                    $count++;
                }
        }
        if($count!=count($ids))
            return response()->json([
                'error' => "Problème se produit dans la suppression"
            ], 422);
        return response()->json();
    }
    
    public function DataTable()
    {
        if(!in_array("MC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $all = Course::all();
        foreach($all as $val)
        {
            $module_level = ModuleLevel::find($val->module);
            $val->module_name = Module::find($module_level->code)->label;
            $val->level_name = Level::find($module_level->level)->label;
        }
        return json_encode($all);
    }
    
    public function getScholarYear()
    {
        if(date("m")>8)
            return (date("Y")."-".(date("Y")+1));
        else
            return ((date("Y")-1)."-".date("Y"));
    }
    
    function calculateDiffTime($datetime)
    {
        $diff = time() - strtotime($datetime);
        if($diff<60)
            return "juste maintenant";
        else if($diff>=60and$diff<120)
            return "Il y a une minute";
        else if($diff>120 and $diff<3600)
            return "Il y a ".(int)($diff/60)." minutes";
        else if($diff>=3600 and $diff<7200)
            return "Il y a une heure";
        else if($diff>=7200 and $diff<86400)
            return "Il y a ".(int)($diff/3600)." heures";
        else if($diff>=86400and$diff<172800)
            return "Il y a un jour";
        else if($diff>=172800 and $diff<2629743.83)
            return "Il y a ".(int)($diff/86400)." jours";
        else 
            return "Il y a ".(int)($diff/2629743.83)." mois";
    }
    
    public function Download(Course $course)
    {
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $history = new HistoryController();
        $history->action("Telechargment d'un attachement du cours numero ".$course->id,NULL,NULL);
        return Storage::exists($course->pdf_path) ? Storage::download($course->pdf_path) : 'file does not exit';
    }
    
    public function findById(Course $course)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->phd==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un prof."
            ], 422);
        }
        if(!in_array("MC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(Auth::User()->id!=$course->prof)
            {
            return response()->json([
                'error' => "Vous n'êtes pas le prof responsable."
            ], 422);
        }
        return response()->json($course);
    }
    
    public function VideoUpload(Request $request,Course $course)
    {
        $old = $course;
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->phd==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un prof."
            ], 422);
        }
        if(!in_array("MC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        Storage::delete($course->video);
        $filename=pathinfo($request->file("file")->getClientOriginalName(),PATHINFO_FILENAME);
        $extention=pathinfo($request->file("file")->getClientOriginalName(),PATHINFO_EXTENSION);
        $path = md5(time(). $filename).".".$extention;
        $path = request()->file("file")->storeAs('courses', $path);
        $course->video = $path;
        $course->save();
        $history = new HistoryController();
        $history->action("Upload d'un video pour cours numero ".$course->id,$course,$old);
        return response()->json($course);
    }
    
    public function VideoURL(Course $course)
    {
        return json_encode(url('/storage/app/'.$course->video));
    }
    
    public function findOne(Course $course)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $course->prof_name=User::find($course->prof)->fname." ".User::find($course->prof)->lname;
        $course->pdf=url('/storage/app/'.$course->pdf_path);
        $module_level = ModuleLevel::find($course->module);
        $course->module_name = Module::find($module_level->code)->label;
        $course->level_name = Level::find($module_level->level)->label;
        if($course->video!=NULL and $course->video!="")
            {
                $course->video_url=url('/storage/app/'.$course->video);
                $course->video_exist=true;
            }
        else
            $course->video_exist=false;
        
        if($course->school_year!=$this->getScholarYear())
        {
            $course->school_year_badge="Archive";
            $course->school_year_color="badge-info";
        }
        else if((time()-strtotime($course->updated_at))<86400)
        {
            $course->school_year_badge="Nouveau";
            $course->school_year_color="badge-danger";
        }
        else
        {
            $course->school_year_badge="Courant";
            $course->school_year_color="badge-primary";
        }
        if($course->updated_at!=$course->created_at)
            $course->timelabel="Modifié le ";
        else 
            $course->timelabel="Publié le ";
        return view("course.cours",compact("course"));
    }
    
    public function findAllByModule(ModuleLevel $module)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $courses = Course::all()->where("module","=",$module->id)->where("school_year","=",$this->getScholarYear());
        

        
        foreach($courses as $val)
        {
            $val->prof_name=User::find($val->prof)->fname." ".User::find($val->prof)->lname;
            $module_level = ModuleLevel::find($val->module);
            $val->module_name = Module::find($module_level->code)->label;
            $val->level_name = Level::find($module_level->level)->label;
            $val->timeLabel = $this->calculateDiffTime($val->updated_at);
        }
        
        return $courses;
        $next = Course::all()->where("module",">",$module->id)->where("school_year","=",$this->getScholarYear())->first();
        $prev = Course::all()->where("module","<",$module->id)->where("school_year","=",$this->getScholarYear())->first();
        if($next==NULL)
            $next="";
        else
            $next = $next->module;
        if($prev==NULL)
            $prev="";
        else
            $prev = $prev->module;
        
        if(count($courses)!=0)
        {
            if(count($courses)==1)
            {
                $courses=array($courses->first());
            }
            $courses[0]->next=$next;
            $courses[0]->prev=$prev;
            return view("course.coursmodule",compact('courses'));
        }
        else
            {
                $temp = new \stdClass;
                $module_level = ModuleLevel::find($module->id);
                $temp->module_name = Module::find($module_level->code)->label;
                $temp->level_name = Level::find($module_level->level)->label;
                return view("course.coursmodule",compact('temp'));
            }
    }
    
    public function findAllByLevel(Level $level)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $module_level = ModuleLevel::all()->where("level","=",$level->id);
        foreach($module_level as $val)
        {
            $val->module_name=Module::find($val->code)->label;
        }
        $data = new \stdClass;
        $data->level=$level->label;
        $data->modules=$module_level;
        return view("course.courslevel",compact('data'));
    }
    
    public function findAllByFiliere(Faculty $filiere)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $level = Level::all()->where("faculty","=",$filiere->code);
        $data = new \stdClass;
        $data->levels=$level;
        $data->filiere=$filiere->code;
        return view("course.coursfiliere",compact('data'));
    }
    
    public function myClass()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(Auth::User()->cne==NULL)
            return redirect('/');
        else
            {
               $level = DB::table('students')->where('cne','=',Auth::User()->cne)->get()[0]->level;
               return redirect('/cours/level/'.$level);
            }
    }
    
    /***************************************************** Archive ***************************************************************************/
    
    public function findAllByModuleArchive(ModuleLevel $module)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $courses = Course::all()->where("module","=",$module->id)->where("school_year","<>",$this->getScholarYear());
        
        
        foreach($courses as $val)
        {
            $val->prof_name=User::find($val->prof)->fname." ".User::find($val->prof)->lname;
            $module_level = ModuleLevel::find($val->module);
            $val->module_name = Module::find($module_level->code)->label;
            $val->level_name = Level::find($module_level->level)->label;
            $val->timeLabel = $this->calculateDiffTime($val->updated_at);
        }
        $next = Course::all()->where("module",">",$module->id)->where("school_year","=",$this->getScholarYear())->first();
        $prev = Course::all()->where("module","<",$module->id)->where("school_year","=",$this->getScholarYear())->first();
        if($next==NULL)
            $next="";
        else
            $next = $next->module;
        if($prev==NULL)
            $prev="";
        else
            $prev = $prev->module;
        
        if(count($courses)!=0)
        {
            if(count($courses)==1)
            {
                $courses=array($courses->first());
            }
            $courses[0]->next=$next;
            $courses[0]->prev=$prev;
            return view("course.coursmodule",compact('courses'));
        }
        else
            {
                $temp = new \stdClass;
                $module_level = ModuleLevel::find($module->id);
                $temp->module_name = Module::find($module_level->code)->label;
                $temp->level_name = Level::find($module_level->level)->label;
                return view("course.coursmodule",compact('temp'));
            }
    }
    
    public function findAllByLevelArchive(Level $level)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $module_level = ModuleLevel::all()->where("level","=",$level->id);
        foreach($module_level as $val)
        {
            $val->module_name=Module::find($val->code)->label;
        }
        $data = new \stdClass;
        $data->level=$level->label;
        $data->modules=$module_level;
        return view("course.courslevela",compact('data'));
    }
    
    public function findAllByFiliereArchive(Faculty $filiere)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $level = Level::all()->where("faculty","=",$filiere->code);
        $data = new \stdClass;
        $data->levels=$level;
        $data->filiere=$filiere->code;
        return view("course.coursfilierea",compact('data'));
    }


    /********************/
    public function GetmyClass()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(Auth::User()->cne==NULL)
            return redirect('/');
        else
            {
               $level = DB::table('students')->where('cne','=',Auth::User()->cne)->get()[0]->level;
               return redirect('/cours/level/'.$level);
            }
    }
    public function GetMbyLevels()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $l = DB::table('students')->where('cne','=',Auth::User()->cne)->get()[0]->level;
        $level = DB::table('levels')->where('id','=',$l)->first();
        $module_level = ModuleLevel::all()->where("level","=",$level->id);
        foreach($module_level as $val)
        {
            $val->module_name=Module::find($val->code)->label;
        }
        $data = new \stdClass;
        $data->level=$level->label;
        $data->modules=$module_level;
        return json_encode($data);
    }
    public function GetMCrs($m)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $courses = Course::all()->where("module","=",$m)->where("school_year","=",$this->getScholarYear());        

        
        foreach($courses as $val)
        {
            $val->prof_name=User::find($val->prof)->fname." ".User::find($val->prof)->lname;
            $module_level = ModuleLevel::find($val->module);
            $val->module_name = Module::find($module_level->code)->label;
            $val->level_name = Level::find($module_level->level)->label;
            $val->timeLabel = $this->calculateDiffTime($val->updated_at);
        }
        
        return $courses;
    }
    public function GetMCrsALL($m)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $courses = Course::all()->where("module","=",$m);        

        
        foreach($courses as $val)
        {
            $val->prof_name=User::find($val->prof)->fname." ".User::find($val->prof)->lname;
            $module_level = ModuleLevel::find($val->module);
            $val->module_name = Module::find($module_level->code)->label;
            $val->level_name = Level::find($module_level->level)->label;
            $val->timeLabel = $this->calculateDiffTime($val->updated_at);
        }
        
        return $courses;
    }
    public function getOneCours($c)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $course = DB::table('courses')->where('id','=',$c)->get()[0];

        $course->prof_name=User::find($course->prof)->fname." ".User::find($course->prof)->lname;
        $course->pdf=url('/storage/app/'.$course->pdf_path);
        $module_level = ModuleLevel::find($course->module);
        $course->module_name = Module::find($module_level->code)->label;
        $course->level_name = Level::find($module_level->level)->label;
        if($course->video!=NULL and $course->video!="")
            {
                $course->video_url=url('/storage/app/'.$course->video);
                $course->video_exist=true;
                 $course->type_video=explode(".",$course->video_url)[count(explode(".",$course->video_url))-1];
            }
        else
            $course->video_exist=false;
        
        if($course->school_year!=$this->getScholarYear())
        {
            $course->school_year_badge="Archive";
            $course->school_year_color="badge-info";
        }
        else if((time()-strtotime($course->updated_at))<86400)
        {
            $course->school_year_badge="Nouveau";
            $course->school_year_color="badge-danger";
        }
        else
        {
            $course->school_year_badge="Courant";
            $course->school_year_color="badge-primary";
        }
        if($course->updated_at!=$course->created_at)
            $course->timelabel="Modifié le ";
        else 
            $course->timelabel="Publié le ";
        return json_encode($course);
    }
    
    public function getEmailsFromLevel($level)
    {
        $ddddd = DB::table("users AS u")->select("u.email")->where("s.level","=",$level)->join("students AS s","s.cne","=","u.cne")->get();
        $emails = array();
        foreach($ddddd as $d)
        {
            $emails[]=$d->email;
        }
        return $emails;
    }
}
