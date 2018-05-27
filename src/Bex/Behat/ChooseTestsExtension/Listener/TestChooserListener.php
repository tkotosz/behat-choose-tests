<?php

namespace Bex\Behat\ChooseTestsExtension\Listener;

use Bex\Behat\ChooseTestsExtension\Chooser\FeatureChooser;
use Bex\Behat\ChooseTestsExtension\Chooser\ScenarioChooser;
use Bex\Behat\ChooseTestsExtension\Chooser\SuiteChooser;
use Bex\Behat\ChooseTestsExtension\Event\AfterAvailableSuitesRegistered;
use Bex\Behat\ChooseTestsExtension\Event\AvailableSuitesRegistered;
use Bex\Behat\ChooseTestsExtension\Event\BeforeAvailableSuitesRegistered;
use Bex\Behat\ChooseTestsExtension\ServiceContainer\Config;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TestChooserListener implements EventSubscriberInterface
{
    /**
     * @var Config
     */
    private $config;
    
    /**
     * @var SuiteChooser
     */
    private $suiteChooser;
    
    /**
     * @var FeatureChooser
     */
    private $featureChooser;
    
    /**
     * @var ScenarioChooser
     */
    private $scenarioChooser;
    
    /**
     * @param Config          $config
     * @param SuiteChooser    $suiteChooser
     * @param FeatureChooser  $featureChooser
     * @param ScenarioChooser $scenarioChooser
     */
    public function __construct(
        Config $config,
        SuiteChooser $suiteChooser,
        FeatureChooser $featureChooser,
        ScenarioChooser $scenarioChooser
    ) {
        $this->config = $config;
        $this->suiteChooser = $suiteChooser;
        $this->featureChooser = $featureChooser;
        $this->scenarioChooser = $scenarioChooser;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            AvailableSuitesRegistered::BEFORE => [
                ['selectSuite']
            ],
            AvailableSuitesRegistered::AFTER => [
                ['selectFeature'],
                ['selectScenario']
            ],
        ];
    }

    public function selectSuite(BeforeAvailableSuitesRegistered $event)
    {
        if ($this->config->isSuiteSelectorEnabled()) {
            $this->suiteChooser->execute();
        }
    }

    public function selectFeature(AfterAvailableSuitesRegistered $event)
    {
        if ($this->config->isFeatureSelectorEnabled()) {
            $this->featureChooser->execute();
        }
    }

    public function selectScenario(AfterAvailableSuitesRegistered $event)
    {
        if ($this->config->isScenarioSelectorEnabled()) {
            $this->scenarioChooser->execute();
        }
    }
}
