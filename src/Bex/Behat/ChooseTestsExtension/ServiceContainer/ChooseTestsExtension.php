<?php

namespace Bex\Behat\ChooseTestsExtension\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This class is the entry point of the extension
 *
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class ChooseTestsExtension implements Extension
{
    const CONFIG_KEY = 'choosetests';

     /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return self::CONFIG_KEY;
    }
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // nothing to do here
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        // nothing to do here
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        // ...
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/config'));
        $loader->load('services.xml');
        $extensionConfig = new Config($config);
        $container->set('bex.choose_tests_extension.config', $extensionConfig);
    }
}
