<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    
    protected $table = 'licenses';
   protected $fillable = [
    'user_id',
    'plan_id',
    'subscription_id',
    'license_key',
    'store_url',
    'max_activations',
    'used_activations',
    'status',
    'expiration_date',
];

   // use HasFactory;



    protected $casts = [
        'expiration_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function isExpired()
    {
        return $this->expiration_date && $this->expiration_date->isPast();
    }

    public function canActivate()
    {
        if ($this->status !== 'active') {
            return false;
        }
        if ($this->isExpired()) {
            return false;
        }
        return $this->used_activations < $this->max_activations;
    }
    
    
    public function activations()
    {
        return $this->hasMany(LicenseActivation::class, 'license_id', 'id');
    }
    
    

   public function planInfo()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }



    protected function validateLicense($licenseKey)
    {
        $license = License::where('license_key', $licenseKey)
            ->where('status', 'active')
            ->first();

        if (!$license) {
            abort(response()->json([
                'status' => false,
                'message' => 'Invalid or inactive License'
            ], 401));
        }

        return $license;
    }

}
