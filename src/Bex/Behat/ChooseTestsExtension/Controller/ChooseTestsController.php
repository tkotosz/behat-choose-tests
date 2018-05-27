<?php

namespace Bex\Behat\ChooseTestsExtension\Controller;

use Behat\Gherkin\Node\FeatureNode;
use Behat\Testwork\Cli\Controller;
use Behat\Testwork\Specification\SpecificationFinder;
use Behat\Testwork\Suite\SuiteRepository;
use Bex\Behat\ChooseTestsExtension\ServiceContainer\Config;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class ChooseTestsController implements Controller
{
    /**
     * @var Config
     */
    private $config;
    
    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Configures command to be executable by the controller.
     *
     * @param SymfonyCommand $command
     */
    public function configure(SymfonyCommand $command)
    {
        $command->addOption('--choose-tests', null, InputOption::VALUE_NONE, 'Choose tests');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('choose-tests') && $input->isInteractive()) {
            $this->config->enableAll();
        }
    }
}
