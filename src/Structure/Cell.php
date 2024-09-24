<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Structure;

class Cell
{
    public function __construct(
        public readonly int $columnIndex,
        public readonly int $rowIndex,
        public ?Format $format,
        public mixed $value,
    ) {
    }

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
