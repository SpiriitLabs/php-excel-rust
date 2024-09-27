<?php

require __DIR__.'/../vendor/autoload.php';

use Spiriit\Rustsheet\ExcelRust;
use Spiriit\Rustsheet\WorkbookFactory;
use Spiriit\Tests\Fixtures\MyExcel;
use Psr\Log\NullLogger;

@unlink($output = __DIR__.'/../myexcel.xlsx');

$excelGeneratorFromAvro = new ExcelRust(
    workbookFactory: new WorkbookFactory(),
    rustGenLocation: __DIR__ . '/../vendor/bin/excel_gen'
);
$excelGeneratorFromAvro->setLogger(new NullLogger());

$excelGeneratorFromAvro->generateExcelFromAvro(new MyExcel());

@unlink($output);