<?php
/**
 *
 *
 * @author joshuag
 * @created: 04/09/13 09:32
 * @project libphonenumber-for-php
 */

namespace libphonenumber\Tests;

use libphonenumber\CountryCodeToRegionCodeMapForTesting;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;
use libphonenumber\ShortNumberCost;
use libphonenumber\ShortNumberInfo;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/PhoneNumberUtilTest.php';

class ShortNumberInfoTest extends \PHPUnit_Framework_TestCase
{
    private static $plusSymbol;
    /**
     * @var ShortNumberInfo
     */
    private $shortInfo;

    public function setUp()
    {
        self::$plusSymbol = pack('H*', 'efbc8b');

        PhoneNumberUtil::resetInstance();
        $this->shortInfo = ShortNumberInfo::getInstance(
            PhoneNumberUtil::getInstance(
                PhoneNumberUtilTest::TEST_META_DATA_FILE_PREFIX,
                CountryCodeToRegionCodeMapForTesting::$countryCodeToRegionCodeMapForTesting
            )
        );
    }

    public function testIsPossibleShortNumber()
    {
        $possibleNumber = new PhoneNumber();
        $possibleNumber->setCountryCode(33)->setNationalNumber(123456);

        $this->assertTrue($this->shortInfo->isPossibleShortNumberFromNumber($possibleNumber));
        $this->assertTrue($this->shortInfo->isPossibleShortNumber(123456, RegionCode::FR));

        $impossibleNumber = new PhoneNumber();
        $impossibleNumber->setCountryCode(33)->setNationalNumber(9);
        $this->assertFalse($this->shortInfo->isPossibleShortNumberFromNumber($impossibleNumber));
        $this->assertFalse($this->shortInfo->isPossibleShortNumber(9, RegionCode::FR));
    }

    public function testIsValidShortNumber()
    {
        $phoneNumberObj = new PhoneNumber();
        $phoneNumberObj->setCountryCode(33)->setNationalNumber(1010);
        $this->assertTrue($this->shortInfo->isValidShortNumberFromNumber($phoneNumberObj));
        $this->assertTrue($this->shortInfo->isValidShortNumber(1010, RegionCode::FR));

        $phoneNumberObj = new PhoneNumber();
        $phoneNumberObj->setCountryCode(33)->setNationalNumber(123456);
        $this->assertFalse($this->shortInfo->isValidShortNumberFromNumber($phoneNumberObj));
        $this->assertFalse($this->shortInfo->isValidShortNumber(123456, RegionCode::FR));

        // Note that GB and GG share the country calling code 44
        $phoneNumberObj = new PhoneNumber();
        $phoneNumberObj->setCountryCode(44)->setNationalNumber(18001);
        $this->assertTrue($this->shortInfo->isValidShortNumberFromNumber($phoneNumberObj));
    }

    public function testGetExpectedCost()
    {
        $premiumRateNumber = new PhoneNumber();
        $premiumRateNumber->setCountryCode(33)->setNationalNumber(
            $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::PREMIUM_RATE)
        );
        $this->assertEquals(ShortNumberCost::PREMIUM_RATE, $this->shortInfo->getExpectedCost($premiumRateNumber));

        $standardRateNumber = new PhoneNumber();
        $standardRateNumber->setCountryCode(33)->setNationalNumber(
            $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::STANDARD_RATE)
        );
        $this->assertEquals(
            ShortNumberCost::STANDARD_RATE,
            $this->shortInfo->getExpectedCost($standardRateNumber)
        );

        $tollFreeNumber = new PhoneNumber();
        $tollFreeNumber->setCountryCode(33)->setNationalNumber(
            $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::TOLL_FREE)
        );
        $this->assertEquals(ShortNumberCost::TOLL_FREE, $this->shortInfo->getExpectedCost($tollFreeNumber));

        $unknownCostNumber = new PhoneNumber();
        $unknownCostNumber->setCountryCode(33)->setNationalNumber(12345);
        $this->assertEquals(ShortNumberCost::UNKNOWN_COST, $this->shortInfo->getExpectedCost($unknownCostNumber));

        // Test that an invalid number may nevertheless have a cost other than UNKNOWN_COST.
        $invalidNumber = new PhoneNumber();
        $invalidNumber->setCountryCode(33)->setNationalNumber(116123);
        $this->assertFalse($this->shortInfo->isValidShortNumberFromNumber($invalidNumber));
        $this->assertEquals(ShortNumberCost::TOLL_FREE, $this->shortInfo->getExpectedCost($invalidNumber));

        // Test a non-existent country code.
        $unknownCostNumber->clear();
        $unknownCostNumber->setCountryCode(123)->setNationalNumber(911);
        $this->assertEquals(ShortNumberCost::UNKNOWN_COST, $this->shortInfo->getExpectedCost($unknownCostNumber));
    }

    public function testGetExampleShortNumber()
    {
        $this->assertEquals("8711", $this->shortInfo->getExampleShortNumber(RegionCode::AM));
        $this->assertEquals("1010", $this->shortInfo->getExampleShortNumber(RegionCode::FR));
        $this->assertEquals("", $this->shortInfo->getExampleShortNumber(RegionCode::UN001));
        $this->assertEquals("", $this->shortInfo->getExampleShortNumber(null));
    }

    public function testGetExampleShortNumberForCost()
    {
        $this->assertEquals(
            "3010",
            $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::TOLL_FREE)
        );
        $this->assertEquals(
            "118777",
            $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::STANDARD_RATE)
        );
        $this->assertEquals(
            "3200",
            $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::PREMIUM_RATE)
        );
        $this->assertEquals(
            "",
            $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::UNKNOWN_COST)
        );
    }

    public function testConnectsToEmergencyNumber_US()
    {
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber("911", RegionCode::US));
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber("112", RegionCode::US));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("999", RegionCode::US));
    }

    public function testConnectsToEmergencyNumberLongNumber_US()
    {
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber("9116666666", RegionCode::US));
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber("1126666666", RegionCode::US));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("9996666666", RegionCode::US));
    }

    public function testConnectsToEmergencyNumberWithFormatting_US()
    {
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber("9-1-1", RegionCode::US));
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber("1-1-2", RegionCode::US));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("9-9-9", RegionCode::US));
    }

    public function testConnectsToEmergencyNumberWithPlusSign_US()
    {
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("+911", RegionCode::US));
        $this->assertFalse(
            $this->shortInfo->connectsToEmergencyNumber(self::$plusSymbol . "911", RegionCode::US)
        );
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber(" +911", RegionCode::US));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("+112", RegionCode::US));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("+999", RegionCode::US));
    }

    public function testConnectsToEmergencyNumber_BR()
    {
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber("911", RegionCode::BR));
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber("190", RegionCode::BR));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("999", RegionCode::BR));
    }

    public function testConnectsToEmergencyNumberLongNumber_BR()
    {
        // Brazilian emergency numbers don't work when additional digits are appended.
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("9111", RegionCode::BR));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("1900", RegionCode::BR));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("9996", RegionCode::BR));
    }

    public function testConnectsToEmergencyNumber_CL()
    {
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber('131', RegionCode::CL));
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber('133', RegionCode::CL));
    }

    public function testConnectsToEmergencyNumberLongNumber_CL()
    {
        // Chilean emergency numbers don't work when additional digits are appended.
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber('1313', RegionCode::CL));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber('1330', RegionCode::CL));
    }

    public function testConnectsToEmergencyNumber_AO()
    {
        // Angola doesn't have any metadata for emergency numbers in the test metadata.
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("911", RegionCode::AO));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("222123456", RegionCode::BR));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("923123456", RegionCode::BR));
    }

    public function testConnectsToEmergencyNumber_ZW()
    {
        // Zimbabwe doesn't have any metadata in the test metadata.
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("911", RegionCode::ZW));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("01312345", RegionCode::ZW));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber("0711234567", RegionCode::ZW));
    }

    public function testIsEmergencyNumber_US()
    {
        $this->assertTrue($this->shortInfo->isEmergencyNumber("911", RegionCode::US));
        $this->assertTrue($this->shortInfo->isEmergencyNumber("112", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("999", RegionCode::US));
    }

    public function testIsEmergencyNumberLongNumber_US()
    {
        $this->assertFalse($this->shortInfo->isEmergencyNumber("9116666666", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("1126666666", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("9996666666", RegionCode::US));
    }

    public function testIsEmergencyNumberWithFormatting_US()
    {
        $this->assertTrue($this->shortInfo->isEmergencyNumber("9-1-1", RegionCode::US));
        $this->assertTrue($this->shortInfo->isEmergencyNumber("*911", RegionCode::US));
        $this->assertTrue($this->shortInfo->isEmergencyNumber("1-1-2", RegionCode::US));
        $this->assertTrue($this->shortInfo->isEmergencyNumber("*112", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("9-9-9", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("*999", RegionCode::US));
    }

    public function testIsEmergencyNumberWithPlusSign_US()
    {
        $this->assertFalse($this->shortInfo->isEmergencyNumber("+911", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber(self::$plusSymbol . "911", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber(" +911", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("+112", RegionCode::US));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("+999", RegionCode::US));
    }

    public function testIsEmergencyNumber_BR()
    {
        $this->assertTrue($this->shortInfo->isEmergencyNumber("911", RegionCode::BR));
        $this->assertTrue($this->shortInfo->isEmergencyNumber("190", RegionCode::BR));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("999", RegionCode::BR));
    }

    public function testIsEmergencyNumberLongNumber_BR()
    {
        $this->assertFalse($this->shortInfo->isEmergencyNumber("9111", RegionCode::BR));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("1900", RegionCode::BR));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("9996", RegionCode::BR));
    }

    public function testIsEmergencyNumber_AO()
    {
        // Angola doesn't have any metadata for emergency numbers in the test metadata.
        $this->assertFalse($this->shortInfo->isEmergencyNumber("911", RegionCode::AO));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("222123456", RegionCode::AO));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("923123456", RegionCode::AO));
    }

    public function testIsEmergencyNumber_ZW()
    {
        // Zimbabwe doesn't have any metadata in the test metadata.
        $this->assertFalse($this->shortInfo->isEmergencyNumber("911", RegionCode::ZW));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("01312345", RegionCode::ZW));
        $this->assertFalse($this->shortInfo->isEmergencyNumber("0711234567", RegionCode::ZW));
    }
}

/* EOF */ 