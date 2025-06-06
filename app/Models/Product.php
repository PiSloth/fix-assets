<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function remarks()
    {
        return $this->hasMany(ProductRemark::class);
    }

    public function stockTransfer()
    {
        return $this->hasMany(StockTransfer::class);
    }
}
