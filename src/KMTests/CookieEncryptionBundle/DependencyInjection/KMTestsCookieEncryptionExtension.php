<?php

namespace KMTests\CookieEncryptionBundle\DependencyInjection;

use KMTests\CookieEncryptionBundle\Services\ConfigProvider;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class KMTestsCookieEncryptionExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setDefinition('test_config.provider', new Definition(ConfigProvider::class, [$config]));
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('encoders.yml');
        $container->setAlias('cookie_data_provider.service', new Alias($config[Configuration::COOKIE_DATA_PROVIDER_KEY]));
        $container->setAlias('cookie_encoder.service', new Alias($config[Configuration::ENCODER_SERVICE_KEY]));
        $loader->load('services.yml');
    }

    public function getAlias()
    {
        return 'km_tests_cookie_encryption';
    }
}
