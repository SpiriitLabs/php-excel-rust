<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Symfony\Bundle\DependencyInjection\Compiler;

use Spiriit\Rustsheet\WorkbookFactory;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\ServiceLocatorTagPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Reference;

class ExcelInterfacePass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(WorkbookFactory::class)) {
            return;
        }

        $excelsReferences = [];
        $excelsNames = [];
        $excelsConfig = [];

        foreach ($container->findTaggedServiceIds('spiriit_excel_rust.excel_rust') as $id => $tags) {
            $definition = $container->findDefinition($id);

            $name = $definition->getClass();

            foreach ($tags as $tag) {
                if (!\array_key_exists('key', $tag)) {
                    if (\in_array($name, $excelsNames, true)) {
                        throw new LogicException(\sprintf('Failed creating the "%s" excel with the automatic name "%s": another excel already has this name. To fix this, give the excel an explicit name (hint: using "%s" will override the existing excel).', $fqcn, $name, $name));
                    }

                    $tag['key'] = $name;
                }

                $excelsConfig[$tag['key']] = $tag;
                $excelsReferences[$tag['key']] = new Reference($id);
                $excelsNames[] = $tag['key'];
            }
        }

        $factoryDefinition = $container->findDefinition(WorkbookFactory::class);

        $factoryDefinition->setArgument(0, ServiceLocatorTagPass::register($container, $excelsReferences));
        $factoryDefinition->setArgument(1, $excelsConfig);
    }
}
