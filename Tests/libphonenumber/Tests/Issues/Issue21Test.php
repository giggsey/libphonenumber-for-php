<?php
namespace libphonenumber\Tests\Issues;


use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Issue21Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    public function setUp()
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function testFloatNumber()
    {
        $number = "0358112345678987";
        $phoneNumber = $this->phoneUtil->parse($number, "DE");

        $this->assertTrue($this->phoneUtil->isValidNumber($phoneNumber));

        $this->assertEquals('+49358112345678987', $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::E164));
        $this->assertEquals('+49 3581 12345678987', $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::INTERNATIONAL));
        $this->assertEquals('03581 12345678987', $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::NATIONAL));


        $this->assertEquals('011 49 3581 12345678987', $this->phoneUtil->formatOutOfCountryCallingNumber($phoneNumber, 'US'));
        $this->assertEquals('00 49 3581 12345678987', $this->phoneUtil->formatOutOfCountryCallingNumber($phoneNumber, 'CH'));
    }

    public function testLongerNumber()
    {
        $number = "12345678901234567";
        $phoneNumber = $this->phoneUtil->parse($number, "DE");

        $this->assertEquals('+4912345678901234567', $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::E164));
        $this->assertEquals('+49 12345678901234567', $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::INTERNATIONAL));
        $this->assertEquals('12345678901234567', $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::NATIONAL));


        $this->assertEquals('011 49 12345678901234567', $this->phoneUtil->formatOutOfCountryCallingNumber($phoneNumber, 'US'));
        $this->assertEquals('00 49 12345678901234567', $this->phoneUtil->formatOutOfCountryCallingNumber($phoneNumber, 'CH'));
    }
}
