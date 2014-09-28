<?php

namespace libphonenumber\prefixmapper;

/**
 * A utility which knows the data files that are available for the phone prefix mappers to use.
 * The data files contain mappings from phone number prefixes to text descriptions, and are
 * organized by country calling code and language that the text descriptions are in.
 *
 * Class MappingFileProvider
 * @package libphonenumber\prefixmapper
 */
class MappingFileProvider
{

    private $map;

    public function __construct($map)
    {
        $this->map = $map;
    }

    public function getFileName($countryCallingCode, $language, $script)
    {
        if (strlen($language) == 0) {
            return "";
        }

        if ($this->inMap($language, $countryCallingCode)) {
            return $language . DIRECTORY_SEPARATOR . $countryCallingCode . '.php';
        }


        return "";
    }

    private function inMap($language, $countryCallingCode)
    {
        return (array_key_exists($language, $this->map) && in_array($countryCallingCode, $this->map[$language]));
    }

}
