<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductFilialSize;
use Illuminate\Http\Request;

class ProductFilialSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get_stock(Request $request)
    {
        // dd($request->all());
        $stock = ProductFilialSize::query()->where('product_id',$request->id)->with('size')->get();
        return response()->json($stock,200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductFilialSize $productFilialSize, Product $product)
    {
        $productFilial = ProductFilialSize::with(['filial','size'])->get();
        return response()->json($productFilial);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductFilialSize $productFilialSize)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductFilialSize $productFilialSize)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductFilialSize $productFilialSize)
    {
        //
    }
}
