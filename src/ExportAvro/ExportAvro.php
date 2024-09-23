<?php

namespace Spiriit\Rustsheet\ExportAvro;

class ExportAvro
{
    public const EXPORT_OK = 'ok';

    public function __construct(
        private readonly string $schema,
        private ?string $pathAvro = null
    )
    {
        if (null === $this->pathAvro) {
            $this->pathAvro = sys_get_temp_dir() . '/' . uniqid('avr', true);
        }
    }

    public function     export(array $values): string
    {
        @unlink($this->pathAvro);
        $dataWriter = \AvroDataIO::open_file($this->pathAvro, \AvroIO::WRITE_MODE, $this->schema, \AvroDataIO::DEFLATE_CODEC);

        $dataWriter->append($values);
        $dataWriter->close();

        return self::EXPORT_OK;
    }
}