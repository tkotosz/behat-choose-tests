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

class FeatureChooser extends BaseChooser
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
        $features = $this->getFeatures();

        if ($this->shouldAskQuestion($features)) {
            $answer = $this->askQuestion('Choose feature:', array_merge(['All'], array_keys($features)), 'All');

            if ($answer !== 'All') {
                $this->input->setArgument('paths', $features[$answer]);
            }
        }
    }

    private function shouldAskQuestion(array $features = [])
    {
        $selectedFeature = $this->input->getArgument('paths');
        $numberOfFeatures = count($features);

        return empty($selectedFeature) && ($numberOfFeatures > 1);
    }

    private function getFeatures()
    {
        $features = [];

        $specificationIterators = $this->specificationFinder->findSuitesSpecifications($this->suiteRepository->getSuites());

        foreach ($specificationIterators as $iterator) {
            foreach ($iterator as $specification) {
                if ($specification instanceof FeatureNode) {
                    $value = $specification->getFile();
                    $key = sprintf('%s (%s)', $specification->getTitle(), $value);
                    $features[$key] = $value;
                }
            }
        }

        return $features;
    }
}
