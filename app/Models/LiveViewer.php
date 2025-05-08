<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveViewer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'last_ping',
    ];

    protected $casts = [
        'last_ping' => 'datetime',
    ];
}
