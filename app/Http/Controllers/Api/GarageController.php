<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GarageResourceCollection;
use App\Models\Garage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class GarageController extends Controller
{
    public function index(Request $request) : GarageResourceCollection
    {
        return new GarageResourceCollection(
            Garage::withCount([
                'spots as total_spots',
                'spots as free_spots' => function(Builder $query) {
                    $query->whereDoesntHave('reservations', function(Builder $query) {
                        $query->whereRaw("? BETWEEN start AND end", [now()]);
                    });
                }
            ])->get()
        );
    }
}
