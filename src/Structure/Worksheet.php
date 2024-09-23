<?php

namespace Spiriit\Rustsheet\Structure;

use AvroDataIO;
use Symfony\Component\Filesystem\Filesystem;

class Worksheet
{
    private string $name;

    /**
     * @var CellValueFormat[]
     */
    private array $cells = [];

    private bool $autofit = false;

    private function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function new(?string $name = null): self
    {
        return new self($name ?? 'Sheet');
    }

    public function writeCell(Cell $cell, CellDataType $type = null): self
    {
        $value = $cell->value;

        $this->cells[] = match ($type) {
            CellDataType::ArrayFormula => new CellValueFormat(cellDataType: CellDataType::ArrayFormula, cell: $cell, value: $value),
            CellDataType::Blank => new CellValueFormat(cellDataType: CellDataType::Blank, cell: $cell, value: 0),
            CellDataType::Error => new CellValueFormat(cellDataType: CellDataType::Error, cell: $cell, value: 0),
            CellDataType::Boolean => new CellValueFormat(cellDataType: CellDataType::Boolean, cell: $cell, value: (bool) $value),
            CellDataType::Formula => new CellValueFormat(cellDataType: CellDataType::Formula, cell: $cell, value: $value),
            CellDataType::Number => new CellValueFormat(cellDataType: CellDataType::Number, cell: $cell, value: (float) $value),
            CellDataType::DateTime => new CellValueFormat(cellDataType: CellDataType::DateTime, cell: $cell, value: $value),
            CellDataType::RichString => new CellValueFormat(cellDataType: CellDataType::RichString, cell: $cell, value: $value),
            CellDataType::String => new CellValueFormat(cellDataType: CellDataType::String, cell: $cell, value: (string) $value),
            default => new CellValueFormat(cellDataType: CellDataType::String, cell: $cell, value: $value),
        };

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'cells' => array_map(function (CellValueFormat $cellValueFormat) {
                return [
                    'cell_type' => $cellValueFormat->cellDataType->name,
                    'columnIndex' => $cellValueFormat->cell->columnIndex,
                    'rowIndex' => $cellValueFormat->cell->rowIndex,
                    'value' => $cellValueFormat->value,
                    'format' => $cellValueFormat->cell->format?->toArray(),
                ];
            }, $this->cells)
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setAutofit(): self
    {
        $this->autofit = true;
        return $this;
    }

    /**
     * @return CellValueFormat[]
     */
    public function getCellsRowHeaders(): array
    {
        return array_filter($this->cells, fn(CellValueFormat $cellValueFormat) => $cellValueFormat->cell->rowIndex === 0);
    }
}
