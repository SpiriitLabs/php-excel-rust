<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Tests\Bundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use PHPUnit\Framework\Attributes\Test;
use Spiriit\Rustsheet\Symfony\Bundle\DependencyInjection\Compiler\ExcelInterfacePass;
use Spiriit\Rustsheet\Symfony\Bundle\WorkbookServiceLocatorFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class WorkbookFactoryPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ExcelInterfacePass());
    }

    #[Test]
    public function if_compiler_pass_collects_services_by_adding_method_calls_these_will_exist(): void
    {
        $collectingService = new Definition();
        $this->setDefinition(WorkbookServiceLocatorFactory::class, $collectingService);

        $collectedService = new Definition();
        $collectedService->addTag('spiriit_excel_rust.excel_rust');
        $this->setDefinition('collected_service', $collectedService);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithServiceLocatorArgument(
            WorkbookServiceLocatorFactory::class,
            0,
            [
                '' => new Reference('collected_service'),
            ]
        );
    }
}
