<?php

namespace Bex\Behat\ChooseTestsExtension\Controller;

use Behat\Testwork\Cli\Controller;
use Bex\Behat\ChooseTestsExtension\ServiceContainer\Config;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class FeatureChooserController implements Controller
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
        $command->addOption('--choose-feature', null, InputOption::VALUE_NONE, 'Choose feature');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('choose-feature') && $input->isInteractive()) {
            $this->config->enableFeatureSelector();
        }
    }
}
