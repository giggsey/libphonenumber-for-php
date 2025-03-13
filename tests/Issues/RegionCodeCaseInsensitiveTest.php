<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\TestCase;
use libphonenumber\PhoneMetadata;

class RegionCodeCaseInsensitiveTest extends TestCase
{
    private PhoneNumberUtil $phoneUtil;

    private ShortNumberInfo $shortInfo;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
        $this->shortInfo = ShortNumberInfo::getInstance();
    }

    public function testParse(): void
    {
        $number = '07987458147';
        $phoneObject = $this->phoneUtil->parse($number, 'gb');

        self::assertTrue($this->phoneUtil->isValidNumber($phoneObject));

        self::assertTrue($this->phoneUtil->isValidNumberForRegion($phoneObject, 'gb'));
    }

    public function testIsNANPACountry(): void
    {
        self::assertTrue($this->phoneUtil->isNANPACountry('us'));
    }

    public function testGetMetadataForRegion(): void
    {
        $metadata = $this->phoneUtil->getMetadataForRegion('gb');

        self::assertInstanceOf(PhoneMetadata::class, $metadata);
    }

    public function testConnectsToEmergency(): void
    {
        self::assertTrue($this->shortInfo->connectsToEmergencyNumber('911', 'us'));
        self::assertFalse($this->shortInfo->connectsToEmergencyNumber('9111', 'br'));
    }

    public function testGetCountryCodeForRegion(): void
    {
        self::assertSame(44, $this->phoneUtil->getCountryCodeForRegion('gb'));
    }

    public function testExampleNumber(): void
    {
        self::assertSame(
            (string) $this->phoneUtil->parse('+441212345678'),
            (string) $this->phoneUtil->getExampleNumber('gb')
        );
        self::assertSame(
            (string) $this->phoneUtil->parse('+44121234567'),
            (string) $this->phoneUtil->getInvalidExampleNumber('gb')
        );
        self::assertSame(
            (string) $this->phoneUtil->parse('+447400123456'),
            (string) $this->phoneUtil->getExampleNumberForType('gb', PhoneNumberType::MOBILE)
        );
    }

    public function testFindNumbers(): void
    {
        $phoneNumberMatcher = $this->phoneUtil->findNumbers('Testing 01212345678', 'gb');

        $phoneNumberMatcher->next();
        $match = $phoneNumberMatcher->current();
        self::assertNotNull($match);
    }
}
