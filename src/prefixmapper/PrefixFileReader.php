<?php

namespace libphonenumber\prefixmapper;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;

/**
 * A helper class doing file handling and lookup of phone number prefix mappings.
 *
 * @package libphonenumber\prefixmapper
 * @internal
 */
class PrefixFileReader
{
    protected string $phonePrefixDataDirectory;
    /**
     * The mappingFileProvider knows for which combination of countryCallingCode and language a phone
     * prefix mapping file is available in the file system, so that a file can be loaded when needed.
     */
    protected MappingFileProvider $mappingFileProvider;
    /**
     * A mapping from countryCallingCode_lang to the corresponding phone prefix map that has been
     * loaded.
     */
    protected array $availablePhonePrefixMaps = [];

    public function __construct(string $phonePrefixDataDirectory)
    {
        $this->phonePrefixDataDirectory = $phonePrefixDataDirectory;
        $this->loadMappingFileProvider();
    }

    protected function loadMappingFileProvider(): void
    {
        $mapPath = $this->phonePrefixDataDirectory . DIRECTORY_SEPARATOR . 'Map.php';
        if (!file_exists($mapPath)) {
            throw new \InvalidArgumentException("Invalid data directory: $mapPath");
        }

        $map = require $mapPath;

        $this->mappingFileProvider = new MappingFileProvider($map);
    }

    public function getPhonePrefixDescriptions(string $prefixMapKey, string $language, string $script, string $region): ?PhonePrefixMap
    {
        $fileName = $this->mappingFileProvider->getFileName($prefixMapKey, $language, $script, $region);
        if (strlen($fileName) == 0) {
            return null;
        }

        if (!isset($this->availablePhonePrefixMaps[$fileName])) {
            $this->loadPhonePrefixMapFromFile($fileName);
        }

        return $this->availablePhonePrefixMaps[$fileName];
    }

    protected function loadPhonePrefixMapFromFile(string $fileName): void
    {
        $path = $this->phonePrefixDataDirectory . DIRECTORY_SEPARATOR . $fileName;
        if (!file_exists($path)) {
            throw new \InvalidArgumentException('Data does not exist');
        }

        $map = require $path;
        $areaCodeMap = new PhonePrefixMap($map);

        $this->availablePhonePrefixMaps[$fileName] = $areaCodeMap;
    }

    public function mayFallBackToEnglish(string $language): bool
    {
        // Don't fall back to English if the requested language is among the following:
        // - Chinese
        // - Japanese
        // - Korean
        return ($language != 'zh' && $language != 'ja' && $language != 'ko');
    }

    /**
     * Returns a text description in the given language for the given phone number.
     *
     * @param PhoneNumber $number the phone number for which we want to get a text description
     * @param string $language two or three-letter lowercase ISO language as defined by ISO 639
     * @param string $script four-letter titlecase (the first letter is uppercase and the rest of the letters
     *     are lowercase) ISO script code as defined in ISO 15924
     * @param string $region two-letter uppercase ISO country code as defined by ISO 3166-1
     * @return string a text description for the given language code for the given phone number, or empty
     *     string if the number passed in is invalid or could belong to multiple countries
     */
    public function getDescriptionForNumber(PhoneNumber $number, string $language, string $script, string $region): string
    {
        $phonePrefix = $number->getCountryCode() . PhoneNumberUtil::getInstance()->getNationalSignificantNumber($number);

        $phonePrefixDescriptions = $this->getPhonePrefixDescriptions($phonePrefix, $language, $script, $region);

        $description = ($phonePrefixDescriptions !== null) ? $phonePrefixDescriptions->lookup($number) : null;
        // When a location is not available in the requested language, fall back to English.
        if (($description === null || strlen($description) === 0) && $this->mayFallBackToEnglish($language)) {
            $defaultMap = $this->getPhonePrefixDescriptions($phonePrefix, 'en', '', '');
            if ($defaultMap === null) {
                return '';
            }
            $description = $defaultMap->lookup($number);
        }

        return ($description !== null) ? $description : '';
    }
}
