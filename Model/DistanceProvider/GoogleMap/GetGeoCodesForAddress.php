<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Model\DistanceProvider\GoogleMap;

class GetGeoCodesForAddress extends \Magento\InventoryDistanceBasedSourceSelection\Model\DistanceProvider\GoogleMap\GetGeoCodesForAddress
{
    protected const string GOOGLE_ENDPOINT = 'https://maps.google.com/maps/api/geocode/json';
    protected const int TIMEOUT = 10;

    protected ?\GuzzleHttp\Client $httpClient = null;

    public function __construct(
        \Magento\Framework\HTTP\ClientInterface $client,
        protected \Magento\Framework\Serialize\Serializer\Json $json,
        protected \Magento\InventoryDistanceBasedSourceSelection\Model\DistanceProvider\GoogleMap\GetApiKey $getApiKey,
        protected \Magento\InventoryDistanceBasedSourceSelection\Model\Convert\AddressToComponentsString $addressToComponentsString,
        protected \Magento\InventoryDistanceBasedSourceSelection\Model\Convert\AddressToQueryString $addressToQueryString,
        protected \Magento\InventoryDistanceBasedSourceSelection\Model\Convert\AddressToString $addressToString,
        protected \MageSuite\GoogleApi\Helper\Configuration $configuration
    ) {
        parent::__construct(
            $client,
            $json,
            $getApiKey,
            $addressToComponentsString,
            $addressToQueryString,
            $addressToString
        );
    }

    public function execute(\Magento\InventorySourceSelectionApi\Api\Data\AddressInterface $address): array
    {
        $httpProxy = $this->configuration->getDistanceProviderHttpProxy();

        if (empty($httpProxy)) {
            return parent::execute($address);
        }

        return $this->geocodeThroughProxy($address, $httpProxy);
    }

    protected function geocodeThroughProxy(
        \Magento\InventorySourceSelectionApi\Api\Data\AddressInterface $address,
        string $httpProxy
    ): array {
        $response = $this->getClient()->get(self::GOOGLE_ENDPOINT, [
            'query' => [
                'key' => $this->getApiKey->execute(),
                'components' => $this->addressToComponentsString->execute($address),
                'address' => $this->addressToQueryString->execute($address),
            ],
            'proxy' => $httpProxy,
            'timeout' => self::TIMEOUT,
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Unable to connect google API for geocoding')
            );
        }

        $result = $this->json->unserialize($response->getBody()->getContents());

        if ($result['status'] !== 'OK') {
            throw new \Magento\Framework\Exception\LocalizedException(
                __('Unable to geocode address %1', $this->addressToString->execute($address))
            );
        }

        return $result;
    }

    protected function getClient(): \GuzzleHttp\Client
    {
        if ($this->httpClient === null) {
            $this->httpClient = new \GuzzleHttp\Client([
                'timeout' => self::TIMEOUT,
                'allow_redirects' => true,
                'http_errors' => false,
            ]);
        }

        return $this->httpClient;
    }
}
