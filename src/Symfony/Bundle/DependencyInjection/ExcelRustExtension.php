<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Symfony\Bundle\DependencyInjection;

use Spiriit\Rustsheet\Attributes\AsExcelRust;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ChildDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

class ExcelRustExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('excel_rust.php');

        $container->setParameter('spiriit_excel_rust.rust_binary', $config['rust_binary']);

        $container->setParameter('spiriit_excel_rust.schema_json', file_get_contents(__DIR__.'/../../../../schema.json'));
        $container->setParameter('spiriit_excel_rust.avro_codec', $config['avro_codec']);

        $container->registerAttributeForAutoconfiguration(
            AsExcelRust::class,
            static function (ChildDefinition $definition, AsExcelRust $attribute): void {
                $definition->addTag('spiriit_excel_rust.excel_rust', array_filter($attribute->serviceConfig()));
            }
        );
    }
}
