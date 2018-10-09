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

    /**
     * @var \Magento\Framework\Locale\Resolver
     */
    protected $localeResolver;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface,
        \Magento\Framework\Locale\Resolver $localeResolver
    ) {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfigInterface;
        $this->localeResolver = $localeResolver;
    }

    public function getGoogleApiSettings()
    {
        $config = $this->getConfig();
        $localeData = $this->getLocaleData();

        return [
            'key' => $config['api_key'],
            'language' => $localeData[0],
            'region' => $localeData[1]
        ];
    }

    protected function getLocaleData()
    {
        $locale = $this->localeResolver->getLocale();

        return explode('_', $locale);
    }

    protected function getConfig()
    {
        if(!$this->config){
            $this->config = $this->scopeConfig->getValue(self::GOOGLE_API_CONFIG_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }

        return $this->config;
    }
}
