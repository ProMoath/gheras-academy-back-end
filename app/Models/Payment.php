<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['amount', 'method', 'status', 'transaction_id', 'user_id', 'course_id', 'confirmed_by', 'confirmed_at'])]
class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'method' => 'cliq',
        'status' => 'pending',
        'amount' => 0,
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'confirmed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function confirmor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
