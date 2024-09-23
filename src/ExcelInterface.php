<?php

namespace Spiriit\Rustsheet;

use Symfony\Component\OptionsResolver\OptionsResolver;

interface ExcelInterface
{

    public function buildSheet(RustSheetBuilder $builder): void;

    public function configureOptions(OptionsResolver $resolver): void;
}