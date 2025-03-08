<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

/**
 * Test E164 formatted numbers with extensions
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/152
 * @package libphonenumber\Tests\Issues
 */
class Issue152Test extends TestCase
{
    public function setUp(): void
    {
        // Reset instance each time
        PhoneNumberUtil::resetInstance();
    }

    public function testE164NumberWithExtension(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(44)->setNationalNumber('1174960123')->setExtension('101');

        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        self::assertSame('+441174960123', $phoneNumberUtil->format($number, PhoneNumberFormat::E164));
        self::assertSame('+44 117 496 0123 x101', $phoneNumberUtil->format($number, PhoneNumberFormat::INTERNATIONAL));
        self::assertSame('0117 496 0123 x101', $phoneNumberUtil->format($number, PhoneNumberFormat::NATIONAL));
        self::assertSame('tel:+44-117-496-0123;ext=101', $phoneNumberUtil->format($number, PhoneNumberFormat::RFC3966));
    }
}
