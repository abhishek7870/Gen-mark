<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;
use Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::all();
        //return response()->json($company);
         return response()->json($company->load('dealers'),200);
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
        $validation = Validator::make($request->all(),[
            "key" => "required",
            "company_code" => "required",
            "name" => "required",
            "api_url" => "required",
            "sms_registration_url" => "required",
            "sms_verification_url" => "required",
            "dealer_verification_url" => "required",
            "dealer_registration_url" => "required",
            "image" => "required"
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
            return response()->json($errors,400);
        }

        $temp = downloadImageAndSave($request->all());
        $request['image_name'] = $temp['image_name'];
        $request['image_url'] = $temp['image_url'];
        $company = Company::create($request->all());
        return response()->json($company,201);
    }
    public function companyDealer(Request $request,$id) 
    { 
        //dd($request->all());
        $company = Company::find($id);  
         //dd($company);
       $temp['dealer_id'] = $request['dealer_id'];
       $temp['company_id'] =  $company->id;
       // dd($temp);
       // $temp['company_delaer_id'] = $request['company_delaer_id'];
       $company->dealers()->sync($temp);
           return response()->json($company->load('dealers'),201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
