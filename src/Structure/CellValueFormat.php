<?php

namespace Spiriit\Rustsheet\Structure;

readonly class CellValueFormat
{

    public function __construct(
        public CellDataType $cellDataType,
        public Cell $cell,
        public mixed $value,
    )
    {
    }
}