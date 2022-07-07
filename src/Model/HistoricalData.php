<?php

declare(strict_types=1);

namespace App\Model;

final class HistoricalData
{
    /** @var Price[] */
    public array $prices;
    public bool $isPending;
    public int $firstTradeDate;
    public string $id;
    public TimeZone $timeZone;
    public array $eventsData;
}
