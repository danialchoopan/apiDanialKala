<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function subCategories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }
}
