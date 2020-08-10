<?php

namespace App\Http\Controllers;

use App\State;
use Illuminate\Http\Request;
use Validator;
class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states = State::all();
        return response()->json($states,200);
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
           'state_name' => 'required|max:50'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
        }
        $state = State::create($request->all());
        return response()->json($state,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd("njhjjk");   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        
         $validation = Validator::make($request->all(),[
           'state_name' => 'required|max:50'
        ]);
        if($validation->fails()) {
            $errors = $validation->errors();
        }
        $state = State::find($id);
        if($state)
        {
            $state->update($request->all());
            return response()->json($state,201);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, State $state)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(State $state)
    {
        //
    }
}
