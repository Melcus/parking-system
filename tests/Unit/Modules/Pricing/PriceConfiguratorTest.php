<?php

namespace Tests\Unit\Modules\Pricing;

use App\Modules\Pricing\PeriodConfigurator;
use PHPUnit\Framework\TestCase;

class PriceConfiguratorTest extends TestCase
{
    protected PeriodConfigurator $configurator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configurator = new PeriodConfigurator();
    }

    public function test_configuration_next_weekday(): void
    {
        $dayOfYear = now()->nextWeekday()->dayOfYear;
        $period = $this->configurator->configure(
            today()->nextWeekday()->addHours(12)->addMinutes(15),
            today()->nextWeekday()->addHours(16)->addMinutes(15),
        )->getPeriodMap();

        self::assertArrayHasKey($dayOfYear, $period);

        $period = $period[$dayOfYear];
        self::assertArrayHasKey(12, $period);
        self::assertArrayNotHasKey(11, $period);
        self::assertArrayNotHasKey(17, $period);

        self::assertEquals(0.75, $period[12]);
        self::assertEquals(1, $period[13]);
        self::assertEquals(1, $period[14]);
        self::assertEquals(1, $period[15]);
        self::assertEquals(0.25, $period[16]);
    }

    public function test_configuration_next_weekday_with_full_hours(): void
    {
        $dayOfYear = now()->nextWeekday()->dayOfYear;
        $period = $this->configurator->configure(
            today()->nextWeekday()->addHours(12),
            today()->nextWeekday()->addHours(14),
        )->getPeriodMap();

        self::assertArrayHasKey($dayOfYear, $period);

        $period = $period[$dayOfYear];
        self::assertArrayHasKey(12, $period);
        self::assertArrayHasKey(13, $period);
        self::assertArrayNotHasKey(11, $period);
        self::assertArrayNotHasKey(14, $period);

        self::assertEquals(1, $period[12]);
        self::assertEquals(1, $period[13]);
    }

    public function test_configuration_over_three_days(): void
    {
        $dayOfYear = now()->nextWeekday()->dayOfYear;

        $period = $this->configurator->configure(
            today()->nextWeekday()->addHours(12)->addMinutes(15),
            today()->nextWeekday()->addDays(2)->addHours(16)->addMinutes(15),
        )->getPeriodMap();

        self::assertArrayHasKey($dayOfYear, $period);
        self::assertArrayHasKey(($dayOfYear + 1), $period);
        self::assertArrayHasKey(($dayOfYear + 2), $period);

        self::assertArrayNotHasKey(($dayOfYear + 3), $period);
        self::assertArrayNotHasKey(($dayOfYear + 4), $period);
        self::assertArrayNotHasKey(($dayOfYear + 5), $period);
        self::assertArrayNotHasKey(($dayOfYear + 6), $period);
    }
}
