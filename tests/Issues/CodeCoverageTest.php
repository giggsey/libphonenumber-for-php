<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class CodeCoverageTest extends TestCase
{
    private PhoneNumberUtil $phoneUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function testTooShortNumber(): void
    {
        $this->expectException(NumberParseException::class);
        $this->expectExceptionMessage('The string supplied is too short to be a phone number.');
        $this->expectExceptionCode(3);

        $this->phoneUtil->parse('+441', 'GB');
    }

    public function testIsValidNumberForRegionWithManualPhoneNumber(): void
    {
        $number = new PhoneNumber();
        $number->setNationalNumber('1234');

        self::assertFalse($this->phoneUtil->isValidNumberForRegion($number, 'GB'));
    }

    public function testFormatWithManualPhoneNumber(): void
    {
        $number = new PhoneNumber();
        $number->setNationalNumber('1234');

        self::assertEquals('1234', $this->phoneUtil->format($number, PhoneNumberFormat::E164));
        self::assertEquals('1234', $this->phoneUtil->format($number, PhoneNumberFormat::NATIONAL));
    }
}
