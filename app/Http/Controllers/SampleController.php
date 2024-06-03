<?php

namespace App\Http\Controllers;

use App\Models\Sample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SampleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'title'=>['required','unique:samples']
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $type = new Sample();
        $type->title = $request->title;
        $type->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sample $sample)
    {
        $samples = Sample::all();
        return response()->json($samples);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sample $sample)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sample $sample)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sample $sample)
    {
        //
    }
}
