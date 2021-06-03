<?php

namespace App\Modules\Pricing;

use Carbon\Carbon;

class PeriodConfigurator
{

    protected array $periodMap = [];

    public function configure(Carbon $from, Carbon $to): self
    {
        $this->mapDatesToList($from, $to);

        return $this;
    }

    protected function mapDatesToList(Carbon $from, Carbon $to): void
    {
        $this->setPeriodMapValue($from->dayOfYear, $from->hour, $this->calculateFactor($from, true));

        $date = $from->clone()->startOfHour()->addHour();

        while ($date->lt($to)) {
            $factor = ($date->dayOfYear !== $to->dayOfYear || $date->hour !== $to->hour) ? 1 : $this->calculateFactor($to);
            $this->setPeriodMapValue($date->dayOfYear, $date->hour, $factor);
            $date->addHour();
        }
    }

    public function getPeriodMap(): array
    {
        return $this->periodMap;
    }

    protected function setPeriodMapValue($day, $hour, $value): void
    {
        $this->periodMap[$day][$hour] = $value;
    }

    protected function calculateFactor(Carbon $date, bool $isStartOfPeriod = false): float
    {
        $minutes = $date->minute;

        if ($isStartOfPeriod) {
            $minutes = 60 - $minutes;
        }

        $factor = $minutes / 60;

        return $factor === 0 ? 1 : $factor;
    }
}
