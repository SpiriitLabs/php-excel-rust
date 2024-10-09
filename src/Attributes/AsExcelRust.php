<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
class AsExcelRust
{
    public function __construct(
        private readonly ?string $name = null,
    ) {
    }

    public function serviceConfig(): array
    {
        return [
            'key' => $this->name,
        ];
    }
}
