<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet;

use Spiriit\Rustsheet\Structure\Workbook;

class WorkbookFactory implements WorkbookFactoryInterface
{
    public function create(ExcelInterface|string $name): array
    {
        if (\is_string($name)) {
            throw new \InvalidArgumentException('Parameter name must be a ExcelInterface in standalone implementation. String parameter is only for Symfony Bundle');
        }

        $builder = new WorkbookBuilder(new Workbook(WorkbookFactoryInterface::DEFAULT_OUTPUT_NAME));

        $name->buildSheet($builder);

        return $builder->build();
    }
}
