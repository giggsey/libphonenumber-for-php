<?php

namespace libphonenumber\buildtools;

use libphonenumber\PhoneMetadata;
use Symfony\Component\VarExporter\VarExporter;

/**
 * Tool to convert phone number metadata from the XML format to protocol buffer format.
 *
 * @author Davide Mendolia
 * @internal
 */
class BuildMetadataPHPFromXml
{
    public const GENERATION_COMMENT = <<<EOT
        /**
         * libphonenumber-for-php-lite data file
         * This file has been @generated from libphonenumber data
         * Do not modify!
         * @internal
         */

        EOT;
    public const MAP_COMMENT = <<<EOT
          // A mapping from a country code to the region codes which denote the
          // country/region represented by that country code. In the case of multiple
          // countries sharing a calling code, such as the NANPA countries, the one
          // indicated with "isMainCountryForCode" in the metadata should be first.

        EOT;
    public const COUNTRY_CODE_SET_COMMENT =
        "  // A set of all country codes for which data is available.\n";
    public const REGION_CODE_SET_COMMENT =
        "  // A set of all region codes for which data is available.\n";

    public function start($inputFile, $outputDir, $filePrefix, $mappingClass, $mappingClassLocation, $liteBuild)
    {
        $savePath = $outputDir . $filePrefix;

        $metadataCollection = BuildMetadataFromXml::buildPhoneMetadataCollection($inputFile, $liteBuild, false);
        $this->writeMetadataToFile($metadataCollection, $savePath);

        $countryCodeToRegionCodeMap = BuildMetadataFromXml::buildCountryCodeToRegionCodeMap($metadataCollection);
        // Sort $countryCodeToRegionCodeMap just to have the regions in order
        \ksort($countryCodeToRegionCodeMap);
        $this->writeCountryCallingCodeMappingToFile($countryCodeToRegionCodeMap, $mappingClassLocation, $mappingClass);
    }

    /**
     * @param $metadataCollection PhoneMetadata[]
     */
    private function writeMetadataToFile($metadataCollection, $filePrefix)
    {
        foreach ($metadataCollection as $metadata) {
            /** @var $phoneMetadata PhoneMetadata */
            $regionCode = $metadata->getId();
            // For non-geographical country calling codes (e.g. +800), use the country calling codes
            // instead of the region code to form the file name.
            if ($regionCode === '001' || $regionCode == '') {
                $regionCode = $metadata->getCountryCode();
            }

            $data = '<?php' . PHP_EOL
                . self::GENERATION_COMMENT . PHP_EOL
                . 'return ' . VarExporter::export($metadata->toArray()) . ';' . PHP_EOL;

            \file_put_contents($filePrefix . '_' . $regionCode . '.php', $data);
        }
    }

    /**
     * @param array<int,array<string>> $countryCodeToRegionCodeMap
     */
    private function writeCountryCallingCodeMappingToFile(array $countryCodeToRegionCodeMap, string $outputDir, string $mappingClass): void
    {
        // Find out whether the countryCodeToRegionCodeMap has any region codes or country
        // calling codes listed in it.
        $hasRegionCodes = false;
        foreach ($countryCodeToRegionCodeMap as $key => $listWithRegionCode) {
            if ((is_countable($listWithRegionCode) ? \count($listWithRegionCode) : 0) > 0) {
                $hasRegionCodes = true;
                break;
            }
        }

        $hasCountryCodes = \count($countryCodeToRegionCodeMap) > 1;

        $variableName = \lcfirst($mappingClass);

        $data = '<?php' . PHP_EOL .
            self::GENERATION_COMMENT . PHP_EOL .
            'namespace libphonenumber;' . PHP_EOL .
            "class {$mappingClass} {" . PHP_EOL .
            PHP_EOL;

        if ($hasRegionCodes && $hasCountryCodes) {
            $data .= self::MAP_COMMENT . PHP_EOL;
            $data .= "   public static \${$variableName} = " . VarExporter::export($countryCodeToRegionCodeMap) . ';' . PHP_EOL;
        } elseif ($hasCountryCodes) {
            $data .= self::COUNTRY_CODE_SET_COMMENT . PHP_EOL;
            $data .= "   public static \${$variableName} = " . VarExporter::export(\array_keys($countryCodeToRegionCodeMap)) . ';' . PHP_EOL;
        } else {
            $data .= self::REGION_CODE_SET_COMMENT . PHP_EOL;
            $data .= "   public static \${$variableName} = " . VarExporter::export($countryCodeToRegionCodeMap[0]) . ';' . PHP_EOL;
        }

        $data .= PHP_EOL .
            '}' . PHP_EOL;

        \file_put_contents($outputDir . $mappingClass . '.php', $data);
    }
}
