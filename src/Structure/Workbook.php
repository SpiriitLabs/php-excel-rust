<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Structure;

class Workbook
{
    private array $worksheets = [];

    public function __construct(public string $filename)
    {
    }

    public function addWorksheet(Worksheet $worksheet): self
    {
        $this->worksheets[] = $worksheet;

        return $this;
    }

    public function getWorksheets(): array
    {
        return $this->worksheets;
    }

    public function toArray(): array
    {
        return [
            'filename' => $this->filename,
            'worksheets' => array_map(fn (Worksheet $worksheet) => $worksheet->toArray(), $this->worksheets),
        ];
    }
}
