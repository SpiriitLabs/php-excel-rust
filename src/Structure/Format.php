<?php

namespace Spiriit\Rustsheet\Structure;

class Format
{
    private string $fontName = 'Arial';
    private int $fontSize = 10;
    private bool $bold = false;
    private ?string $dateFormat = null;

    private function __construct() {}

    public static function new(): self
    {
        return new self();
    }

    public function fontName(string $fontName): self
    {
        $this->fontName = $fontName;
        return $this;
    }

    public function fontSize(int $fontSize): self
    {
        $this->fontSize = $fontSize;
        return $this;
    }

    public function bold(): self
    {
        $this->bold = true;
        return $this;
    }

    public function dateFormat(string $dateFormat): self
    {
        $this->dateFormat = $dateFormat;
        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'fontName' => $this->fontName,
            'fontSize' => $this->fontSize,
            'bold' => $this->bold,
            'dateFormat' => $this->dateFormat,
        ]);
    }
}
