<?php

namespace spec\App\Service;

use App\Interfaces\GetHistoricalDataInterface;
use App\Model\HistoricalData;
use App\Model\Price;
use App\Service\GetHistoricalQuotes;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GetHistoricalQuotesSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GetHistoricalQuotes::class);
    }

    function let(GetHistoricalDataInterface $getHistoricalData)
    {
        $this->beConstructedWith($getHistoricalData);
    }

    function it_returns_historical_quotes(GetHistoricalDataInterface $getHistoricalData)
    {
        $companySymbol = 'TEST';
        $startDate = new \DateTimeImmutable('2021/12/22');
        $endDate = new \DateTimeImmutable('2022/01/22');

        $historicalData = new HistoricalData();
        $historicalData->prices = [
            $this->createPrice($startDate->getTimestamp() - 1000),
            $this->createPrice($startDate->getTimestamp() + 1),
            $this->createPrice($endDate->getTimestamp() - 1),
            $this->createPrice($endDate->getTimestamp() + 1000),
        ];

        $getHistoricalData
            ->__invoke($companySymbol)
            ->shouldBeCalled()
            ->willReturn($historicalData);

        $this
            ->__invoke($companySymbol, $startDate, $endDate)
            ->shouldBe([
                $historicalData->prices[1],
                $historicalData->prices[2],
            ])
        ;
    }

    function it_returns_empty_array_if_no_data_in_range(GetHistoricalDataInterface $getHistoricalData)
    {
        $companySymbol = 'TEST';
        $startDate = new \DateTimeImmutable('2021/12/22');
        $endDate = new \DateTimeImmutable('2022/01/22');

        $historicalData = new HistoricalData();
        $historicalData->prices = [
            $this->createPrice($startDate->getTimestamp() - 1000),
            $this->createPrice($endDate->getTimestamp() + 1000),
        ];

        $getHistoricalData
            ->__invoke($companySymbol)
            ->shouldBeCalled()
            ->willReturn($historicalData);

        $this->__invoke($companySymbol, $startDate, $endDate)->shouldBe([]);
    }

    function it_fails_if_any_exception_happen(GetHistoricalDataInterface $getHistoricalData)
    {
        $companySymbol = 'TEST';
        $startDate = new \DateTimeImmutable('2021/12/22');
        $endDate = new \DateTimeImmutable('2022/01/22');

        $getHistoricalData
            ->__invoke($companySymbol)
            ->shouldBeCalled()
            ->willThrow($exception = new \Exception());

        $this->shouldThrow($exception)->during('__invoke',[$companySymbol, $startDate, $endDate]);
    }


    private function createPrice(int $date)
    {
        $price = new Price();
        $price->date = $date;

        return $price;
    }
}
