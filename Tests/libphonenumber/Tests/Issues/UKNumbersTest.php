<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\CountryCodeToRegionCodeMap;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;


class UKNumbersTest extends \PHPUnit_Framework_TestCase
{
    const META_DATA_FILE_PREFIX = 'PhoneNumberMetadata';
    /**
     * @var \libphonenumber\PhoneNumberUtil
     */
    protected $phoneUtil;

    public function __construct()
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance(
            self::META_DATA_FILE_PREFIX,
            CountryCodeToRegionCodeMap::$countryCodeToRegionCodeMap
        );;
    }

    public function testMobileNumber()
    {
        $number = '07987458147';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertTrue($valid, "Checking phone number is valid");

        $type = $this->phoneUtil->getNumberType($phoneObject);
        $this->assertEquals(PhoneNumberType::MOBILE, $type, "Checking phone number is detected as mobile");

        $formattedE164 = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::E164);
        $this->assertEquals("+447987458147", $formattedE164, "Checking E164 format is correct");

        $formattedNational = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::NATIONAL);
        $this->assertEquals("07987 458147", $formattedNational, "Checking National format is correct");
    }

    public function testFixedLine()
    {
        $number = '01234512345';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertTrue($valid, "Checking phone number is valid");

        $type = $this->phoneUtil->getNumberType($phoneObject);
        $this->assertEquals(PhoneNumberType::FIXED_LINE, $type, "Checking phone number is detected as fixed line");

        $formattedE164 = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::E164);
        $this->assertEquals("+441234512345", $formattedE164, "Checking E164 format is correct");

        $formattedNational = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::NATIONAL);
        $this->assertEquals("01234 512345", $formattedNational, "Checking National format is correct");
    }

    public function testSharedCost()
    {
        $number = '08451234568';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertTrue($valid, "Checking phone number is valid");

        $type = $this->phoneUtil->getNumberType($phoneObject);
        $this->assertEquals(PhoneNumberType::SHARED_COST, $type, "Checking phone number is detected as shared cost");

        $formattedE164 = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::E164);
        $this->assertEquals("+448451234568", $formattedE164, "Checking E164 format is correct");

        $formattedNational = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::NATIONAL);
        $this->assertEquals("0845 123 4568", $formattedNational, "Checking National format is correct");
    }

    public function testPersonalNumber()
    {
        $number = '07010020249';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertTrue($valid, "Checking phone number is valid");

        $type = $this->phoneUtil->getNumberType($phoneObject);
        $this->assertEquals(
            PhoneNumberType::PERSONAL_NUMBER,
            $type,
            "Checking phone number is detected as a personal number"
        );

        $formattedE164 = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::E164);
        $this->assertEquals("+447010020249", $formattedE164, "Checking E164 format is correct");

        $formattedNational = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::NATIONAL);
        $this->assertEquals("070 1002 0249", $formattedNational, "Checking National format is correct");
    }

    public function testUAN()
    {
        $number = '03335555555';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertTrue($valid, "Checking phone number is valid");

        $type = $this->phoneUtil->getNumberType($phoneObject);
        $this->assertEquals(PhoneNumberType::UAN, $type, "Checking phone number is detected as UAN");

        $formattedE164 = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::E164);
        $this->assertEquals("+443335555555", $formattedE164, "Checking E164 format is correct");

        $formattedNational = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::NATIONAL);
        $this->assertEquals("0333 555 5555", $formattedNational, "Checking National format is correct");
    }

    public function testTollFree()
    {
        $number = '0800800150';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertTrue($valid, "Checking phone number is valid");

        $type = $this->phoneUtil->getNumberType($phoneObject);
        $this->assertEquals(PhoneNumberType::TOLL_FREE, $type, "Checking phone number is detected as TOLL FREE");

        $formattedE164 = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::E164);
        $this->assertEquals("+44800800150", $formattedE164, "Checking E164 format is correct");

        $formattedNational = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::NATIONAL);
        $this->assertEquals("0800 800150", $formattedNational, "Checking National format is correct");
    }

    public function testPremium()
    {
        $number = '09063020288';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertTrue($valid, "Checking phone number is valid");

        $type = $this->phoneUtil->getNumberType($phoneObject);
        $this->assertEquals(PhoneNumberType::PREMIUM_RATE, $type, "Checking phone number is detected as PREMIUM RATE");

        $formattedE164 = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::E164);
        $this->assertEquals("+449063020288", $formattedE164, "Checking E164 format is correct");

        $formattedNational = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::NATIONAL);
        $this->assertEquals("0906 302 0288", $formattedNational, "Checking National format is correct");
    }

    public function testChildLine()
    {
        $number = '08001111';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertTrue($valid, "Checking phone number is valid");

        $type = $this->phoneUtil->getNumberType($phoneObject);
        $this->assertEquals(
            PhoneNumberType::TOLL_FREE,
            $type,
            "Checking phone number is detected as TOLL FREE"
        );

        $formattedE164 = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::E164);
        $this->assertEquals("+448001111", $formattedE164, "Checking E164 format is correct");

        $formattedNational = $this->phoneUtil->format($phoneObject, PhoneNumberFormat::NATIONAL);
        $this->assertEquals("0800 1111", $formattedNational, "Checking National format is correct");
    }

    public function testInvalidNumber()
    {
        $number = '123401234512345';
        $phoneObject = $this->phoneUtil->parse($number, 'GB');

        $valid = $this->phoneUtil->isValidNumber($phoneObject);
        $this->assertFalse($valid, "Checking phone number is invalid");
    }
}
