<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    #[Fillable(['name'])]

    public const int student = 1;
    public const int supervisor = 2;
    public const int admin = 3;

    public function user():HasMany
    {
        return $this->hasMany(User::class);
    }

}
