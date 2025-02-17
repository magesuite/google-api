<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Service;

class GeoLocationResolver
{
    const GEOLOCATION_TIMEOUT = 10;
    const GEOLOCATION_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    protected $googleApiParameters = ['key', 'address', 'language', 'region', 'components'];
    protected ?\GuzzleHttp\Client $http = null;

    public function __construct(
        protected \MageSuite\GoogleApi\Helper\Configuration $configuration,
        protected \Psr\Log\LoggerInterface $logger
    ) {}

    public function execute(array $params = []): ?object
    {
        $params = $this->prepareParameters($params);
        $options = [
            'query' => $params,
            'timeout' => self::GEOLOCATION_TIMEOUT
        ];
        $httpProxy = $this->configuration->getHttpProxy();

        if (!empty($httpProxy)) {
            $options['proxy'] = $httpProxy;
        }

        $response = $this->getClient()->get(self::GEOLOCATION_URL, $options);

        if ($response->getStatusCode() != 200){
            $message = sprintf('Problem in GeoLocationResolver request, status code: %s, parameters: %s, response: %s', $response->getStatusCode(), implode(',', $params), $response->getBody()->getContents());
            $this->logger->warning($message);

            return null;
        }

        return json_decode($response->getBody()->getContents());
    }

    public function prepareParameters(array $params)
    {
        $params = array_merge($this->configuration->getGoogleApiSettings(), $params);
        $params = array_intersect_key($params, array_flip($this->googleApiParameters));

        return $params;
    }

    protected function getClient(): \GuzzleHttp\Client
    {
        if ($this->http === null) {
            $this->http = new \GuzzleHttp\Client([
                'timeout' => self::GEOLOCATION_TIMEOUT,
                'allow_redirects' => true,
                'http_errors' => false,
            ]);
        }

        return $this->http;
    }
}
