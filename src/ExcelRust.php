<?php

/*
 * This file is part of the SpiriitLabs php-excel-rust package.
 * Copyright (c) SpiriitLabs <https://www.spiriit.com/>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Spiriit\Rustsheet;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Spiriit\Rustsheet\ExportAvro\ExportAvro;
use Symfony\Component\Process\Process;

use function Symfony\Component\String\u;

class ExcelRust implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public const RUST_GEN_AVRO = 'rust_gen_avro';
    public const RUST_GEN_HTML = 'rust_gen_html';

    public function __construct(
        private WorkbookFactoryInterface $workbookFactory,
        private string $rustGenLocation,
        private ?ExportAvro $exportAvro = null,
    ) {
    }

    public function generateExcelFromAvro(ExcelInterface|string $name, ?string $filenameOutput): string
    {
        $results = $this->buildExcel($name);

        $filenameOutput = $filenameOutput ?? $results['filename'];

        if (null === $filenameOutput) {
            $filenameOutput = u($results['filename'])
                ->ensureEnd('.xlsx')
                ->toString();
        } else {
            $filenameOutput = u($filenameOutput)
                ->ensureEnd('.xlsx')
                ->toString();
        }

        unset($results['filename']);

        $avro = $this->exportAvro($results);

        $this->execute($avro, $filenameOutput, self::RUST_GEN_AVRO);

        return $filenameOutput;
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

    private function buildExcel(ExcelInterface|string $name): array
    {
        return $this->workbookFactory->create($name);
    }

    private function exportAvro(array $results): string
    {
        if (null === $this->exportAvro) {
            throw new \RuntimeException('There is no ExportAvro instance available.');
        }

        return $this->exportAvro->export($results);
    }

    /**
     * @return mixed[]
     */
    protected function rustGen(string $filePath, string $mode, string $outputFile): array
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

    private function checkProcessStatus(mixed $status, mixed $stdout, mixed $stderr)
    {
        if (0 !== $status && '' !== $stderr) {
            throw new \RuntimeException(\sprintf('The exit status code \'%s\' says something went wrong:'."\n".'stderr: "%s"'."\n".'stdout: "%s"', $status, $stderr, $stdout), $status);
        }
    }

    protected function checkOutput(string $filenameOutput): void
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
        $filesize = filesize($filename);

        if (false === $filesize) {
            throw new \RuntimeException(\sprintf('Could not read file \'%s\' size.', $filename));
        }

        return $filesize;
    }
}
