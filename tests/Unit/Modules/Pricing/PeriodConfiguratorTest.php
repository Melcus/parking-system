<?php

namespace Tests\Unit\Modules\Pricing;

use App\Modules\Pricing\PeriodConfigurator;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class PeriodConfiguratorTest extends TestCase
{
    protected PeriodConfigurator $configurator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configurator = new PeriodConfigurator();
    }


    public function test_return_map_with_fractional_hours_same_day(): void
    {
        $start = Carbon::parse("01-06-2021 12:15:00");
        $end = Carbon::parse("01-06-2021 16:15:00");

        $map = $this->configurator->configure(
            $start,
            $end
        )->getPeriodMap();

        $dayOfYear = $start->dayOfYear;

        self::assertArrayHasKey($dayOfYear, $map);
        self::assertArrayHasKey(12, $map[$dayOfYear]);
        self::assertArrayHasKey(13, $map[$dayOfYear]);
        self::assertArrayHasKey(14, $map[$dayOfYear]);
        self::assertArrayHasKey(15, $map[$dayOfYear]);
        self::assertArrayHasKey(16, $map[$dayOfYear]);
        self::assertArrayNotHasKey(11, $map[$dayOfYear]);
        self::assertArrayNotHasKey(17, $map[$dayOfYear]);

        self::assertEquals(0.75, $map[$dayOfYear][12]);
        self::assertEquals(1, $map[$dayOfYear][13]);
        self::assertEquals(1, $map[$dayOfYear][14]);
        self::assertEquals(1, $map[$dayOfYear][15]);
        self::assertEquals(0.25, $map[$dayOfYear][16]);
    }


    public function test_map_same_day_full_hours(): void
    {
        $start = Carbon::parse("01-06-2021 12:00:00");
        $end = Carbon::parse("01-06-2021 16:00:00");

        $map = $this->configurator->configure(
            $start,
            $end
        )->getPeriodMap();

        $dayOfYear = $start->dayOfYear;

        self::assertArrayHasKey($dayOfYear, $map);
        self::assertArrayHasKey(12, $map[$dayOfYear]);
        self::assertArrayHasKey(13, $map[$dayOfYear]);
        self::assertArrayHasKey(14, $map[$dayOfYear]);
        self::assertArrayHasKey(15, $map[$dayOfYear]);
        self::assertArrayNotHasKey(11, $map[$dayOfYear]);
        self::assertArrayNotHasKey(16, $map[$dayOfYear]);
        self::assertArrayNotHasKey(17, $map[$dayOfYear]);

        self::assertEquals(1, $map[$dayOfYear][12]);
        self::assertEquals(1, $map[$dayOfYear][13]);
        self::assertEquals(1, $map[$dayOfYear][14]);
        self::assertEquals(1, $map[$dayOfYear][15]);
    }


    public function test_map_different_days_fractional_hours() :void
    {
        $start = Carbon::parse("01-06-2021 22:15:00");
        $end = Carbon::parse("02-06-2021 02:15:00");

        $map = $this->configurator->configure(
            $start,
            $end
        )->getPeriodMap();

        $dayOfYear = $start->dayOfYear;

        self::assertArrayHasKey($dayOfYear, $map);
        self::assertArrayHasKey($dayOfYear + 1, $map);
        self::assertArrayHasKey(22, $map[$dayOfYear]);
        self::assertArrayHasKey(23, $map[$dayOfYear]);
        self::assertArrayHasKey(0, $map[$dayOfYear + 1]);
        self::assertArrayHasKey(1, $map[$dayOfYear + 1]);
        self::assertArrayHasKey(2, $map[$dayOfYear + 1]);
        self::assertArrayNotHasKey(21, $map[$dayOfYear]);
        self::assertArrayNotHasKey(3, $map[$dayOfYear + 1]);

        self::assertEquals(0.75, $map[$dayOfYear][22]);
        self::assertEquals(1, $map[$dayOfYear][23]);
        self::assertEquals(1, $map[$dayOfYear + 1][0]);
        self::assertEquals(1, $map[$dayOfYear + 1][1]);
        self::assertEquals(0.25, $map[$dayOfYear + 1][2]);
    }

    public function test_map_different_days_full_hours(): void
    {
        $start = Carbon::parse("01-06-2021 22:00:00");
        $end = Carbon::parse("02-06-2021 02:00:00");

        $map = $this->configurator->configure(
            $start,
            $end
        )->getPeriodMap();

        $dayOfYear = $start->dayOfYear;

        self::assertArrayHasKey($dayOfYear, $map);
        self::assertArrayHasKey($dayOfYear + 1, $map);
        self::assertArrayHasKey(22, $map[$dayOfYear]);
        self::assertArrayHasKey(23, $map[$dayOfYear]);
        self::assertArrayHasKey(0, $map[$dayOfYear + 1]);
        self::assertArrayHasKey(1, $map[$dayOfYear + 1]);
        self::assertArrayNotHasKey(21, $map[$dayOfYear]);
        self::assertArrayNotHasKey(2, $map[$dayOfYear + 1]);

        self::assertEquals(1, $map[$dayOfYear][22]);
        self::assertEquals(1, $map[$dayOfYear][23]);
        self::assertEquals(1, $map[$dayOfYear + 1][0]);
        self::assertEquals(1, $map[$dayOfYear + 1][1]);
    }

    public function test_map_different_years() : void
    {
        self::markTestIncomplete('to do');
    }
}
