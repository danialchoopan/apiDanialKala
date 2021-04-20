<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPropertiesProduct extends Model
{
    use HasFactory;


    protected $guarded = [];

    public function properties_product()
    {
        return $this->belongsTo(PropertiesProduct::class);
    }
}
