<?php

declare(strict_types=1);

namespace App\ApiClient\YhFinance;

use App\Interfaces\GetHistoricalDataInterface;
use App\Model\HistoricalData;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class GetHistoricalData implements GetHistoricalDataInterface
{
    private const METHOD = 'GET';
    private const ENDPOINT = 'get-historical-data';
    private const RESPONSE_FORMAT = 'json';

    public function __construct(
        private readonly HttpClientInterface $yhFinanceHttpClient,
        private readonly SerializerInterface $serializer,
    ) {
    }

    /** @throws TransportExceptionInterface|HttpExceptionInterface */
    public function __invoke(string $symbol, ?string $region = null): HistoricalData
    {
        $queryParams = ['symbol' => $symbol];
        if (isset($region)) {
            $queryParams['region'] = $region;
        }

        $response = $this->yhFinanceHttpClient->request(self::METHOD, self::ENDPOINT, ['query' => $queryParams]);
        $content = $response->getContent();

        return $this->serializer->deserialize(
            $content,
            HistoricalData::class,
            self::RESPONSE_FORMAT,
        );
    }
}
