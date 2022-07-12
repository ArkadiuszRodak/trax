<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Trip extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'miles',
        'car_id',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($trip) {
            $trip->total = static::where('car_id', $trip->car_id)->sum('miles') + $trip->miles;
        });
    }

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format('m/d/Y') : null,
            set: fn ($value) => $value ? Carbon::parse($value) : null,
        );
    }

    protected function miles(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => round($value, 1),
        );
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
