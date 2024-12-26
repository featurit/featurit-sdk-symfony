<?php

namespace Featurit\Client\Symfony\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class FeaturitExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('twig.yaml');
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('featurit.client');

        if ($config['tenant_identifier']) {
            $definition->replaceArgument(0, $config['tenant_identifier']);
        }

        if ($config['environment_key']) {
            $definition->replaceArgument(1, $config['environment_key']);
        }

        if ($config['enable_analytics']) {
            $definition->replaceArgument(2, $config['enable_analytics']);
        }

        if ($config['enable_tracking']) {
            $definition->replaceArgument(3, $config['enable_tracking']);
        }

        if ($config['cache_ttl_minutes']) {
            $definition->replaceArgument(4, $config['cache_ttl_minutes']);
        }

        if ($config['send_analytics_interval_minutes']) {
            $definition->replaceArgument(5, $config['send_analytics_interval_minutes']);
        }

        if ($config['featurit_user_context_provider']) {
            $container->setAlias(
                'featurit.featurit_user_context_provider',
                substr($config['featurit_user_context_provider'], 1)
            );
        }
    }
}