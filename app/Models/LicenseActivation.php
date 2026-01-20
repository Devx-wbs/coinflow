<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseActivation extends Model
{
    protected $table = 'license_activations';

    protected $fillable = [
        'license_id',
        'store_url',
        'activated_at',
        'deactivated_at'
    ];
    
    public function license()
    {
        return $this->belongsTo(License::class, 'license_id');
    }

}
