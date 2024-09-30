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

class ExportAvroTest extends TestCase
{
    #[Test]
    public function it_must_export_to_avro(): void
    {
        $path = __DIR__.'/Fixtures/test.avro';
        @unlink($path);

        $avroSchema = <<<SCHEMA
{
  "type": "record",
  "namespace": "example.avro",
  "name": "User",
  "fields": [
    {
      "type": "string",
      "name": "name"
    },
    {
      "type": [
        "string",
        "null"
      ],
      "name": "favorite_color"
    },
    {
      "type": {
        "items": "int",
        "type": "array"
      },
      "name": "favorite_numbers"
    }
  ]
}
SCHEMA;

        $exportAvro = new ExportAvro(
            schema: $avroSchema,
            pathAvro: $path
        );

        $values = [
            'name' => 'Pierre',
            'favorite_color' => 'red',
            'favorite_numbers' => [1, 2, 3],
        ];

        $exportAvro->export($values);

        self::assertFileExists($path);
        @unlink($path);
    }
}
