Spiriit Excel Rust
==================

# Rust Excel Library: A High-Performance Solution for Generating Excel Files from PHP

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

# Two way for use

## With WorkbookFactory

First create a class implements `ExcelInterface`

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

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'filename' => '/path/to/output/myexcel.xlsx', // path where file will be generated 
        ]);
    }
}
```

Then create a new instance of ExcelRust and prepare the WorkbookFactory and the excel_rust binary:

```php
    $excelGeneratorFromAvro = new ExcelRust(
        workbookFactory: new WorkbookFactory(),
        rustGenLocation: __DIR__ . '/../vendor/bin/excel_gen'
    );
    $excelGeneratorFromAvro->setLogger(new NullLogger());
    
    $excelGeneratorFromAvro->generateExcelFromAvro(new MyExcel());
```

## From HTML file

```php
    $output = '/tmp/output.xlsx';
    
    $avroFactory = new ExcelRust(
        workbookFactory: new WorkbookFactory(),
        rustGenLocation: __DIR__ . '/../vendor/bin/excel_gen'
    );
    $avroFactory->setLogger(new NullLogger());
    
    $htmlFile = 'fixtures.html';
    
    $avroFactory->generateExcelFromHtml($htmlFile, $output);
```

