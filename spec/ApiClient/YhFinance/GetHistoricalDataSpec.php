<?php

namespace spec\App\ApiClient\YhFinance;

use App\ApiClient\YhFinance\GetHistoricalData;
use App\Interfaces\GetHistoricalDataInterface;
use App\Model\HistoricalData;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class GetHistoricalDataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(GetHistoricalData::class);
        $this->shouldBeAnInstanceOf(GetHistoricalDataInterface::class);
    }

    function let(HttpClientInterface $yhFinanceHttpClient, SerializerInterface $serializer)
    {
        $this->beConstructedWith($yhFinanceHttpClient, $serializer);
    }

    function it_returns_historical_data(
        HttpClientInterface $yhFinanceHttpClient,
        ResponseInterface $response,
        SerializerInterface $serializer,
    ) {
        $symbol = 'TEST';
        $region = 'US';

        $yhFinanceHttpClient
            ->request('GET', 'get-historical-data', ['query' => ['symbol' => $symbol, 'region' => $region]])
            ->shouldBeCalled()
            ->willReturn($response);

        $response->getContent()->shouldBeCalled()->willReturn($jsonString = '{"key": "value"}');

        $serializer
            ->deserialize($jsonString, HistoricalData::class, 'json')
            ->shouldBeCalled()
            ->willReturn($historicalData = new HistoricalData());

        $this->__invoke($symbol, $region)->shouldBe($historicalData);
    }

    function it_fails_if_failed_if_transport_exception(
        HttpClientInterface $yhFinanceHttpClient,
        ResponseInterface $response,
        SerializerInterface $serializer,
        TransportExceptionInterface $exceptionWrap,
    ) {
        $exception = $exceptionWrap->getWrappedObject();

        $symbol = 'TEST';
        $region = 'US';

        $yhFinanceHttpClient
            ->request('GET', 'get-historical-data', ['query' => ['symbol' => $symbol, 'region' => $region]])
            ->shouldBeCalled()
            ->willThrow($exception);

        $response->getContent()->shouldNotBeCalled();
        $serializer->deserialize(Argument::any(), Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->shouldThrow($exception)->during('__invoke', [$symbol, $region]);
    }

    function it_fails_if_failed_if_not_success_response(
        HttpClientInterface $yhFinanceHttpClient,
        ResponseInterface $response,
        SerializerInterface $serializer,
        HttpExceptionInterface $exceptionWrap,
    ) {
        $exception = $exceptionWrap->getWrappedObject();

        $symbol = 'TEST';
        $region = 'US';

        $yhFinanceHttpClient
            ->request('GET', 'get-historical-data', ['query' => ['symbol' => $symbol, 'region' => $region]])
            ->shouldBeCalled()
            ->willReturn($response);

        $response->getContent()->shouldBeCalled()->willThrow($exception);

        $serializer->deserialize(Argument::any(), Argument::any(), Argument::any())->shouldNotBeCalled();

        $this->shouldThrow($exception)->during('__invoke', [$symbol, $region]);
    }

}
