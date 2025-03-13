<?php

declare(strict_types=1);

namespace libphonenumber\Tests\timezone;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberToTimeZonesMapper;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class UKTest extends TestCase
{
    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
    }

    public function testGBNumber(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(44)->setNationalNumber('1614960000');

        $timeZone = PhoneNumberToTimeZonesMapper::getInstance();
        self::assertSame(['Europe/London'], $timeZone->getTimeZonesForNumber($number));
    }

    public function testNonGeocodableNumber(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(44)->setNationalNumber('8001111');

        $timeZone = PhoneNumberToTimeZonesMapper::getInstance();
        self::assertSame(
            [
                'Europe/Guernsey',
                'Europe/Isle_of_Man',
                'Europe/Jersey',
                'Europe/London',
            ],
            $timeZone->getTimeZonesForNumber($number)
        );
    }
}
