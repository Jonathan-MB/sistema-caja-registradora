<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity_product',
        'sale_detail_total',
        'sale_id',
        'product_id'
    ];
    

    public function sale()
    {
        return $this->belongsTo(sale::class);
    }


    public function product()
    {
        return $this->belongsTo(product::class);
    }

}
