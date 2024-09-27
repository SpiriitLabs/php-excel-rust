<?php

require __DIR__.'/../vendor/autoload.php';

use Spiriit\Rustsheet\ExcelRust;
use Spiriit\Rustsheet\WorkbookFactory;
use Psr\Log\NullLogger;

@unlink($output = 'myexcel_html.xlsx');

$avroFactory = new ExcelRust(
    workbookFactory: new WorkbookFactory(),
    rustGenLocation: __DIR__ . '/../vendor/bin/excel_gen'
);
$avroFactory->setLogger(new NullLogger());

$htmlFile = __DIR__.DIRECTORY_SEPARATOR.'fixtures.html';

$avroFactory->generateExcelFromHtml($htmlFile, $output);

@unlink($output = 'myexcel_html.xlsx');