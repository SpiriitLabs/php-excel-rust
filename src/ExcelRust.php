<?php

namespace Spiriit\Rustsheet;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Spiriit\Rustsheet\ExportAvro\ExportAvro;
use Symfony\Component\Process\Process;

class ExcelRust implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    const RUST_GEN_AVRO = 'rust_gen_avro';
    const RUST_GEN_HTML = 'rust_gen_html';

    public function __construct(
        private WorkbookFactory $workbookFactory,
        private string $rustGenLocation,
    )
    {
    }

    public function generateExcelFromAvro(ExcelInterface $excel): void
    {
        $results = $this->buildExcel($excel);
        $filenameOutput = $results['filename'];
        unset($results['filename']);

        $avro = $this->exportAvro($results);

        $this->execute($avro, $filenameOutput, self::RUST_GEN_AVRO);
    }

    public function generateExcelFromHtml(string $htmlFile, string $filenameOutput): void
    {
        $this->execute($htmlFile, $filenameOutput, self::RUST_GEN_HTML);
    }

    private function execute(string $filePath, string $filenameOutput, string $rustGenMode): void
    {
        try {
            ['exit_code' => $status, 'output' => $stdout, 'error_output' => $stderr] = $this->rustGen($filePath, $rustGenMode, $filenameOutput);
            $this->checkProcessStatus($status, $stdout, $stderr);
            $this->checkOutput($filenameOutput);
        } catch (\Throwable $e) {
            $this->logger?->error(\sprintf('There is an error while generating "%s".', $filenameOutput), [
                'status' => $status ?? null,
                'stdout' => $stdout ?? null,
                'stderr' => $stderr ?? null,
            ]);

            throw $e;
        }

        $this->logger?->info(\sprintf('Excel file "%s" has been successfully generated.', $filenameOutput), [
            'stdout' => $stdout,
            'stderr' => $stderr,
        ]);
    }

    private function buildExcel(ExcelInterface $excel): array
    {
        return $this->workbookFactory->create($excel);
    }

    private function exportAvro(array $results)
    {
        $schema = file_get_contents(__DIR__.'/../schema.json');

        $avroFilePath = sprintf('%s/%s.avro', sys_get_temp_dir(), uniqid('avro', true));

        $exportAvro = new ExportAvro(schema: $schema, pathAvro: $avroFilePath);
        $exportAvro->export($results);

        return $avroFilePath;
    }

    /**
     * @return mixed[]
     */
    private function rustGen(string $filePath, string $mode, string $outputFile): array
    {
        $command = [$this->rustGenLocation, '--output', $outputFile, self::RUST_GEN_AVRO === $mode ? 'avro' : 'html', '--file', $filePath];

        $process = new Process($command);

        $process->mustRun();

        $exitCode = $process->getExitCode();
        $output = $process->getOutput();
        $errorOutput = $process->getErrorOutput();

        return [
            'exit_code' => $exitCode,
            'output' => $output,
            'error_output' => $errorOutput,
        ];
    }

    private function rustGenHtml(string $htmlFile)
    {

    }

    private function checkProcessStatus(mixed $status, mixed $stdout, mixed $stderr)
    {
        if (0 !== $status && '' !== $stderr) {
            throw new \RuntimeException(\sprintf('The exit status code \'%s\' says something went wrong:' . "\n" . 'stderr: "%s"' . "\n" . 'stdout: "%s"', $status, $stderr, $stdout), $status);
        }
    }

    private function checkOutput(string $filenameOutput): void
    {
        // the output file must exist
        if (!file_exists($filenameOutput)) {
            throw new \RuntimeException(\sprintf('The file \'%s\' was not created.', $filenameOutput));
        }

        // the output file must not be empty
        if (0 === $this->filesize($filenameOutput)) {
            throw new \RuntimeException(\sprintf('The file \'%s\' was created but is empty.', $filenameOutput));
        }
    }

    protected function filesize(string $filename): int
    {
        $filesize = \filesize($filename);

        if (false === $filesize) {
            throw new \RuntimeException(\sprintf('Could not read file \'%s\' size.', $filename));
        }

        return $filesize;
    }
}