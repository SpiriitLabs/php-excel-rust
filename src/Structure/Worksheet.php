<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Structure;

class Worksheet
{
    /**
     * @var Cell[]
     */
    private array $cells = [];

    private bool $autofit = true;

    private function __construct(private string $name)
    {
    }

    public static function new(?string $name = null): self
    {
        return new self($name ?? 'Sheet');
    }

    public function writeCell(Cell $cell): self
    {
        $this->cells[] = $cell;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'cells' => array_map(fn (Cell $cell) => [
                'columnIndex' => $cell->columnIndex,
                'rowIndex' => $cell->rowIndex,
                'value' => $cell->value,
                'format' => $cell->format?->toArray(),
            ], $this->cells),
            'autofit' => $this->autofit,
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

    public function setAutofit(bool $autofit): self
    {
        $this->autofit = $autofit;

        return $this;
    }

    /**
     * @return Cell[]
     */
    public function getCellsRowHeaders(): array
    {
        return array_filter($this->cells, fn (Cell $cell) => 0 === $cell->rowIndex);
    }
}
