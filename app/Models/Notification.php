<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['title', 'message', 'role_id', 'status'];

    const TARGET_ALL_USERS        = 0;
    const TARGET_ADMIN            = 1;
    const TARGET_SUBADMIN         = 2;
    const TARGET_SUPPORT          = 3;
    const TARGET_USERS            = 4;
    const TARGET_PRO_PLAN_USER    = 5;
    const TARGET_LICENCE_ACTIVE   = 6;
    const TARGET_LICENCE_INACTIVE = 7;


    /**
     * Return all target audiences as id => label array
     */
    public static function targetAudiences()
    {
        return [
            self::TARGET_ALL_USERS        => 'All User',
            self::TARGET_ADMIN            => 'Admin',
            self::TARGET_SUBADMIN         => 'Sub Admin',
            self::TARGET_SUPPORT          => 'Support',
            self::TARGET_USERS            => 'User',
            self::TARGET_PRO_PLAN_USER    => 'Pro Plan User',
            self::TARGET_LICENCE_ACTIVE   => 'Active License',
            self::TARGET_LICENCE_INACTIVE => 'Inactive License',
        ];
    }

    /**
     * Get target audience label by ID
     */
    public static function getTargetLabel($id)
    {
        $audiences = self::targetAudiences();
        return $audiences[$id] ?? 'Unknown';
    }

    public function logs()
    {
        return $this->hasMany(NotificationLog::class);
    }

    public static function getUsersByTarget($role_id)
    {
        switch ($role_id) {

            case self::TARGET_ALL_USERS: // all users
                return User::all();

            case self::TARGET_ADMIN:
            case self::TARGET_SUBADMIN:
            case self::TARGET_SUPPORT:
            case self::TARGET_USERS:
                return User::where('role', $role_id)->get();

            case self::TARGET_PRO_PLAN_USER: // all users who have any license
                return User::whereHas('license')->get();

            case self::TARGET_LICENCE_ACTIVE: // users with licenses not expired
                return User::whereHas('license', function ($q) {
                    $q->whereNull('expiration_date')
                        ->orWhere('expiration_date', '>=', now());
                })->get();

            case self::TARGET_LICENCE_INACTIVE: // users with licenses expired
                return User::whereHas('license', function ($q) {
                    $q->whereNotNull('expiration_date')
                        ->where('expiration_date', '<', now());
                })->get();

            default:
                return collect(); // empty collection if unknown
        }
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'sent'      => 'bg-success',
            'queued'   => 'bg-info',
            'draft'     => 'bg-secondary',
            'failed'    => 'bg-danger',
            'scheduled' => 'bg-warning text-dark',
            'pending'   => 'bg-primary',
            default     => 'bg-light text-dark',
        };
    }

    public function getStatusBadgeClassForQueueAttribute()
    {
        return match ($this->status) {
            'sent'      => 'bg-success',
            'queued'   => 'bg-info',
            'draft'     => 'bg-secondary',
            'failed'    => 'bg-danger',
            'scheduled' => 'bg-warning text-dark',
            'pending'   => 'bg-primary',
            default     => 'bg-light text-dark',
        };
    }
}
