<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MarkController;
use App\Models\Student;


class UserController extends Controller
{
    //validate data
    protected function validateInput(){
        //return input
        return request()->validate([
            'fname'=>'required|string|max:60',
            'lname'=>'required|string|max:60',
            'email'=>'required|email|max:60',
            'password'=>'required|string|max:60', 
            'password_confirm'=>'required|same:password',
            'vkey'=>'required|string',
            'role_id'=>'nullable',
            'matricule'=>'required|srting',
            'phd'=>'string|nullable',
            'cne'=>'string|nullable|max:12|min:7',
            'cin'=>'required|string|max:7|min:5',
            'adress'=>'required|string|min:60|max:60',
            'telephone'=>'required|string|min:10|max:10',
            'verified'=>'required|numeric',
            'sexe'=>'string|required',
            'photo_path'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    }
    
    
    
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
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = time().'.'.$request->photo_path->extension();  

        $request->photo_path->move(public_path('images'), $imageName);
        $request->image->storeAs('images', $imageName);
        
        $request->password = Hash::make($request->password);
        
        $user = User::create($this->validateInput());
        
        
        if($user !=  null){
            return back()->with('success');    
        }else{
            return back()->with('failure');
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }
    
    public function gestion(){
        if(auth()->check()){
            if(in_array("MA",Auth::User()->prv)){ //don't forget to change it to admin
                return view('gestion-user.index');
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/');
        }
    }
    
    public function users(){
        if(auth()->check()){
            if(in_array("MA",Auth::User()->prv)){ //don't forget to change it to admin
                $users = User::select('id', 'fname', 'lname', 'cne', 'verified', 'role_id', 'email')->where("role_id", "<>",  "12")->get();
                return json_encode($users);
            }else{
                response()->json(["error"=>"permission rejéter"], 422);
            }
        }else{
            response()->json(["error"=>"Vous n'êtes pas connecter"], 422);
        }
    }
    
    /*tayeb--- verify user*/
    public function verify(User $user){
        if(auth()->check()){
            if(in_array("MA",Auth::User()->prv)){//rememeber to change the role for only admin
                if($user->verified==1 or $user->verified=="1")
                    return response()->json(["error"=>"Déja verifié"], 422);
                $user->update(["verified"=>"1"]);
                $emailController = new EmailController();
                $genSex = ($user->sexe=="M"?"monsieur":"madamme");
                if($user->sexe===NULL) $genSex="";
                $msg="<br>Bonjour ".$genSex." ".$user->lname." ".$user->fname.",<br>Votre compte dans l'ensah est vérifié maintenant.<br>Vous pouvez consulter notre service <a href='".url("/Dashbord")."'>En cliquant ICI</a>";
                $emailController->sendMessage($msg,"Votre compte a été vérifié avec success ✔️✔️",$user->email);
            }else{
                response()->json(["error"=>"permission rejéter"], 422);
            }
        }else{
            response()->json(["error"=>"Vous n'êtes pas connecter"], 422);
        }
        
    }
    
    public function reinstatePassword(Request $request, User $user){
        if(!empty($pwd)){
            $pwd = Hash::make($request->pwd);    
        }
        
        if(auth()->check()){
            if(in_array("MA",Auth::User()->prv)){//rememeber to change the role for only admin
                if(empty($pwd)){
                    $user->update(["email"=>$request->email]);  
                }else if(empty($request->email)){
                    $user->update(["password"=>"$pwd"]); 
                }else{
                    $user->update(["password"=>"$pwd", "email"=>$request->email]); 
                }
                $emailController = new EmailController();
                $genSex = ($user->sexe=="M"?"Monsieur":"Madamme");
                if($user->sexe===NULL) $genSex="";
                $msg="<br>Bonjour ".$genSex." ".$user->lname." ".$user->fname.",<br>Votre compte dans l'ensah est changé.<br>Si vous n'êtes pas le responsable <a href='".url("/contact")."'>contactez-nous</a>";
                $emailController->sendMessage($msg,"Votre compte a été changé avec success",$user->email);
                return response()->json();
            }else{
                response()->json(["error"=>"permission rejéter"], 422);
            }
        }else{
            response()->json(["error"=>"Vous n'êtes pas connecter"], 422);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json();
    }
    
    public function getProf(){
        $role = 2;
        return json_encode($users = DB::table('users')
        ->select('id', 'fname', 'lname','cin')
        ->when($role, function ($query) {
            return $query->where('role_id', 2);
        })
        ->get());;
    }
    public function getUserProfile(){
        $data=[];
        $user=DB::table('users')->select('id', 'fname', 'lname','cne','cin','role_id','matricule','phd','adress','email','telephone','sexe','photo_path')->where('id','=',Auth::user()->id)->first();
        $data['fname']=$user->fname;
        $data['lname']=$user->lname;
        $data['adress']=$user->adress;
        $data['telephone']=$user->telephone;
        $data['sexe']=$user->sexe;
        $data['photo_path']=$user->photo_path;
        $data['cin']=$user->cin;
        $data['email']=$user->email;

        if($user->cne!=null){
            $data['cne']=$user->cne;
            $student=DB::table('students')->where('cne','=',$user->cne)->first();
            $data['level']=DB::table('levels')->where('id','=',$student->level)->first()->label;
            $data['bac_type']=$student->bac_type ;
            $data['bac_mark']=$student->bac_mark ;
            $data['role']="Eleve";
        }
        else{
            if($user->phd!=NULL){
                $phds=DB::table('phds')->where('id','=',$user->phd)->first();
                $data['subject']=$phds->subject ;
                $data['date_start']=$phds->date_start ;
                $data['bac_mark']=$phds->date_end ;
                $data['role']="Professeur";

            }
            else $data['role']=DB::table('roles')->where('id','=',$user->role_id)->first()->label;

        }

        return json_encode($data);
    }

    
    public function DecisionAvancement($cne){
        
        $mark = new MarkController();
        //get total mark
        $note = $mark->getNoteTotal($cne);
        //get student level
        $level_object = Student::select('level')->where('cne', $cne)->get();
        //get the string
        $level_1 = $level_object->first()->level;
        //get the first letters CP1 ==> CP
        $level = $level_1[0].$level_1[1];
        
        
        if($level == "CP"){
            if($note >= 10){
                //we need cne and current cycle level 1,2,3
                $this->LevelUp($cne, $level_1);        
            }else{
                //same thing
                $this->Ajourner($cne, $level_1);
            }
            
        }elseif($level[0] == "G"){
            if($note >= 12){
                $this->LevelUp($cne, $level_1);
            }else{
                $this->Ajourner($cne, $level_1);
            }
        }
                        
        
    }
    
    public function LeveLUp($cne, $level){
        if($level[0].$level[1] == "CP"){
            if($level[2] == 1){
                //update level
                Student::where('cne', $cne)->update(['level'=>$level[0].$level[1].($level[2]+1)]);
            }elseif($level[2] == 2){
                return response()->json(["error" => "L'étudiant n'a pas confirmé sont choix!"], 405);
            }
        }elseif($level[0] == "G"){
            if($level[2] == 3){
                //change level to grad
                User::where('cne', $cne)->update(['level'=>'Grad']);
            }
            else{
                Student::where('cne', $cne)->update(['level'=>$level[0].$level[1].($level[2]+1)]);
            }
            return response()->json();
            
        }
    }
    
    public function Ajourner($cne, $level){
            $ajr = Student::select('ajourner')->where('cne', $cne)->get();
            $ajr = $ajr->first()->ajourner;
            
            
            
            if($ajr == 0){
                //increment
                Student::where('cne', $cne)->update(["ajourner"=>8]);
            }elseif($ajr == 1){
                Student::where('cne', $cne)->update(["ajourner"=>++$ajr]);
            }elseif($ajr == 2){
                //fail hhhhhhh mout
                Student::where('cne', $cne)->update(["level"=>"Ajourner"]);
            }
    }
    
    
}





