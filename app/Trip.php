<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
