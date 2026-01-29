<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    protected $fillable = [
        'level',
        'message',
        'trace',
        'file',
        'line',
        'url',
        'method',
        'user_id',
        'ip',
        'is_resolved',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function systemLogsEnabled(): bool
    {
        $value = GlobalSetting::where('key', 'enable_error_logs')->value('value');
        return (bool) $value;
    }
}
