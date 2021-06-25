<?php

namespace App\Models;

use App\Filters\Spot\SpotFilters;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;

class Spot extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function spotAttributes(): BelongsToMany
    {
        return $this->belongsToMany(SpotAttribute::class);
    }

    public function garage(): BelongsTo
    {
        return $this->belongsTo(Garage::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return (new SpotFilters($filters))->filter($query);
    }
}
