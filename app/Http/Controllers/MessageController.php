<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use DB;
use Auth;
class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware("auth");
    }
    
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
    }
    public function getConversationbyId(Request $request)
    {
        $data=[];
        $chat_id=$request->users;
        $users=[Auth::user()->id];

        $chat=DB::table('chats')->where('id','=',$chat_id)->get()[0];
        $x=[];
        $x=str_replace('[','',$chat->User);
        $x=str_replace(']','',$x);
        $x=str_replace('"','',$x);
        $x=explode(',',$x);
       
        $vv="";
        if(array_diff($x,$users )==[])$vv=$users[0];
        else $vv=array_values(array_diff($x,$users ))[0];
        $name="";
        $u=DB::table('users')->select('fname','lname','photo_path')->where("id","=",$vv)->get()[0];
        $name=$u->lname." ".$u->fname;
        $img=$u->photo_path;
        $data['id']=$chat->id;
        $data['message']=DB::table('messages')->where("chats","=",$chat_id)->get();   
        DB::table('messages')->where("chats","=",$chat_id)->where("seen","=",NULL)->where("user","<>",Auth::user()->id)->update(['seen'=>"1"]);

        $data['name']=$chat->name===NULL?$name:$chat->name;
        $data['image']=$img;

        return json_encode($data);
    }

    public function getConversation(Request $request)
    {
        $data=[];
        $users=[intval($request->users),Auth::user()->id];
        $name="";
        $img=NULL;
        if(count($users)===2){
            $u=DB::table('users')->select('fname','lname','photo_path')->where("id","=",intval($request->users))->get()[0];
            $name=$u->lname." ".$u->fname;
            $img=$u->photo_path;
        }
        $chat=DB::table('chats')->get();
        
        foreach ($chat as $key => $ch) {
            $x=[];
            $x=str_replace('[','',$ch->User);
            $x=str_replace(']','',$x);
            $x=str_replace('"','',$x);
            $x=explode(',',$x);
          if(array_diff($x,$users )==NULL){
            $data['id']=$ch->id;
            $data['message']=DB::table('messages')->where("chats","=",$ch->id)->get();     
            $data['name']=$ch->name===NULL?$name:$ch->name;
            $data['image']=$img;
            break;
          }
        }
        if($data===[])
           { $data['name']=$name;
            $data['id']=null;
            $data['image']=$img;
        }

        return json_encode($data);
    }
    
   
    public function getConversationList(Request $request)
    {
        $data=[];
        $users=[Auth::user()->id];
        $name="";
        $img=NULL;
        
        $chat=DB::table('chats')->get();

        foreach ($chat as $key => $ch) {
            $data1=[];
            $x=[];
            $x=str_replace('[','',$ch->User);
            $x=str_replace(']','',$x);
            $x=str_replace('"','',$x);
            $x=explode(',',$x);
          if(in_array(Auth::user()->id,$x )){
              $vv="";

            if(array_diff($x,$users )==[])$vv=$users[0];
            else $vv=array_values(array_diff($x,$users ))[0];
            $u=DB::table('users')->select('fname','lname','photo_path')->where("id","=",$vv)->get()[0];
            $name=$u->lname." ".$u->fname;
            $img=$u->photo_path;
            $data1['id']=$ch->id;
            $data1['message']=DB::table('messages')->where("chats","=",$ch->id)->orderBy('id', 'desc')->first()->data;     
            $data1['name']=$ch->name===NULL?$name:$ch->name;
            $data1['image']=$img;
            
            $data1['not_seen']=DB::table('messages')->where("chats","=",$ch->id)->where("seen","=",NULL)->where("user","<>",Auth::user()->id)->count();
            array_push($data,$data1);
          }
        }
        return  response()->json($data,200);

    }

    public function SendMessage(Request $request){
        $id_chats=$request->chats_id;
        if($request->data!==null)
        {
            if($id_chats==NULL){
            $data=[];
            $name="";
            $users=[intval($request->user_id),Auth::user()->id];
            $chat=DB::table('chats')->get();
            foreach ($chat as $key => $ch) {
                $x=[];
                $x=str_replace('[','',$ch->User);
                $x=str_replace(']','',$x);
                $x=str_replace('"','',$x);
                $x=explode(',',$x);
              if(array_diff($x,$users )==NULL){
                $data['id']=$ch->id;
                $data['message']=DB::table('messages')->where("chats","=",$ch->id)->get();     
                $data['name']=$ch->name===NULL?$name:$ch->name;
                break;
              }
            }
            if($data==[])
            {$id_chats = DB::table('chats')->insertGetId(
               ['User' => json_encode($users)]
            );}
            else $id_chats=$data['id'];
        }
        DB::table('messages')->insert([
            'chats'=>$id_chats,
            'user'=>Auth::user()->id,
            'type'=>$request->type,
            'data'=>$request->data,
            'date'=>$request->date,
        ]);
        DB::table('messages')->where("chats","=",$id_chats)->where("seen","=",NULL)->where("user","<>",Auth::user()->id)->update(['seen'=>"1"]);

        return json_encode($id_chats);
        }
        return json_encode(false);
    }

    public function getUsers()
    {
        return json_encode(DB::table('users')->select('id','fname','lname','photo_path','role_id')->where('id','<>',Auth::user()->id)->get());
    }
    public function getId()
    {
        return json_encode(Auth::user()->id);
    }
    
    public function getSEen()
    {
        
        return json_encode(DB::table("messages AS m")->where([["m.seen","=",NULL],["m.user","<>",Auth::User()->id]])->where("c.User","LIKE","%,".Auth::User()->id."]")
        ->orWhere([["c.User","LIKE","[".Auth::User()->id.",%"],["m.seen","=",NULL],["m.user","<>",Auth::User()->id]])->join("chats AS c","m.chats","=","c.id")->count());
        /*$xx=0;
        $data=[];
        $users=[Auth::user()->id];
        $name="";
        $img=NULL;
        
        $chat=DB::table('chats')->get();

        foreach ($chat as $key => $ch) {
            $data1=[];
            $x=[];
            $x=str_replace('[','',$ch->User);
            $x=str_replace(']','',$x);
            $x=str_replace('"','',$x);
            $x=explode(',',$x);
          if(in_array(Auth::user()->id,$x )){
             
            
          $xx+=DB::table('messages')->where("chats","=",$ch->id)->where("seen","=",NULL)->where("user","<>",Auth::user()->id)->count();
          }
        }

        return json_encode($xx);*/
    }
    public function getRoleId()
    {
        return json_encode(Auth::user()->role_id);
    }
    public function getPathimg()
    {
        return json_encode(Auth::user()->photo_path);
    }
}
