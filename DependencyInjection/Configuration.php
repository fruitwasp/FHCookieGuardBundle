<?php
declare(strict_types=1);

namespace FH\Bundle\CookieGuardBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

use function method_exists;

final class Configuration implements ConfigurationInterface
{
    private const ROOT_NAME = 'fh_cookie_guard';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::ROOT_NAME);

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root(self::ROOT_NAME);
        }

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
