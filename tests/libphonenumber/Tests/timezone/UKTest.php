<?php

namespace libphonenumber\Tests\timezone;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberToTimeZonesMapper;
use libphonenumber\PhoneNumberUtil;

class UKTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        PhoneNumberUtil::resetInstance();
    }

    public function testGBNumber()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(44)->setNationalNumber(1614960000);

        $timeZone = PhoneNumberToTimeZonesMapper::getInstance();
        $this->assertEquals(array("Europe/London"), $timeZone->getTimeZonesForNumber($number));
    }

    public function testNonGeocodableNumber()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(44)->setNationalNumber(8001111);

        $timeZone = PhoneNumberToTimeZonesMapper::getInstance();
        $this->assertEquals(array("Europe/London"), $timeZone->getTimeZonesForNumber($number));
    }
}
