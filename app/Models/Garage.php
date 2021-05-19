<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Garage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function prices(): HasMany
    {
        return $this->hasMany(Price::class);
    }

    public function spots(): HasMany
    {
        return $this->hasMany(Spot::class);
    }

    public function spotAttributes(): BelongsToMany
    {
        return $this->belongsToMany(SpotAttribute::class)->withPivot('price_per_hour');
    }
}
