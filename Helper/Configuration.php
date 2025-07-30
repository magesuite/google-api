<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected const GOOGLE_API_CONFIG_PATH = 'google/api';

    protected const GOOGLE_API_CONSENT_REQUIRED_PATH = 'google/api/consent_required';

    protected array $config = [];

    protected \Magento\Framework\Locale\Resolver $localeResolver;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\Locale\Resolver $localeResolver
    ) {
        parent::__construct($context);

        $this->localeResolver = $localeResolver;
    }

    public function getGoogleApiSettings(): array
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

    public function getHttpProxy(): string
    {
        $config = $this->getConfig();

        return $config['http_proxy'] ?? '';
    }

    protected function getLocaleData(): array
    {
        $locale = $this->localeResolver->getLocale();
        return explode('_', $locale);
    }

    protected function getConfig(): array
    {
        if (!$this->config) {
            $this->config = $this->scopeConfig->getValue(self::GOOGLE_API_CONFIG_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }

        return $this->config;
    }

    public function isApiKeyConfigured(): bool
    {
        $config = $this->getConfig();

        return !empty($config['api_key']);
    }

    public function isConsentRequired(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::GOOGLE_API_CONSENT_REQUIRED_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}
