<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Module;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Http\Controllers\HistoryController;

class LibraryController extends Controller
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
    
    public function data(){
        $library = Library::all();
        return json_encode($library);
    } 
     
     
    public function index()
    {
        $library = Library::all();
        return view('library.index', compact('library'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $module = Module::select('code','label')->get();
        return view('library.create', compact('module'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!in_array("ML",Auth::User()->prv)){
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $id = Library::select('*')->where('id', $request->id)->get();
        if(count($id) > 0){
            return response()->json([
                'error' => "Ce ISBN deja existe dans la base de donné"
            ], 422);
        }
        
        $valid = Validator::make($request->all(),[
            'id' => 'required|string|nullable',
            'title' => 'required|string',
            'author' => 'required|string',
            'type' => 'required|string',
            'available' => 'required|boolean',
        ]);
        
        if($valid->fails()){
            return response()->json([
                'error' => "Les champs ne sont pas corrects\n". $data_validator->errors()->first()
            ], 422);
        }
        
        if(!($book = Library::create($request->all()))){
            return response()->json([
                'error' => "Error dans l'insertion des champs"
            ], 422);            
        }
        $history = new HistoryController();
        $history->action("Ajout d'un livre dans bibliothèque",$book,NULL);
        return response()->json();
        
    }
    
    public function getData(){
        return json_encode(Library::select('id', 'title', 'author', 'type', 'available')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('library.table');
    }
    
    public function reserve(Request $request){
        if(!in_array("CL",Auth::User()->prv))
        {
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $available = Library::select('available')->where('id', $request->id)->get();
        $taken = Library::all()->where("taken_by","=",Auth::User()->cne)->count();
        if($taken>0)
        {
            return response()->json([
                "error"=>"Vous avez déja reservé un livre",    
            ], 422); 
        }
        if(count($available) == 0){
            return response()->json([
                "error"=>"Erreur de securité",    
            ], 422);
        }
        
        if($available->first()->available == 0){
            return response()->json([
                "error"=>"Erreur de securité - non disponoble",    
            ], 422);            
        }
        else if($available->first()->available == 1){
            if(!($lib = Library::where('id', $request->id)->update(['taken_by'=>auth()->user()->cne, 'available' => 0]))){
                return response()->json([
                    "error"=>"Erreur d'insertion",    
                ], 422); 
            }
        }
        $history = new HistoryController();
        $history->action("Reservation d'un livre dans bibliothèque numero".$request->id,NULL,NULL);
        return response()->json();
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function edit(Library $library)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!in_array("ML",Auth::User()->prv))
        {
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
       if(!empty($request->student)){
            $student = Student::select()->where('cne', $request->student)->get();
            if(count($student) == 0){
                return response()->json(["error"=>$request->student." n'est pas un étudiant"], 422);
            }
            Library::where('id', $request->id)->update(['taken_by' => $request->student, 'available' => '0']);
       }else{
            Library::where('id', $request->id)->update(['taken_by' => $request->student, 'available' => '1']);        
       }
       
       $history = new HistoryController();
    $history->action("Modification d'un livre dans bibliothèque numero ".$request->id,NULL,NULL);
       return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Library  $library
     * @return \Illuminate\Http\Response
     */
    public function destroy(Library $library)
    {
        if(!in_array("ML",Auth::User()->prv))
        {
            return response()->json([
                'error' => "Vous n'avez pas l'authorisation à cette action"
            ], 422);
        }
        $history = new HistoryController();
        $history->action("Suppression d'un livre dans bibliothèque ",NULL,$library);
        $library->delete();
        return response()->json();
    }
}
