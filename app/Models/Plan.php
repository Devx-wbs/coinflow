<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    // Mass assignable fields
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'duration_type',
        'license_type',
        'max_activations',
        'auto_generate_license',
        'features',
        'is_active',
        'trial_days',
    ];

    // Casts (for auto type conversion)
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'auto_generate_license' => 'boolean',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }


    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public static function resolveMaxActivations(array $data): int
    {
        return match ($data['license_type']) {
            'single_site' => 1,
            'unlimited'  => 0, // or -1
            default      => $data['max_activations'],
        };
    }


    /**
     * Convert duration to days
     */
    public static function durationToDays(int $duration, string $type): int
    {
        return match ($type) {
            'days'   => $duration,
            'months' => $duration * 30,
            'years'  => $duration * 365,
        };
    }

    /**
     * Validate trial days against duration
     * Returns error message or null
     */
    public static function validateTrialDays(array $data): ?string
    {
        if (empty($data['trial_days'])) {
            return null;
        }

        $durationInDays = self::durationToDays(
            $data['duration'],
            $data['duration_type']
        );

        if ($data['trial_days'] > $durationInDays) {
            return "Trial days cannot be greater than plan duration.";
        }

        return null;
    }
}
