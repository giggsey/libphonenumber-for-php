<?php
/**
 * Utility for international short phone numbers, such as short codes and emergency numbers.
 * Note most commercial short numbers are not handled here, but by the PhoneNumberUtil
 *
 * @author Shaopeng Jia
 * @author David Yonge-Mallo
 * @deprecated As of release 5.8, replaced by ShortNumberInfo.
 */

namespace libphonenumber;

/**
 * Class ShortNumberUtil
 * @package libphonenumber
 * @deprecated As of release 5.8, replaced by ShortNumberInfo.
 */
class ShortNumberUtil
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    public function __construct(PhoneNumberUtil $phoneNumberUtil = null)
    {
        $this->phoneUtil = $phoneNumberUtil;
    }

    public function getSupportedRegions()
    {
        return ShortNumberInfo::getInstance($this->phoneUtil)->getSupportedRegions();
    }

    /**
     * Returns true if the number might be used to connect to an emergency service in the given
     * region.
     *
     * This method takes into account cases where the number might contain formatting, or might have
     * additional digits appended (when it is okay to do that in the region specified).
     *
     * @param $number String the phone number to test
     * @param $regionCode String the region where the phone number is being dialed
     * @return boolean if the number might be used to connect to an emergency service in the given region.
     */
    public function connectsToEmergencyNumber($number, $regionCode)
    {
        return ShortNumberInfo::getInstance($this->phoneUtil)->connectsToEmergencyNumber($number, $regionCode);
    }

    /**
     * Returns true if the number exactly matches an emergency service number in the given region.
     *
     * This method takes into account cases where the number might contain formatting, but doesn't
     * allow additional digits to be appended.
     *
     * @param $number String The phone number to test
     * @param $regionCode String The region where the phone number is being dialed
     * @return boolean if the number exactly matches an emergency services number in the given region.
     */
    public function isEmergencyNumber($number, $regionCode)
    {
        return ShortNumberInfo::getInstance($this->phoneUtil)->isEmergencyNumber($number, $regionCode);
    }
}
