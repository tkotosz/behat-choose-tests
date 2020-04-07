<?php

namespace Bex\Behat\ChooseTestsExtension\Decorator;

use Behat\Testwork\Cli\Controller;
use Behat\Testwork\EventDispatcher\TestworkEventDispatcherSymfonyLegacy;
use Bex\Behat\ChooseTestsExtension\Event\AfterAvailableSuitesRegistered;
use Bex\Behat\ChooseTestsExtension\Event\AvailableSuitesRegistered;
use Bex\Behat\ChooseTestsExtension\Event\BeforeAvailableSuitesRegistered;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SuiteControllerDecorator implements Controller
{
    /**
     * @var Controller
     */
    private $suiteContoller;
    
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    
    /**
     * @param Controller               $suiteContoller
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(Controller $suiteContoller, EventDispatcherInterface $eventDispatcher)
    {
        $this->suiteContoller = $suiteContoller;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Configures command to be executable by the controller.
     *
     * @param SymfonyCommand $command
     */
    public function configure(SymfonyCommand $command)
    {
        return $this->suiteContoller->configure($command);
    }

    /**
     * Executes controller.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return null|integer
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->eventDispatcher instanceof TestworkEventDispatcherSymfonyLegacy) {
            $this->eventDispatcher->dispatch(AvailableSuitesRegistered::BEFORE, new BeforeAvailableSuitesRegistered());
        } else {
            $this->eventDispatcher->dispatch(new BeforeAvailableSuitesRegistered(), AvailableSuitesRegistered::BEFORE);    
        }
        
        $result = $this->suiteContoller->execute($input, $output);

        if ($this->eventDispatcher instanceof TestworkEventDispatcherSymfonyLegacy) {
            $this->eventDispatcher->dispatch(AvailableSuitesRegistered::AFTER, new AfterAvailableSuitesRegistered());
        } else {
            $this->eventDispatcher->dispatch(new AfterAvailableSuitesRegistered(), AvailableSuitesRegistered::AFTER);    
        }

        return $result;
    }
}
