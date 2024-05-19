<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('weather_app');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('name')->end()
            ->scalarNode('frontend_url')->end()
            ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}