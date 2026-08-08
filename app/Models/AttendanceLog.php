<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'session_id', 'status', 'gps_lat', 'gps_lng', 'distance_from_session', 'scanned_at', 'source'])]
class AttendanceLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'status' => 'confirmed',
        'source' => 'qr',
    ];

    protected function casts(): array
    {
        return [
            'scanned_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(AttendanceSession::class, 'session_id');
    }
}
