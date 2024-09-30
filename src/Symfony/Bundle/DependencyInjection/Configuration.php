<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Symfony\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('spiriit_excel_rust');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
              ->scalarNode('rust_binary')
                ->info('The rust binary path')
                ->isRequired()
              ->end()
              ->scalarNode('default_output_folder')
                ->info('The default folder for output excel')
                ->defaultValue('/tmp')
            ->end()
        ;

        return $treeBuilder;
    }
}
