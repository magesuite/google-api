<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Service;

class PlaceAutocompleteResolver
{
    protected const AUTOCOMPLETE_TIMEOUT = 10;
    protected const AUTOCOMPLETE_URL = 'https://maps.googleapis.com/maps/api/place/autocomplete/json';

    protected array $googleApiParameters = ['key', 'input', 'language', 'components'];

    protected \GuzzleHttp\Client $http;

    protected \MageSuite\GoogleApi\Helper\Configuration $configuration;

    protected \Psr\Log\LoggerInterface $logger;

    public function __construct(
        \MageSuite\GoogleApi\Helper\Configuration $configuration,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->configuration = $configuration;
        $this->logger = $logger;

        $this->http = new \GuzzleHttp\Client([
            'timeout' => self::AUTOCOMPLETE_TIMEOUT,
            'allow_redirects' => true,
            'http_errors' => false,
        ]);
    }

    public function execute(array $params = []): ?array
    {
        $params = $this->prepareParameters($params);

        $response = $this->http->get(self::AUTOCOMPLETE_URL, [
            'query' => $params,
            'timeout' => self::AUTOCOMPLETE_TIMEOUT
        ]);

        if ($response->getStatusCode() != 200) {
            $message = sprintf('Problem in PlaceAutocompleteResolver request, status code: %s, parameters: %s, response: %s', $response->getStatusCode(), implode(',', $params), $response->getBody()->getContents());
            $this->logger->warning($message);

            return null;
        }

        return json_decode($response->getBody()->getContents());
    }

    public function prepareParameters(array $params): array
    {
        $params = array_merge($this->configuration->getGoogleApiSettings(), $params);
        $params = array_intersect_key($params, array_flip($this->googleApiParameters));

        return $params;
    }
}
