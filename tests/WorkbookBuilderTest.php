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
use Spiriit\Rustsheet\Structure\Cell;
use Spiriit\Rustsheet\Structure\Format;
use Spiriit\Rustsheet\Structure\Workbook;
use Spiriit\Rustsheet\Structure\Worksheet;
use Spiriit\Rustsheet\WorkbookBuilder;

class WorkbookBuilderTest extends TestCase
{
    #[Test]
    public function it_must_build_workbook(): void
    {
        $builder = new WorkbookBuilder(new Workbook('test.xlsx'));

        $builder = $builder
            ->setDefaultStyleHeader(
                Format::new()
                    ->fontName('Arial')
                    ->fontSize(12)
            );

        $worksheet = Worksheet::new()
            ->setName('Worksheet1');

        $worksheet->writeCell(new Cell(columnIndex: 0, rowIndex: 0, format: null, value: 'Item'));
        $worksheet->writeCell(new Cell(columnIndex: 0, rowIndex: 1, format: null, value: 'Cost'));
        $worksheet->writeCell(new Cell(columnIndex: 0, rowIndex: 2, format: Format::new()->bold(), value: 'Date'));

        $worksheet->writeCell(
            new Cell(
                columnIndex: 1,
                rowIndex: 0,
                format: null,
                value: 'test'
            ),
        );

        $worksheet->writeCell(
            new Cell(
                columnIndex: 1,
                rowIndex: 1,
                format: null,
                value: '=1+1'
            ),
        );

        $worksheet->writeCell(
            new Cell(
                columnIndex: 1,
                rowIndex: 2,
                format: Format::new()->setNumFormat('d mmm yyyy'),
                value: '2024-09-28'
            ),
        );

        $builder->addWorksheet($worksheet);
        $workbookArray = $builder->build();

        self::assertEquals('Worksheet1', $worksheet->getName());
        self::assertEquals('2024-09-28', $workbookArray['worksheets'][0]['cells'][5]['value']);
    }
}
