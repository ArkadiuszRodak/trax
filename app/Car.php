<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'year',
        'make',
        'model',
    ];

    protected static function boot(): void
    {
        parent::boot();

        if (auth()->check()) {
            static::creating(function (Car $car) {
                $car->user_id = auth()->user()->id;
            });
        }

        static::deleting(function (Car $car) {
            $car->trips()->delete();
        });
    }

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('owned', function (Builder $query) {
                $query->where('user_id', auth()->user()->id);
            });
        }
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
