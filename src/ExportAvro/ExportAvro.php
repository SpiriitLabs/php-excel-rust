<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\ExportAvro;

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

    public function export(array $values, bool $codec = true): string
    {
        @unlink($this->pathAvro);
        $dataWriter = \AvroDataIO::open_file($this->pathAvro, \AvroIO::WRITE_MODE, $this->schema, $codec ? \AvroDataIO::DEFLATE_CODEC : \AvroDataIO::NULL_CODEC);

        $dataWriter->append($values);
        $dataWriter->close();

        return self::EXPORT_OK;
    }
}
