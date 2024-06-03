<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
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
            'title'=>['required','unique:brands']
        ]);
        if ($valid->fails()){
            return response()->json($valid->errors(),400);
        }
        $type = new Brand();
        $type->title = $request->title;
        $type->save();
        return response()->json('Сохранено',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        $brands = Brand::all();
        return response()->json($brands);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
