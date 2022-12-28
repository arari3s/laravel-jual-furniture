<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id', 'products_id'
    ];

    // relasi hasOne cart to product
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    // relasi belongsTo cart to user
    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'users_id');
    }
}
