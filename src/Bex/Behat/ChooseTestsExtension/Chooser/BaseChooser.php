<?php

namespace Bex\Behat\ChooseTestsExtension\Chooser;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

abstract class BaseChooser
{
    /**
     * @var InputInterface
     */
    protected $input;
    
    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * Asks user question.
     *
     * @param string   $message
     * @param string[] $choices
     * @param string   $default
     *
     * @return string
     */
    protected function askQuestion($message, $choices, $default)
    {
        $this->output->writeln('');
        $helper = new QuestionHelper();
        $question = new ChoiceQuestion(' ' . $message . "\n", $choices, $default);

        return $helper->ask($this->input, $this->output, $question);
    }

    abstract public function execute();
}
