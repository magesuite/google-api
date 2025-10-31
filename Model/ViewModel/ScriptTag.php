<?php

declare(strict_types=1);

namespace MageSuite\GoogleApi\Model\ViewModel;

class ScriptTag implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    protected \MageSuite\GoogleApi\Helper\Configuration $configuration;

    protected \Magento\Framework\App\Request\Http $request;

    protected array $actionsWithScriptTag = [];

    public function __construct(
        \MageSuite\GoogleApi\Helper\Configuration $configuration,
        \Magento\Framework\App\Request\Http $request,
        array $actionsWithScriptTag = []
    ) {
        $this->configuration = $configuration;
        $this->actionsWithScriptTag = $actionsWithScriptTag;
        $this->request = $request;
    }

    public function getApiKey(): string
    {
        $googleApiSettings = $this->configuration->getGoogleApiSettings();
        return $googleApiSettings['key'];
    }

    public function getFrontendApiKey(): string
    {
        $googleApiSettings = $this->configuration->getGoogleApiSettings();

        if (!empty($googleApiSettings['frontend_key'])) {
            return $googleApiSettings['frontend_key'];
        }

        return $this->getApiKey();
    }

    public function shouldScriptTagBeRendered(): bool
    {
        if (!$this->configuration->isApiKeyConfigured()) {
            return false;
        }

        $currentActionName = $this->request->getFullActionName();
        return in_array($currentActionName, $this->actionsWithScriptTag);
    }

    public function isConsentRequired(): bool
    {
        return $this->configuration->isConsentRequired();
    }

    public function getMapId(): string
    {
        return $this->configuration->getMapId() ?: '';
    }
}
