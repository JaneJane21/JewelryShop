<?php

namespace App\Http\Controllers;

use App\Models\Filial;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductFilialSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPageController extends Controller
{
    public function admin_profile(){
        $user = Auth::user();
        return view('admin.profile',['user'=>$user]);
    }
    public function show_categories(){
        return view('admin.categories.index');
    }

    public function show_filials(){
        // $filials = Filial::all();
        return view('admin.filials.index');
    }

    public function show_products(){
        return view('admin.products.index');
    }

    public function show_products_add(){
        return view('admin.products.add');
    }

    public function show_products_edit(Product $product, $id){
        $p = Product::query()->where('id',$id)->first();
        $filials = ProductFilialSize::query()->where('product_id',$p->id)->with(['filial'])->get();


        return view('admin.products.edit',['product'=>$p,'spec_filials'=>$filials]);
    }

    public function show_orders(){
        $orders = Order::query()->where('status','!=','новый')->orderByDesc('created_at')->get();
        return view('admin.orders.index',['orders'=>$orders]);
    }
}
