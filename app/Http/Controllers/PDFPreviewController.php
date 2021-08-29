<?php

namespace App\Http\Controllers;

use App\Models\PDFPreview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PDFPreviewController extends Controller
{
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
        if(!Auth::check()){
            return response()->json([
                'error' => "Vous n'êtes pas connecté"
            ], 422);
        }
        if(Auth::User()->cne==NULL)
            {
            return response()->json([
                'error' => "Vous n'êtes pas un étudiant."]);
        }
        if(PDFPreview::where("student","=",Auth::User()->cne)->where("course","=",$request->course)->first()==NULL){
        $request->request->add(["student"=>Auth::User()->cne]);
        if(!(PDFPreview::create($request->all())))
            return response()->json([
                'error' => "Problème se produit dans l'insertion"
            ], 422);}
        else{
            $view = PDFPreview::where("student","=",Auth::User()->cne)->where("course","=",$request->course)->first();
            if(!PDFPreview::where("student","=",Auth::User()->cne)->where("course","=",$request->course)->update(["updated_at"=>date('Y-m-d H:i:s')]))
                return response()->json([
                    'error' => "Problème se produit dans la modification"
                ], 422);
        }
        
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PDFPreview  $pDFPreview
     * @return \Illuminate\Http\Response
     */
    public function show(PDFPreview $pDFPreview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PDFPreview  $pDFPreview
     * @return \Illuminate\Http\Response
     */
    public function edit(PDFPreview $pDFPreview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PDFPreview  $pDFPreview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PDFPreview $pDFPreview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PDFPreview  $pDFPreview
     * @return \Illuminate\Http\Response
     */
    public function destroy(PDFPreview $pDFPreview)
    {
        //
    }
    
    public function countVisit($course)
    {
        $visits = PDFPreview::all()->where("course","=",$course);
        if($visits==NULL)
            return json_encode("0");
        else
            return json_encode($visits->count());
    }
}
