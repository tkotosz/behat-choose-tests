<?php

namespace Bex\Behat\ChooseTestsExtension\Chooser;

use Bex\Behat\ChooseTestsExtension\Chooser\BaseChooser;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class SuiteChooser extends BaseChooser
{
    /**
     * @var string[]
     */
    private $suiteNames;
    
    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param array           $suiteConfigurations
     */
    public function __construct(InputInterface $input, OutputInterface $output, array $suiteConfigurations = [])
    {
        parent::__construct($input, $output);

        $this->suiteNames = array_keys($suiteConfigurations);
    }
    
    public function execute()
    {
        if ($this->shouldAskQuestion()) {
            $answer = $this->askQuestion('Choose suite:', array_merge(['All'], $this->suiteNames), 'All');

            if ($answer !== 'All') {
                $this->input->setOption('suite', $answer);
            }
        }
    }

    private function shouldAskQuestion()
    {
        return (count($this->suiteNames) > 1) && empty($this->input->getOption('suite'));
    }
}
