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
use Spiriit\Rustsheet\ExcelRust;
use Spiriit\Rustsheet\ExportAvro\ExportAvro;
use Spiriit\Rustsheet\WorkbookFactory;
use Spiriit\Rustsheet\WorkbookFactoryInterface;

class ExcelRustTest extends TestCase
{
    #[Test]
    public function it_must_create_without_output_name(): void
    {
        $workbookFactory = $this->createMock(WorkbookFactoryInterface::class);
        $workbookFactory->method('create')->willReturn(['filename' => 'test.xlsx']);

        $exportAvro = $this->createMock(ExportAvro::class);
        $exportAvro->method('export')->willReturn($pathAvroPath = '/path/avro');

        $excelRust = $this->getMockBuilder(ExcelRust::class)
            ->onlyMethods([
                'rustGen',
                'checkOutput',
                //                'getCommand',
                //                'executeCommand',
                //                'checkOutput',
                //                'checkProcessStatus',
            ])
            ->setConstructorArgs([$workbookFactory, 'the binary', $exportAvro])
            ->getMock()
        ;

        $excelRust
            ->expects($this->once())
            ->method('rustGen')
            ->willReturn(['exit_code' => 0, 'output' => 'out', 'error_output' => ''])
        ;

        $excelRust
            ->expects(self::once())
            ->method('checkOutput');

        //        $excel = new ExcelRust(
        //            workbookFactory: $workbookFactory,
        //            rustGenLocation: __DIR__.'/Fixtures/excel_rust_test',
        //            exportAvro: $exportAvro
        //        );

        $output = $excelRust->generateExcelFromAvro('test', null);

        self::assertEquals('test.xlsx', $output);
    }
}
