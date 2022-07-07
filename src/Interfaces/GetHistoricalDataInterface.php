<?php

declare(strict_types=1);

namespace App\Interfaces;

use App\Model\HistoricalData;

interface GetHistoricalDataInterface
{
    public function __invoke(string $symbol, ?string $region = null): HistoricalData;
}
