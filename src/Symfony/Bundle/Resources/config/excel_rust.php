<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Spiriit\Rustsheet\ExcelRust;
use Spiriit\Rustsheet\ExportAvro\ExportAvro;
use Spiriit\Rustsheet\Symfony\Bundle\WorkbookServiceLocatorFactory;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(WorkbookServiceLocatorFactory::class)->public()
        ->set(ExportAvro::class)
            ->args([
                param('spiriit_excel_rust.schema_json'),
                param('spiriit_excel_rust.avro_codec'),
            ])
        ->set(ExcelRust::class)
            ->args([
                service(WorkbookServiceLocatorFactory::class),
                param('spiriit_excel_rust.rust_binary'),
                service(ExportAvro::class),
            ])
        ->call('setLogger', [service('logger')])
    ;
};
