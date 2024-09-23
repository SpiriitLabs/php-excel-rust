<?php

namespace Spiriit\Rustsheet;

use Spiriit\Rustsheet\Structure\Workbook;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExcelFactory
{
    public function __construct()
    {
    }

    public function create(ExcelInterface $excel, array $options = []): array
    {
        $options = $this->getOptionsResolver($excel)->resolve($options);

        $builder = new RustSheetBuilder(new Workbook($options['filename']));

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