<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PluginVersion extends Model
{
    protected $fillable = [
        'version',
        'zip_path',
        'released_at',
        'state_id',
        'category_id',
        'type_id',
        'description'
    ];

    protected $casts = [
        'released_at' => 'date',
    ];

    protected $appends = [
        'image_url',
        'download_url',
        'released_date'
    ];
    protected $hidden = [
        'screenshot'
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->screenshot) {
            return null;
        }

        return asset('storage/' . $this->screenshot->file_path);
    }

    public function getDownloadUrlAttribute()
    {
        $licenseKey = request()->query('license_key');

        if (!$licenseKey) {
            return null;
        }

        return route('plugin.download', $this->id)
            . "?license_key={$licenseKey}";
    }

    public function getReleasedDateAttribute()
    {
        return $this->released_at
            ? $this->released_at->format('Y-m-d')
            : null;
    }

    public function activations()
    {
        return $this->hasMany(LicenseActivation::class, 'plugin_id');
    }

    /**
     * ==============================
     * STATE CONSTANTS
     * ==============================
     * Controls whether version is usable or not
     */
    public const STATE_INACTIVE = 0;
    public const STATE_ACTIVE   = 1;

    public static function states(): array
    {
        return [
            self::STATE_ACTIVE   => 'Active',
            self::STATE_INACTIVE => 'Inactive',
        ];
    }

    public function getStateNameAttribute(): string
    {
        return self::states()[$this->state_id] ?? 'Unknown';
    }

    /**
     * ==============================
     * TYPE CONSTANTS
     * ==============================
     * Defines update alert category
     */
    public const TYPE_STANDARD         = 1;
    public const TYPE_SUPPORT_ALERT  = 2;
    public const TYPE_SECURITY_ALERT = 3;

    public static function categories(): array
    {
        return [
            self::TYPE_STANDARD         => 'Standard',
            self::TYPE_SUPPORT_ALERT  => 'Support Alert',
            self::TYPE_SECURITY_ALERT => 'Security Alert',
        ];
    }

    public function getCategoryNameAttribute(): string
    {
        return self::categories()[$this->category_id] ?? 'Unknown';
    }

    public function getCategoryBadgeClassAttribute(): string
    {
        return match ($this->category_id) {
            self::TYPE_STANDARD         => 'bg-success',
            self::TYPE_SUPPORT_ALERT  => 'bg-warning',
            self::TYPE_SECURITY_ALERT => 'bg-danger',
            default                  => 'bg-secondary',
        };
    }

    public function getStateBadgeClassAttribute(): string
    {
        return match ($this->state_id) {
            self::STATE_ACTIVE   => 'bg-success',
            self::STATE_INACTIVE => 'bg-secondary',
            default              => 'bg-dark',
        };
    }


    public const TYPE_LATEST = 1;
    public const TYPE_OUTDATED   = 0;

    public static function types(): array
    {
        return [
            self::TYPE_LATEST   => 'Latest',
            self::TYPE_OUTDATED => 'Outdated',
        ];
    }

    public function getTypeNameAttribute(): string
    {
        return self::types()[$this->type_id] ?? 'Unknown';
    }

    public function getTypeBadgeClassAttribute(): string
    {
        return match ($this->type_id) {
            self::TYPE_LATEST   => 'bg-success',
            self::TYPE_OUTDATED => 'bg-danger',
            default              => 'bg-dark',
        };
    }

    public function storages()
    {
        return $this->morphMany(Storage::class, 'model');
    }

    // If you want only screenshot image
    public function screenshot()
    {
        return $this->morphOne(Storage::class, 'model')
            ->where('file_type', 'image');
    }
}
