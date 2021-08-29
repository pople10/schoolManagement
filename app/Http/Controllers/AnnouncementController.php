<?php

namespace App\Http\Controllers;

use App\Http\Controllers\HistoryController;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     
    
    public function home(){
        //announcement with attachements
        $announcement = Announcement::select('*')->where('role', '0')->orderBy("updated_at","DESC")->limit(3)->get();
        return view('welcome', compact('announcement'));
    } 
     
    
    public function index()
    {
        return view('announcement.index');
    }

    public function dataTableJson(){
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MA",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $whereCond;
        if(Auth::User()->role_id!="3")
        {
            $whereCond=["user_id"=>Auth::User()->id];
        }
        else
        {
            $whereCond=[];
        }
        $data = DB::table('announcements')->select('id', 'user_id', 'title', 'type', 'role','attachement','updated_at','created_at')->where($whereCond)->get();
        return  json_encode($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('announcement.create');
    }


    public function store(Request $request)
    {
       if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
       }
        if(Auth::User()->cne!=NULL or Auth::User()->user_id=="2")
            {
            return response()->json([
                'error' => "Vous êtes un étudiant.\nC'est just pour les autres personnes"
            ], 422);
       }
       if(!in_array("MA",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
       $request->request->add(['user_id' => Auth::User()->id]);
        $path="";
        if(!is_null($request->attachement)){
            $filename=pathinfo($request->attachement->getClientOriginalName(),PATHINFO_FILENAME);
            $extention=pathinfo($request->attachement->getClientOriginalName(),PATHINFO_EXTENSION);
            $path = md5(time(). $filename).".".$extention;
            $path = request()->attachement->storeAs('attachements', $path);
           // $request->file()->fileName = $path;
        }
        //$request->attachement = $path;
        //dd($request->attachement);
        //dd($request);
        $data_validator = Validator::make($request->all(),
        [
            'title' => 'required|required|max:255|min:10',
            'type' => 'required|string',
            'role' =>'string|nullable',
            'content'=>'required|string',
            'attachement'=>'nullable|file|mimes:pdf,jpeg,jpg,png'
        ]);
        if ($data_validator->fails()) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
        if(!($ann = Announcement::create($request->all())))
            return response()->json([
                'error' => "Problème se produit dans l'insertion"
            ], 422);
        if(!is_null($path)){
            $announcement = Announcement::find($ann->id);
            $announcement->attachement = $path;
            $announcement->save();
        }
        $history = new HistoryController();
        $history->action("Ajout d'une annonce",$ann,NULL);
        return response()->json(["sucess"=>$ann,200]);
        //dd($data);
        //return redirect('announcement'); //($ann != null)? back()->with('success') : back()->with('failure');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        return view('announcement.show', compact('announcement'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        return view('announcement.edit', compact('announcement'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Announcement $announcement)
    {
        $old=$announcement;
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
       }
        if(Auth::User()->cne!=NULL)
            {
            return response()->json([
                'error' => "Vous êtes un étudiant.\nC'est just pour les autres personnes"
            ], 422);
       }
       if(!in_array("MA",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(Auth::User()->role_id!="3")
        {
            if($announcement->user_id!=Auth::User()->id)
            {
                return response()->json([
                    'error' => "Vous n'avez pas l'authorisation à cette action"
                ], 422);
            }
        }
       $request->request->add(['user_id' => Auth::User()->id]);
        $path="";
        $att=false;
        if(!is_null($request->attachement)){
            Storage::delete($announcement->attachement);
            $filename=pathinfo($request->attachement->getClientOriginalName(),PATHINFO_FILENAME);
            $extention=pathinfo($request->attachement->getClientOriginalName(),PATHINFO_EXTENSION);
            $path = md5(time(). $filename).".".$extention;
            $path = request()->attachement->storeAs('attachements', $path);
           // $request->file()->fileName = $path;
        }
        else
            $att=true;
        //$request->attachement = $path;
        //dd($request->attachement);
        //dd($request);
        $data_validator = Validator::make($request->all(),
        [
            'title' => 'required|required|max:255|min:10',
            'type' => 'required|string',
            'role' =>'string|nullable',
            'content'=>'required|string',
            'attachement'=>'nullable|file|mimes:pdf,jpeg,jpg,png'
        ]);
        if($att)
            $request->request->add(['attachement' => Announcement::find($request->id)->attachement]);
        if ($data_validator->fails()) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
        if(!($announcement->update($request->all())))
            return response()->json([
                'error' => "Problème se produit dans la modification"
            ], 422);
        if(isset($path)&&!is_null($path)&&$path!=""){
            $announcement = Announcement::find($request->id);
            $announcement->attachement = $path;
            $announcement->save();
        }
        $history = new HistoryController();
        $history->action("Modification d'une annonce",$announcement,$old);
       return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(!in_array("MA",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(Auth::User()->role_id!="3")
        {
            if($announcement->user_id!=Auth::User()->id)
            {
                return response()->json([
                    'error' => "Vous n'avez pas l'authorisation à cette action"
                ], 422);
            }
        }
        $history = new HistoryController();
        $history->action("Suppression d'une annonce",NULL,$announcement);
        Storage::delete($announcement->attachement);
        if(!$announcement->delete())
            return response()->json("undone");
        return response()->json("done");
    }

    /**
     * validates request data
     */

     public function validateInput(Request $request){
        return $request->validate([
            'user_id'=>'required|numeric',
            'title' => 'required|required|max:255|min:10',
            'type' => 'required|string',
            'role' =>'numeric|nullable',
            'content'=>'required|string',
            'attachement'=>'nullable|file|mimes:pdf,jpeg,jpg,png'
        ]);
     }

     public function download($attachement)
     {
        $cond=["role","=","0"];
        if(Auth::check())
        {
            $cond=["role","<=",Auth::User()->role_id];
        }
        $attachement=Announcement::select("attachement")->where([["id","=",$attachement],$cond])->first();
        if($attachement==NULL or !$attachement or empty((array)$attachement))
        {
            return response()->json([
                    'error' => "Vous n'avez pas l'authorisation à cette action"
                ], 422);
        }
        $history = new HistoryController();
        $history->action("Telechargment d'un attachement dans les annonces",NULL,NULL);
        return Storage::exists($attachement->attachement) ? Storage::download($attachement->attachement) : 'file does not exit';
       
    }
    
    public function getContentById($id)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
       }
        if(!in_array("MA",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data = DB::table("announcements")->select("user_id","content")->where("id","=",$id)->get();
        if(Auth::User()->role_id!="3")
        {
            if($data[0]->user_id!=Auth::User()->id)
            {
                return response()->json([
                    'error' => "Vous n'avez pas l'authorisation à cette action"
                ], 422);
            }
        }
        return $data[0]->content;
    }
    
    public function findById($id)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
       }
        if(!in_array("MA",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data = DB::table("announcements")->where("id","=",$id)->get();
        if(Auth::User()->role_id!="3")
        {
            if($data[0]->user_id!=Auth::User()->id)
            {
                return response()->json([
                    'error' => "Vous n'avez pas l'authorisation à cette action"
                ], 422);
            }
        }
        return json_encode($data[0]);
    }
    
    public function finyFromId(Request $request)
    {
        $id=$request->id;
        $cond=["role","=","0"];
        if(Auth::check())
        {
            $cond=["role","<=",Auth::User()->role_id];
        }
        $data = DB::table("announcements")->where([["id",">=",$id],["type","<>","concour"],["type","<>","resultatConcour"],$cond])->limit(10)->get();
        foreach($data as $key=>$val)
        {
            if($val->created_at==$val->updated_at)
                $val->time_label="Publiée en : ";
            else
                $val->time_label="Modifiée en : ";
            $val->publisher=User::find($val->user_id);
           if(!empty($val->attachement) or $val->attachement!=NULL){
               $val->fichier=new \stdClass();
                if(strpos($val->attachement,".png") or strpos($val->attachement,".jpg") or strpos($val->attachement,".jpeg"))
                    {$val->fichier->type="image";$val->fichier->src=url('storage/app/'.$val->attachement);}
                else if(strpos($val->attachement,".pdf"))
                    $val->fichier->type="pdf";
           }
        }
        return json_encode($data);
    }
    
    public function finyFromIdConcours(Request $request)
    {
        $cond=["role","=","0"];
        if(Auth::check())
        {
            $cond=["role","<=",Auth::User()->role_id];
        }
        $id=$request->id;
        $data = DB::table("announcements")->where([["id",">=",$id],["type","=","concour"],$cond])->limit(10)->get();
        foreach($data as $key=>$val)
        {
            if($val->created_at==$val->updated_at)
                $val->time_label="Publiée en : ";
            else
                $val->time_label="Modifiée en : ";
            $val->publisher=User::find($val->user_id);
           if(!empty($val->attachement) or $val->attachement!=NULL){
               $val->fichier=new \stdClass();
                if(strpos($val->attachement,".png") or strpos($val->attachement,".jpg") or strpos($val->attachement,".jpeg"))
                    {$val->fichier->type="image";$val->fichier->src=url('storage/app/'.$val->attachement);}
                else if(strpos($val->attachement,".pdf"))
                    $val->fichier->type="pdf";
           }
        }
        return json_encode($data);
    }
    
    public function finyFromIdResults(Request $request)
    {
        $id=$request->id;
        $cond=["role","=","0"];
        if(Auth::check())
        {
            $cond=["role","<=",Auth::User()->role_id];
        }
        $data = DB::table("announcements")->where([["id",">=",$id],["type","=","resultatConcour"],$cond])->limit(10)->get();
        foreach($data as $key=>$val)
        {
            if($val->created_at==$val->updated_at)
                $val->time_label="Publiée en : ";
            else
                $val->time_label="Modifiée en : ";
            $val->publisher=User::find($val->user_id);
           if(!empty($val->attachement) or $val->attachement!=NULL){
               $val->fichier=new \stdClass();
                if(strpos($val->attachement,".png") or strpos($val->attachement,".jpg") or strpos($val->attachement,".jpeg"))
                    {$val->fichier->type="image";$val->fichier->src=url('storage/app/'.$val->attachement);}
                else if(strpos($val->attachement,".pdf"))
                    $val->fichier->type="pdf";
           }
        }
        return json_encode($data);
    }
    
    public function showOne($id)
    {
        $cond=["role","=","0"];
        if(Auth::check())
        {
            $cond=["role","<=",Auth::User()->role_id];
        }
        $data = DB::table("announcements")->where([["id","=",$id],$cond])->get();
        $val=NULL;
        if(!empty($data)&&$data->count() > 0){
            $val=$data[0];
            if($val->created_at==$val->updated_at)
                $val->time_label="Publiée en : ";
            else
                $val->time_label="Modifiée en : ";
            $val->publisher=User::find($val->user_id);
           if(!empty($val->attachement) or $val->attachement!=NULL){
               $val->fichier=new \stdClass();
                if(strpos($val->attachement,".png") or strpos($val->attachement,".jpg") or strpos($val->attachement,".jpeg"))
                    {$val->fichier->type="image";$val->fichier->src=url('storage/app/'.$val->attachement);}
                else if(strpos($val->attachement,".pdf"))
                    $val->fichier->type="pdf";
           }
        }
        
        return view('announcement.showOne', compact('val'));
    }
}
