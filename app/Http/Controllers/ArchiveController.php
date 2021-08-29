<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;


class ArchiveController extends Controller
{
    //create a student archive
    
    public function storeStudentArchive($cne){
        
        $archives = Archive::select('*')->where('student', $cne)->get();
        ////if student speant more than 7 years
        if(count($archives) == 7){
            return response()->json(["error" => "impossible d'archiver l'etudient 7 fois."], 422);
        }
        
        if(count($archives) > 1){
            
            $i = array_fill(0, count($archives), 0);
            
            foreach($archives as $key => $value){
                $level = $value->level;
                $schoo_year = $value->school_year;
                $j = 0;
                foreach($archives as $k => $val){
                    //if student repeated a year more than two times
                    if($level == $val->level && $schoo_year != $val->school_year){
                        if($i[$j] == 2){
                            return response()->json(["error" => "impossible d'archiver l'etudient 3 dans le même niveau."], 422); 
                        }
                        $i[$j]++;
                    }
                    $j++; 
                }  
                              
            }
           
        }
        
        
        $student = Student::select('*')->where('cne', $cne)->get();
        if(count($student) != 0){
            Archive::insert([
                'student' => $student->first()->cne,
                'level' => $student->first()->level,
                'school_year' => date("Y-m-d h:m:i")
            ]);
        }
        
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
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function show(Archive $archive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function edit(Archive $archive)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Archive $archive)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archive $archive)
    {
        //
    }
}
