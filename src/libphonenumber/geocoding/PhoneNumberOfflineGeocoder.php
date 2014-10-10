<?php

namespace libphonenumber\geocoding;


use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\prefixmapper\PrefixFileReader;

class PhoneNumberOfflineGeocoder
{
    const MAPPING_DATA_DIRECTORY = '/data';
    /**
     * @var PhoneNumberOfflineGeocoder
     */
    private static $instance;
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;
    /**
     * @var PrefixFileReader
     */
    private $prefixFileReader = null;

    private function __construct($phonePrefixDataDirectory)
    {
        if(!extension_loaded('intl')) {
            throw new \RuntimeException('The intl extension must be installed');
        }

        $this->phoneUtil = PhoneNumberUtil::getInstance();

        $this->prefixFileReader = new PrefixFileReader(dirname(__FILE__) . $phonePrefixDataDirectory);
    }

    /**
     * Gets a PhoneNumberOfflineGeocoder instance to carry out international phone number geocoding.
     *
     * <p>The PhoneNumberOfflineGeocoder is implemented as a singleton. Therefore, calling this method
     * multiple times will only result in one instance being created.
     *
     * @param string $mappingDir (Optional) Mapping Data Directory
     * @return PhoneNumberOfflineGeocoder
     */
    public static function getInstance($mappingDir = self::MAPPING_DATA_DIRECTORY)
    {
        if (self::$instance === null) {
            self::$instance = new self($mappingDir);
        }

        return self::$instance;
    }

    public static function resetInstance()
    {
        self::$instance = null;
    }

    /**
     * As per getDescriptionForValidNumber, but explicitly checks the validity of the number
     * passed in.
     *
     *
     * @see getDescriptionForValidNumber
     * @param PhoneNumber $number a valid phone number for which we want to get a text description
     * @param string $locale the language code for which the description should be written
     * @param string $userRegion the region code for a given user. This region will be omitted from the
     *     description if the phone number comes from this region. It is a two-letter uppercase ISO
     *     country code as defined by ISO 3166-1.
     * @return string a text description for the given language code for the given phone number, or empty
     *     string if the number passed in is invalid
     */
    public function getDescriptionForNumber(PhoneNumber $number, $locale, $userRegion = null)
    {

        /** @var PhoneNumberType $numberType */
        $numberType = $this->phoneUtil->getNumberType($number);

        if ($numberType === PhoneNumberType::UNKNOWN) {
            return "";
        } elseif (!$this->canBeGeocoded($numberType)) {
            return $this->getCountryNameForNumber($number, $locale);
        }

        return $this->getDescriptionForValidNumber($number, $locale, $userRegion);
    }

    /**
     * A similar method is implemented as PhoneNumberUtil.isNumberGeographical, which performs a
     * stricter check, as it determines if a number has a geographical association. Also, if new
     * phone number types were added, we should check if this other method should be updated too.
     *
     * @param int $numberType
     * @return boolean
     */
    private function canBeGeocoded($numberType)
    {
        return ($numberType === PhoneNumberType::FIXED_LINE || $numberType === PhoneNumberType::MOBILE || $numberType === PhoneNumberType::FIXED_LINE_OR_MOBILE);
    }

    /**
     * Returns the customary display name in the given language for the given territory the phone
     * number is from. If it could be from many territories, nothing is returned.
     *
     * @param PhoneNumber $number
     * @param $locale
     * @return string
     */
    private function getCountryNameForNumber(PhoneNumber $number, $locale)
    {
        $regionCodes = $this->phoneUtil->getRegionCodesForCountryCode($number->getCountryCode());

        if (count($regionCodes) === 1) {
            return $this->getRegionDisplayName($regionCodes[0], $locale);
        } else {
            $regionWhereNumberIsValid = 'ZZ';
            foreach ($regionCodes as $regionCode) {
                if ($this->phoneUtil->isValidNumberForRegion($number, $regionCode)) {
                    if ($regionWhereNumberIsValid !== 'ZZ') {
                        // If we can't assign the phone number as definitely belonging to only one territory,
                        // then we return nothing.
                        return "";
                    }
                    $regionWhereNumberIsValid = $regionCode;
                }
            }

            return $this->getRegionDisplayName($regionWhereNumberIsValid, $locale);
        }
    }

    /**
     * Returns the customary display name in the given language for the given region.
     *
     * @param $regionCode
     * @param $locale
     * @return string
     */
    private function getRegionDisplayName($regionCode, $locale)
    {
        if ($regionCode === null || $regionCode == 'ZZ' || $regionCode === PhoneNumberUtil::REGION_CODE_FOR_NON_GEO_ENTITY) {
            return "";
        }

        return Locale::getDisplayRegion(
            Locale::countryCodeToLocale($regionCode),
            $locale
        );
    }

    /**
     * Returns a text description for the given phone number, in the language provided. The
     * description might consist of the name of the country where the phone number is from, or the
     * name of the geographical area the phone number is from if more detailed information is
     * available.
     *
     * <p>This method assumes the validity of the number passed in has already been checked, and that
     * the number is suitable for geocoding. We consider fixed-line and mobile numbers possible
     * candidates for geocoding.
     *
     * <p>If $userRegion is set, we also consider the region of the user. If the phone number is from
     * the same region as the user, only a lower-level description will be returned, if one exists.
     * Otherwise, the phone number's region will be returned, with optionally some more detailed
     * information.
     *
     * <p>For example, for a user from the region "US" (United States), we would show "Mountain View,
     * CA" for a particular number, omitting the United States from the description. For a user from
     * the United Kingdom (region "GB"), for the same number we may show "Mountain View, CA, United
     * States" or even just "United States".
     *
     * @param PhoneNumber $number a valid phone number for which we want to get a text description
     * @param string $locale the language code for which the description should be written
     * @param string $userRegion the region code for a given user. This region will be omitted from the
     *     description if the phone number comes from this region. It is a two-letter uppercase ISO
     *     country code as defined by ISO 3166-1.
     * @return string a text description for the given language code for the given phone number
     */
    public function getDescriptionForValidNumber(PhoneNumber $number, $locale, $userRegion = null)
    {
        // If the user region matches the number's region, then we just show the lower-level
        // description, if one exists - if no description exists, we will show the region(country) name
        // for the number.
        $regionCode = $this->phoneUtil->getRegionCodeForNumber($number);
        if ($userRegion == null || $userRegion == $regionCode) {
            $languageStr = Locale::getPrimaryLanguage($locale);
            $scriptStr = "";
            $regionStr = Locale::getRegion($locale);

            $mobileToken = $this->phoneUtil->getCountryMobileToken($number->getCountryCode());
            $nationalNumber = $this->phoneUtil->getNationalSignificantNumber($number);
            if ($mobileToken !== "" && (!strncmp($nationalNumber, $mobileToken, strlen($mobileToken)))) {
                // In some countries, eg. Argentina, mobile numbers have a mobile token before the national
                // destination code, this should be removed before geocoding.
                $nationalNumber = substr($nationalNumber, strlen($mobileToken));
                $region = $this->phoneUtil->getRegionCodeForCountryCode($number->getCountryCode());
                try {
                    $copiedNumber = $this->phoneUtil->parse($nationalNumber, $region);
                } catch (NumberParseException $e) {
                    // If this happens, just reuse what we had.
                    $copiedNumber = $number;
                }
                $areaDescription = $this->prefixFileReader->getDescriptionForNumber($copiedNumber, $languageStr, $scriptStr, $regionStr);
            } else {
                $areaDescription = $this->prefixFileReader->getDescriptionForNumber($number, $languageStr, $scriptStr, $regionStr);
            }

            return (strlen($areaDescription) > 0) ? $areaDescription : $this->getCountryNameForNumber($number, $locale);
        }
        // Otherwise, we just show the region(country) name for now.
        return $this->getRegionDisplayName($regionCode, $locale);
        // TODO: Concatenate the lower-level and country-name information in an appropriate
        // way for each language.
    }
}
