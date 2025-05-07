<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DartMatch extends Model
{
    protected $fillable = [
        'guestName',
        'homeName',
        'guestScore',
        'homeScore',
        'status',
    ];

    protected $casts = [
        'guestScore' => 'integer',
        'homeScore' => 'integer',
    ];

    public function isEnded(): bool
    {
        return $this->status === 'ended';
    }

    public function getGuestScoreAttribute($value): int
    {
        return (int) $value;
    }

    public function getHomeScoreAttribute($value): int
    {
        return (int) $value;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
