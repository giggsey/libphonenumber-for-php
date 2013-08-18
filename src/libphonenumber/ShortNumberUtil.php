<?php
/**
 * Utility for international short phone numbers, such as short codes and emergency numbers.
 * Note most commercial short numbers are not handled here, but by the PhoneNumberUtil
 *
 * @author Shaopeng Jia
 * @author David Yonge-Mallo
 */

namespace libphonenumber;


class ShortNumberUtil
{
    const META_DATA_FILE_PREFIX = 'ShortNumberMetadata';
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;
    private $currentFilePrefix;
    private $regionToMetadataMap = array();
    private $countryCodeToNonGeographicalMetadataMap = array();

    public function __construct(PhoneNumberUtil $phoneNumberUtil = null)
    {
        if ($phoneNumberUtil === null) {
            $this->phoneUtil = PhoneNumberUtil::getInstance();
        } else {
            $this->phoneUtil = $phoneNumberUtil;
        }
        $this->currentFilePrefix = dirname(__FILE__) . '/data/' . self::META_DATA_FILE_PREFIX;

        //
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
        $desc = $this->getShortNumberDescByCost($phoneMetadata, $cost);
        if ($desc !== null && $desc->hasExampleNumber()) {
            return $desc->getExampleNumber();
        }

        return "";
    }

    private function getShortNumberDescByCost($metadata, $cost)
    {
        switch ($cost) {
            case ShortNumberCost::TOLL_FREE:
                return $metadata->getTollFree();
                break;
            case ShortNumberCost::STANDARD_RATE:
                return $metadata->getStandardRate();
                break;
            case ShortNumberCost::PREMIUM_RATE:
                return $metadata->getPremiumRate();
                break;
            default:
                // UNKNOWN_COST numbers are computed by the process of elimination from the other cost categories
                return null;
                break;
        }
    }

    /**
     * Returns true if the number might be used to connect to an emergency service in the given region
     *
     * This method takes into account cases where the number might contain formatting, or might have
     * additional digits appended (when it is okay to do that in the region specified).
     *
     * @param string $number the phone number to test
     * @param string $regionCode the region where the phone number if being dialled
     * @return boolean if the number might be used to connect to an emergency service in the given region
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

        $metadata = $this->phoneUtil->getMetadataForRegion($regionCode);
        if ($metadata === null || !$metadata->hasEmergency()) {
            return false;
        }

        $emergencyNumberPattern = $metadata->getEmergency()->getNationalNumberPattern();
        $normalizedNumber = PhoneNumberUtil::normalizeDigitsOnly($number);

        // In Brazil, emergency numbers don't work when additional digits are appended

        $emergencyMatcher = new Matcher($emergencyNumberPattern, $normalizedNumber);

        return (!$allowPrefixMatch || $regionCode == "BR")
            ? $emergencyMatcher->matches()
            : $emergencyMatcher->lookingAt();
    }

    /**
     * Returns true if the number exactly matches an emergency service number in the given region.
     *
     * This method takes into account cases where the number might contain formatting, but doesn't
     * allow additional digits to be appended.
     *
     * @param string $number the phone number to test
     * @param string $regionCode the region where the phone number is being dialled
     * @return boolean if the number exactly matches an emergency services number in the given region
     */
    public function isEmergencyNumber($number, $regionCode)
    {
        return $this->matchesEmergencyNumberHelper($number, $regionCode, false /* doesn't allow prefix match */);
    }

    private function getMetadataForRegion($regionCode)
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
}

/* EOF */