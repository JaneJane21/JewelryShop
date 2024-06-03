<?php

namespace App\Http\Controllers;

use App\Models\Whome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WhomeController extends Controller
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
            'title'=>['required','unique:whomes']
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $type = new Whome();
        $type->title = $request->title;
        $type->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Whome $whome)
    {
        $whomes = Whome::all();
        return response()->json($whomes);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Whome $whome)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Whome $whome)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Whome $whome)
    {
        //
    }
}
