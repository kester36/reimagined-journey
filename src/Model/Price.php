<?php

declare(strict_types=1);

namespace App\Model;

final class Price
{
    public float $date;
    public float $open;
    public float $high;
    public float $low;
    public float $close;
    public int $volume;
    public float $adjclose;
}
