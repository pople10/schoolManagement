<?php

namespace App\Http\Controllers;


use App\Models\Faculty;
use Request;

class DepartementController extends Controller{
    
    public function departement(){
        $faculty = Faculty::all();
        return view('departement', compact('faculty'));
    }
    
}


?>