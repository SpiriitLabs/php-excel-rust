<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet;

use Symfony\Component\OptionsResolver\OptionsResolver;

interface ExcelInterface
{
    public function buildSheet(WorkbookBuilder $builder): void;

    public function configureOptions(OptionsResolver $resolver): void;
}
