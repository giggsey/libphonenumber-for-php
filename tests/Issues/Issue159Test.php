<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberToTimeZonesMapper;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

/**
 * Test that an extra not operator is messing up timezone lookup
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/159
 * @package libphonenumber\Tests\Issues
 */
class Issue159Test extends TestCase
{
    public const LOS_ANGELES_TZ = 'America/Los_Angeles';

    public function setUp(): void
    {
        // Reset instance each time
        PhoneNumberUtil::resetInstance();
    }

    public function testLookupTZ_LA(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber('2082924565');

        $timeZoneMapper = PhoneNumberToTimeZonesMapper::getInstance();

        self::assertSame([self::LOS_ANGELES_TZ], $timeZoneMapper->getTimeZonesForNumber($number));
    }
}
