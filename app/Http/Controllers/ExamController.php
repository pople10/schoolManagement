<?php

namespace App\Http\Controllers;

use App\Models\ModuleLevel;
use App\Models\Level;
use App\Models\Module;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use App\Http\Controllers\EmailController;

        
class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        $allQst = DB::table('examQst')->get();
            foreach($allQst as $val)
            {
                $exam = DB::table("examens")->where("id","=",$val->examen)->get()[0];
                /*var_dump($exam)."<br>";
                echo strtotime($exam->end)."<br>";
                echo time()."<br>";*/
                if(strtotime($exam->end)<time())
                {
                    $level = ModuleLevel::find($exam->moduleLevel)->level;
                    $students = Student::all()->where("level","=",$level);
                    foreach($students as $val2)
                    {
                        if(count(DB::table("examRs")->where([["qst","=",$val->id],["student","=",$val2->cne]])->get())==0)
                        {
                            if(!DB::table("examRs")->insert(["student"=>$val2->cne,"qst"=>$val->id,"mark"=>"0"]))
                                echo "Probleme dans l'insertion\n";
                            else
                                echo "done\n";
                        }
                        else
                        {
                             //echo "Probleme dans le code";
                        }
                    }
                }
                else
                {
                    //echo "Probleme dans le code 2";
                }
            }
    }
    
    public function createExam(Request $request)
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data_validator = Validator::make($request->all(),
        [
            'module' => 'required|numeric',
            'start' => 'required|date',
            'end' =>'required|date|after:start',
        ]);
        if ($data_validator->fails()) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
        if(!DB::table("examens")->insert(array("moduleLevel"=>$request->module,"prof"=>Auth::User()->id,"start"=>$request->start,"end"=>$request->end)))
            return response()->json([
                'error' => "Erreur produit dans l'insertion"
            ], 422);
        $emailController = new EmailController();
        $level_temp = ModuleLevel::find($request->module)->level;
        $sub = "Une examen a été lancé pour ".Level::find($level_temp)->label;
        $msg="Vous avez un examen dans le module ".Module::find(ModuleLevel::find($request->module)->code)->label;
        $msg.="<br>L'examen commance de ".$request->start." et sera fini à ".$request->end;
        $lastInserted = DB::getPdo()->lastInsertId();
        $msg.="<br><a href='".url("/exam/$lastInserted")."'>Cliquer ici</a>";
        $emails=array();
        foreach(Student::all()->where("level","=",$level_temp) as $etu)
        {
            $emails[]=User::where("cne","=",$etu->cne)->first()->email;
        }
        $emailController->sendMessageArray($msg,$sub,$emails);
        return response()->json($lastInserted);
    }
    
    public function getExams()
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $all = DB::table("examens")->where("prof","=",Auth::User()->id)->get();
        foreach($all as $val)
        {
            $val->level=Level::find(ModuleLevel::find($val->moduleLevel)->level)->label;
            $val->module_name=Module::find(ModuleLevel::find($val->moduleLevel)->code)->label;
        }
        return json_encode($all);
    }
    
    
    public function addView()
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        return view("exams.prof");
    }
    
    public function qstView($exam)
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(count(DB::table("examens")->where("id",$exam)->get())==0)
            return response()->json([
                'error' => "Examen n'existe pas"
            ], 422);
        $qst=DB::table("examQst")->where("examen",$exam)->get();
        if(count($qst)==0)
            return view("exams.addQst",compact("exam"));
        else
        {
            $merged= new \stdClass;
            $merged->exam=$exam;
            $merged->qst=$qst;
            return view("exams.editQst",compact("merged"));
        }
    }
    
    public function addQst(Request $request,$exam)
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(count(DB::table("examens")->where("id",$exam)->get())==0)
            return response()->json([
                'error' => "Examen n'existe pas"
            ], 422);
        if(count(DB::table("examens")->where([["id","=",$exam],["prof","=",Auth::User()->id]])->get())==0)
            return response()->json([
                'error' => "Vous n'êtes pas le responsable pour cet examen"
            ], 422);
        if(count(DB::table("examQst")->where("examen",$exam)->get())!=0)
            return response()->json([
                'error' => "Examen a déja des questions. Veuillez actualiser la page"
            ], 422);
        $cmp=0;
        foreach($request->data as $val)
        {
            if(DB::table("examQst")->insert(array("examen"=>$exam,"qst"=>$val["qst"],"time"=>$val["tmp"],"data"=>$val["r"])))
                $cmp++;
        }
        if($cmp==0)
            return response()->json([
                'error' => "Insertion echouée"
            ], 422);
        if($cmp!=count($request->data))
            return response()->json([
                'error' => "Insertion echouée\nJuste instetion du ".$cmp."\nActualiser la page pour modifier"
            ], 422);
        return  response()->json();
    }
    
    public function editQst(Request $request,$exam)
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(count(DB::table("examens")->where("id",$exam)->get())==0)
            return response()->json([
                'error' => "Examen n'existe pas"
            ], 422);
        if(count(DB::table("examens")->where([["id","=",$exam],["prof","=",Auth::User()->id]])->get())==0)
            return response()->json([
                'error' => "Vous n'êtes pas le responsable pour cet examen"
            ], 422);
        if(!DB::table("examQst")->where("examen",$exam)->delete())
            return response()->json([
                'error' => "Erreur dans la suppression des anciennes"
            ], 422);
        $cmp=0;
        foreach($request->data as $val)
        {
            if(DB::table("examQst")->insert(array("examen"=>$exam,"qst"=>$val["qst"],"time"=>$val["tmp"],"data"=>$val["r"])))
                $cmp++;
        }
        if($cmp==0)
            return response()->json([
                'error' => "Insertion echouée"
            ], 422);
        if($cmp!=count($request->data))
            return response()->json([
                'error' => "Insertion echouée\nJuste instetion du ".$cmp."\nActualiser la page pour modifier"
            ], 422);
        return  response()->json();
    }
    
    public function getQuestion($exam)
    {
        if(!in_array("CE",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $examen = DB::table("examens")->where("id","=",$exam)->get();
        if(count($examen)==0)
            return response()->json([
                'error' => "L'examen n'existe pas"
            ], 422);
        $examen=$examen[0];
        if(strtotime($examen->end)<time())
        {
            return response()->json([
                'error' => "L'examen est finit"
            ], 422);
        }
        if(strtotime($examen->start)>time())
            return response()->json([
                'error' => "L'examen n'est pas encore commancer"
            ], 422);
            
        if(ModuleLevel::find($examen->moduleLevel)->level != Student::find(Auth::User()->cne)->level)
            return response()->json([
                'error' => "L'examen n'est pas pour vous"
            ], 422);
        $answerd = DB::table("examRs")->where("student","=",Auth::User()->cne)->get();
        $values = array();
        foreach($answerd as $val)
        {
            $values[]=$val->qst;
        }
        $qst = DB::table("examQst AS q")->select("q.*")->where([["q.examen","=",$exam]])->whereNotIn("q.id",$values)->orderBy(DB::raw('RAND()'))->limit(1)->get();
        if(count($qst)!=0)
        {
            $resp = (array)json_decode($qst[0]->data);
            $qst[0]->data = array_keys($resp);
            
        }
        return json_encode($qst);
    }
    
    public function cheated(Request $request)
    {
        $exam = $request->exam;
        if(!in_array("CE",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $examen = DB::table("examens")->where("id","=",$exam)->get();
        if(count($examen)==0)
            return response()->json([
                'error' => "L'examen n'existe pas"
            ], 422);
        $examen=$examen[0];
        if(strtotime($examen->end)<time())
        {
            return response()->json([
                'error' => "L'examen est finit"
            ], 422);
        }
        if(strtotime($examen->start)>time())
            return response()->json([
                'error' => "L'examen n'est pas encore commancer"
            ], 422);
        if(ModuleLevel::find($examen->moduleLevel)->level != Student::find(Auth::User()->cne)->level)
            {return response()->json([
                'error' => "L'examen n'est pas pour vous"
            ], 422);}
        $values=array();
        $qst = DB::table("examQst AS q")->select("q.*")->where([["q.examen","=",$exam]])->get();
        foreach($qst as $val)
        {
             $values[]=$val->id;
        }
        DB::table("examRs")->where("student","=",Auth::User()->cne)->whereIn("qst",$values)->delete();
        foreach($qst as $val)
        {
             DB::table("examRs")->insert(["student"=>Auth::User()->cne,"qst"=>$val->id,"mark"=>"0"]);
        }
    }
    
    public function responseValidate(Request $request)
    {
        $qstWanted = DB::table("examQst")->where("id","=",$request->question)->get()[0];
        if(!in_array("CE",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $examen = DB::table("examens")->where("id","=",$qstWanted->examen)->get();
        if(count($examen)==0)
            return response()->json([
                'error' => "L'examen n'existe pas"
            ], 422);
        $examen=$examen[0];
        if(strtotime($examen->end)<time())
        {
            return response()->json([
                'error' => "L'examen est finit"
            ], 422);
        }
        if(strtotime($examen->start)>time())
            return response()->json([
                'error' => "L'examen n'est pas encore commancer"
            ], 422);
        if(ModuleLevel::find($examen->moduleLevel)->level != Student::find(Auth::User()->cne)->level)
            {return response()->json([
                'error' => "L'examen n'est pas pour vous"
            ], 422);}
        /******************************** Traitement ********************************/
        $answers = $request->answers;
        $resp = (array)json_decode($qstWanted->data);
        $respText = array_keys($resp);
        $respVal = array_values($resp);
        $correct = array();
        foreach($respText as $val)
        {
            if($resp[$val]=="V")
                $correct[] = $val;
        }
        $mark="0";
        if($this->array_equal($correct,$answers))
            $mark="1";
        if(count(DB::table("examRs")->where([["student","=",Auth::User()->cne],["qst","=",$request->question]])->get())!=0)
            {return response()->json([
                'error' => "Question répondu"
            ], 422);}
        DB::table("examRs")->insert(["student"=>Auth::User()->cne,"qst"=>$request->question,"mark"=>$mark]);
    }
    
    public function array_equal($a,$b)
    {
        return ( is_array($a) && is_array($b) && count($a) == count($b) && array_diff($a, $b) === array_diff($b, $a) );
    }
    
    public function getExamView($exam)
    {
        if(!in_array("CE",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $examen = DB::table("examens")->where("id","=",$exam)->get();
        if(count($examen)==0)
            return response()->json([
                'error' => "L'examen n'existe pas"
            ], 422);
        $examen=$examen[0];
        if(ModuleLevel::find($examen->moduleLevel)->level != Student::find(Auth::User()->cne)->level)
            {return response()->json([
                'error' => "L'examen n'est pas pour vous"
            ], 422);}
        $qstsAllTiming = DB::table("examQst")->select("time","id")->where("examen","=",$exam)->get();
        if(count($qstsAllTiming)==0)
            {return response()->json([
                'error' => "L'examen n'a pas encore des questions"
            ], 422);}
        $qstAllArray = array();
        $fullTime = 0;
        foreach($qstsAllTiming as $val)
        {
            $fullTime+=(int)$val->time;
            $qstAllArray[]=$val->id;
        }
        $rspAll = DB::table("examRs")->whereIn("qst",$qstAllArray)->where("student","=",Auth::User()->cne)->get();
        if(count($rspAll)==count($qstsAllTiming))
            return redirect("/exam/result/".$exam);
        $examen->module = Module::find(ModuleLevel::find($examen->moduleLevel)->code)->label;
        $examen->level = Level::find(ModuleLevel::find($examen->moduleLevel)->level)->label;
        $examen->timing = $fullTime;
        return view("exams.student",compact("examen"));
    }
    
    public function getResultView($exam)
    {
        if(!in_array("CE",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $examen = DB::table("examens")->where("id","=",$exam)->get();
        if(count($examen)==0)
            return response()->json([
                'error' => "L'examen n'existe pas"
            ], 422);
        $examen=$examen[0];
        if(ModuleLevel::find($examen->moduleLevel)->level != Student::find(Auth::User()->cne)->level)
            {return response()->json([
                'error' => "L'examen n'est pas pour vous"
            ], 422);}
        $qstsAllTiming = DB::table("examQst")->select("time","id")->where("examen","=",$exam)->get();
        if(count($qstsAllTiming)==0)
            {return response()->json([
                'error' => "L'examen n'a pas encore des questions"
            ], 422);}
        $qstAllArray = array();
        $fullTime = 0;
        foreach($qstsAllTiming as $val)
        {
            $fullTime+=(int)$val->time;
            $qstAllArray[]=$val->id;
        }
        $rspAll = DB::table("examRs")->whereIn("qst",$qstAllArray)->where("student","=",Auth::User()->cne)->get();
        if(count($rspAll)!=count($qstsAllTiming))
            return redirect("/exam/".$exam);
        $examen->module = Module::find(ModuleLevel::find($examen->moduleLevel)->code)->label;
        $rspValid = DB::table("examRs")->whereIn("qst",$qstAllArray)->where([["student","=",Auth::User()->cne],["mark","<>","0"]])->get();
        $examen->level = Level::find(ModuleLevel::find($examen->moduleLevel)->level)->label;
        $examen->mark =  count($rspValid);
        $examen->total = count($rspAll);
        $examen->mark_rel = (float)($examen->mark/$examen->total)*20;
        if(Student::find(Auth::User()->cne)->level=="CP1" or Student::find(Auth::User()->cne)->level=="CP2")
            $examen->passed = ($examen->mark_rel>10);
        else 
            $examen->passed = ($examen->mark_rel>12);
        return view("exams.result",compact("examen"));
    }
    
    public function getExamResultProf()
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data = DB::table("examens")->where([["prof","=",Auth::User()->id],["end","<",date('Y-m-d h:i:s')]])->get();
        return view("exams.resultatProf",compact("data"));
    }
     public function getExamReultapi()
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data = DB::table("examens")->where([["prof","=",Auth::User()->id],["end","<",date('Y-m-d h:i:s')]])->get();
        return json_encode($data);
    }
    
    public function getMarksByExam($exam)
    {
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(count(DB::table("examens")->where([["prof","=",Auth::User()->id],["id","=",$exam]])->get())==0)
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        $qstsAllTiming = DB::table("examQst")->where("examen","=",$exam)->get();
        $qstAllArray = array();
        foreach($qstsAllTiming as $val)
        {
            $qstAllArray[]=$val->id;
        }
        $rspAll = DB::table("examRs")->whereIn("qst",$qstAllArray)->get();
        $students = array();
        foreach($rspAll as $val)
        {
            if(!isset($students[$val->student]))
                $students[$val->student]=array(
                    "note"=>count(DB::table("examRs")->whereIn("qst",$qstAllArray)->where([["student","=",$val->student],["mark","<>","0"]])->get()),
                    "total"=>count(DB::table("examRs")->whereIn("qst",$qstAllArray)->where("student","=",$val->student)->get()),
                    "nom"=>User::where("cne","=",$val->student)->first()->lname,
                    "prenom"=>User::where("cne","=",$val->student)->first()->fname
                    );
        }
        $students_pr=array();
        foreach($students as $key=>$val)
        {
            $students_pr[] = new \stdClass;
            end($students_pr)->cne=$key;
            end($students_pr)->note = $val["note"]."/".$val["total"];
            end($students_pr)->note_rel = (float)($val["note"]/$val["total"])*20;
            end($students_pr)->nom = $val["nom"];
            end($students_pr)->prenom = $val["prenom"];
        }
        return json_encode($students_pr);
    }
}
