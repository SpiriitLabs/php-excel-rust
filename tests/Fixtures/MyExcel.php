<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Tests\Fixtures;

use Spiriit\Rustsheet\ExcelInterface;
use Spiriit\Rustsheet\Structure\Cell;
use Spiriit\Rustsheet\Structure\Format;
use Spiriit\Rustsheet\Structure\Worksheet;
use Spiriit\Rustsheet\WorkbookBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyExcel implements ExcelInterface
{
    public function buildSheet(WorkbookBuilder $builder): void
    {
        $builder = $builder
            ->setDefaultStyleHeader(
                Format::new()
                    ->fontName('Arial')
                    ->fontSize(14)
            );

        $worksheet = Worksheet::new()
            ->setName('Worksheet1');

        //        $worksheet->writeCell(new Cell(columnIndex: 0, rowIndex: 0, format: null, value: 'Item'));
        //        $worksheet->writeCell(new Cell(columnIndex: 1, rowIndex: 0, format: null, value: 'Cost'));
        //        $worksheet->writeCell(new Cell(columnIndex: 2, rowIndex: 0, format: Format::new()->bold(), value: 'Date'));
        //        $worksheet->writeCell(new Cell(columnIndex: 3, rowIndex: 0, format: Format::new()->bold(), value: 'Autre'));
        //
        //        $worksheet->writeCell(
        //            new Cell(
        //                columnIndex: 0,
        //                rowIndex: 1,
        //                format: null,
        //                value: 'test'
        //            ),
        //        );
        //
        //        $worksheet->writeCell(
        //            new Cell(
        //                columnIndex: 1,
        //                rowIndex: 1,
        //                format: null,
        //                value: '=1+1'
        //            ),
        //        );
        //
        //        $worksheet->writeCell(
        //            new Cell(
        //                columnIndex: 2,
        //                rowIndex: 1,
        //                format: Format::new()->setNumFormat('d mmm yyyy'),
        //                value: '2024-09-28'
        //            ),
        //        );
        //
        //        $worksheet->writeCell(
        //            new Cell(
        //                columnIndex: 3,
        //                rowIndex: 1,
        //                format: Format::new()->fontSize(20)->setNumFormat(Format::FORMAT_NUMBER_CURRENCY_FR),
        //                value: 1200.554
        //            ),
        //        );

        for ($i = 0; $i < 4000; ++$i) {
            for ($j = 0; $j < 50; ++$j) {
                if (1 === $j % 2) {
                    $worksheet->writeCell(
                        new Cell(
                            columnIndex: $j,
                            rowIndex: $i,
                            format: null,
                            value: 'Foo'
                        ),
                    );
                } else {
                    $worksheet->writeCell(
                        new Cell(
                            columnIndex: $j,
                            rowIndex: $i,
                            format: null,
                            value: 12345.0
                        ),
                    );
                }
            }
        }

        $builder->addWorksheet($worksheet);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'filename' => 'myexcel.xlsx',
        ]);
    }
}
