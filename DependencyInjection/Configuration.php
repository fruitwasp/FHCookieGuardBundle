<?php

namespace FH\Bundle\CookieGuardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fh_cookie_guard');

        $rootNode
            ->children()
                ->scalarNode('cookie_name')
                    ->defaultValue('cookies-accepted')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
