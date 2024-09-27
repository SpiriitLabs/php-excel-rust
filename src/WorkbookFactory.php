<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet;

use Spiriit\Rustsheet\Structure\Workbook;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WorkbookFactory
{
    public function create(ExcelInterface $excel, array $options = []): array
    {
        $options = $this->getOptionsResolver($excel)->resolve($options);

        $builder = new WorkbookBuilder(new Workbook($options['filename']));

        $excel->buildSheet($builder);

        return $builder->build();
    }

    private function getOptionsResolver(ExcelInterface $excel): OptionsResolver
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'filename' => 'excel.xlsx',
        ]);

        $excel->configureOptions($resolver);

        return $resolver;
    }
}
