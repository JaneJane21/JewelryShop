<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
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
        
        if($request->text || $request->positive || $request->negative){
            $rev = new Review();
            $rev->text = $request->text;
            $rev->positive = $request->positive;
            $rev->negative = $request->negative;
            $rev->user_id = Auth::id();
            $rev->product_id = $id;
            $rev->save();
            return redirect()->back();
        }
        else{
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review, $id)
    {
        Review::find($id)->delete();
        return redirect()->back()->with('success','Отзыв удален');
    }
}
