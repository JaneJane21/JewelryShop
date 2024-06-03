<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
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
        $valid = Validator::make($request->all(),
        ['title'=>['required','unique:subtypes']]);
        if($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $size = new Size();
        $size->type_id = $request->id;
        $size->number = doubleval($request->title);
        $size->save();
        $sizes = Size::query()->where('type_id',$request->id)->get();
        return response()->json(['Успешно', $sizes],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Size $size)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Size $size)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Size $size)
    {

        $valid = Validator::make($request->all(),[
            'number'=>['required','unique:sizes']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),404);
        }
        $size = Size::query()->where('id',$request->id)->first();
        if($size){
            $size->number = $request->number;
            $size->update();
            $sizes = Size::query()->where('type_id', $size->type_id)->get();

            return response()->json(['Успешно', $sizes],200);
        }
        else{
            return response()->json('Ошибка в сохранении',400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_sub_char(Size $size, Request $request)
    {
        $size = Size::query()->where('id',$request->id)->first();
        $type_id = $size->type_id;
        $size->delete();
        $sizes = Size::query()->where('type_id', $type_id)->get();
        return response()->json(['Успешно удалено', $sizes],200);
    }
}
