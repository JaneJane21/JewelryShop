<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::query()->where('user_id',Auth::id())->where('status','в обработке')->orWhere('status','подтвержден')->get();
        $history = Order::query()->where('user_id',Auth::id())->where('status','отменен')->orWhere('status','получен')->get();
        return view('user.order',['orders'=>$orders,'history'=>$history]);
    }
    public function new_order(){
        $orders = Order::query()->where('status','в обработке')->get();
        $total = count($orders);
        return response()->json([$total],200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function admin_confirm(Request $request, Order $order)
    {
        // dd($request->all(),$order);
        $request->validate([
            'date_start'=>'required',
            'date_end'=>'required'
        ]);
        $order->date_start = $request->date_start;
        $order->date_end = $request->date_end;
        $order->status = 'подтвержден';
        $order->update();
        return redirect()->back();
    }

    public function admin_cancel(Request $request, Order $order)
    {
        // dd($request->all(),$order);
        $request->validate([
            'comment'=>'required',
            
        ]);
        $order->status = 'отменен';
        $order->comment = $request->comment;
        $order->update();
        return redirect()->back();
    }

    public function admin_done(Order $order)
        {
            $order->status = 'получен';
            $order->update();
            return redirect()->back();
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order, $id)
    {
        // dd($request->all());
        $order = Order::query()->where('id',$id)->first();
        $order->status = 'в обработке';
        $order->filial_id = $request->filial;
        $order->update();
        return redirect()->back()->with('success','Заказ оформлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // dd($order);
        $order->status = 'отменен';
        $order->update();
        return redirect()->back()->with('success','Заказ отменен');
    }
}
