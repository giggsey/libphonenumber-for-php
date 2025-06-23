<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\CountryCodeSource;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\TestCase;

use function serialize;
use function unserialize;

/**
 * Tests for the PhoneNumber object itself.
 */
class PhoneNumberTest extends TestCase
{
    public function testEqualSimpleNumber(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber('6502530000');

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber('6502530000');

        self::assertEquals($numberA, $numberB);
    }

    public function testEqualWithItalianLeadingZeroSetToDefault(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber('6502530000')->setItalianLeadingZero(false);

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber('6502530000');

        // These should still be equal, since the default value for this field is false.
        self::assertEquals($numberA, $numberB);
    }

    public function testEqualWithCountryCodeSourceSet(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setRawInput('+1 650 253 00 00')->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);

        $numberB = new PhoneNumber();
        $numberB->setRawInput('+1 650 253 00 00')->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);

        self::assertEquals($numberA, $numberB);
    }

    public function testNonEqualWithItalianLeadingZeroSetToTrue(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber('6502530000')->setItalianLeadingZero(true);

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber('6502530000');

        self::assertNotEquals($numberA, $numberB);
        self::assertFalse($numberA->equals($numberB));
    }

    public function testNonEqualWithDifferingRawInput(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)
            ->setNationalNumber('6502530000')
            ->setRawInput('+1 650 253 00 00')
            ->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)
            ->setNationalNumber('6502530000')
            ->setRawInput('+1-650-253-00-00')
            ->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);

        self::assertNotEquals($numberA, $numberB);
        self::assertFalse($numberA->equals($numberB));
    }

    public function testNonEqualWithPreferredDomesticCarrierCodeSetToDefault(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber('6502530000')->setPreferredDomesticCarrierCode('');

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber('6502530000');

        self::assertNotSame($numberA, $numberB);
        self::assertFalse($numberA->equals($numberB));
    }

    public function testEqualWithSameExtension(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setNationalNumber('6502530000')->setExtension('123');

        $numberB = new PhoneNumber();
        $numberB->setNationalNumber('6502530000')->setExtension('123');

        self::assertTrue($numberA->equals($numberB));
    }

    public function testNonEqualWithDifferentExtension(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setNationalNumber('6502530000')->setExtension('123');

        $numberB = new PhoneNumber();
        $numberB->setNationalNumber('6502530000')->setExtension('321');

        self::assertFalse($numberA->equals($numberB));
    }

    public function testEqualWithPreferredDomesticCarrierCodeSetToDefault(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber('6502530000')->setPreferredDomesticCarrierCode('');

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber('6502530000')->setPreferredDomesticCarrierCode('');

        self::assertEquals($numberA, $numberB);
    }

    public function testUnserialize(): void
    {
        $numberA = new PhoneNumber();
        $numberB = new PhoneNumber();

        self::assertEquals($numberA, unserialize(serialize($numberB)));
    }

    public function testUnserializeWithOldPhoneNumberData(): void
    {
        $oldPhoneNumberSerialized = 'O:26:"libphonenumber\PhoneNumber":8:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;i:1;i:5;N;i:6;i:4;i:7;N;}';

        self::assertEquals(new PhoneNumber(), unserialize($oldPhoneNumberSerialized));
    }
}
