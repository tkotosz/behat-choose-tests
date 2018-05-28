<?php

namespace Bex\Behat\ChooseTestsExtension\Chooser;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Testwork\Specification\SpecificationFinder;
use Behat\Testwork\Suite\SuiteRepository;
use Bex\Behat\ChooseTestsExtension\Chooser\BaseChooser;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class ScenarioChooser extends BaseChooser
{   
    /**
     * @var SuiteRepository
     */
    private $suiteRepository;
    
    /**
     * @var SpecificationFinder
     */
    private $specificationFinder;
    
    /**
     * @param InputInterface      $input
     * @param OutputInterface     $output
     * @param SuiteRepository     $suiteRepository
     * @param SpecificationFinder $specificationFinder
     */
    public function __construct(
        InputInterface $input,
        OutputInterface $output,
        SuiteRepository $suiteRepository,
        SpecificationFinder $specificationFinder
    ) {
        parent::__construct($input, $output);
        
        $this->suiteRepository = $suiteRepository;
        $this->specificationFinder = $specificationFinder;
    }
    
    public function execute()
    {
        $scenarios = $this->getScenarios();

        if ($this->shouldAskQuestion($scenarios)) {
            $answer = $this->askQuestion('Choose scenario:', array_merge(['All'], array_keys($scenarios)), 'All');
            
            if ($answer !== 'All') {
                $this->input->setArgument('paths', $scenarios[$answer]);
            }
        }
    }

    private function shouldAskQuestion(array $scenarios = [])
    {
        $selectedFeature = $this->input->getArgument('paths');
        $numberOfScenarios = count($scenarios);

        return (empty($selectedFeature) || (strpos($selectedFeature, ':') === false)) && ($numberOfScenarios > 1);
    }

    public function getScenarios()
    {
        $scenarios = [];

        $specificationIterators = $this->specificationFinder->findSuitesSpecifications(
            $this->suiteRepository->getSuites(),
            $this->input->getArgument('paths')
        );

        foreach ($specificationIterators as $iterator) {
            foreach ($iterator as $specification) {
                if ($specification instanceof FeatureNode) {
                    foreach ($specification->getScenarios() as $scenario) {
                        $value = $specification->getFile() . ':' . $scenario->getLine();
                        $key = sprintf('%s (%s)', $scenario->getTitle(), $value);
                        $scenarios[$key] = $value;
                    }
                }
            }
        }

        return $scenarios;
    }
}
