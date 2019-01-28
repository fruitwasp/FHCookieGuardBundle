<?php
declare(strict_types=1);

namespace FH\Bundle\CookieGuardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    private const ROOT_NAME = 'fh_cookie_guard';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::ROOT_NAME);
        $rootNode = $treeBuilder->root(self::ROOT_NAME);

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
