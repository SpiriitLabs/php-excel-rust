<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Spiriit\Rustsheet\ExportAvro\ExportAvro;
use Spiriit\Rustsheet\WorkbookFactory;
use Spiriit\Tests\Fixtures\MyExcel;
use Symfony\Component\DependencyInjection\ServiceLocator;

class GenerateExcelTest extends TestCase
{
    #[Test]
    public function it_must_generate_excel(): void
    {
        $myExcel = new MyExcel();

        $config = [MyExcel::class => ['outputName' => 'test.xlsx']];

        $serviceLocator = $this->createMock(ServiceLocator::class);
        $serviceLocator->method('has')->willReturn(true);
        $serviceLocator->method('get')->willReturn($myExcel);

        $excelFactory = new WorkbookFactory(
            excelSheets: $serviceLocator,
            config: $config
        );
        $results = $excelFactory->create(MyExcel::class);

        $schema = file_get_contents(__DIR__.'/../schema.json');

        $avroFile = __DIR__.\DIRECTORY_SEPARATOR.'test.avro';
        $exportAvro = new ExportAvro(schema: $schema, pathAvro: $avroFile);
        $exportAvro->export($results);

        self::assertFileExists($avroFile);

        @unlink($avroFile);
    }
}
