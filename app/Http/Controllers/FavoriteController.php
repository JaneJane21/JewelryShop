<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
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
    public function store(Request $request,$id)
    {
        // $product = Product::query()->where('id',$id)->first();
        $fav = Favorite::query()->where('product_id',$id)->where('user_id',Auth::id())->first();
        if($fav){
            $fav ->delete();
            return redirect()->back()->with('success','Удалено из избранного');
        }
        else{
            $fav = new Favorite();
            $fav->user_id = Auth::id();
            $fav->product_id = $id;
            $fav->save();
            return redirect()->back()->with('success','Добавлено в избранное');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Favorite $favorite)
    {
        $favs = Favorite::query()->where('user_id',Auth::id())->get();
        return response()->json($favs);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Favorite $favorite)
    {
        //
    }
}
