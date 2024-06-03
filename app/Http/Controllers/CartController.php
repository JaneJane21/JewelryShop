<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Filial;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = [];
        $filials = [];
        $order = Order::query()->where('user_id',Auth::id())->where('status','новый')->first();
        
        if($order){
            $carts = Cart::query()->where('order_id',$order->id)->with(['size'])->get();
            $filials = Filial::all();

        }
        return view('user.cart',['carts'=>$carts,'order'=>$order,'filials'=>$filials]);
        // return response()->json(['carts'=>$carts,'order'=>$order,'filials'=>$filials],200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function show_order(Request $request)
    {
        $carts = Cart::query()->where('order_id',$request->id)->with(['product','size'])->get();
        return response()->json($carts,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $size = '';
        if($request->size){
            $size = Size::query()->where('number',$request->size)->first();
        }
        // dd($size);      
        $product = Product::query()->where('id',$request->id)->first();
        $order = Order::query()->where('user_id',Auth::id())->where('status','новый')->firstOrCreate(['user_id'=>Auth::id()],['status'=>'новый']);
        if($order){
            $cart = Cart::query()->where('order_id',$order->id)->where('product_id',$product->id)->firstOrCreate(['order_id'=>$order->id],['product_id'=>$product->id]);

            if($cart->count){
                $cart->count +=1;
                if($size){
                    $cart->size_id = $size->id;
                }
                $cart->price += $product->price;
                $cart->save();
                $order->sum += $product->price;
                $order->save();
                return redirect()->back();
            }
            else{
                $cart->count +=1;
                if($size){
                    $cart->size_id = $size->id;
                }
                $cart->price += $product->price;
                $cart->update();
                $order->sum += $product->price;
                $order->update();
                return redirect()->back();
            }
        }
        
    }

    public function store_one(Request $request,$id)
    {
        // dd($request->all());
        
        // dd($size);      
        $product = Product::query()->where('id',$request->id)->first();
        $order = Order::query()->where('user_id',Auth::id())->where('status','новый')->firstOrCreate(['user_id'=>Auth::id()],['status'=>'новый']);
        $cart = Cart::query()->where('order_id',$order->id)->where('product_id',$product->id)->firstOrCreate(['order_id'=>$order->id],['product_id'=>$product->id]);

        if($cart->count){
            $cart->count +=1;
            $cart->price += $product->price;
            $cart->save();
            $order->sum += $product->price;
            $order->save();
            return redirect()->back();
        }
        else{
            $cart->count +=1;
            $cart->price += $product->price;
            $cart->update();
            $order->sum += $product->price;
            $order->update();
            return redirect()->back();
        }


    }

    public function decrease(Request $request, $id)
        {
            // dd($id);
            $product = Product::query()->where('id',$id)->first();
            $order = Order::query()->where('user_id',Auth::id())->where('status','новый')->firstOrCreate(['user_id'=>Auth::id()],['status'=>'новый']);
            $cart = Cart::query()->where('order_id',$order->id)->where('product_id',$product->id)->firstOrCreate(['order_id'=>$order->id],['product_id'=>$product->id]);

            if($cart->count>1){
                $cart->count -=1;
                $cart->price -= $product->price;
                $cart->save();
                $order->sum -= $product->price;
                $order->save();
            }
            else{
                $cart->delete();
                $order->sum -= $product->price;
                $order->update();
            }
            return redirect()->back();

        }
    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        // dd($request->all());

        $cart = Cart::query()->where('id',$request->cart)->first();
        $last_cnt = $cart->count;
        $product = Product::query()->where('id',$cart->product->id)->first();
        if($request->count == "0"){
            $this->destroy($cart,$product->id);
        }
        else{
            $order = Order::query()->where('id',$cart->order_id)->first();
            $cart->count = (int)$request->count;
            $cart->price = $product->price*(int)$request->count;
            $order->sum -= $product->price * $last_cnt;
            $order->sum += $product->price * (int)$request->count;
            $cart->update();
            $order->update();
            return response()->json([],200);
        }

        // return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart, $id)
    {
        $product = Product::query()->where('id',$id)->first();
        $order = Order::query()->where('user_id',Auth::id())->where('status','новый')->firstOrCreate(['user_id'=>Auth::id()],['status'=>'новый']);
        $cart = Cart::query()->where('order_id',$order->id)->where('product_id',$product->id)->firstOrCreate(['order_id'=>$order->id],['product_id'=>$product->id]);
        $cart->delete();
        $order->sum -= $product->price * $cart->count;
        $order->update();
        return redirect()->back();

    }
}
