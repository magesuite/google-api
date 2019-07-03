<?php

namespace MageSuite\GoogleApi\Model\ViewModel;

class ScriptTag implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \MageSuite\GoogleApi\Helper\Configuration
     */
    protected $configuration;

    /**
     * @var \Magento\Framework\App\Request\Http
     */
    protected $request;

    /**
     * @var array
     */
    protected $actionsWithScriptTag = [];

    public function __construct(
        \MageSuite\GoogleApi\Helper\Configuration $configuration,
        \Magento\Framework\App\Request\Http $request,
        $actionsWithScriptTag = []
    )
    {
        $this->configuration = $configuration;
        $this->actionsWithScriptTag = $actionsWithScriptTag;
        $this->request = $request;
    }

    public function getApiKey() {
        $googleApiSettings = $this->configuration->getGoogleApiSettings();

        return $googleApiSettings['key'];
    }

    public function shouldScriptTagBeRendered() {
        if(!$this->configuration->isApiKeyConfigured()) {
            return false;
        }

        $currentActionName = $this->request->getFullActionName();

        return in_array($currentActionName, $this->actionsWithScriptTag);
    }
}