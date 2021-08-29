<?php

namespace App\Http\Controllers;

use App\Models\RequestType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class RequestTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->check()){
            if(auth()->user()->role_id == 1){
                return view('request-type.index');   
            }else{
                return redirect('/');
            }
        }else{
            return redirect('/login');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request-type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $data = $request->all();
 
        $valid = Validator::make($data,
            [
                'label' => 'string|required',
                'min_duration' => 'numeric|required'
            ]
        );
        
        if($valid->fails()){
            return resposne()->json(["error" => "les champs sont incorrectes!"],422);
        }
        
        if(!($rt = RequestType::create($data))){
            return response()->json(['error' => "error dans l'insertion"]);
        }
        
        return response()->json();    
    }
    
    public function getData(){
        return RequestType::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RequestType  $requestType
     * @return \Illuminate\Http\Response
     */
    public function show(RequestType $requestType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestType  $requestType
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestType $requestType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestType  $requestType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestType $requestType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestType  $requestType
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestType $requestType)
    {
        $requestType->delete();
        return response()->json();
    }
}

