<?php

namespace MageSuite\GoogleApi\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const GOOGLE_API_CONFIG_PATH = 'google/api';

    private $config;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
    ) {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfigInterface;
    }

    public function getGoogleApiKey()
    {
        $config = $this->getConfig();

        return $config['api_key'];
    }

    private function getConfig()
    {
        if(!$this->config){
            $this->config = $this->scopeConfig->getValue(self::GOOGLE_API_CONFIG_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }

        return $this->config;
    }
}
