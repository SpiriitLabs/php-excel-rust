<?php

namespace Spiriit\Tests;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Spiriit\Rustsheet\ExcelFactory;
use Spiriit\Rustsheet\ExportAvro\ExportAvro;
use Spiriit\Tests\Fixtures\MyExcelTest;

class GenerateExcelTest extends TestCase
{
    #[Test]
    public function it_must_generate_excel(): void
    {
        $excelFactory = new ExcelFactory();
        $results = $excelFactory->create(new MyExcelTest());

        $schema = file_get_contents(__DIR__.'/../schema.json');

        $exportAvro = new ExportAvro(schema: $schema, pathAvro: __DIR__.'/us.avro');
        $exportAvro->export($results);

      //  dd($results);
    }
}