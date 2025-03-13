<?php

declare(strict_types=1);

namespace libphonenumber\buildtools;

use libphonenumber\buildtools\Builders\PhoneMetadataBuilder;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PsrPrinter;
use RuntimeException;

use function array_keys;
use function count;
use function file_put_contents;
use function ksort;

/**
 * Tool to convert phone number metadata from the XML format to protocol buffer format.
 *
 * @author Davide Mendolia
 * @internal
 */
class BuildMetadataPHPFromXml
{
    public const GENERATION_COMMENT = <<<EOT
        libphonenumber-for-php data file
        This file has been @generated from libphonenumber data
        Do not modify!
        @internal

        EOT;
    public const MAP_COMMENT = <<<EOT
        A mapping from a country code to the region codes which denote the
        country/region represented by that country code. In the case of multiple
        countries sharing a calling code, such as the NANPA countries, the one
        indicated with "isMainCountryForCode" in the metadata should be first.
        @var array<int,string[]>

        EOT;
    public const COUNTRY_CODE_SET_COMMENT = <<<EOT
        A set of all country calling codes for which data is available.
        @var int[]
        EOT;
    public const REGION_CODE_SET_COMMENT = <<<EOT
         A set of all region codes for which data is available.
         @var string[]
        EOT;

    public function start(string $inputFile, string $outputDir, string $namespaceAndClassPrefix, string $mappingClass, string $mappingClassLocation): void
    {
        $metadataCollection = BuildMetadataFromXml::buildPhoneMetadataCollection($inputFile);
        $this->writeMetadataToFile($metadataCollection, $outputDir, $namespaceAndClassPrefix);

        $countryCodeToRegionCodeMap = BuildMetadataFromXml::buildCountryCodeToRegionCodeMap($metadataCollection);
        // Sort $countryCodeToRegionCodeMap just to have the regions in order
        ksort($countryCodeToRegionCodeMap);
        $this->writeCountryCallingCodeMappingToFile($countryCodeToRegionCodeMap, $mappingClassLocation, $mappingClass);
    }

    /**
     * @param PhoneMetadataBuilder[] $metadataCollection
     */
    private function writeMetadataToFile(array $metadataCollection, string $directory, string $namespaceAndClassPrefix): void
    {
        foreach ($metadataCollection as $metadata) {
            $regionCode = $metadata->getId();
            // For non-geographical country calling codes (e.g. +800), use the country calling codes
            // instead of the region code to form the file name.
            if ($regionCode === '001' || $regionCode === '') {
                $regionCode = $metadata->getCountryCode();
            }

            $pos = strrpos($namespaceAndClassPrefix, '\\');

            if ($pos === false) {
                throw new RuntimeException('Invalid namespaceAndClassPrefix: ' . $namespaceAndClassPrefix);
            }

            $namespace = substr($namespaceAndClassPrefix, 0, $pos);
            $classPrefix = substr($namespaceAndClassPrefix, $pos + 1);

            $data = $metadata->toFile($classPrefix . '_' . $regionCode, $namespace);
            $data->addComment(self::GENERATION_COMMENT);

            $printer = new PsrPrinter();

            file_put_contents($directory . DIRECTORY_SEPARATOR . $classPrefix . '_' . $regionCode . '.php', $printer->printFile($data));
        }
    }

    /**
     * @param array<int|string,array<string>> $countryCodeToRegionCodeMap
     */
    private function writeCountryCallingCodeMappingToFile(array $countryCodeToRegionCodeMap, string $outputDir, string $mappingClass): void
    {
        // Find out whether the countryCodeToRegionCodeMap has any region codes or country
        // calling codes listed in it.
        $hasRegionCodes = false;
        foreach ($countryCodeToRegionCodeMap as $key => $listWithRegionCode) {
            if ((is_countable($listWithRegionCode) ? count($listWithRegionCode) : 0) > 0) {
                $hasRegionCodes = true;
                break;
            }
        }

        $hasCountryCodes = count($countryCodeToRegionCodeMap) > 1;

        $variableName = strtoupper(preg_replace('/(?<!^)[A-Z]/', '_$0', $mappingClass));

        $file = new PhpFile();
        $file->setStrictTypes();
        $file->addComment(self::GENERATION_COMMENT);

        $namespace = $file->addNamespace('libphonenumber');

        $class = $namespace->addClass($mappingClass);
        $class->addComment('@internal');

        if ($hasRegionCodes && $hasCountryCodes) {
            $constant = $class->addConstant($variableName, $countryCodeToRegionCodeMap);
            $constant->setComment(self::MAP_COMMENT);
        } elseif ($hasCountryCodes) {
            $constant = $class->addConstant($variableName, array_keys($countryCodeToRegionCodeMap));
            $constant->setComment(self::COUNTRY_CODE_SET_COMMENT);
        } else {
            $constant = $class->addConstant($variableName, $countryCodeToRegionCodeMap[0]);
            $constant->setComment(self::REGION_CODE_SET_COMMENT);
        }

        $constant->setPublic();

        $printer = new PsrPrinter();

        file_put_contents($outputDir . $mappingClass . '.php', $printer->printFile($file));
    }
}
