<?php

namespace App\Http\Controllers;

use App\Models\Cutting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CuttingController extends Controller
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
            'title'=>['required','unique:cuttings']
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $type = new Cutting();
        $type->title = $request->title;
        $type->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cutting $cutting)
    {
        $cuttings = Cutting::all();
        return response()->json($cuttings);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cutting $cutting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cutting $cutting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cutting $cutting)
    {
        //
    }
}
