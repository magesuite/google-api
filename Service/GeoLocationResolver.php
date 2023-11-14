<?php

namespace MageSuite\GoogleApi\Service;

class GeoLocationResolver
{
    const GEOLOCATION_TIMEOUT = 10;
    const GEOLOCATION_URL = 'https://maps.googleapis.com/maps/api/geocode/json';

    protected $googleApiParameters = ['key', 'address', 'language', 'region', 'components'];

    /**
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * @var \MageSuite\GoogleApi\Helper\Configuration
     */
    protected $configuration;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    public function __construct(
        \MageSuite\GoogleApi\Helper\Configuration $configuration,
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->configuration = $configuration;
        $this->logger = $logger;

        $this->http = new \GuzzleHttp\Client([
            'timeout' => self::GEOLOCATION_TIMEOUT,
            'allow_redirects' => true,
            'http_errors' => false,
        ]);
    }

    public function execute($params = [])
    {
        $params = $this->prepareParameters($params);

        $response = $this->http->get(self::GEOLOCATION_URL, [
            'query' => $params,
            'timeout' => self::GEOLOCATION_TIMEOUT
        ]);

        if ($response->getStatusCode() != 200){
            $message = sprintf('Problem in GeoLocationResolver request, status code: %s, parameters: %s, response: %s', $response->getStatusCode(), implode(',', $params), $response->getBody()->getContents());
            $this->logger->warning($message);

            return null;
        }

        return json_decode($response->getBody()->getContents());
    }

    public function prepareParameters($params)
    {
        $params = array_merge($this->configuration->getGoogleApiSettings(), $params);
        $params = array_intersect_key($params, array_flip($this->googleApiParameters));

        return $params;
    }

}
