<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\CountryCodeSource;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

use function serialize;
use function unserialize;

class Issue35Test extends TestCase
{
    private PhoneNumberUtil $phoneUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function testSerializingPhoneNumber(): void
    {
        $number = '+441174900000';
        $region = 'GB';
        $phoneNumber = $this->phoneUtil->parse($number, $region);

        $serializedString = serialize($phoneNumber);

        $phoneObject2 = unserialize($serializedString);

        self::assertTrue($phoneObject2->equals($phoneNumber));
    }

    public function testSerializingPhoneNumber2(): void
    {
        $phoneNumber = new PhoneNumber();
        $phoneNumber->setCountryCode(1);
        $phoneNumber->setNationalNumber('1');
        $phoneNumber->setExtension('1');
        $phoneNumber->setItalianLeadingZero(true);
        $phoneNumber->setNumberOfLeadingZeros(1);
        $phoneNumber->setRawInput('1');
        $phoneNumber->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_IDD);
        $phoneNumber->setPreferredDomesticCarrierCode('1');

        $serializedString = serialize($phoneNumber);
        $phoneObject2 = unserialize($serializedString);

        self::assertTrue($phoneObject2->equals($phoneNumber));
    }
}
