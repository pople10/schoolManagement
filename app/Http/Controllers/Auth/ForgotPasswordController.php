<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{

    use SendsPasswordResetEmails;
    
    public function indexForget()
    {
        if(Auth::check())
            return redirect("/");
        return view("auth.passwords.reset");
    }
    
    public function reset(Request $request)
    {
        if(Auth::check())
            return redirect("/");
        $emailController = new EmailController();
        $message="";
        if(!$emailController->isEmail($request->email))
        {
            $message="<div class='alert alert-danger'>Email format est incorrect.</div>";
            return view("auth.passwords.reset",compact("message"));
        }
        $user = User::where('email','=',$request->email)->first();
        if($user == NULL)
        {
            $message="<div class='alert alert-danger'>Email n'existe pas dans notre base de données.</div>";
            return view("auth.passwords.reset",compact("message"));
        }
        $body = "<div>Bonjour ".$user->lname." ".$user->fname.",<br>Voici votre lien pour réinstialiser. </div>
        <a href='".url('/forget/'.$user->vkey)."' style='text-decoration: none;'>Réintialiser</a>";
        if(!($emailController->sendMessage($body,"ENSAH : Reinstialisation du mot de passe",$request->email)))
        {
            $message="<div class='alert alert-danger'>Email ne peut pas être envoyé.</div>";
            return view("auth.passwords.reset",compact("message"));
        }
        $message="<div class='alert alert-success'>Email de réinstialisation a été envoyé. <br>Vous pouvez vérifie SPAM dossier.</div>";
        return view("auth.passwords.reset",compact("message"));
        
    }
    
    public function indexChange($vkey)
    {
        $user = User::where('vkey','=',$vkey)->first();
        if($user == NULL)
            return redirect('/');
        return view("auth.passwords.resetPassword",compact("user"));
    }
    
    public function changePass(Request $request,$vkey)
    {
        $user = User::where(['vkey'=>$vkey,'id'=>$request->user_id])->first();
        if($user == NULL)
            return redirect('/');
        if(strlen($request->newpass)<8)
        {
            $user->message="<div class='bootstrap'><div class='alert alert-danger'>Mot de passe très petit (8 charactère au moins).</div></div>";
            return view("auth.passwords.resetPassword",compact("user"));
        }
        $user->vkey=md5($user->cin.$user->id.time());
        $user->password=Hash::make($request->newpass);
        $email = $user->email;
        if(!$user->save())
        {
            $user->message="<div class='bootstrap'><div class='alert alert-danger'>Le mot de passe ne peut pas être changé.</div></div>";
            return view("auth.passwords.resetPassword",compact("user"));
        }
        $emailController = new EmailController();
        $body = "<div>Bonjour ".$user->lname." ".$user->fname.",<br>Votre mot de passe à été changé. Si vous n'êtes pas le responsable à cet action, contactez-nous!</div>
        <a href='".url('/contact')."' style='text-decoration: none;'>Cliquer ici</a>";
        $emailController->sendMessage($body,"ENSAH : Mot de passe changé",$email);
        return redirect('/login');
    }
}
