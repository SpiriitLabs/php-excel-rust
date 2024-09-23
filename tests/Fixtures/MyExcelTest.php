<?php

namespace Spiriit\Tests\Fixtures;

use Spiriit\Rustsheet\ExcelInterface;
use Spiriit\Rustsheet\RustSheetBuilder;
use Spiriit\Rustsheet\Structure\Cell;
use Spiriit\Rustsheet\Structure\CellDataType;
use Spiriit\Rustsheet\Structure\Format;
use Spiriit\Rustsheet\Structure\Worksheet;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MyExcelTest implements ExcelInterface
{
    public function buildSheet(RustSheetBuilder $builder): void
    {
        $builder = $builder
            ->setDefaultStyleHeader(
                Format::new()
                    ->fontName('Arial')
                    ->fontSize(14)
            );

        $worksheet = Worksheet::new()
            ->setName('Worksheet1')
            ->setAutofit();

        function generateRandomWord($length = 5) {
            return substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
        }

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                if (0 === $i) {
                    $worksheet->writeCell(new Cell(columnIndex: $j, rowIndex: $i, format: null, value: generateRandomWord(rand(1, 10))));
                    continue;
                }

                $worksheet->writeCell(
                    new Cell(
                        columnIndex: $j,
                        rowIndex: $i,
                        format: null,
                        value: rand(1, 100)
                    ),
                    CellDataType::Number
                );
            }
        }

//        $worksheet->writeCell(new Cell(columnIndex: 0, rowIndex: 0, format: null, value: 'Item'));
//        $worksheet->writeCell(new Cell(columnIndex: 0, rowIndex: 1, format: null, value: 'Cost'));
//        $worksheet->writeCell(new Cell(columnIndex: 0, rowIndex: 2, format: Format::new()->bold(), value: 'Date'));
//
//        $worksheet->writeCell(
//            new Cell(
//                columnIndex: 1,
//                rowIndex: 0,
//                format: null,
//                value: 'test'
//            ),
//            CellDataType::String
//        );
//
//        $worksheet->writeCell(
//            new Cell(
//                columnIndex: 1,
//                rowIndex: 1,
//                format: null,
//                value: '=1+1'
//            ),
//            CellDataType::Formula
//        );
//
//        $worksheet->writeCell(
//            new Cell(
//                columnIndex: 1,
//                rowIndex: 2,
//                format: Format::new()->dateFormat('d mmm yyyy'),
//                value: '2024-09-28'
//            ),
//            CellDataType::DateTime
//        );

        $builder->addWorksheet($worksheet);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'filename' => 'myexcel.xlsx',
        ]);
    }
}