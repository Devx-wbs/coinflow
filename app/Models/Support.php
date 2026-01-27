<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Support extends Model
{
    use HasFactory;

    protected $table = 'supports';

    protected $fillable = [
        'user_id',
        'subject',
        'description',
        'status',
        'priority',
        'assigned_to',
        'category_id',
        'closed_at',
    ];

    /* =========================
     |  CATEGORY CONSTANTS
     |=========================*/
    public const CATEGORY_BILLING   = 1;
    public const CATEGORY_TECHNICAL = 2;
    public const CATEGORY_GENERAL   = 3;

    public static function categories(): array
    {
        return [
            self::CATEGORY_BILLING   => 'Billing',
            self::CATEGORY_TECHNICAL => 'Technical',
            self::CATEGORY_GENERAL   => 'General',
        ];
    }

    public function getCategoryNameAttribute(): string
    {
        return self::categories()[$this->category_id] ?? 'Unknown';
    }

    /* =========================
     |  STATUS
     |=========================*/
    public const STATUS_INACTIVE    = 0;
    public const STATUS_ACTIVE      = 1;
    public const STATUS_IN_PROGRESS = 2;
    public const STATUS_CLOSED      = 3;



    public static function statuses(): array
    {
        return [
            self::STATUS_INACTIVE    => 'Inactive',
            self::STATUS_ACTIVE      => 'Active',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_CLOSED      => 'Closed',
        ];
    }


    public function getStatusNameAttribute(): string
    {
        return self::statuses()[$this->status] ?? 'Unknown';
    }


    /* =========================
     |  PRIORITY
     |=========================*/
    public const PRIORITY_LOW    = 0;
    public const PRIORITY_MEDIUM = 1;
    public const PRIORITY_HIGH   = 2;


    public static function priorities(): array
    {
        return [
            self::PRIORITY_LOW    => 'Low',
            self::PRIORITY_MEDIUM => 'Medium',
            self::PRIORITY_HIGH   => 'High',
        ];
    }



    public function getPriorityNameAttribute(): string
    {
        return self::priorities()[$this->priority] ?? 'Unknown';
    }


    /* =========================
     |  RELATIONSHIPS
     |=========================*/
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }


    public function reply()
{
    return $this->hasOne(SupportReply::class);
}
}
