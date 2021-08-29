<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Student;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\EmailController;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::User()->cne!=NULL)
        {
            return view("questions.student");
        }
        else if(Auth::User()->phd!=NULL)
        {
            return view("questions.prof");
        }
        else
            return view("welcome");
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
        if(Auth::User()->cne==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un étudiant."
            ], 422);
       }
       if(!in_array("CC",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
       $request->request->add(["student"=>Auth::User()->cne]);
       $data_validator = Validator::make($request->all(),
        [
            'prof' => 'required|string',
            'question' => 'required|string'
        ]);
        if ($data_validator->fails()) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
       if(!Question::create($request->all()))
       {
           return response()->json([
                'error' => "Problème se produit dans l'insertion"
            ], 422);
       }
       $email = new EmailController();
       $message="Bonjour Professeur,<br>Vous avez une question crée par l'étudiant ".Auth::User()->fname." ".Auth::User()->lname."<br><a href='".url('/questions')."'>Pour répondre</a>";
       $emailTo = User::where("phd","=",$request->prof)->first()->email;
       $email->sendMessage($message,"ENSAH : Nouvelle question",$emailTo);
        $history = new HistoryController();
        $history->action("Ajout d'une question",NULL,NULL);
       return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->cne!=$question->student)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un étudiant."
            ], 422);
       }
       $history = new HistoryController();
        $history->action("Suppression d'une question",NULL,$question);
       if(!$question->delete())
            return response()->json([
                'error' => "Suppression annulée."
            ], 422);
       return response()->json(); 
    }
    
    public function confirm(Question $question)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->cne!=$question->student)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un étudiant."
            ], 422);
       }
       $question->answered="1";
       if(!$question->save())
            return response()->json([
                'error' => "Confirmation annulée."
            ], 422);
       return response()->json(); 
    }
    
    public function reply(Question $question,Request $request)
    {
        $old = $question;
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->phd!=$question->prof)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un étudiant."
            ], 422);
       }
        $data_validator = Validator::make($request->all(),
        [
            'answer' => 'required|string',
        ]);
        if ($data_validator->fails()) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
       $question->answer=$request->answer;
       if(!$question->save())
            return response()->json([
                'error' => "Réponse annulée."
            ], 422);
        $history = new HistoryController();
        $history->action("Reponse à une question",$question,$old);
       return response()->json(); 
    }
    
    public function findAllStudent()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->cne==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un étudiant."
            ], 422);
       }
       $questions = DB::table('questions')->where("student","=",Auth::User()->cne)->get();
       foreach($questions as $val)
       {
           //$val->answer = str_replace("\n", '\n',  $val->answer);
           //$val->question = str_replace("\n", '\n',  $val->question);
           $name = User::where("phd","=",$val->prof)->first();
           $val->prof_name=$name->fname." ".$name->lname;
           $val->labeltime = $this->calculateDiffTime($val->created_at);
           $val->replylabeltime = $this->calculateDiffTime($val->updated_at);
       }
       return json_encode($questions);
    }
    
    public function findAllProf()
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
       $questions = DB::table('questions')->where("prof","=",Auth::User()->phd)->get();
       foreach($questions as $val)
       {
           //$val->answer = str_replace("\n", '\n',  $val->answer);
           //$val->question = str_replace("\n", '\n',  $val->question);
           $name = User::where("cne","=",$val->student)->first();
           $val->student_name=$name->fname." ".$name->lname;
           $val->student_level = Level::find(Student::where("cne","=",$val->student)->first()->level)->label;
           $val->labeltime = $this->calculateDiffTime($val->created_at);
           $val->replylabeltime = $this->calculateDiffTime($val->updated_at);
       }
       return response()->json($questions);
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
}
