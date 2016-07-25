<?php

namespace KMTests\CookieEncryptionBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    const CONFIG_ROOT_KEY = 'km_tests_cookie_encryption';
    const ENCODER_SERVICE_KEY = 'cookie_encoder_service';
    const COOKIE_DATA_PROVIDER_KEY = 'cookie_data_provider_service';
    const SSl_ENCODER_SECRET_KEY = 'sll_encoder_secret';
    const SSL_ENCODER_METHOD_KEY = 'ssl_encoder_method';
    const COOKIE_EXPIRE_KEY = 'expiry_interval';
    const COOKIE_NAME_KEY = 'default_name';
    const COOKIE_ARG_NAME_KEY = 'default_arg_key';
    const AUTO_STORE_KEY = 'cookie_auto_store';
    const COOKIE_DOMAIN_KEY = 'cookie_domain';

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(self::CONFIG_ROOT_KEY);
        $rootNode
            ->children()
                ->scalarNode(self::ENCODER_SERVICE_KEY)
                    ->defaultValue('ssl_encoder.service')
                ->end()
                ->scalarNode(self::COOKIE_DATA_PROVIDER_KEY)->end()
                ->scalarNode(self::SSl_ENCODER_SECRET_KEY)
                    ->defaultValue('%secret%')
                ->end()
                ->scalarNode(self::SSL_ENCODER_METHOD_KEY)
                    ->defaultValue('AES-128-CFB')
                ->end()
                ->scalarNode(self::COOKIE_EXPIRE_KEY)
                    ->defaultValue('P1D')
                ->end()
                ->scalarNode(self::COOKIE_NAME_KEY)
                    ->defaultValue('secret_cookie')
                ->end()
                ->scalarNode(self::COOKIE_ARG_NAME_KEY)
                    ->defaultValue('secretCookie')
                ->end()
                ->booleanNode(self::AUTO_STORE_KEY)
                    ->defaultTrue()
                ->end()
                ->scalarNode(self::COOKIE_DOMAIN_KEY)
                    ->defaultValue('127.0.0.1')
                ->end()
            ->end()
        ;
        return $treeBuilder;
    }
}
