<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
