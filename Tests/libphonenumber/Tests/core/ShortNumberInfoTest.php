<?php

namespace libphonenumber\Tests\core;

use libphonenumber\CountryCodeToRegionCodeMapForTesting;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;
use libphonenumber\ShortNumberCost;
use libphonenumber\ShortNumberInfo;

class ShortNumberInfoTest extends \PHPUnit_Framework_TestCase
{
    private static $plusSymbol;
    /**
     * @var PhoneNumberUtil
     */
    protected $phoneUtil;
    /**
     * @var ShortNumberInfo
     */
    private $shortInfo;

    public function setUp()
    {
        self::$plusSymbol = pack('H*', 'efbc8b');

        PhoneNumberUtil::resetInstance();
        ShortNumberInfo::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance(
            PhoneNumberUtilTest::TEST_META_DATA_FILE_PREFIX,
            CountryCodeToRegionCodeMapForTesting::$countryCodeToRegionCodeMapForTesting
        );
        $this->shortInfo = ShortNumberInfo::getInstance();
    }

    public function testIsPossibleShortNumber()
    {
        $possibleNumber = new PhoneNumber();
        $possibleNumber->setCountryCode(33)->setNationalNumber(123456);

        $this->assertTrue($this->shortInfo->isPossibleShortNumber($possibleNumber));
        $this->assertTrue($this->shortInfo->isPossibleShortNumberForRegion($this->parse(123456, RegionCode::FR), RegionCode::FR));

        $impossibleNumber = new PhoneNumber();
        $impossibleNumber->setCountryCode(33)->setNationalNumber(9);
        $this->assertFalse($this->shortInfo->isPossibleShortNumber($impossibleNumber));

        // Note that GB and GG share the country calling code 44, and that this number is possible but
        // not valid.
        $gbNumber = new PhoneNumber();
        $gbNumber->setCountryCode(44)->setNationalNumber(11001);
        $this->assertTrue($this->shortInfo->isPossibleShortNumber($gbNumber));
    }

    public function testIsValidShortNumber()
    {
        $phoneNumberObj = new PhoneNumber();
        $phoneNumberObj->setCountryCode(33)->setNationalNumber(1010);
        $this->assertTrue($this->shortInfo->isValidShortNumber($phoneNumberObj));
        $this->assertTrue($this->shortInfo->isValidShortNumberForRegion($this->parse(1010, RegionCode::FR), RegionCode::FR));

        $phoneNumberObj = new PhoneNumber();
        $phoneNumberObj->setCountryCode(33)->setNationalNumber(123456);
        $this->assertFalse($this->shortInfo->isValidShortNumber($phoneNumberObj));
        $this->assertFalse($this->shortInfo->isValidShortNumberForRegion($this->parse(123456, RegionCode::FR), RegionCode::FR));

        // Note that GB and GG share the country calling code 44
        $phoneNumberObj = new PhoneNumber();
        $phoneNumberObj->setCountryCode(44)->setNationalNumber(18001);
        $this->assertTrue($this->shortInfo->isValidShortNumber($phoneNumberObj));
    }

    public function testGetExpectedCost()
    {
        $premiumRateExample = $this->shortInfo->getExampleShortNumberForCost(
            RegionCode::FR,
            ShortNumberCost::PREMIUM_RATE
        );
        $this->assertEquals(
            ShortNumberCost::PREMIUM_RATE,
            $this->shortInfo->getExpectedCostForRegion($this->parse($premiumRateExample, RegionCode::FR), RegionCode::FR)
        );

        $premiumRateNumber = new PhoneNumber();
        $premiumRateNumber->setCountryCode(33)->setNationalNumber($premiumRateExample);
        $this->assertEquals(ShortNumberCost::PREMIUM_RATE, $this->shortInfo->getExpectedCost($premiumRateNumber));

        $standardRateExample = $this->shortInfo->getExampleShortNumberForCost(
            RegionCode::FR,
            ShortNumberCost::STANDARD_RATE
        );
        $this->assertEquals(
            ShortNumberCost::STANDARD_RATE,
            $this->shortInfo->getExpectedCostForRegion($this->parse($standardRateExample, RegionCode::FR), RegionCode::FR)
        );

        $standardRateNumber = new PhoneNumber();
        $standardRateNumber->setCountryCode(33)->setNationalNumber($standardRateExample);
        $this->assertEquals(ShortNumberCost::STANDARD_RATE, $this->shortInfo->getExpectedCost($standardRateNumber));

        $tollFreeExample = $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::TOLL_FREE);
        $this->assertEquals(
            ShortNumberCost::TOLL_FREE,
            $this->shortInfo->getExpectedCostForRegion($this->parse($tollFreeExample, RegionCode::FR), RegionCode::FR)
        );
        $tollFreeNumber = new PhoneNumber();
        $tollFreeNumber->setCountryCode(33)->setNationalNumber($tollFreeExample);
        $this->assertEquals(ShortNumberCost::TOLL_FREE, $this->shortInfo->getExpectedCost($tollFreeNumber));

        $this->assertEquals(
            ShortNumberCost::UNKNOWN_COST,
            $this->shortInfo->getExpectedCostForRegion($this->parse("12345", RegionCode::FR), RegionCode::FR)
        );
        $unknownCostNumber = new PhoneNumber();
        $unknownCostNumber->setCountryCode(33)->setNationalNumber(12345);
        $this->assertEquals(ShortNumberCost::UNKNOWN_COST, $this->shortInfo->getExpectedCost($unknownCostNumber));

        // Test that an invalid number may nevertheless have a cost other than UNKNOWN_COST.
        $this->assertFalse($this->shortInfo->isValidShortNumberForRegion($this->parse("116123", RegionCode::FR), RegionCode::FR));
        $this->assertEquals(
            ShortNumberCost::TOLL_FREE,
            $this->shortInfo->getExpectedCostForRegion($this->parse("116123", RegionCode::FR), RegionCode::FR)
        );
        $invalidNumber = new PhoneNumber();
        $invalidNumber->setCountryCode(33)->setNationalNumber(116123);
        $this->assertFalse($this->shortInfo->isValidShortNumber($invalidNumber));
        $this->assertEquals(ShortNumberCost::TOLL_FREE, $this->shortInfo->getExpectedCost($invalidNumber));

        // Test a nonexistent country code.
        $this->assertEquals(
            ShortNumberCost::UNKNOWN_COST,
            $this->shortInfo->getExpectedCostForRegion($this->parse("911", RegionCode::US), RegionCode::ZZ)
        );
        $unknownCostNumber->clear();
        $unknownCostNumber->setCountryCode(123)->setNationalNumber(911);
        $this->assertEquals(ShortNumberCost::UNKNOWN_COST, $this->shortInfo->getExpectedCost($unknownCostNumber));
    }

    public function testGetExpectedCostForSharedCountryCallingCode()
    {
        // Test some numbers which have different costs in countries sharing the same country calling
        // code. In Australia, 1234 is premium-rate, 1194 is standard-rate, and 733 is toll-free. These
        // are not known to be valid numbers in the Christmas Islands.
        $ambiguousPremiumRateString = "1234";
        $ambiguousPremiumRateNumber = new PhoneNumber();
        $ambiguousPremiumRateNumber->setCountryCode(61)->setNationalNumber(1234);
        $ambiguousStandardRateString = "1194";
        $ambiguousStandardRateNumber = new PhoneNumber();
        $ambiguousStandardRateNumber->setCountryCode(61)->setNationalNumber(1194);
        $ambiguousTollFreeString = "733";
        $ambiguousTollFreeNumber = new PhoneNumber();
        $ambiguousTollFreeNumber->setCountryCode(61)->setNationalNumber(733);

        $this->assertTrue($this->shortInfo->isValidShortNumber($ambiguousPremiumRateNumber));
        $this->assertTrue($this->shortInfo->isValidShortNumber($ambiguousStandardRateNumber));
        $this->assertTrue($this->shortInfo->isValidShortNumber($ambiguousTollFreeNumber));

        $this->assertTrue($this->shortInfo->isValidShortNumberForRegion($this->parse($ambiguousPremiumRateString, RegionCode::AU), RegionCode::AU));
        $this->assertEquals(
            ShortNumberCost::PREMIUM_RATE,
            $this->shortInfo->getExpectedCostForRegion($this->parse($ambiguousPremiumRateString, RegionCode::AU), RegionCode::AU)
        );
        $this->assertFalse($this->shortInfo->isValidShortNumberForRegion($this->parse($ambiguousPremiumRateString, RegionCode::CX), RegionCode::CX));
        $this->assertEquals(
            ShortNumberCost::UNKNOWN_COST,
            $this->shortInfo->getExpectedCostForRegion($this->parse($ambiguousPremiumRateString, RegionCode::CX), RegionCode::CX)
        );
        // PREMIUM_RATE takes precedence over UNKNOWN_COST.
        $this->assertEquals(
            ShortNumberCost::PREMIUM_RATE,
            $this->shortInfo->getExpectedCost($ambiguousPremiumRateNumber)
        );

        $this->assertTrue($this->shortInfo->isValidShortNumberForRegion($this->parse($ambiguousStandardRateString, RegionCode::AU), RegionCode::AU));
        $this->assertEquals(
            ShortNumberCost::STANDARD_RATE,
            $this->shortInfo->getExpectedCostForRegion($this->parse($ambiguousStandardRateString, RegionCode::AU), RegionCode::AU)
        );
        $this->assertFalse($this->shortInfo->isValidShortNumberForRegion($this->parse($ambiguousStandardRateString, RegionCode::CX), RegionCode::CX));
        $this->assertEquals(
            ShortNumberCost::UNKNOWN_COST,
            $this->shortInfo->getExpectedCostForRegion($this->parse($ambiguousStandardRateString, RegionCode::CX), RegionCode::CX)
        );
        $this->assertEquals(
            ShortNumberCost::UNKNOWN_COST,
            $this->shortInfo->getExpectedCost($ambiguousStandardRateNumber)
        );

        $this->assertTrue($this->shortInfo->isValidShortNumberForRegion($this->parse($ambiguousTollFreeString, RegionCode::AU), RegionCode::AU));
        $this->assertEquals(
            ShortNumberCost::TOLL_FREE,
            $this->shortInfo->getExpectedCostForRegion($this->parse($ambiguousTollFreeString, RegionCode::AU), RegionCode::AU)
        );
        $this->assertFalse($this->shortInfo->isValidShortNumberForRegion($this->parse($ambiguousTollFreeString, RegionCode::CX), RegionCode::CX));
        $this->assertEquals(
            ShortNumberCost::UNKNOWN_COST,
            $this->shortInfo->getExpectedCostForRegion($this->parse($ambiguousTollFreeString, RegionCode::CX), RegionCode::CX)
        );
        $this->assertEquals(ShortNumberCost::UNKNOWN_COST, $this->shortInfo->getExpectedCost($ambiguousTollFreeNumber));
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
            "1023",
            $this->shortInfo->getExampleShortNumberForCost(RegionCode::FR, ShortNumberCost::STANDARD_RATE)
        );
        $this->assertEquals(
            "42000",
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


    public function testEmergencyNumberForSharedCountryCallingCode()
    {
        // Test the emergency number 112, which is valid in both Australia and the Christmas Islands.
        $this->assertTrue($this->shortInfo->isEmergencyNumber("112", RegionCode::AU));
        $this->assertTrue($this->shortInfo->isValidShortNumberForRegion($this->parse("112", RegionCode::AU), RegionCode::AU));
        $this->assertEquals(
            ShortNumberCost::TOLL_FREE,
            $this->shortInfo->getExpectedCostForRegion($this->parse("112", RegionCode::AU), RegionCode::AU)
        );
        $this->assertTrue($this->shortInfo->isEmergencyNumber("112", RegionCode::CX));
        $this->assertTrue($this->shortInfo->isValidShortNumberForRegion($this->parse("112", RegionCode::CX), RegionCode::CX));
        $this->assertEquals(
            ShortNumberCost::TOLL_FREE,
            $this->shortInfo->getExpectedCostForRegion($this->parse("112", RegionCode::CX), RegionCode::CX)
        );
        $sharedEmergencyNumber = new PhoneNumber();
        $sharedEmergencyNumber->setCountryCode(61)->setNationalNumber(112);
        $this->assertTrue($this->shortInfo->isValidShortNumber($sharedEmergencyNumber));
        $this->assertEquals(ShortNumberCost::TOLL_FREE, $this->shortInfo->getExpectedCost($sharedEmergencyNumber));
    }

    public function testOverlappingNANPANumber()
    {
        // 211 is an emergency number in Barbados, while it is a toll-free information line in Canada
        // and the USA.
        $this->assertTrue($this->shortInfo->isEmergencyNumber("211", RegionCode::BB));
        $this->assertEquals(
            ShortNumberCost::TOLL_FREE,
            $this->shortInfo->getExpectedCostForRegion($this->parse("211", RegionCode::BB), RegionCode::BB)
        );
        $this->assertFalse($this->shortInfo->isEmergencyNumber("211", RegionCode::US));
        $this->assertEquals(
            ShortNumberCost::UNKNOWN_COST,
            $this->shortInfo->getExpectedCostForRegion($this->parse("211", RegionCode::US), RegionCode::US)
        );
        $this->assertFalse($this->shortInfo->isEmergencyNumber("211", RegionCode::CA));
        $this->assertEquals(
            ShortNumberCost::UNKNOWN_COST,
            $this->shortInfo->getExpectedCostForRegion($this->parse("211", RegionCode::CA), RegionCode::CA)
        );
    }

    /**
     * @param string $number
     * @param string $regionCode
     * @return PhoneNumber
     */
    private function parse($number, $regionCode)
    {
        try {
            return $this->phoneUtil->parse($number, $regionCode);
        } catch (NumberParseException $e) {
            $this->fail("Test input data should always parse correctly: " . $number . " (" . $regionCode . ")");
        }
    }
}
