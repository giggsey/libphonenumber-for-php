<?php
/**
 * Methods for getting information about short phone numbers, such as short codes and emergency
 * numbers. Note that most commercial short numbers are not handled here, but by the
 * {@link PhoneNumberUtil}.
 *
 * @author Shaopeng Jia
 * @author David Yonge-Mallo
 * @since 5.8
 */

namespace libphonenumber;


class ShortNumberInfo
{
    const META_DATA_FILE_PREFIX = 'ShortNumberMetadata';
    /**
     * @var ShortNumberInfo
     */
    private static $instance = null;
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;
    private $currentFilePrefix;
    private $regionToMetadataMap = array();
    private $countryCodeToNonGeographicalMetadataMap = array();

    private function __construct(PhoneNumberUtil $phoneNumberUtil = null)
    {
        if ($phoneNumberUtil === null) {
            $this->phoneUtil = PhoneNumberUtil::getInstance();
        } else {
            $this->phoneUtil = $phoneNumberUtil;
        }
        $this->currentFilePrefix = dirname(__FILE__) . '/data/' . self::META_DATA_FILE_PREFIX;
    }

    /**
     * Returns the singleton instance of ShortNumberInfo
     *
     * @param PhoneNumberUtil $phoneNumberUtil Optional instance of PhoneNumber Util
     * @return \libphonenumber\ShortNumberInfo
     */
    public static function getInstance(PhoneNumberUtil $phoneNumberUtil = null)
    {
        if (null === self::$instance) {
            self::$instance = new self($phoneNumberUtil);
        }

        return self::$instance;
    }

    public static function resetInstance()
    {
        self::$instance = null;
    }

    public function getSupportedRegions()
    {
        return ShortNumbersRegionCodeSet::$shortNumbersRegionCodeSet;
    }

    /**
     * Gets a valid short number for the specified region.
     *
     * @param $regionCode String the region for which an example short number is needed
     * @return string a valid short number for the specified region. Returns an empty string when the
     *      metadata does not contain such information.
     */
    public function getExampleShortNumber($regionCode)
    {
        $phoneMetadata = $this->getMetadataForRegion($regionCode);
        if ($phoneMetadata === null) {
            return "";
        }

        /** @var PhoneNumberDesc $desc */
        $desc = $phoneMetadata->getShortCode();
        if ($desc !== null && $desc->hasExampleNumber()) {
            return $desc->getExampleNumber();
        }
        return "";
    }

    /**
     * @param $regionCode
     * @return PhoneMetadata|null
     */
    public function getMetadataForRegion($regionCode)
    {
        if (!in_array($regionCode, ShortNumbersRegionCodeSet::$shortNumbersRegionCodeSet)) {
            return null;
        }

        if (!isset($this->regionToMetadataMap[$regionCode])) {
            // The regionCode here will be valid and won't be '001', so we don't need to worry about
            // what to pass in for the country calling code.
            $this->loadMetadataFromFile($this->currentFilePrefix, $regionCode, 0);
        }

        return isset($this->regionToMetadataMap[$regionCode]) ? $this->regionToMetadataMap[$regionCode] : null;
    }

    private function loadMetadataFromFile($filePrefix, $regionCode, $countryCallingCode)
    {
        $isNonGeoRegion = PhoneNumberUtil::REGION_CODE_FOR_NON_GEO_ENTITY === $regionCode;
        $fileName = $filePrefix . '_' . ($isNonGeoRegion ? $countryCallingCode : $regionCode) . '.php';
        if (!is_readable($fileName)) {
            throw new Exception('missing metadata: ' . $fileName);
        } else {
            $data = include $fileName;
            $metadata = new PhoneMetadata();
            $metadata->fromArray($data);
            if ($isNonGeoRegion) {
                $this->countryCodeToNonGeographicalMetadataMap[$countryCallingCode] = $metadata;
            } else {
                $this->regionToMetadataMap[$regionCode] = $metadata;
            }
        }
    }

    /**
     *  Gets a valid short number for the specified cost category.
     *
     * @param string $regionCode the region for which an example short number is needed
     * @param int $cost the cost category of number that is needed
     * @return string a valid short number for the specified region and cost category. Returns an empty string
     * when the metadata does not contain such information, or the cost is UNKNOWN_COST.
     */
    public function getExampleShortNumberForCost($regionCode, $cost)
    {
        $phoneMetadata = $this->getMetadataForRegion($regionCode);
        if ($phoneMetadata === null) {
            return "";
        }

        /** @var PhoneNumberDesc $desc */
        $desc = null;
        switch ($cost) {
            case ShortNumberCost::TOLL_FREE:
                $desc = $phoneMetadata->getTollFree();
                break;
            case ShortNumberCost::STANDARD_RATE:
                $desc = $phoneMetadata->getStandardRate();
                break;
            case ShortNumberCost::PREMIUM_RATE:
                $desc = $phoneMetadata->getPremiumRate();
                break;
            default:
                // UNKNOWN_COST numbers are computed by the process of elimination from the other cost categories
                break;
        }

        if ($desc !== null && $desc->hasExampleNumber()) {
            return $desc->getExampleNumber();
        }

        return "";
    }

    /**
     * Returns true if the number might be used to connect to an emergency service in the given region
     *
     * This method takes into account cases where the number might contain formatting, or might have
     * additional digits appended (when it is okay to do that in the region specified).
     *
     * @param string $number the phone number to test
     * @param string $regionCode the region where the phone number if being dialled
     * @return boolean whether the number might be used to connect to an emergency service in the given region
     */
    public function connectsToEmergencyNumber($number, $regionCode)
    {
        return $this->matchesEmergencyNumberHelper($number, $regionCode, true /* allows prefix match */);
    }

    private function matchesEmergencyNumberHelper($number, $regionCode, $allowPrefixMatch)
    {
        $number = PhoneNumberUtil::extractPossibleNumber($number);
        $matcher = new Matcher(PhoneNumberUtil::$PLUS_CHARS_PATTERN, $number);
        if ($matcher->lookingAt()) {
            // Returns false if the number starts with a plus sign. WE don't believe dialling the country
            // code before emergency numbers (e.g. +1911) works, but later, if that proves to work, we can
            // add additional logic here to handle it.
            return false;
        }

        $metadata = $this->getMetadataForRegion($regionCode);
        if ($metadata === null || !$metadata->hasEmergency()) {
            return false;
        }

        $emergencyNumberPattern = $metadata->getEmergency()->getNationalNumberPattern();
        $normalizedNumber = PhoneNumberUtil::normalizeDigitsOnly($number);

        // In Brazil and Chile, emergency numbers don't work when additional digits are appended

        $emergencyMatcher = new Matcher($emergencyNumberPattern, $normalizedNumber);

        return (!$allowPrefixMatch || $regionCode == "BR" || $regionCode == "CL")
            ? $emergencyMatcher->matches()
            : $emergencyMatcher->lookingAt();
    }

    /**
     * Given a valid short number, determines whether it is carrier-specific (however, nothing is
     * implied about its validity). If it is important that the number is valid, then its validity
     * must first be checked using {@link isValidShortNumber}.
     *
     * @param PhoneNumber $number the valid short number to check
     * @return boolean whether the short number is carrier-specific (assuming the input was a valid short
     *     number).
     */
    public function isCarrierSpecific(PhoneNumber $number)
    {
        $regionCodes = $this->phoneUtil->getRegionCodesForCountryCode($number->getCountryCode());
        $regionCode = $this->getRegionCodeForShortNumberFromRegionList($number, $regionCodes);
        $nationalNumber = $this->phoneUtil->getNationalSignificantNumber($number);
        $phoneMetadata = $this->getMetadataForRegion($regionCode);

        return ($phoneMetadata != null) && ($this->phoneUtil->isNumberMatchingDesc(
            $nationalNumber,
            $phoneMetadata->getCarrierSpecific()
        ));
    }

    /**
     * Helper method to get the region code for a given phone number, from a list of possible region
     * codes. If the list contains more than one region, the first region for which the number is
     * valid is returned.
     *
     * @param PhoneNumber $number
     * @param $regionCodes
     * @return String|null Region Code (or null if none are found)
     */
    private function getRegionCodeForShortNumberFromRegionList(PhoneNumber $number, $regionCodes)
    {
        if (count($regionCodes) == 0) {
            return null;
        } elseif (count($regionCodes) == 1) {
            return $regionCodes[0];
        }

        $nationalNumber = $this->phoneUtil->getNationalSignificantNumber($number);

        foreach ($regionCodes as $regionCode) {
            $phoneMetadata = $this->getMetadataForRegion($regionCode);
            if ($phoneMetadata != null && $this->phoneUtil->isNumberMatchingDesc(
                    $nationalNumber,
                    $phoneMetadata->getShortCode()
                )
            ) {
                // The number is valid for this region.
                return $regionCode;
            }
        }
        return null;
    }

    /**
     * Check whether a short number is a possible number. This provides a more lenient check than
     * {@link #isValidShortNumber}. See {@link #isPossibleShortNumber(String, String)} for
     * details.
     *
     * @param $number PhoneNumber the short number to check
     * @return boolean whether the number is a possible short number
     */
    public function isPossibleShortNumberFromNumber(PhoneNumber $number)
    {
        $regionCodes = $this->phoneUtil->getRegionCodesForCountryCode($number->getCountryCode());
        $shortNumber = $this->phoneUtil->getNationalSignificantNumber($number);

        $regionCode = $this->getRegionCodeForShortNumberFromRegionList($number, $regionCodes);

        if (count($regionCodes) > 1 && $regionCode !== null) {
            // If a matching region had been found for the phone number from among two or more regions,
            // then we have already implicitly verified its validity for that region.
            return true;
        }
        return $this->isPossibleShortNumber($shortNumber, $regionCode);
    }

    /**
     * Check whether a short number is a possible number. This provides a more lenient check than
     * {@link #isValidShortNumber}. See {@link #isPossibleShortNumber(String, String)} for
     * details.
     *
     * @param $shortNumber String The short number to check
     * @param $regionDialingFrom String Region dialing From
     * @return boolean whether the number is a possible short number
     */
    public function isPossibleShortNumber($shortNumber, $regionDialingFrom)
    {
        $phoneMetadata = $this->getMetadataForRegion($regionDialingFrom);

        if ($phoneMetadata === null) {
            return false;
        }

        $generalDesc = $phoneMetadata->getGeneralDesc();

        return $this->phoneUtil->isNumberPossibleForDesc($shortNumber, $generalDesc);
    }

    /**
     * Tests whether a short number matches a valid pattern. Note that this doesn't verify the number
     * is actually in use, which is impossible to tell by just looking at the number itself. See
     * {@link #isValidShortNumber(String, String)} for details.
     *
     * @param $number PhoneNumber the short number for which we want to test the validity
     * @return boolean whether the short number matches a valid pattern
     */
    public function isValidShortNumberFromNumber(PhoneNumber $number)
    {
        $regionCodes = $this->phoneUtil->getRegionCodesForCountryCode($number->getCountryCode());
        $shortNumber = $this->phoneUtil->getNationalSignificantNumber($number);
        $regionCode = $this->getRegionCodeForShortNumberFromRegionList($number, $regionCodes);
        if (count($regionCodes) > 1 && $regionCode !== null) {
            // If a matching region had been found for the phone number from among two or more regions,
            // then we have already implicitly verified its validity for that region.
            return true;
        }

        return $this->isValidShortNumber($shortNumber, $regionCode);
    }

    public function isValidShortNumber($shortNumber, $regionDialingFrom)
    {
        $phoneMetadata = $this->getMetadataForRegion($regionDialingFrom);

        if ($phoneMetadata === null) {
            return false;
        }

        $generalDesc = $phoneMetadata->getGeneralDesc();

        if (!$generalDesc->hasNationalNumberPattern() || !$this->phoneUtil->isNumberMatchingDesc(
                $shortNumber,
                $generalDesc
            )
        ) {
            return false;
        }

        $shortNumberDesc = $phoneMetadata->getShortCode();
        if (!$shortNumberDesc->hasNationalNumberPattern()) {
            // No short code national number pattern found for region
            return false;
        }

        return $this->phoneUtil->isNumberMatchingDesc($shortNumber, $shortNumberDesc);
    }

    /**
     * Gets the expected cost category of a short number (however, nothing is implied about its
     * validity). If it is important that the number is valid, then its validity must first be checked
     * using {@link isValidShortNumber}. Note that emergency numbers are always considered toll-free.
     * Example usage:
     * <pre>{@code
     * PhoneNumberUtil phoneUtil = PhoneNumberUtil.getInstance();
     * ShortNumberInfo shortInfo = ShortNumberInfo.getInstance();
     * PhoneNumber number = phoneUtil.parse("110", "FR");
     * if (shortInfo.isValidShortNumber(number)) {
     *   ShortNumberInfo.ShortNumberCost cost = shortInfo.getExpectedCost(number);
     *   // Do something with the cost information here.
     * }}</pre>
     *
     * @param $number PhoneNumber the short number for which we want to know the expected cost category
     * @return int the expected cost category of the short number. Returns UNKNOWN_COST if the number does
     *     not match a cost category. Note that an invalid number may match any cost category.
     */
    public function getExpectedCost(PhoneNumber $number)
    {
        $regionCodes = $this->phoneUtil->getRegionCodesForCountryCode($number->getCountryCode());
        $regionCode = $this->getRegionCodeForShortNumberFromRegionList($number, $regionCodes);

        // Note that regionCode may be null, in which case phoneMetadata will also be null.
        $phoneMetadata = $this->getMetadataForRegion($regionCode);
        if ($phoneMetadata === null) {
            return ShortNumberCost::UNKNOWN_COST;
        }

        $nationalNumber = $this->phoneUtil->getNationalSignificantNumber($number);

        // The cost categories are tested in order of decreasing expense, since if for some reason the
        // patterns overlap the most expensive matching cost category should be returned.

        if ($this->phoneUtil->isNumberMatchingDesc($nationalNumber, $phoneMetadata->getPremiumRate())) {
            return ShortNumberCost::PREMIUM_RATE;
        }

        if ($this->phoneUtil->isNumberMatchingDesc($nationalNumber, $phoneMetadata->getStandardRate())) {
            return ShortNumberCost::STANDARD_RATE;
        }

        if ($this->phoneUtil->isNumberMatchingDesc($nationalNumber, $phoneMetadata->getTollFree())) {
            return ShortNumberCost::TOLL_FREE;
        }

        if ($this->isEmergencyNumber($nationalNumber, $regionCode)) {
            // Emergency numbers are implicitly toll-free.
            return ShortNumberCost::TOLL_FREE;
        }

        return ShortNumberCost::UNKNOWN_COST;
    }

    /**
     * Returns true if the number exactly matches an emergency service number in the given region.
     *
     * This method takes into account cases where the number might contain formatting, but doesn't
     * allow additional digits to be appended.
     *
     * @param string $number the phone number to test
     * @param string $regionCode the region where the phone number is being dialled
     * @return boolean whether the number exactly matches an emergency services number in the given region
     */
    public function isEmergencyNumber($number, $regionCode)
    {
        return $this->matchesEmergencyNumberHelper($number, $regionCode, false /* doesn't allow prefix match */);
    }


}

/* EOF */ 