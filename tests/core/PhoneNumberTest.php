<?php

namespace libphonenumber\Tests\core;

use libphonenumber\CountryCodeSource;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\TestCase;

/**
 * Tests for the PhoneNumber object itself.
 */
class PhoneNumberTest extends TestCase
{
    public function testEqualSimpleNumber(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber(6502530000);

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber(6502530000);

        $this->assertEquals($numberA, $numberB);
    }

    public function testEqualWithItalianLeadingZeroSetToDefault(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber(6502530000)->setItalianLeadingZero(false);

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber(6502530000);

        // These should still be equal, since the default value for this field is false.
        $this->assertEquals($numberA, $numberB);
    }

    public function testEqualWithCountryCodeSourceSet(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setRawInput('+1 650 253 00 00')->setCountryCode(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);

        $numberB = new PhoneNumber();
        $numberB->setRawInput('+1 650 253 00 00')->setCountryCode(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);

        $this->assertEquals($numberA, $numberB);
    }

    public function testNonEqualWithItalianLeadingZeroSetToTrue(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber(6502530000)->setItalianLeadingZero(true);

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber(6502530000);

        $this->assertNotEquals($numberA, $numberB);
        $this->assertFalse($numberA->equals($numberB));
    }

    public function testNonEqualWithDifferingRawInput(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)
            ->setNationalNumber(6502530000)
            ->setRawInput('+1 650 253 00 00')
            ->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)
            ->setNationalNumber(6502530000)
            ->setRawInput('+1-650-253-00-00')
            ->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);

        $this->assertNotEquals($numberA, $numberB);
        $this->assertFalse($numberA->equals($numberB));
    }

    public function testNonEqualWithPreferredDomesticCarrierCodeSetToDefault(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber(6502530000)->setPreferredDomesticCarrierCode('');

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber(6502530000);

        $this->assertNotSame($numberA, $numberB);
        $this->assertFalse($numberA->equals($numberB));
    }

    public function testEqualWithSameExtension(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setNationalNumber(6502530000)->setExtension('123');

        $numberB = new PhoneNumber();
        $numberB->setNationalNumber(6502530000)->setExtension('123');

        $this->assertTrue($numberA->equals($numberB));
    }

    public function testNonEqualWithDifferentExtension(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setNationalNumber(6502530000)->setExtension('123');

        $numberB = new PhoneNumber();
        $numberB->setNationalNumber(6502530000)->setExtension('321');

        $this->assertFalse($numberA->equals($numberB));
    }

    public function testEqualWithPreferredDomesticCarrierCodeSetToDefault(): void
    {
        $numberA = new PhoneNumber();
        $numberA->setCountryCode(1)->setNationalNumber(6502530000)->setPreferredDomesticCarrierCode('');

        $numberB = new PhoneNumber();
        $numberB->setCountryCode(1)->setNationalNumber(6502530000)->setPreferredDomesticCarrierCode('');

        $this->assertEquals($numberA, $numberB);
    }

    public function testUnserialize(): void
    {
        $numberA = new PhoneNumber();
        $numberB = new PhoneNumber();

        $this->assertEquals($numberA, \unserialize(\serialize($numberB)));
    }
}
