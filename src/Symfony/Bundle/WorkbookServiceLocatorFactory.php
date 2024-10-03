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
use Spiriit\Rustsheet\WorkbookBuilder;
use Spiriit\Rustsheet\WorkbookFactoryInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class WorkbookServiceLocatorFactory implements WorkbookFactoryInterface
{
    public function __construct(
        private readonly ServiceLocator $excelSheets,
        private array $config,
    ) {
    }

    public function create(ExcelInterface|string $name): array
    {
        if (!\is_string($name)) {
            throw new \InvalidArgumentException('Parameter must be a string in symfony context');
        }

        $excel = $this->getsheet($name);

        $outputName = $this->getOutputName($name);

        $builder = new WorkbookBuilder(new Workbook($outputName));

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

    private function getOutputName(string $name): string
    {
        if (null !== ($this->config[$name] ?? null)) {
            return $this->config[$name]['outputName'];
        }

        return WorkbookFactoryInterface::DEFAULT_OUTPUT_NAME;
    }
}
