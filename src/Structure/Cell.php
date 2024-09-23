<?php

namespace Spiriit\Rustsheet\Structure;

class Cell
{
    public function __construct(
        public readonly int $columnIndex,
        public readonly int $rowIndex,
        public ?Format $format,
        public mixed $value
    ) {}

    public function toArray(): array
    {
        return [
            'columnIndex' => $this->columnIndex,
            'rowIndex' => $this->rowIndex,
            'format' => $this->format?->toArray(),
            'value' => $this->value,
        ];
    }
}