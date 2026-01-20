<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'plan_id',
        'store_url',
        'plugin_version',
        'status',
        'last_seen'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
