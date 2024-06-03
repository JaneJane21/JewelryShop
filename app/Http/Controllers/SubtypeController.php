<?php

namespace App\Http\Controllers;

use App\Models\Subtype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubtypeController extends Controller
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
        // dd($request->all());
        $valid = Validator::make($request->all(),
        ['title'=>['required','unique:subtypes']]);
        if($valid->fails()){
            return response()->json($valid->errors(),404);
        }
        $subtype = new Subtype();
        $subtype->type_id = $request->id;
        $subtype->title = $request->title;
        $subtype->save();
        $subtypes = Subtype::query()->where('type_id',$request->id)->get();
        return response()->json(['Успешно', $subtypes],200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subtype $subtype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subtype $subtype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subtype $subtype)
    {
        // dd($request);
        $valid = Validator::make($request->all(),[
            'title'=>['required','unique:subtypes']
        ]);
        if($valid->fails()){
            return response()->json($valid->errors(),404);
        }
        $subtype = Subtype::query()->where('id',$request->id)->first();
        if($subtype){
            $subtype->title = $request->title;
            $subtype->update();
            $subtypes = Subtype::query()->where('type_id', $subtype->type_id)->get();
            return response()->json(['Успешно', $subtypes],200);
        }
        else{
            return response()->json('Ошибка в сохранении',400);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy_sub_char(Subtype $subtype, Request $request)
    {
        // dd($request->all());
        $subtype = Subtype::query()->where('id',$request->id)->first();
        $type_id = $subtype->type_id;
        $subtype->delete();
        $subtypes = Subtype::query()->where('type_id', $type_id)->get();
        return response()->json(['Успешно удалено', $subtypes],200);
    }
}
