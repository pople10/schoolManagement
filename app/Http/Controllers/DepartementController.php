<?php

namespace App\Http\Controllers;

use App\Models\Faculty;

class DepartementController extends Controller{
    
    public function departement(){
        $faculty = Faculty::all();
        return view('departement', compact('faculty'));
    }
    
}


?>