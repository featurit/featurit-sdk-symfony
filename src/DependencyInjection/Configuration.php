<?php

namespace Featurit\Client\Symfony\DependencyInjection;

use Featurit\Client\Modules\Segmentation\FeaturitUserContextProvider;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('featurit');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('tenant_identifier')
                    ->info('The tenant identifier (usually your tenant subdomain)')
                    ->defaultNull()
                ->end()
                ->scalarNode('environment_key')
                    ->info('The environment key to use by your application')
                    ->defaultNull()
                ->end()
                ->scalarNode('cache_ttl_minutes')
                    ->info('Cache time between calls to the FeaturIT API')
                    ->defaultValue(5)
                ->end()
                ->scalarNode('featurit_user_context_provider')
                    ->info('The user context provider for FeaturIT, must implement the ' . FeaturitUserContextProvider::class . ' interface')
                    ->defaultNull()
                ->end()
            ->end();

        return $treeBuilder;
    }
}