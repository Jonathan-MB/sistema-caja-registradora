<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'user_cc_nit',
        'user_business_name',
        'type_id'
    ];


    public function type()
    {

        return $this->belongsTo(Type::class);
    }

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}