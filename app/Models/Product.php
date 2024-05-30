<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_code',
        'product_price',
        'product_stock'
    ];

    public function saleDetail()
    {
        return $this->hasMany(SaleDetail::class);
    }

}
