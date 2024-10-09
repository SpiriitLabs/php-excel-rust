<?php

namespace Spiriit\Rustsheet\Traits;

use Spiriit\Rustsheet\ExcelInterface;
use Spiriit\Rustsheet\WorkbookFactoryInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

trait WorkbookFactoryTrait
{
    protected function getOptionsResolver(ExcelInterface $excel): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'filename' => WorkbookFactoryInterface::DEFAULT_OUTPUT_NAME,
        ]);

        $excel->configureOptions($resolver);

        return $resolver->resolve();
    }
}