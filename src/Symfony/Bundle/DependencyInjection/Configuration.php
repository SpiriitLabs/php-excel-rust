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
                ->validate()
                    ->ifTrue(static function ($v) {
                        return !file_exists($v);
                    })
                    ->thenInvalid('The rust binary path must be a valid path')
                  ->end()
                ->isRequired()
              ->end()
                ->enumNode('avro_codec')
                    ->values([\AvroDataIO::NULL_CODEC, \AvroDataIO::DEFLATE_CODEC, \AvroDataIO::SNAPPY_CODEC])
                    ->defaultValue(\AvroDataIO::NULL_CODEC)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
