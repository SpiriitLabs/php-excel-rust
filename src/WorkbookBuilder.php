<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet;

use Spiriit\Rustsheet\Structure\Format;
use Spiriit\Rustsheet\Structure\Workbook;
use Spiriit\Rustsheet\Structure\Worksheet;

class WorkbookBuilder
{
    private ?Format $defaultStyleHeader = null;

    public function __construct(private readonly Workbook $workbook)
    {
    }

    public function setDefaultStyleHeader(Format $format): self
    {
        $this->defaultStyleHeader = $format;

        return $this;
    }

    public function addWorksheet(Worksheet $worksheet): self
    {
        $this->workbook->addWorksheet($worksheet);

        return $this;
    }

    public function build(): array
    {
        if (is_a($this->defaultStyleHeader, Format::class)) {
            /** @var Worksheet $worksheet */
            foreach ($this->workbook->getWorksheets() as $worksheet) {
                foreach ($worksheet->getCellsRowHeaders() as $cell) {
                    if (null === $cell->format) {
                        $cell->format = $this->defaultStyleHeader;
                    }
                }
            }
        }

        return $this->workbook->toArray();
    }
}
