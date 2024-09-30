<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/WorkbookFactoryStub.php';

use Spiriit\Rustsheet\ExcelRust;
use Spiriit\Tests\Fixtures\MyExcel;
use Psr\Log\NullLogger;


@unlink($output = __DIR__.'/../myexcel.xlsx');

$factory = new WorkbookFactoryStub();

$excelRust = new ExcelRust(
    workbookFactory: $factory,
    rustGenLocation: __DIR__ . '/../excel_gen',
    defaultOutputFolder: __DIR__.'/../',
);
$excelRust->setLogger(new NullLogger());

$output = $excelRust->generateExcelFromAvro(MyExcel::class);

// echo $output;

@unlink($output);