<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
set_time_limit(0);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\Xmlapi;
use DB;
use Auth;
use App\Models\Level;
use App\Models\Student;
use App\Models\User;

require 'vendor/phpmailer/phpmailer/src/Exception.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

        
class EmailController extends Controller
{
    private $mail;
    
    public function __construct()
    {
        
        $this->mail =  new PHPMailer();
    }
    
    public function isEmail($email)
    {
        return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
    }
    
    public function contact_us(Request $request)
    {
        $this->mail =  new PHPMailer();
        $data_validator = Validator::make($request->all(),
        [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' =>'required|email',
            'subject'=>'required|string',
            'message'=>'required|string'
        ]);
        if ($data_validator->fails() or !$this->isEmail($request->email)) {
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n".$data_validator->errors()->first().(($this->isEmail($request->email))?"":"\nL'email est incorrect.")
            ], 422);
        }
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host       = 'premium36.web-hosting.com';    
        $this->mail->SMTPAuth   = true;    
        $this->mail->Username   = 'noreply@ensah.trackiness.com';   
        $this->mail->Password   = '@WT*6FA&p{G7';   
        $this->mail->SMTPSecure = 'ssl';     
        $this->mail->Port       = 465;  
        
        $this->mail->setFrom('noreply@ensah.trackiness.com', 'ENSAH');        
        $this->mail->addAddress('support@ensah.trackiness.com');   
        $this->mail->AddReplyTo($request->email, $request->firstname." ".$request->lastname);
        
        $body=file_get_contents(url('resources/emailTemplate/contactus.html'));
        
        $body=str_replace("***Name***",$request->firstname." ".$request->lastname,$body);
        $body=str_replace("***Email***",$request->email,$body);
        $body=str_replace("***Subject***",$request->subject,$body);
        $body=str_replace("***Message***",$request->message,$body);
        
        $this->mail->isHTML(true);                                  
        $this->mail->Subject = 'Nouveau message : '.$request->subject;
        $this->mail->Body    = $body;
        try{
            $this->mail->send();
            $this->message_received($request);
            return response()->json("sent");
        }
        catch(Exception  $e){
            return response()->json([
                'error' => "Nous pouvons pas envoyer l'email"
            ], 422);
            
        }
    }
    
    public function message_received(Request $request)
    {
        $this->mail =  new PHPMailer();
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host       = 'premium36.web-hosting.com';   
        $this->mail->SMTPAuth   = true;    
        $this->mail->Username   = 'noreply@ensah.trackiness.com';   
        $this->mail->Password   = '@WT*6FA&p{G7';   
        $this->mail->SMTPSecure = 'ssl';     
        $this->mail->Port       = 465;  
        
        $this->mail->setFrom('noreply@ensah.trackiness.com', 'ENSAH');        
        $this->mail->addAddress($request->email);   
        
        $body=file_get_contents(url('resources/emailTemplate/wellreceived.html'));
        
        $body=str_replace("***NAME***",$request->firstname." ".$request->lastname,$body);
        
        $this->mail->isHTML(true);                                  
        $this->mail->Subject = 'ENSAH : Reception du message';
        $this->mail->Body    = $body;
        try{
            $this->mail->send();
        }
        catch(Exception  $e){
            
        }
    }
    
    public function sendMessage($message,$subject,$email)
    {
        $this->mail =  new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host       = 'premium36.web-hosting.com';   
        $this->mail->SMTPAuth   = true;    
        $this->mail->Username   = 'noreply@ensah.trackiness.com';   
        $this->mail->Password   = '@WT*6FA&p{G7';   
        $this->mail->SMTPSecure = 'ssl';     
        $this->mail->Port       = 465;  
        
        $this->mail->setFrom('noreply@ensah.trackiness.com', 'ENSAH');        
        $this->mail->addAddress($email);   
        
        $body=file_get_contents(url('resources/emailTemplate/global.html'));
        
        $body=str_replace("**message**",$message,$body);
        
        $this->mail->isHTML(true);                                  
        $this->mail->Subject = $subject;
        $this->mail->Body    = $body;
        try{
            $this->mail->send();
            return true;
        }
        catch(Exception  $e){
            return false;
        }
    }
    
    public function sendMessageArray($message,$subject,$emails)
    {
        $this->mail =  new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host       = 'premium36.web-hosting.com';   
        $this->mail->SMTPAuth   = true;    
        $this->mail->Username   = 'noreply@ensah.trackiness.com';   
        $this->mail->Password   = '@WT*6FA&p{G7';   
        $this->mail->SMTPSecure = 'ssl';     
        $this->mail->Port       = 465;  
        
        $this->mail->setFrom('noreply@ensah.trackiness.com', 'ENSAH');
        foreach($emails as $email)
        {
            $this->mail->addAddress($email); 
        }
        
        $body=file_get_contents(url('resources/emailTemplate/global.html'));
        
        $body=str_replace("**message**",$message,$body);
        
        $this->mail->isHTML(true);                                  
        $this->mail->Subject = $subject;
        $this->mail->Body    = $body;
        try{
            $this->mail->send();
            return true;
        }
        catch(Exception  $e)
        {
            return false;
        }
    }
    
    public function createAccount(Request $request)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connécté"
            ], 422);
        }
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(count(DB::table("emails")->where("user_id","=",Auth::User()->id)->get())>0)
            return response()->json([
                'error' => "Vous avez le droit d'un seule compte"
            ], 422);
        if(!DB::table("emails")->insert(["user_id"=>Auth::User()->id,"user"=>$request->user,"password"=>$request->password]))
            return response()->json([
                'error' => "Quelque chose ne nous permet pas de créer un compte\nAvez vous un compte?"
            ], 422);
        $ip = "198.54.114.237";            // should be server IP address or 127.0.0.1 if local server
        $cred = require "app/Http/Controllers/credentials.php";
        $account = $cred[0];        // cpanel user account name
        $passwd =$cred[1];          // cpanel user password
        $port =2083;                  // cpanel secure authentication port unsecure port# 2082
        $email_domain = $_SERVER["SERVER_NAME"];
        $email_user = $request->user;
        $email_pass = $request->password;
        $email_quota = 0;             // 0 is no quota, or set a number in mb
        
        $xmlapi = new xmlapi($ip);
        $xmlapi->set_port($port);     //set port number.
        $xmlapi->password_auth($account, $passwd);
        $xmlapi->set_output('json');
        $xmlapi->set_debug(1);        //output to error file  set to 1 to see error_log.
        
        $call = array("domain"=>$email_domain, "email"=>$email_user, "password"=>$email_pass, "quota"=>$email_quota);
        $result = $xmlapi->api2_query($account, "Email", "addpop", $call );
        
        if(isset(json_decode($result)->cpanelresult->error) and json_decode($result)->cpanelresult->error!=""){               
                 DB::table("emails")->where("user_id","=",Auth::User()->id)->delete();         
        }
        
        return json_encode($result);            //show the result of your query
    }
    
    public function sendEmailCustomArray($message,$subject,$emails)
    {
        $data = DB::table("emails")->where("user_id","=",Auth::User()->id)->get();
        if(count($data)==0)
            return response()->json([
                'error' => "Vous avez aucune compte\nVeuillez ajouter un email"
            ], 422);
        $this->mail =  new PHPMailer();
        $this->mail->isSMTP();
        $this->mail->CharSet = 'UTF-8';
        $this->mail->Host       = 'premium36.web-hosting.com';   
        $this->mail->SMTPAuth   = true;    
        $this->mail->Username   = $data[0]->user."@".$_SERVER["SERVER_NAME"];   
        $this->mail->Password   = $data[0]->password;   
        $this->mail->SMTPSecure = 'ssl';     
        $this->mail->Port       = 465;  
        
        $this->mail->setFrom($data[0]->user."@".$_SERVER["SERVER_NAME"], "ENSAH");
        
        foreach($emails as $email)
        {
            $this->mail->addAddress($email); 
        }
        
        $body=file_get_contents(url('resources/emailTemplate/global.html'));
        
        $body=str_replace("**message**",$message,$body);
        
        $this->mail->isHTML(true);                                  
        $this->mail->Subject = $subject;
        $this->mail->Body    = $body;
        try{
            $this->mail->send();
            return true;
        }
        catch(Exception  $e)
        {
            return false;
        }
    }
    
    public function getSendEmailsView()
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connécté"
            ], 422);
        }
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data = DB::table("emails")->where("user_id","=",Auth::User()->id)->get();
        $data->levels = Level::all();
        return view("emails.index",compact("data"));
    }
     public function getSendEmailsViewapi()
    {
       if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connécté"
            ], 422);
        }
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $x=[];
        $x[0] = DB::table("emails")->where("user_id","=",Auth::User()->id)->get();
        $x[1] = Level::all();
        
        return json_encode($x);
    }
    public function sendMessagePromos(Request $req)
    {
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connécté"
            ], 422);
        }
        if(!in_array("ME",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $data = DB::table("emails")->where("user_id","=",Auth::User()->id)->get();
        if(count($data)==0)
            return response()->json([
                'error' => "Vous avez aucune compte\nVeuillez ajouter un email"
            ], 422);
        $emails = array();
        $std = Student::all()->where("level","=",$req->level);
        foreach($std as $val)
        {
            $emails[]=User::all()->where("cne","=",$val->cne)->first()->email;
        }
        if(!$this->sendEmailCustomArray($req->msg,'ENSAH message par : '.Auth::User()->fname." ".Auth::User()->lname,$emails))
            return response()->json([
                'error' => "Erreur quelque part"
            ], 422);
        return response()->json();
    }
}
