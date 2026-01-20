<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PluginUser extends Model
{
    use HasFactory;

    protected $table = 'plugin_user';

    protected $fillable = [
        'email',
        'plan',
        'domain',
        'status',
    ];
}
