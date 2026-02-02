<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LicenseActivation extends Model
{
    protected $table = 'license_activations';

    protected $fillable = [
        'license_id',
        'store_url',
        'status',
        'activated_at',
        'deactivated_at'
    ];

    public function license()
    {
        return $this->belongsTo(License::class, 'license_id');
    }

    public function plugin()
    {
        return $this->belongsTo(PluginVersion::class, 'plugin_id');
    }
}
