<?php

namespace MageSuite\GoogleApi\Controller\Index;

class Geolocation extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \MageSuite\GoogleApi\Service\GeoLocationResolver
     */
    protected $geoLocationResolver;

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $resultJsonFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \MageSuite\GoogleApi\Service\GeoLocationResolver $geoLocationResolver,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    )
    {
        parent::__construct($context);

        $this->geoLocationResolver = $geoLocationResolver;
        $this->formKeyValidator = $formKeyValidator;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    public function execute()
    {
        $resultJson = $this->resultJsonFactory->create();

        if (!$this->formKeyValidator->validate($this->getRequest())) {

            $result = [
                'error' => __('Bad Request'),
                'errorcode' => \Zend\Http\Response::STATUS_CODE_400
            ];

            $resultJson->setStatusHeader(
                \Zend\Http\Response::STATUS_CODE_400,
                \Zend\Http\AbstractMessage::VERSION_11,
                'Bad Request'
            );

            return $resultJson->setData($result);
        }

        $parameters = $this->getRequest()->getParams();

        $response = $this->geoLocationResolver->execute($parameters);

        return $resultJson->setData($response);
    }
}
