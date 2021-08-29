<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use DB;
use File;
use Auth;
use App\Http\Controllers\HistoryController;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('filiere.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
       if(!in_array("MF",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $strmv=["de","et","a","à","ou","du"," ","l","d","le","la","les","des"];
         $table = [ 
        'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
        'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
        'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
        'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
        'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
        'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
        'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r'];
        
         if(!is_null($request['fil'])){
           $y=str_replace("l’","",strtolower($request['fil']));
           $y=str_replace("d’","",$y);
           $y=str_replace("l'","",$y);
           $y=str_replace("d'","",$y);
           
            $x=strtr($y,$table);
            $idp=explode(" ",$x);
            $id="";
            $nidp=[];
            foreach($idp as $v){
                if(!in_array($v,$strmv)){
                   $id.=strtoupper($v[0]);
                   array_push($nidp,$v);
                }
            }
            $i=1;
            $k=1;
            while( sizeof(DB::table('faculties')->where('code',"=",$id)->get())!=0){
                $id="";
                $j=0;
                $m=sizeof($nidp);
                foreach($nidp as $ip){
                    
                        $id.=strtoupper( $ip[0]);
                        if( $i>=$j && $j>0){
                            for($s=1;$s<=$k;$s++)
                            if($k<strlen($ip)){ $id.=strtoupper($ip[$s]);}
                        }
                        
                    $j++;
                }
                if($i<$m)
                    $i++;
                if($i===$m) {$i=1;$k++;}
            }
            $url=NULL;
            if($request->hasFile('img')){
                $file=$request->file('img');
                $filename="";
                $pS="/storage/Filieres";
                $p= public_path($pS);
                if (!File::isDirectory($p)) {
                    File::makeDirectory($p, 0777, true);
                }
                $filename=$id.".".$file->getClientOriginalExtension();
                $path=$request->img->move($p,$filename);
                $url="/public".$pS."/".$filename;}
                
            DB::table('faculties')->insert([
                'code'=>$id,
                'label'=>$request['fil'],
                'description'=>$request['desc'],
                'logo_url'=>$url
                ]);
        $onetothre=['Première année','Deuxième année','Troisième année'];
        for($i=0;$i<3;$i++){
            $ind=$i+1;
             DB::table('levels')->insert([
                'id'=>$id.$ind,
                'faculty'=>$id,
                'label'=>$onetothre[$i]." ".strtolower($request['fil']),
                'cycle'=>"Cycle d'ingénieur"
                ]);
        }
            $history = new HistoryController();
            $history->action("Ajout d'une filliere",NULL,NULL);
            return response()->json(true,200);

        }
    return response()->json(false,200);
    }


    public function GetAllJson(Faculty $faculty)
    {
      return  Faculty::all();
    }

    public function delete(Request $request,$f)
    {   

        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
       }
       if(!in_array("MF",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(!is_null($f)){
        for($i=0;$i<3;$i++){
             DB::table('levels')->where('faculty',"=",$f)->delete();
        }
         
        $c=Faculty::where('code',"=",$f);
        $url=$c->first();
        $url=$url['logo_url'];
        $c->delete();
        if($url!=null){
            if(file_exists('.'.$url)) unlink('.'.$url);
        }
        $history = new HistoryController();
        $history->action("Supression d'une filliere numero ".$f,NULL,NULL);
        return response()->json(true,200);
        }
        return response()->json(false,200);


    }


    public function update(Request $request,$f)
    {

        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
       }
       if(!in_array("MF",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        if(!is_null($request['fil']))
        {
            
            
            $url=DB::table('faculties')->where('code','=',$f)->first()->logo_url;
            if($request->hasFile('img')){
                $file=$request->file('img');
                $filename="";
                $pS="/storage/Filieres";
                $p= public_path($pS);
                if (!File::isDirectory($p)) {
                    File::makeDirectory($p, 0777, true);
                }
                $filename=$f.".".$file->getClientOriginalExtension();
                $path=$request->img->move($p,$filename);
                $url="/public".$pS."/".$filename;
                
            }
                
                DB::table('faculties')->where('code','=',$f)->update([
                'label'=>$request['fil'],
                'description'=>$request['desc'],
                'logo_url'=>$url
                ]);
                $history = new HistoryController();
                $history->action("Modification d'une fillire numero ".$f,NULL,NULL);
            return response()->json(true,200);
            

        }
       return response()->json(false,200);
        
    }
}
