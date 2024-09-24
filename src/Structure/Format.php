<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Structure;

class Format
{
    public const FORMAT_NUMBER_CURRENCY_FR = '"[$€-1036] # ##0,00"';
    public const FORMAT_NUMBER_CURRENCY_US = '"[$$-409]#,##0.00"';

    private ?string $fontName = null;
    private ?int $fontSize = null;
    private bool $bold = false;
    private ?string $numFormat = null;

    private function __construct()
    {
    }

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

    public function setNumFormat(?string $numFormat): self
    {
        $this->numFormat = $numFormat;

        return $this;
    }

    public function toArray(): array
    {
        return array_filter([
            'fontName' => $this->fontName,
            'fontSize' => $this->fontSize,
            'bold' => $this->bold,
            'numFormat' => $this->numFormat,
        ]);
    }
}
