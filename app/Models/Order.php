<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
        'status',
        'date',
        'total'
        ];
        public function customer(): BelongsTo
        {
            return $this->belongsTo(Customer::class);
        }
}
