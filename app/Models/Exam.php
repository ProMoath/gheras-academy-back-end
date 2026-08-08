<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'passing_score', 'starts_at', 'ends_at', 'time_limit', 'program_id'])]
class Exam extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'passing_score' => 0,
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }
}
