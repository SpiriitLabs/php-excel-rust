<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\ExportAvro;

use Spiriit\Rustsheet\AvroExportException;

class ExportAvro
{
    public function __construct(
        private readonly string $schema,
        private string $codec = \AvroDataIO::NULL_CODEC,
    ) {
    }

    public function export(array $values): string
    {
        $avroFilePath = \sprintf('%s/%s.avro', sys_get_temp_dir(), uniqid('avro', true));

        try {
            @unlink($avroFilePath);
            $dataWriter = \AvroDataIO::open_file($avroFilePath, \AvroIO::WRITE_MODE, $this->schema, $this->codec);

            $dataWriter->append($values);
            $dataWriter->close();

            return $avroFilePath;
        } catch (\Throwable $e) {
            throw new AvroExportException('There is an error when export avro '.$e->getMessage(), $e->getCode(), $e);
        }
    }
}
