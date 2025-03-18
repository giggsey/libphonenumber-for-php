<?php

declare(strict_types=1);

namespace libphonenumber\buildtools;

use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use RuntimeException;

use function explode;
use function file;
use function file_put_contents;
use function is_readable;
use function str_replace;
use function strpos;
use function trim;

/**
 * Class GenerateTimeZonesMapData
 * @package libphonenumber\buildtools
 * @internal
 */
class GenerateTimeZonesMapData
{
    public const GENERATION_COMMENT = <<<'EOT'
        /**
         * libphonenumber-for-php data file
         * This file has been @generated from libphonenumber data
         * Do not modify!
         * @internal
         */

        EOT;
    private string $inputTextFile;

    public function __construct(string $inputFile, string $outputDir, string $outputNamespace)
    {
        $this->inputTextFile = $inputFile;

        if (!is_readable($this->inputTextFile)) {
            throw new RuntimeException('The provided input text file does not exist.');
        }

        $data = $this->parseTextFile();
        $this->writeMappingFile($outputDir, $outputNamespace, $data);
    }

    /**
     * Reads phone prefix data from the provided input stream and returns a SortedMap with the
     * prefix to time zones mappings.
     * @return array<string,string>
     */
    private function parseTextFile(): array
    {
        $data = file($this->inputTextFile);

        if ($data === false) {
            throw new RuntimeException('The provided input text file could not be read.');
        }

        $timeZoneMap = [];

        foreach ($data as $line) {
            // Remove \n
            $line = str_replace(["\n", "\r"], '', $line);
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }
            if (strpos($line, '|') > 0) {
                // Valid line
                $parts = explode('|', $line);

                [$prefix, $timezone] = $parts;

                $timeZoneMap[$prefix] = $timezone;
            }
        }

        return $timeZoneMap;
    }

    /**
     * @param array<string,string> $data
     */
    private function writeMappingFile(string $outputFile, string $outputNamespace, array $data): void
    {
        $mappingClass = 'Map';

        $file = new PhpFile();
        $file->setStrictTypes();
        $file->addComment(self::GENERATION_COMMENT);

        $namespace = $file->addNamespace($outputNamespace);

        $class = $namespace->addClass($mappingClass);
        $class->addComment('@internal');

        $constant = $class->addConstant('DATA', $data);
        $constant->setPublic();

        $printer = new PsrPrinter();

        $outputPath = $outputFile . DIRECTORY_SEPARATOR . $mappingClass . '.php';

        file_put_contents($outputPath, $printer->printFile($file));
    }
}
