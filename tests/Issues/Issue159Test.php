<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberToTimeZonesMapper;
use libphonenumber\PhoneNumberUtil;

/**
 * Test that an extra not operator is messing up timezone lookup
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/159
 * @package libphonenumber\Tests\Issues
 */
class Issue159Test extends \PHPUnit_Framework_TestCase
{
    const LOS_ANGELES_TZ = "America/Los_Angeles";

    public function setUp()
    {
        // Reset instance each time
        PhoneNumberUtil::resetInstance();
    }

    public function testLookupTZ_LA()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber(2082924565);

        $timeZoneMapper = PhoneNumberToTimeZonesMapper::getInstance();

        $this->assertEquals(array(self::LOS_ANGELES_TZ), $timeZoneMapper->getTimeZonesForNumber($number));
    }
}
