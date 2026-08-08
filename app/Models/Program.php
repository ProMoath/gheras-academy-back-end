<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'description'])]
class Program extends Model
{
    use HasFactory, SoftDeletes;

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
