<?php

namespace MageSuite\GoogleApi\Block;

class ApiSettings extends \Magento\Framework\View\Element\Template
{
    protected $_template = 'MageSuite_GoogleApi::api_settings.phtml';

    /**
     * @var \Magento\Framework\Locale\Resolver
     */
    protected $localeResolver;

    /**
     * @var \MageSuite\GoogleApi\Helper\Configuration
     */
    protected $configuration;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Locale\Resolver $localeResolver,
        \MageSuite\GoogleApi\Helper\Configuration $configuration,
        array $data = []
    ) {
        parent::__construct($context, $data);

        $this->localeResolver = $localeResolver;
        $this->configuration = $configuration;
    }

    public function getGoogleApiSettings()
    {
        $localeData = $this->getLocaleData();

        return [
            'key' => $this->getGoogleApiKey(),
            'language' => $localeData[0],
            'region' => $localeData[1]
        ];
    }

    private function getGoogleApiKey()
    {
        return $this->configuration->getGoogleApiKey();
    }

    private function getLocaleData()
    {
        $locale = $this->localeResolver->getLocale();

        return explode('_', $locale);
    }


}