<?php

namespace App\Processors;

use App\Models\Reservation;
use App\Modules\Pricing\PeriodConfigurator;
use App\Modules\Pricing\PriceCalculator;
use App\Modules\Pricing\PriceConfigurator;

class PriceCalculationProcessor
{
    protected PriceConfigurator $priceConfigurator;
    protected PeriodConfigurator $periodConfigurator;
    protected PriceCalculator $priceCalculator;

    public function __construct()
    {
        $this->priceCalculator = new PriceCalculator();
        $this->periodConfigurator = new PeriodConfigurator();
        $this->priceConfigurator = new PriceConfigurator();
    }

    public function process(int $reservationId): int
    {
        $reservation = Reservation::findOrFail($reservationId);

        $spot = $reservation->spot;

        $attributesPrice = $spot
            ->garage
            ->spotAttributes()
            ->whereIn('spot_attributes.id', $spot->spotAttributes->pluck('id')->toArray())
            ->get()
            ->sum('pivot.price_per_hour');

        return $this
            ->priceCalculator
            ->setPeriodConfigurator(
                $this->periodConfigurator->configure($reservation->start, $reservation->end)
            )
            ->setPriceConfigurator(
                $this->priceConfigurator->setBasePrice(
                    $spot->garage->prices()->where('size_id', $spot->size_id)->first()->base + $attributesPrice
                )
            )
            ->calculate(
                $reservation->start,
                $reservation->end
            );
    }
}
