<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet;

interface WorkbookFactoryInterface
{
    public const DEFAULT_OUTPUT_NAME = 'made_by_rust.xlsx';

    public function create(ExcelInterface|string $name): array;
}
