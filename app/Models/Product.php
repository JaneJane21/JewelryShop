<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class);
    }

    public function stone(){
        return $this->belongsTo(Stone::class);
    }

    public function whome(){
        return $this->belongsTo(Whome::class);
    }

    public function cutting(){
        return $this->belongsTo(Cutting::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function sample(){
        return $this->belongsTo(Sample::class);
    }

    public function subtype(){
        return $this->belongsTo(Subtype::class);
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function productfilialsizes(){
        return $this->hasMany(ProductFilialSize::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function favorites(){
        return $this->hasMany(Favorite::class);
    }
}
