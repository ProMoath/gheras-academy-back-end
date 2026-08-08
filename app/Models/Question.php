<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['quiz_id', 'type', 'content', 'options', 'correct_answer', 'image_url', 'order_index'])]
class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'type' => 'mcq',
        'order_index' => 0,
    ];

    protected function casts(): array
    {
        return [
            'options' => 'array',
        ];
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
