<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Verta;

class ProductComment extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    
    public function getCreatedAtAttribute($value){
        return new Verta($value)."";
    }
}
