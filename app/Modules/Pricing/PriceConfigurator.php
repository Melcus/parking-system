<?php

namespace App\Modules\Pricing;

use Illuminate\Support\Arr;

class PriceConfigurator
{
    protected int $amount;
    protected array $config;

    /**
     * @param array $additionalConfig
     * 'amount' : int, required
     * 'hours' : string, optional
     * 'days' : array, optional
     */
    public function addConfig(array $additionalConfig): self
    {
        foreach ($additionalConfig as $config) {
            if (!Arr::has($config, 'amount')) {
                Arr::set($config, 'amount', $this->amount);
            }

            $this->configure(
                Arr::get($config, 'amount'),
                Arr::get($config, 'days'),
                Arr::get($config, 'hours'),
            );
        }

        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function setBasePrice(int $price): self
    {
        $this->amount = $price;

        $this->configure($price);

        return $this;
    }

    private function configure(int $amount, array $days = null, string $configHours = null): void
    {
        $hours = null;

        if (is_string($configHours)) {
            $hours = $this->prepareHours($configHours);
        }

        if (is_null($hours)) {
            $hours = range(0, 23);
        }

        if (empty($days)) {
            $days = range(1, 7);
        }

        collect($days)->each(function ($day) use ($hours, $amount) {
            collect($hours)->each(function ($hour) use ($day, $amount) {
                $this->config[$day][$hour] = $amount;
            });
        });
    }

    private function prepareHours(string $hours): array
    {
        [$start, $end] = explode('-', $hours);

        return range($start, $end);
    }

    public function resetConfig(): void
    {
        $this->setBasePrice($this->amount);
    }
}
