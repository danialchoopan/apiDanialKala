<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getStatusAttribute($value)
    {
        switch ($value) {
            case 1:
                return "عرضه شده";
            case 2:
                return "به زودی";
            case 3:
                return "توقف تولید";
            case 4:
                return "آزمایشی";
        }
    }

    public function productPhotos()
    {
        return $this->hasMany(ProductPhoto::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subCategory_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function properties_products()
    {
        return $this->hasMany(PropertiesProduct::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
