<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    public function sizes(){
        return $this->hasMany(Size::class);
    }

    public function subtypes(){
        return $this->hasMany(Subtype::class);
    }
}
