<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PluginUpdateNotice extends Model
{
    protected $fillable = [
        'plugin_version_id',
        'license_id',
        'email',
        'store_url',
        'status',
        'sent_at',
        'error_message'
    ];

    protected $casts = [
        'released_at' => 'date',
    ];



    const STATUS_PENDING = 0;
    const STATUS_SENT    = 1;
    const STATUS_FAILED  = 2;

    public static function status(): array
    {
        return [
            self::STATUS_PENDING   => 'Pending',
            self::STATUS_SENT => 'Send',
            self::STATUS_FAILED => 'Failed',
        ];
    }

    public function getStatusNameAttribute(): string
    {
        return self::status()[$this->type_id] ?? 'Unknown';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->type_id) {
            self::STATUS_PENDING   => 'bg-success',
            self::STATUS_SENT => 'bg-secondary',
            self::STATUS_FAILED => 'bg-danger',
            default              => 'bg-dark',
        };
    }


    public function pluginVersion()
    {
        return $this->belongsTo(PluginVersion::class, 'plugin_version_id');
    }

    public function license()
    {
        return $this->belongsTo(License::class);
    }
}
