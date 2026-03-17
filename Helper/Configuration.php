<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Helper;

class Configuration
{
    protected const GOOGLE_API_CONFIG_PATH = 'google/api';
    protected const GOOGLE_API_CONSENT_REQUIRED_PATH = 'google/api/consent_required';
    protected const GOOGLE_MAP_ID_PATH = 'google/api/map_id';

    public function __construct(
        protected \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        protected \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        protected \Magento\Framework\Locale\Resolver $localeResolver
    ) {}

    public function getGoogleApiSettings(): array
    {
        $config = $this->getConfig();
        $localeData = $this->getLocaleData();

        return [
            'key' => !empty($config['api_key']) ? $this->encryptor->decrypt($config['api_key']) : null,
            'frontend_key' => !empty($config['api_key_frontend']) ? $this->encryptor->decrypt($config['api_key_frontend']) : null,
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
        return $this->scopeConfig->getValue(self::GOOGLE_API_CONFIG_PATH, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
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

    public function getMapId(): string
    {
        return (string) $this->scopeConfig->getValue(self::GOOGLE_MAP_ID_PATH);
    }
}
