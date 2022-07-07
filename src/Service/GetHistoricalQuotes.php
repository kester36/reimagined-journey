<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\GetHistoricalDataInterface;
use App\Model\Price;

class GetHistoricalQuotes
{
    public function __construct(private readonly GetHistoricalDataInterface $getHistoricalData)
    {
    }

    /** @return Price[] */
    public function __invoke(
        string $companySymbol,
        \DateTimeImmutable $startDate,
        \DateTimeImmutable $endDate,
    ): array {
        $historicalData = $this->getHistoricalData->__invoke($companySymbol);

        $result = [];
        foreach ($historicalData->prices as $price) {
            if (
                $price->date >= $startDate->getTimestamp()
                && $price->date <= $endDate->getTimestamp()
            ) {
                $result[] = $price;
            }
        }

        return $result;
    }
}
