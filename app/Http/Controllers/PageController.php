<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\ProductFilialSize;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function show_welcome(){
        $news = Product::query()->orderBy('created_at')->limit(4)->get();
        return view('welcome',['news'=>$news]);

    }
    public function show_reg(){
        return view('guest.registration');
    }

    public function show_auth(){
        return view('guest.auth');
    }
    public function user_profile(){
        $user = Auth::user();
        return view('user.profile',['user'=>$user]);
    }
    public function catalog(){
        // $favs = Favorite::query()->where('user_id',Auth::id())->get();
        return view('guest.catalog');
    }

    public function detail($id){
        $product = Product::with(['material',
        'sample',
        'stone',
        'cutting',
        'whome',
        'type',
        'subtype',
        'brand'])->where('id',$id)->first();
        $fav = Favorite::query()->where('product_id',$id)->where('user_id',Auth::id())->first();
        $stock = ProductFilialSize::with(['filial','size'])->where('product_id',$id)->get();
        $reviews = Review::query()->where('product_id',$id)->get();
        // dd($stock);
        if($fav){
            $is_fav = true;
        }
        else{
            $is_fav = false;
        }
        return view('guest.detail',['product'=>$product,
        'is_fav'=>$is_fav,
        'stock'=>$stock,
        'reviews'=>$reviews]);
    }

    public function cart(){
        return view('user.cart');
    }

    public function favs(){
        $favs = Favorite::query()->where('user_id',Auth::id())->get();
        return view('user.favorites',['favs'=>$favs]);
    }
}
