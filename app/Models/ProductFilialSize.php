<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilialSize extends Model
{
    use HasFactory;

    public function filial(){
        return $this->belongsTo(Filial::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
