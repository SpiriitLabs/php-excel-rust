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
    public const EXPORT_OK = 'ok';

    public function __construct(
        private readonly string $schema,
        private ?string $pathAvro = null,
    ) {
        if (null === $this->pathAvro) {
            $this->pathAvro = sys_get_temp_dir().'/'.uniqid('avr', true);
        }
    }

    public function export(array $values, string $codec = \AvroDataIO::NULL_CODEC)
    {
        try {
            @unlink($this->pathAvro);
            $dataWriter = \AvroDataIO::open_file($this->pathAvro, \AvroIO::WRITE_MODE, $this->schema, $codec);

            $dataWriter->append($values);
            $dataWriter->close();
        } catch (\Throwable $e) {
            throw new AvroExportException('There is an error when export avro '.$e->getMessage(), $e->getCode(), $e);
        }
    }
}
