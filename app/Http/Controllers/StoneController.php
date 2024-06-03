<?php

namespace App\Http\Controllers;

use App\Models\Stone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoneController extends Controller
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
            'title'=>['required','unique:stones']
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $type = new Stone();
        $type->title = $request->title;
        $type->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Stone $stone)
    {
        $stones = Stone::all();
        return response()->json($stones);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stone $stone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stone $stone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stone $stone)
    {
        //
    }
}
