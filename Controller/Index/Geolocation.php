<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Controller\Index;

class Geolocation implements \Magento\Framework\App\Action\HttpPostActionInterface
{
    public function __construct(
        protected \MageSuite\GoogleApi\Service\GeoLocationResolver $geoLocationResolver,
        protected \Magento\Framework\App\RequestInterface $request,
        protected \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {}

    public function execute(): \Magento\Framework\Controller\Result\Json
    {
        $resultJson = $this->resultJsonFactory->create();
        $parameters = $this->request->getParams();
        $response = $this->geoLocationResolver->execute($parameters);

        return $resultJson->setData($response);
    }
}
