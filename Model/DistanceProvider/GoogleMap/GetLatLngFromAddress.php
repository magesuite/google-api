<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Model\DistanceProvider\GoogleMap;

class GetLatLngFromAddress extends \Magento\InventoryDistanceBasedSourceSelection\Model\DistanceProvider\GoogleMap\GetLatLngFromAddress
{
    public function __construct(
        \Magento\Framework\HTTP\ClientInterface $client,
        \Magento\InventoryDistanceBasedSourceSelectionApi\Api\Data\LatLngInterfaceFactory $latLngInterfaceFactory,
        \Magento\Framework\Serialize\Serializer\Json $json,
        \Magento\InventoryDistanceBasedSourceSelection\Model\DistanceProvider\GoogleMap\GetApiKey $getApiKey,
        \Magento\InventoryDistanceBasedSourceSelection\Model\Convert\AddressToComponentsString $addressToComponentsString,
        \Magento\InventoryDistanceBasedSourceSelection\Model\Convert\AddressToQueryString $addressToQueryString,
        \Magento\InventoryDistanceBasedSourceSelection\Model\Convert\AddressToString $addressToString,
        \MageSuite\GoogleApi\Model\DistanceProvider\GoogleMap\GetGeoCodesForAddress $getGeoCodesForAddress
    ) {
        parent::__construct(
            $client,
            $latLngInterfaceFactory,
            $json,
            $getApiKey,
            $addressToComponentsString,
            $addressToQueryString,
            $addressToString,
            $getGeoCodesForAddress
        );
    }
}
