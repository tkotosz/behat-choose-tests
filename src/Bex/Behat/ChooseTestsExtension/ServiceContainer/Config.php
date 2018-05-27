<?php

namespace Bex\Behat\ChooseTestsExtension\ServiceContainer;

class Config
{
    private $suiteSelectorEnabled = false;
    private $featureSelectorEnabled = false;
    private $scenarioSelectorEnabled = false;
    
    /**
     * @param array $config
     */
    public function __construct($config)
    {
        // ...
    }

    public function enableAll()
    {
        $this->enableSuiteSelector();
        $this->enableFeatureSelector();
        $this->enableScenarioSelector();
    }

    public function enableSuiteSelector()
    {
        $this->suiteSelectorEnabled = true;
    }

    public function enableFeatureSelector()
    {
        $this->featureSelectorEnabled = true;
    }

    public function enableScenarioSelector()
    {
        $this->scenarioSelectorEnabled = true;
    }

    public function isSuiteSelectorEnabled()
    {
        return $this->suiteSelectorEnabled;
    }

    public function isFeatureSelectorEnabled()
    {
        return $this->featureSelectorEnabled;
    }

    public function isScenarioSelectorEnabled()
    {
        return $this->scenarioSelectorEnabled;
    }
}
