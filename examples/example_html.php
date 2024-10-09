<?php

require __DIR__.'/../vendor/autoload.php';

use Spiriit\Rustsheet\ExcelRust;
use Psr\Log\NullLogger;

@unlink($output = __DIR__.'/myexcel_html.xlsx');

$factory = new \Spiriit\Rustsheet\WorkbookFactory();

$excelRust = new ExcelRust(
    workbookFactory: $factory,
    rustGenLocation: __DIR__ . '/../excel_gen',
);
$excelRust->setLogger(new NullLogger());

$htmlFile = __DIR__.DIRECTORY_SEPARATOR.'fixtures.html';

$excelRust->generateExcelFromHtml($htmlFile, $output);

@unlink($output);