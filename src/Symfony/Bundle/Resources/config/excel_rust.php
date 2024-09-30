<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Spiriit\Rustsheet\ExcelRust;
use Spiriit\Rustsheet\WorkbookFactory;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(WorkbookFactory::class)->public()
        ->set(ExcelRust::class)
            ->args([
                service(WorkbookFactory::class),
                param('spiriit_excel_rust.rust_binary'),
                param('spiriit_excel_rust.default_output_folder'),
            ])
        ->call('setLogger', [service('logger')])
    ;
};
