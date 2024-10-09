<?php

require __DIR__.'/../vendor/autoload.php';

use Spiriit\Rustsheet\ExcelRust;
use Spiriit\Tests\Fixtures\MyExcel;
use Psr\Log\NullLogger;
use Spiriit\Rustsheet\ExportAvro\ExportAvro;

$factory = new \Spiriit\Rustsheet\WorkbookFactory();

$exportAvro = new ExportAvro(
    schema: file_get_contents(__DIR__.'/../schema.json')
);

$excelRust = new ExcelRust(
    workbookFactory: $factory,
    rustGenLocation: __DIR__ . '/../excel_gen',
    exportAvro: $exportAvro,
);
$excelRust->setLogger(new NullLogger());

$output = $excelRust->generateExcelFromAvro(new MyExcel(), __DIR__.'/myexcel_avro.xlsx');

// echo $output;

@unlink($output);