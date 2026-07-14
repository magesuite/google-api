<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Service;

abstract class AbstractGoogleApiResolver
{
    protected const TIMEOUT = 10;

    protected ?\GuzzleHttp\Client $http = null;

    public function __construct(
        protected \MageSuite\GoogleApi\Helper\Configuration $configuration,
        protected \Psr\Log\LoggerInterface $logger
    ) {}

    abstract protected function getApiUrl(): string;

    abstract protected function getAllowedParameters(): array;

    public function execute(array $params = []): ?\stdClass
    {
        $params = $this->prepareParameters($params);
        $options = [
            'query' => $params,
            'timeout' => static::TIMEOUT
        ];
        $httpProxy = $this->configuration->getHttpProxy();

        if (!empty($httpProxy)) {
            $options['proxy'] = $httpProxy;
        }

        $response = $this->getClient()->get($this->getApiUrl(), $options);

        if ($response->getStatusCode() != 200) {
            $this->logger->warning(sprintf(
                'Problem in %s request, status code: %s, parameters: %s, response: %s',
                static::class,
                $response->getStatusCode(),
                implode(',', $params),
                $response->getBody()->getContents()
            ));

            return null;
        }

        return json_decode($response->getBody()->getContents()) ?: null;
    }

    public function prepareParameters(array $params): array
    {
        $params = array_merge($this->configuration->getGoogleApiSettings(), $params);

        return array_intersect_key($params, array_flip($this->getAllowedParameters()));
    }

    protected function getClient(): \GuzzleHttp\Client
    {
        if ($this->http === null) {
            $this->http = new \GuzzleHttp\Client([
                'timeout' => static::TIMEOUT,
                'allow_redirects' => true,
                'http_errors' => false,
            ]);
        }

        return $this->http;
    }
}
