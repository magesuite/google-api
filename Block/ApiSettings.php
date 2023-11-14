<?php

namespace MageSuite\GoogleApi\Block;

class ApiSettings extends \Magento\Framework\View\Element\Template
{
    protected $_template = 'MageSuite_GoogleApi::api_settings.phtml';

    /**
     * @var \MageSuite\GoogleApi\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \MageSuite\GoogleApi\Helper\Configuration $configuration,
        array $data = []
    ) {
        parent::__construct($context, $data);


        $this->configuration = $configuration;
    }

    public function getGoogleApiSettings()
    {
        return $this->configuration->getGoogleApiSettings();
    }
}
