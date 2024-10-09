Spiriit Excel Rust
==================

# Supercharge Excel generation in PHP with Rust's blazing speed!

This PHP library leverages the power of Rust to create Excel files quickly and efficiently.

## Why choose Rust?

Rust is renowned for its execution speed and memory safety, making it an excellent choice for intensive tasks like generating Excel files.
By combining PHP for data management with Rust for heavy processing, you get optimal performance without sacrificing the simplicity of PHP code.

## How it works

Thanks to a Rust binary, whose source code is available on the [GitHub repository](link_to_repo), it is possible to generate Excel rows and
formats directly from PHP. The data and configuration are transmitted to the binary using the **AVRO** format ([learn more about AVRO](link_to_avro)).

Once the data is received, the Rust binary uses the **excelrust** library to create the Excel file.


# Install

`composer require spiriitlabs/rustsheet`

# Download the last release of the rust binary

Go at https://github.com/SpiriitLabs/excel_gen

Save the binary somewhere

# Symfony bundle

Just active the bundle in your `bundles.php`

```php
Spiriit\Rustsheet\Symfony\Bundle\ExcelRustBundle::class => ['all' => true],
```

Create a file in the folder packages

> config/packages/spiriit_excel_rust.yaml

```yaml
excel_rust:
  rust_binary: '%rust_binary%' # path to rust binary
  avro_codec: 'null' # default to null, because we don't need to compress the file
```

You need to use the `AsExcelRust` attribute

```php
use Spiriit\Rustsheet\Attributes\AsExcelRust;

#[AsExcelRust(name: 'my_super_excel')] // override name is optionnal
class MyExcel implements ExcelInterface 
{
...
}
```

```php
class MyController
{
    public function __invoke(ExcelRust $excelRust)
    {
        $output = $excelRust->generateExcelFromAvro('MyExcel', __DIR__.'/myexcel_avro.xlsx');
    }
}
```

# Use the library in standalone

## Use a builder

First create a class implements `ExcelInterface` and add attribute 'AsExcelRust'

```php
class MyExcel implements ExcelInterface
{
    public function buildSheet(WorkbookBuilder $builder): void
    {
        $builder = $builder
            ->setDefaultStyleHeader(
                Format::new()
                    ->fontName('Arial')
                    ->fontSize(20)
            );

        $worksheet = Worksheet::new()
            ->setName('Worksheet1');

        $worksheet->writeCell(new Cell(columnIndex: 0, rowIndex: 0, format: null, value: 'Item'));
        $worksheet->writeCell(new Cell(columnIndex: 1, rowIndex: 0, format: null, value: 'Cost'));
        $worksheet->writeCell(new Cell(columnIndex: 2, rowIndex: 0, format: Format::new()->bold(), value: 'Date'));
        $worksheet->writeCell(new Cell(columnIndex: 3, rowIndex: 0, format: Format::new()->bold(), value: 'Autre'));

        $worksheet->writeCell(
            new Cell(
                columnIndex: 0,
                rowIndex: 1,
                format: null,
                value: 'test'
            ),
        );
    }
}
```

Then create a new instance of ExcelRust and prepare the WorkbookFactory and the excel_rust binary:

```php
    $factory = new \Spiriit\Rustsheet\WorkbookFactory();

    $exportAvro = new ExportAvro(
        schema: file_get_contents(__DIR__.'/../schema.json')
    );
    
    $excelRust = new ExcelRust(
        workbookFactory: $factory,
        rustGenLocation: __DIR__ . '/path/to/excel_gen',
        exportAvro: $exportAvro,
    );
    
    $output = $excelRust->generateExcelFromAvro(new MyExcel(), __DIR__.'/myexcel_avro.xlsx');

```

## From HTML file

```php
    $factory = new \Spiriit\Rustsheet\WorkbookFactory();

    $excelRust = new ExcelRust(
        workbookFactory: $factory,
        rustGenLocation: __DIR__ . '/path/to/excel_gen',
    );
    
    $htmlFile = 'test.html';
    
    $excelRust->generateExcelFromHtml($htmlFile, $output);
```

