<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_subtotal',
        'sale_total',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saleDetail() 
    {
        return $this->hasMany(SaleDetail::class);
    }
}