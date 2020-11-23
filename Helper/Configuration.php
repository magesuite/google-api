<?php

namespace MageSuite\GoogleApi\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Locale\Resolver;
use Magento\Store\Model\ScopeInterface;

class Configuration extends AbstractHelper
{
    const GOOGLE_API_CONFIG_PATH = 'google/api';

    private $config;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Resolver
     */
    protected $localeResolver;

    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfigInterface,
        Resolver $localeResolver
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
            'key' => $config['api_key'] ?? null,
            'frontend_key' => $config['api_key_frontend'] ?? null,
            'language' => $localeData[0] ?? null,
            'region' => $localeData[1] ?? null
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
            $this->config = $this->scopeConfig->getValue(self::GOOGLE_API_CONFIG_PATH, ScopeInterface::SCOPE_STORE);
        }

        return $this->config;
    }

    public function isApiKeyConfigured() {
        $config = $this->getConfig();

        return isset($config['api_key']) and !empty($config['api_key']);
    }
}
