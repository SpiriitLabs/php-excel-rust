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
use Spiriit\Rustsheet\ExportAvro\ExportAvro;
use Spiriit\Rustsheet\WorkbookFactory;
use Spiriit\Tests\Fixtures\MyExcel;

class GenerateExcelTest extends TestCase
{
    #[Test]
    public function it_must_generate_excel(): void
    {
        $excelFactory = new WorkbookFactory();
        $results = $excelFactory->create(new MyExcel());

        $schema = file_get_contents(__DIR__.'/../schema.json');

        $avroFile = __DIR__.DIRECTORY_SEPARATOR.'test.avro';
        $exportAvro = new ExportAvro(schema: $schema, pathAvro: $avroFile);
        $exportAvro->export($results);

        self::assertFileExists($avroFile);

        @unlink($avroFile);
    }
}
