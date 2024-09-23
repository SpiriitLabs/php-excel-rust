<?php

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
            'worksheets' => array_map(function(Worksheet $worksheet) {
                return $worksheet->toArray();
            }, $this->worksheets),
        ];
    }
}
