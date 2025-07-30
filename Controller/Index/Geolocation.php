<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Controller\Index;

class Geolocation extends \Magento\Framework\App\Action\Action
{
    protected \MageSuite\GoogleApi\Service\GeoLocationResolver $geoLocationResolver;

    protected \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator;

    protected \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\GoogleApi\Service\GeoLocationResolver $geoLocationResolver,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);

        $this->geoLocationResolver = $geoLocationResolver;
        $this->formKeyValidator = $formKeyValidator;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute(): \Magento\Framework\Controller\Result\Json
    {
        $resultJson = $this->resultJsonFactory->create();

        if (!$this->formKeyValidator->validate($this->getRequest())) {

            $result = [
                'error' => __('Bad Request'),
                'errorcode' => \Laminas\Http\Response::STATUS_CODE_400
            ];

            $resultJson->setStatusHeader(
                \Laminas\Http\Response::STATUS_CODE_400,
                \Laminas\Http\AbstractMessage::VERSION_11,
                'Bad Request'
            );

            return $resultJson->setData($result);
        }

        $parameters = $this->getRequest()->getParams();

        $response = $this->geoLocationResolver->execute($parameters);

        return $resultJson->setData($response);
    }
}
