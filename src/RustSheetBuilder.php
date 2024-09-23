<?php

namespace Spiriit\Rustsheet;
use Spiriit\Rustsheet\Structure\Format;
use Spiriit\Rustsheet\Structure\Workbook;
use Spiriit\Rustsheet\Structure\Worksheet;

class RustSheetBuilder
{
    private ?Format $defaultStyleHeader = null;

    public function __construct(private Workbook $workbook)
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
        if (null !== $this->defaultStyleHeader) {
            /** @var Worksheet $worksheet */
            foreach ($this->workbook->getWorksheets() as $worksheet) {
                foreach ($worksheet->getCellsRowHeaders() as $cellValueFormat) {
                    if (null === $cellValueFormat->cell->format) {
                        $cellValueFormat->cell->format = $this->defaultStyleHeader;
                    }
                }
            }
        }

        return $this->workbook->toArray();
    }
}
