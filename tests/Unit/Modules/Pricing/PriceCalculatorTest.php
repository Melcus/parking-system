<?php

namespace Tests\Unit\Modules\Pricing;

use App\Modules\Pricing\PeriodConfigurator;
use App\Modules\Pricing\PriceCalculator;
use App\Modules\Pricing\PriceConfigurator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    protected PriceConfigurator $priceConfigurator;
    protected PeriodConfigurator $periodConfigurator;
    protected PriceCalculator $priceCalculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->priceCalculator = new PriceCalculator();
        $this->priceConfigurator = (new PriceConfigurator())->setBasePrice(1000);
        $this->periodConfigurator = new PeriodConfigurator();
    }

    public function test_same_day_with_default_config_full_hours(): void
    {
        $start = today()->nextWeekday();

        $price = $this
            ->priceCalculator
            ->setPeriodConfigurator($this->periodConfigurator)
            ->setPriceConfigurator($this->priceConfigurator)
            ->calculate(
                $start,
                $start->clone()->addHours(4)
            );

        self::assertEquals(4000, $price);
    }

    public function test_same_day_with_default_config_fractional_hours(): void
    {
        $start = today()->nextWeekday();

        $price = $this
            ->priceCalculator
            ->setPeriodConfigurator($this->periodConfigurator)
            ->setPriceConfigurator($this->priceConfigurator)
            ->calculate(
                $start,
                $start->clone()->addHours(4)->addMinutes(30)
            );

        self::assertEquals(4500, $price);
    }


    public function test_different_days_full_hours_and_default_config(): void
    {
        self::markTestIncomplete('to do');
    }

    public function test_different_days_fractional_hours_and_default_config(): void
    {
        self::markTestIncomplete('to do');
    }

    public function test_same_day_with_custom_hours_config(): void
    {
        $this->priceConfigurator->addConfig([
            [
                'amount' => 2000,
                'hours'  => '9-17'
            ]
        ]);

        self::markTestIncomplete('to do');
    }

    public function test_same_day_with_custom_days_config(): void
    {
        $this->priceConfigurator->addConfig([
            [
                'amount' => 2000,
                'days'   => [6, 7]
            ]
        ]);

        self::markTestIncomplete('to do');
    }

    public function test_same_day_with_custom_days_and_hours_config(): void
    {
        $this->priceConfigurator->addConfig([
            [
                'amount' => 2000,
                'days'   => [6, 7],
                'hours'  => '9-17'
            ]
        ]);

        self::markTestIncomplete('to do');
    }

    public function test_with_multiple_custom_configs(): void
    {
        $this->priceConfigurator->addConfig([
            [
                'amount' => 500,
                'days'   => [6, 7],
                'hours'  => '0-8'
            ],
            [
                'amount' => 1200,
                'days'   => [6, 7],
                'hours'  => '9-17'
            ]
        ]);

        self::markTestIncomplete('to do');
    }

}
