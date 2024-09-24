<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Tests\Structure;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Spiriit\Rustsheet\Structure\Cell;

class CellTest extends TestCase
{
    #[Test]
    public function it_must_create_cell_url(): void
    {
        $cell = new Cell(
            columnIndex: 1,
            rowIndex: 0,
            format: null,
            value: 10
        );

        self::assertEquals([
            'columnIndex' => 1,
            'rowIndex' => 0,
            'format' => null,
            'value' => 10,
        ], $cell->toArray());
    }
}
