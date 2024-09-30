<?php

use Spiriit\Rustsheet\Structure\Workbook;
use Spiriit\Rustsheet\WorkbookBuilder;
use Spiriit\Tests\Fixtures\MyExcel;

require __DIR__.'/../vendor/autoload.php';

class WorkbookFactoryStub implements \Spiriit\Rustsheet\WorkbookFactoryInterface
{

    public function create(string $name): array
    {
        $excel = new MyExcel();

        $builder = new WorkbookBuilder(new Workbook('made_avro.xlsx'));

        $excel->buildSheet($builder);

        return $builder->build();
    }
}