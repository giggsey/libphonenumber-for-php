<?php

namespace libphonenumber\Tests\core;

use libphonenumber\CountryCodeToRegionCodeMapForTesting;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;
use libphonenumber\ShortNumberUtil;

class ShortNumberUtilTest extends \PHPUnit_Framework_TestCase
{
    private static $plusSymbol;
    /**
     * @var ShortNumberUtil
     */
    private $shortUtil;

    public function setUp()
    {
        self::$plusSymbol = pack('H*', 'efbc8b');

        PhoneNumberUtil::resetInstance();
        $this->shortUtil = new ShortNumberUtil(
            PhoneNumberUtil::getInstance(
                PhoneNumberUtilTest::TEST_META_DATA_FILE_PREFIX,
                CountryCodeToRegionCodeMapForTesting::$countryCodeToRegionCodeMapForTesting
            )
        );
    }

    public function testConnectsToEmergencyNumber_US()
    {
        $this->assertTrue($this->shortUtil->connectsToEmergencyNumber("911", RegionCode::US));
        $this->assertTrue($this->shortUtil->connectsToEmergencyNumber("112", RegionCode::US));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("999", RegionCode::US));
    }

    public function testConnectsToEmergencyNumberLongNumber_US()
    {
        $this->assertTrue($this->shortUtil->connectsToEmergencyNumber("9116666666", RegionCode::US));
        $this->assertTrue($this->shortUtil->connectsToEmergencyNumber("1126666666", RegionCode::US));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("9996666666", RegionCode::US));
    }

    public function testConnectsToEmergencyNumberWithFormatting_US()
    {
        $this->assertTrue($this->shortUtil->connectsToEmergencyNumber("9-1-1", RegionCode::US));
        $this->assertTrue($this->shortUtil->connectsToEmergencyNumber("1-1-2", RegionCode::US));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("9-9-9", RegionCode::US));
    }

    public function testConnectsToEmergencyNumberWithPlusSign_US()
    {
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("+911", RegionCode::US));
        $this->assertFalse(
            $this->shortUtil->connectsToEmergencyNumber(self::$plusSymbol . "911", RegionCode::US)
        );
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber(" +911", RegionCode::US));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("+112", RegionCode::US));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("+999", RegionCode::US));
    }

    public function testConnectsToEmergencyNumber_BR()
    {
        $this->assertTrue($this->shortUtil->connectsToEmergencyNumber("911", RegionCode::BR));
        $this->assertTrue($this->shortUtil->connectsToEmergencyNumber("190", RegionCode::BR));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("999", RegionCode::BR));
    }

    public function testConnectsToEmergencyNumberLongNumber_BR()
    {
        // Brazilian emergency numbers don't work when additional digits are appended.
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("9111", RegionCode::BR));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("1900", RegionCode::BR));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("9996", RegionCode::BR));
    }

    public function testConnectsToEmergencyNumber_AO()
    {
        // Angola doesn't have any metadata for emergency numbers in the test metadata.
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("911", RegionCode::AO));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("222123456", RegionCode::BR));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("923123456", RegionCode::BR));
    }

    public function testConnectsToEmergencyNumber_ZW()
    {
        // Zimbabwe doesn't have any metadata in the test metadata.
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("911", RegionCode::ZW));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("01312345", RegionCode::ZW));
        $this->assertFalse($this->shortUtil->connectsToEmergencyNumber("0711234567", RegionCode::ZW));
    }

    public function testIsEmergencyNumber_US()
    {
        $this->assertTrue($this->shortUtil->isEmergencyNumber("911", RegionCode::US));
        $this->assertTrue($this->shortUtil->isEmergencyNumber("112", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("999", RegionCode::US));
    }

    public function testIsEmergencyNumberLongNumber_US()
    {
        $this->assertFalse($this->shortUtil->isEmergencyNumber("9116666666", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("1126666666", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("9996666666", RegionCode::US));
    }

    public function testIsEmergencyNumberWithFormatting_US()
    {
        $this->assertTrue($this->shortUtil->isEmergencyNumber("9-1-1", RegionCode::US));
        $this->assertTrue($this->shortUtil->isEmergencyNumber("*911", RegionCode::US));
        $this->assertTrue($this->shortUtil->isEmergencyNumber("1-1-2", RegionCode::US));
        $this->assertTrue($this->shortUtil->isEmergencyNumber("*112", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("9-9-9", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("*999", RegionCode::US));
    }

    public function testIsEmergencyNumberWithPlusSign_US()
    {
        $this->assertFalse($this->shortUtil->isEmergencyNumber("+911", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber(self::$plusSymbol . "911", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber(" +911", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("+112", RegionCode::US));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("+999", RegionCode::US));
    }

    public function testIsEmergencyNumber_BR()
    {
        $this->assertTrue($this->shortUtil->isEmergencyNumber("911", RegionCode::BR));
        $this->assertTrue($this->shortUtil->isEmergencyNumber("190", RegionCode::BR));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("999", RegionCode::BR));
    }

    public function testIsEmergencyNumberLongNumber_BR()
    {
        $this->assertFalse($this->shortUtil->isEmergencyNumber("9111", RegionCode::BR));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("1900", RegionCode::BR));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("9996", RegionCode::BR));
    }

    public function testIsEmergencyNumber_AO()
    {
        // Angola doesn't have any metadata for emergency numbers in the test metadata.
        $this->assertFalse($this->shortUtil->isEmergencyNumber("911", RegionCode::AO));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("222123456", RegionCode::AO));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("923123456", RegionCode::AO));
    }

    public function testIsEmergencyNumber_ZW()
    {
        // Zimbabwe doesn't have any metadata in the test metadata.
        $this->assertFalse($this->shortUtil->isEmergencyNumber("911", RegionCode::ZW));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("01312345", RegionCode::ZW));
        $this->assertFalse($this->shortUtil->isEmergencyNumber("0711234567", RegionCode::ZW));
    }

}
