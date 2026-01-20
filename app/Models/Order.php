<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'store_id',
        'amount',
        'fee',
        'status',
        'origin',
        'paid_at',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
