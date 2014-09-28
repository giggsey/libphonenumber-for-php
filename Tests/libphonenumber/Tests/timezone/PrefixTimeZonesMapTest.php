<?php

namespace libphonenumber\Tests\timezone;


use libphonenumber\PhoneNumber;
use libphonenumber\prefixmapper\PrefixTimeZonesMap;

class PrefixTimeZonesMapTest extends \PHPUnit_Framework_TestCase
{
    // US time zones
    const CHICAGO_TZ = "America/Chicago";
    const DENVER_TZ = "America/Denver";
    const LOS_ANGELES_TZ = "America/Los_Angeles";
    const NEW_YORK_TZ = "America/New_York";

    // Russian time zones
    const IRKUTSK_TZ = "Asia/Irkutsk";
    const MOSCOW_TZ = "Europe/Moscow";
    const VLADIVOSTOK_TZ = "Asia/Vladivostok";
    const YEKATERINBURG_TZ = "Asia/Yekaterinburg";
    /**
     * @var PrefixTimeZonesMap
     */
    private static $prefixTimeZonesMapForUS;
    /**
     * @var PrefixTimeZonesMap
     */
    private static $prefixTimeZonesMapForRU;

    public static function setUpBeforeClass()
    {
        $sortedMapForUS = array();
        $sortedMapForUS[1] = self::NEW_YORK_TZ . "&" . self::CHICAGO_TZ . "&" . self::LOS_ANGELES_TZ . "&" . self::DENVER_TZ;
        $sortedMapForUS[1201] = self::NEW_YORK_TZ;
        $sortedMapForUS[1205] = self::CHICAGO_TZ;
        $sortedMapForUS[1208292] = self::LOS_ANGELES_TZ;
        $sortedMapForUS[1208234] = self::DENVER_TZ;
        $sortedMapForUS[1541367] = self::LOS_ANGELES_TZ;
        $sortedMapForUS[1423843] = self::NEW_YORK_TZ;
        $sortedMapForUS[1402721] = self::CHICAGO_TZ;
        $sortedMapForUS[1208888] = self::DENVER_TZ;

        self::$prefixTimeZonesMapForUS = new PrefixTimeZonesMap($sortedMapForUS);

        $sortedMapForRU = array();
        $sortedMapForRU[7421] = self::VLADIVOSTOK_TZ;
        $sortedMapForRU[7879] = self::MOSCOW_TZ;
        $sortedMapForRU[7342] = self::YEKATERINBURG_TZ;
        $sortedMapForRU[7395] = self::IRKUTSK_TZ;

        self::$prefixTimeZonesMapForRU = new PrefixTimeZonesMap($sortedMapForRU);
    }

    public function testLookupTimeZonesForNumberCountryLevel_US()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber(1000000000);

        $this->assertEquals(
            array(
                self::NEW_YORK_TZ,
                self::CHICAGO_TZ,
                self::LOS_ANGELES_TZ,
                self::DENVER_TZ,
            ),
            self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number)
        );
    }

    public function testLookupTimeZonesForNumber_ValidNumber_Chicago()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber(2051235458);

        $this->assertEquals(array(self::CHICAGO_TZ), self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number));
    }

    public function testLookupTimeZonesForNumber_LA()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber(2082924565);

        $this->assertEquals(array(self::LOS_ANGELES_TZ), self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number));
    }

    public function testLookupTimeZonesForNumber_NY()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber(2016641234);

        $this->assertEquals(array(self::NEW_YORK_TZ), self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number));
    }

    public function testLookupTimeZonesForNumber_CH()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(41)->setNationalNumber(446681300);

        $this->assertEquals(array(), self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number));
    }

    public function testLookupTimeZonesForNumber_RU()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(7)->setNationalNumber(87945154);

        $this->assertEquals(array(self::MOSCOW_TZ), self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));

        $number->setNationalNumber(421548578);
        $this->assertEquals(array(self::VLADIVOSTOK_TZ), self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));

        $number->setNationalNumber(342457897);
        $this->assertEquals(array(self::YEKATERINBURG_TZ), self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));

        // A mobile number
        $number->setNationalNumber(9342457897);
        $this->assertEquals(array(), self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));

        // An invalid number (too short)
        $number->setNationalNumber(3951);
        $this->assertEquals(array(self::IRKUTSK_TZ), self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));
    }
}
