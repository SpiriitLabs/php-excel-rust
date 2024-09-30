<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/WorkbookFactoryStub.php';

use Spiriit\Rustsheet\ExcelRust;
use Psr\Log\NullLogger;

@unlink($output = 'myexcel_html.xlsx');

$factory = new WorkbookFactoryStub();

$excelRust = new ExcelRust(
    workbookFactory: $factory,
    rustGenLocation: __DIR__ . '/../excel_gen',
    defaultOutputFolder: __DIR__.'/../',
);
$excelRust->setLogger(new NullLogger());

$htmlFile = __DIR__.DIRECTORY_SEPARATOR.'fixtures.html';

$excelRust->generateExcelFromHtml($htmlFile, $output);

@unlink($output = 'myexcel_html.xlsx');