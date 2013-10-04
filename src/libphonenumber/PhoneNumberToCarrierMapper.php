<?php
/**
 * 
 *
 * @author giggsey
 * @created: 02/10/13 16:52
 * @project libphonenumber-for-php
 */

namespace libphonenumber;


use libphonenumber\prefixmapper\PrefixFileReader;

class PhoneNumberToCarrierMapper
{
    /**
     * @var PhoneNumberToCarrierMapper
     */
    private static $instance = null;

    const MAPPING_DATA_DIRECTORY = '/carrier/data/';

    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;
    /**
     * @var PrefixFileReader
     */
    private $prefixFileReader;

    private function __construct($phonePrefixDataDirectory) {
        $this->prefixFileReader = new PrefixFileReader(dirname(__FILE__) . $phonePrefixDataDirectory);
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    /**
     * Gets a {@link PhoneNumberToCarrierMapper} instance to carry out international carrier lookup.
     *
     * <p> The {@link PhoneNumberToCarrierMapper} is implemented as a singleton. Therefore, calling
     * this method multiple times will only result in one instance being created.
     *
     * @param string $mappingDir
     * @return PhoneNumberToCarrierMapper
     */
    public static function getInstance($mappingDir = self::MAPPING_DATA_DIRECTORY) {
        if (self::$instance === null) {
            self::$instance = new self($mappingDir);
        }

        return self::$instance;
    }

    /**
     * Returns a text description for the given phone number, in the language provided. The
     * description consists of the name of the carrier the number was originally allocated to, however
     * if the country supports mobile number portability the number might not belong to the returned
     * carrier anymore. If no mapping is found an empty string is returned.
     *
     * <p>This method assumes the validity of the number passed in has already been checked, and that
     * the number is suitable for carrier lookup. We consider mobile and pager numbers possible
     * candidates for carrier lookup.
     *
     * @param PhoneNumber $number  a valid phone number for which we want to get a text description
     * @param string $languageCode  the language code for which the description should be written
     * @return string a text description for the given language code for the given phone number
     */
    public function getDescriptionForValidNumber(PhoneNumber $number, $languageCode) {
        $languageStr = \Locale::getPrimaryLanguage($languageCode);
        $scriptStr = "";
        $regionStr = \Locale::getRegion($languageCode);

        return $this->prefixFileReader->getDescriptionForNumber($number, $languageStr, $scriptStr, $regionStr);
    }


    /**
     * As per {@link #getDescriptionForValidNumber(PhoneNumber, Locale)} but explicitly checks
     * the validity of the number passed in.
     *
     * @param PhoneNumber $number The phone number  for which we want to get a text description
     * @param string $languageCode Language code for which the description should be written
     * @return  string a text description for the given language code for the given phone number, or empty
     *     string if the number passed in is invalid
     */
    public function getDescriptionForNumber(PhoneNumber $number, $languageCode) {
        $numberType = $this->phoneUtil->getNumberType($number);
        if ($this->isMobile($numberType)) {
            return $this->getDescriptionForValidNumber($number, $languageCode);
        }
        return "";
    }

    /**
     * Checks if the supplied number type supports carrier lookup.
     * @param int $numberType A PhoneNumberType int
     * @return bool
     */
    private function isMobile($numberType) {
        return ($numberType === PhoneNumberType::MOBILE ||
            $numberType === PhoneNumberType::FIXED_LINE_OR_MOBILE ||
            $numberType === PhoneNumberType::PAGER
        );
    }
}

/* EOF */ 