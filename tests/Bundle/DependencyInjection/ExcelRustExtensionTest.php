<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Tests\Bundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use PHPUnit\Framework\Attributes\Test;
use Spiriit\Rustsheet\Symfony\Bundle\DependencyInjection\ExcelRustExtension;

class ExcelRustExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new ExcelRustExtension(),
        ];
    }

    #[Test]
    public function assert_parameter(): void
    {
        $this->load([
            'rust_binary' => $path = __DIR__.'/../../Fixtures/excel_rust_test',
        ]);

        $this->assertContainerBuilderHasParameter('spiriit_excel_rust.rust_binary', $path);
    }
}
