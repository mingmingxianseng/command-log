<?php

namespace mmxs\Bundle\CommandLogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('command_log');

        $rootNode->children()
            ->scalarNode('namespace')->defaultValue('command.log')->end()
            ->arrayNode('handler')->canBeUnset(true)
                ->children()
                    ->scalarNode('type')->defaultValue('logger')->end()
                    ->arrayNode('client_options')->canBeUnset(true)
                        ->children()
                            ->scalarNode('base_uri')->end()
                            ->scalarNode('debug')->defaultValue(false)->end()
                            ->scalarNode('timeout')->defaultValue(3)->end()
                            ->scalarNode('verify')->defaultValue(false)->end()
                        ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
