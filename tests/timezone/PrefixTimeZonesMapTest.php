<?php

declare(strict_types=1);

namespace libphonenumber\Tests\timezone;

use libphonenumber\PhoneNumber;
use libphonenumber\prefixmapper\PrefixTimeZonesMap;
use PHPUnit\Framework\TestCase;

class PrefixTimeZonesMapTest extends TestCase
{
    // US time zones
    public const CHICAGO_TZ = 'America/Chicago';
    public const DENVER_TZ = 'America/Denver';
    public const LOS_ANGELES_TZ = 'America/Los_Angeles';
    public const NEW_YORK_TZ = 'America/New_York';

    // Russian time zones
    public const IRKUTSK_TZ = 'Asia/Irkutsk';
    public const MOSCOW_TZ = 'Europe/Moscow';
    public const VLADIVOSTOK_TZ = 'Asia/Vladivostok';
    public const YEKATERINBURG_TZ = 'Asia/Yekaterinburg';
    private static PrefixTimeZonesMap $prefixTimeZonesMapForUS;
    private static PrefixTimeZonesMap $prefixTimeZonesMapForRU;

    public static function setUpBeforeClass(): void
    {
        $sortedMapForUS = [];
        $sortedMapForUS[1] = self::NEW_YORK_TZ . '&' . self::CHICAGO_TZ . '&' . self::LOS_ANGELES_TZ . '&' . self::DENVER_TZ;
        $sortedMapForUS[1201] = self::NEW_YORK_TZ;
        $sortedMapForUS[1205] = self::CHICAGO_TZ;
        $sortedMapForUS[1208292] = self::LOS_ANGELES_TZ;
        $sortedMapForUS[1208234] = self::DENVER_TZ;
        $sortedMapForUS[1541367] = self::LOS_ANGELES_TZ;
        $sortedMapForUS[1423843] = self::NEW_YORK_TZ;
        $sortedMapForUS[1402721] = self::CHICAGO_TZ;
        $sortedMapForUS[1208888] = self::DENVER_TZ;

        self::$prefixTimeZonesMapForUS = new PrefixTimeZonesMap($sortedMapForUS);

        $sortedMapForRU = [];
        $sortedMapForRU[7421] = self::VLADIVOSTOK_TZ;
        $sortedMapForRU[7879] = self::MOSCOW_TZ;
        $sortedMapForRU[7342] = self::YEKATERINBURG_TZ;
        $sortedMapForRU[7395] = self::IRKUTSK_TZ;

        self::$prefixTimeZonesMapForRU = new PrefixTimeZonesMap($sortedMapForRU);
    }

    public function testLookupTimeZonesForNumberCountryLevel_US(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber('1000000000');

        self::assertSame(
            [
                self::NEW_YORK_TZ,
                self::CHICAGO_TZ,
                self::LOS_ANGELES_TZ,
                self::DENVER_TZ,
            ],
            self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number)
        );
    }

    public function testLookupTimeZonesForNumber_ValidNumber_Chicago(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber('2051235458');

        self::assertSame([self::CHICAGO_TZ], self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number));
    }

    public function testLookupTimeZonesForNumber_LA(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber('2082924565');

        self::assertSame([self::LOS_ANGELES_TZ], self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number));
    }

    public function testLookupTimeZonesForNumber_NY(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber('2016641234');

        self::assertSame([self::NEW_YORK_TZ], self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number));
    }

    public function testLookupTimeZonesForNumber_CH(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(41)->setNationalNumber('446681300');

        self::assertSame([], self::$prefixTimeZonesMapForUS->lookupTimeZonesForNumber($number));
    }

    public function testLookupTimeZonesForNumber_RU(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(7)->setNationalNumber('87945154');

        self::assertSame([self::MOSCOW_TZ], self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));

        $number->setNationalNumber('421548578');
        self::assertSame([self::VLADIVOSTOK_TZ], self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));

        $number->setNationalNumber('342457897');
        self::assertSame([self::YEKATERINBURG_TZ], self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));

        // A mobile number
        $number->setNationalNumber('9342457897');
        self::assertSame([], self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));

        // An invalid number (too short)
        $number->setNationalNumber('3951');
        self::assertSame([self::IRKUTSK_TZ], self::$prefixTimeZonesMapForRU->lookupTimeZonesForNumber($number));
    }
}
