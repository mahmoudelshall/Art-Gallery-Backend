<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Products extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'order_id',
        'product_id',
        'description',
        'product_price',
        'product_subTotal',
        'product_quantity',
        ];
}

