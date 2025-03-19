<?php

declare(strict_types=1);

namespace libphonenumber\buildtools;

use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use Closure;
use InvalidArgumentException;

use function array_key_exists;
use function count;
use function explode;
use function file;
use function file_exists;
use function file_put_contents;
use function in_array;
use function is_dir;
use function is_readable;
use function mkdir;
use function scandir;
use function str_replace;
use function strlen;
use function strpos;
use function substr;
use function trim;

/**
 * Class GeneratePhonePrefixData
 * @package libphonenumber\buildtools
 * @internal
 */
class GeneratePhonePrefixData
{
    public const DATA_FILE_EXTENSION = '.txt';
    public const GENERATION_COMMENT = <<<'EOT'
        libphonenumber-for-php data file
        This file has been @generated from libphonenumber data
        Do not modify!
        @internal

        EOT;

    public string $inputDir;
    /**
     * @var string[]
     */
    private array $filesToIgnore = ['.', '..', '.svn', '.git'];
    private string $outputDir;
    /**
     * @var array<string,array<string|string>>
     */
    private array $englishMaps = [];
    /**
     * @var array<int,int>
     */
    private array $prefixesToExpand = [
        861 => 5,
        12 => 2,
        13 => 2,
        14 => 2,
        15 => 2,
        16 => 2,
        17 => 2,
        18 => 2,
        19 => 2,
    ];


    public function start(string $inputDir, string $outputDir, string $outputNamespace, OutputInterface $consoleOutput, bool $expandCountries): void
    {
        $this->inputDir = $inputDir;
        $this->outputDir = $outputDir;

        $inputOutputMappings = $this->createInputOutputMappings($expandCountries);
        $availableDataFiles = [];

        $progress = new ProgressBar($consoleOutput, count($inputOutputMappings));

        $progress->start();
        foreach ($inputOutputMappings as $textFile => $outputFiles) {
            $mappings = $this->readMappingsFromFile($textFile);

            $language = $this->getLanguageFromTextFile($textFile);

            $this->removeEmptyEnglishMappings($mappings, $language);
            $this->makeDataFallbackToEnglish($textFile, $mappings);
            $mappingForFiles = $this->splitMap($mappings, $outputFiles);

            foreach ($mappingForFiles as $outputFile => $value) {
                $this->writeMappingFile($language, (string) $outputFile, $outputNamespace, $value);
                $this->addConfigurationMapping($availableDataFiles, $language, $outputFile);
            }
            $progress->advance();
        }

        $this->writeConfigMap($availableDataFiles, $outputNamespace);

        $progress->finish();
    }

    /**
     * @return array<string,string[]>
     */
    private function createInputOutputMappings(bool $expandCountries): array
    {
        $topLevel = scandir($this->inputDir);

        $mappings = [];

        foreach ($topLevel as $languageDirectory) {
            if (in_array($languageDirectory, $this->filesToIgnore, true)) {
                continue;
            }

            $fileLocation = $this->inputDir . DIRECTORY_SEPARATOR . $languageDirectory;

            if (is_dir($fileLocation)) {
                // Will contain files

                $countryCodeFiles = scandir($fileLocation);

                foreach ($countryCodeFiles as $countryCodeFileName) {
                    if (in_array($countryCodeFileName, $this->filesToIgnore, true)) {
                        continue;
                    }


                    $outputFiles = $this->createOutputFileNames(
                        $this->getCountryCodeFromTextFileName($countryCodeFileName),
                        $languageDirectory,
                        $expandCountries
                    );

                    $mappings[$languageDirectory . DIRECTORY_SEPARATOR . $countryCodeFileName] = $outputFiles;
                }
            }
        }

        return $mappings;
    }

    /**
     * Method used by {@code #createInputOutputMappings()} to generate the list of output binary files
     * from the provided input text file. For the data files expected to be large (currently only
     * NANPA is supported), this method generates a list containing one output file for each area
     * code. Otherwise, a single file is added to the list.
     * @return string[]
     */
    private function createOutputFileNames(string $countryCode, string $language, bool $expandCountries): array
    {
        $outputFiles = [];

        if ($expandCountries === false) {
            $outputFiles[] = $this->generateFilename($countryCode, $language);
            return $outputFiles;
        }

        /*
         * Reduce memory usage for China numbers
         * @see https://github.com/giggsey/libphonenumber-for-php/issues/44
         *
         * Analytics of the data suggests that the following prefixes need expanding:
         *  - 861 (to 5 chars)
         */
        $phonePrefixes = [];
        $prefixesToExpand = $this->prefixesToExpand;

        $this->parseTextFile(
            $this->getFilePathFromLanguageAndCountryCode($language, $countryCode),
            function ($prefix, $location) use (&$phonePrefixes, $prefixesToExpand, $countryCode) {
                $length = strlen($countryCode);
                foreach ($prefixesToExpand as $p => $l) {
                    if (str_starts_with($prefix, (string) $p)) {
                        // Allow later entries to overwrite initial ones
                        $length = $l;
                    }
                }

                $shortPrefix = substr($prefix, 0, $length);
                if (!in_array($shortPrefix, $phonePrefixes, true)) {
                    $phonePrefixes[] = $shortPrefix;
                }
            }
        );

        foreach ($phonePrefixes as $prefix) {
            $outputFiles[] = $this->generateFilename($prefix, $language);
        }

        return $outputFiles;
    }

    /**
     * Reads phone prefix data from the provides file path and invokes the given handler for each
     * mapping read.
     *
     * @throws InvalidArgumentException
     */
    private function parseTextFile(string $filePath, Closure $handler): void
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            throw new InvalidArgumentException("File '{$filePath}' does not exist");
        }

        $data = file($filePath);

        if ($data === false) {
            throw new InvalidArgumentException("File '{$filePath}' unreadable");
        }

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

                [$prefix, $location] = $parts;

                $handler($prefix, $location);
            }
        }

    }

    private function getFilePathFromLanguageAndCountryCode(string $language, string $code): string
    {
        return $this->getFilePath($language . DIRECTORY_SEPARATOR . $code . self::DATA_FILE_EXTENSION);
    }

    private function getFilePath(string $fileName): string
    {
        return $this->inputDir . $fileName;
    }

    private function generateFilename(string $prefix, string $language): string
    {
        return $language . DIRECTORY_SEPARATOR . $prefix . self::DATA_FILE_EXTENSION;
    }

    private function getCountryCodeFromTextFileName(string $countryCodeFileName): string
    {
        return str_replace(self::DATA_FILE_EXTENSION, '', $countryCodeFileName);
    }

    /**
     * @return array<string,string>
     */
    private function readMappingsFromFile(string $inputFile): array
    {
        $areaCodeMap = [];

        $this->parseTextFile(
            $this->inputDir . $inputFile,
            function ($prefix, $location) use (&$areaCodeMap) {
                $areaCodeMap[$prefix] = $location;
            }
        );

        return $areaCodeMap;
    }

    private function getLanguageFromTextFile(string $textFile): string
    {
        $parts = explode(DIRECTORY_SEPARATOR, $textFile);

        return $parts[0];
    }

    /**
     * @param array<string,string> $mappings
     */
    private function removeEmptyEnglishMappings(array &$mappings, string $language): void
    {
        if ($language !== 'en') {
            return;
        }

        foreach ($mappings as $k => $v) {
            if ($v === '') {
                unset($mappings[$k]);
            }
        }
    }

    /**
     * Compress the provided mappings according to the English data file if any.
     * @param array<string|int,string> $mappings
     */
    private function makeDataFallbackToEnglish(string $textFile, array &$mappings): void
    {
        $englishPath = $this->getEnglishDataPath($textFile);

        if ($textFile === $englishPath || !file_exists($this->getFilePath($englishPath))) {
            return;
        }

        $countryCode = substr($textFile, 3, 2);

        if (!array_key_exists($countryCode, $this->englishMaps)) {
            $englishMap = $this->readMappingsFromFile($englishPath);

            $this->englishMaps[$countryCode] = $englishMap;
        }

        $this->compressAccordingToEnglishData($this->englishMaps[$countryCode], $mappings);
    }

    private function getEnglishDataPath(string $textFile): string
    {
        return 'en' . DIRECTORY_SEPARATOR . substr($textFile, 3);
    }

    /**
     * @param array<string|int,string> $englishMap
     * @param array<string|int,string> $nonEnglishMap
     */
    private function compressAccordingToEnglishData(array $englishMap, array &$nonEnglishMap): void
    {
        foreach ($nonEnglishMap as $prefix => $value) {
            if (array_key_exists($prefix, $englishMap)) {
                $englishDescription = $englishMap[$prefix];
                if ($englishDescription === $value) {
                    if (!$this->hasOverlappingPrefix((string) $prefix, $nonEnglishMap)) {
                        unset($nonEnglishMap[$prefix]);
                    } else {
                        $nonEnglishMap[$prefix] = '';
                    }
                }
            }
        }
    }

    /**
     * @param array<int|string,string> $mappings
     */
    private function hasOverlappingPrefix(string $number, array $mappings): bool
    {
        while ($number !== '') {
            $number = substr($number, 0, -1);

            if (array_key_exists($number, $mappings)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array<string|int,string> $mappings
     * @param string[] $outputFiles
     * @return array<string,array<int|string,string>>
     */
    private function splitMap(array $mappings, array $outputFiles): array
    {
        $mappingForFiles = [];

        foreach ($mappings as $prefix => $location) {
            $targetFile = null;

            foreach ($outputFiles as $k => $outputFile) {
                $outputFilePrefix = $this->getPhonePrefixLanguagePairFromFilename($outputFile)[1];
                if (str_starts_with((string) $prefix, $outputFilePrefix)) {
                    $targetFile = $outputFilePrefix;
                    break;
                }
            }

            if (!array_key_exists($targetFile, $mappingForFiles)) {
                $mappingForFiles[$targetFile] = [];
            }
            $mappingForFiles[$targetFile][$prefix] = $location;
        }

        return $mappingForFiles;
    }

    /**
     * Extracts the phone prefix and the language code contained in the provided file name.
     * @return array{string,string}
     */
    private function getPhonePrefixLanguagePairFromFilename(string $outputFile): array
    {
        $parts = explode(DIRECTORY_SEPARATOR, $outputFile);

        return [$parts[0], $this->getCountryCodeFromTextFileName($parts[1])];
    }

    /**
     * @param array<string|int,string> $data
     */
    private function writeMappingFile(string $language, string $outputFile, string $outputNamespace, array $data): void
    {
        if (!file_exists($this->outputDir . $language)) {
            mkdir($this->outputDir . $language);
        }

        $mappingClass = ucfirst($language) . '_' . $outputFile;

        $file = new PhpFile();
        $file->setStrictTypes();
        $file->addComment(self::GENERATION_COMMENT);

        $namespace = $file->addNamespace($outputNamespace . '\\' . $language);

        $class = $namespace->addClass($mappingClass);
        $class->addComment('@internal');

        // Sort by key to allow array optimizations
        ksort($data);

        $constant = $class->addConstant('DATA', $data);
        $constant->setPublic();

        $printer = new PsrPrinter();

        $outputPath = $this->outputDir . $language . DIRECTORY_SEPARATOR . $mappingClass . '.php';

        file_put_contents($outputPath, $printer->printFile($file));
    }

    /**
     * @param array<string,array<int|string>> $availableDataFiles
     * @param int|string $prefix Build uses int, tests use string.
     */
    public function addConfigurationMapping(array &$availableDataFiles, string $language, int|string $prefix): void
    {
        if (!array_key_exists($language, $availableDataFiles)) {
            $availableDataFiles[$language] = [];
        }

        $availableDataFiles[$language][] = $prefix;
    }

    /**
     * @param array<string,array<string|int>> $availableDataFiles
     */
    private function writeConfigMap(array $availableDataFiles, string $outputNamespace): void
    {
        $mappingClass = 'Map';

        $file = new PhpFile();
        $file->setStrictTypes();
        $file->addComment(self::GENERATION_COMMENT);

        $namespace = $file->addNamespace($outputNamespace);

        $class = $namespace->addClass($mappingClass);
        $class->addComment('@internal');

        $constant = $class->addConstant('DATA', $availableDataFiles);
        $constant->setPublic();

        $printer = new PsrPrinter();

        $outputPath = $this->outputDir . DIRECTORY_SEPARATOR . $mappingClass . '.php';

        file_put_contents($outputPath, $printer->printFile($file));
    }
}
