<?php

namespace App\Models;

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

    public function scopeFilter(Builder $query, array $filters)
    {
        //                      |---------|
        // case1      |---|                                     // happy
        // case2                                |---|           // happy
        // case3       |------------|                           // unhappy
        // case4                   |--|                         // unhappy
        // case5                      |--------|                // unhappy
        // case6     |-----------------------------|            // unhappy
        $query->when(Arr::has($filters, ['start', 'end']), function (Builder $query) use ($filters) {
            $query->whereDoesntHave('reservations', function (Builder $query) use ($filters) {
                $query->where([
                    ['start', '<=', Carbon::parse(Arr::get($filters, 'end'))],
                    ['end', '>=', Carbon::parse(Arr::get($filters, 'start'))],
                ]);

//                $start = Carbon::parse(Arr::get($filters, 'start'));
//                $end = Carbon::parse(Arr::get($filters, 'end'));
//                $query->whereBetween('start', [$start, $end])
//                    ->orWhereBetween('end', [$start, $end])
//                    ->orWhereRaw('? BETWEEN start and end', [$start])
//                    ->orWhereRaw('? BETWEEN start and end', [$end]);
            });
        });
    }
}
