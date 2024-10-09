<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Symfony\Bundle;

use Spiriit\Rustsheet\ExcelInterface;
use Spiriit\Rustsheet\Structure\Workbook;
use Spiriit\Rustsheet\Traits\WorkbookFactoryTrait;
use Spiriit\Rustsheet\WorkbookBuilder;
use Spiriit\Rustsheet\WorkbookFactoryInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class WorkbookServiceLocatorFactory implements WorkbookFactoryInterface
{
    use WorkbookFactoryTrait;

    public function __construct(
        private readonly ServiceLocator $excelSheets,
    ) {
    }

    public function create(ExcelInterface|string $name): array
    {
        if (!\is_string($name)) {
            throw new \InvalidArgumentException('Parameter must be a string in symfony context');
        }

        $excel = $this->getsheet($name);

        $options = $this->getOptionsResolver($excel);

        $builder = new WorkbookBuilder(new Workbook($options['filename']));

        $excel->buildSheet($builder);

        return $builder->build();
    }

    private function getsheet(string $name): ExcelInterface
    {
        if (!$this->excelSheets->has($name)) {
            throw new \InvalidArgumentException('There is no excel class register '.$name);
        }

        return $this->excelSheets->get($name);
    }
}
