<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Model\DistanceProvider\GoogleMap;

class GetLatsLngsFromAddress extends \Magento\InventoryDistanceBasedSourceSelection\Model\DistanceProvider\GoogleMap\GetLatsLngsFromAddress
{
    public function __construct(
        \Magento\InventoryDistanceBasedSourceSelection\Model\Convert\AddressToString $addressToString,
        \MageSuite\GoogleApi\Model\DistanceProvider\GoogleMap\GetGeoCodesForAddress $getGeoCodesForAddress,
        \Magento\InventoryDistanceBasedSourceSelectionApi\Api\Data\LatLngInterfaceFactory $latLngInterfaceFactory
    ) {
        parent::__construct($addressToString, $getGeoCodesForAddress, $latLngInterfaceFactory);
    }
}
