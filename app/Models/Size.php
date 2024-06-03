<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }    

    public function productfilialsizes(){
        return $this->hasMany(ProductFilialSize::class);
    }
}
