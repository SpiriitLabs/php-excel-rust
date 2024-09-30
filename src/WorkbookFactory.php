<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet;

use Spiriit\Rustsheet\Structure\Workbook;
use Symfony\Component\DependencyInjection\ServiceLocator;

class WorkbookFactory implements WorkbookFactoryInterface
{
    public const DEFAULT_OUTPUT_NAME = 'made_by_rust.xlsx';

    public function __construct(
        private readonly ServiceLocator $excelSheets,
        private array $config,
    ) {
    }

    public function create(string $name): array
    {
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
        if (null !== $this->config[$name] ?? null) {
            return $this->config[$name]['outputName'];
        }

        return self::DEFAULT_OUTPUT_NAME;
    }
}
