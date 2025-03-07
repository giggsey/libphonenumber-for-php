<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\TestCase;

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

        $this->assertTrue($this->phoneUtil->isValidNumber($phoneObject));

        $this->assertTrue($this->phoneUtil->isValidNumberForRegion($phoneObject, 'gb'));
    }

    public function testIsNANPACountry(): void
    {
        $this->assertTrue($this->phoneUtil->isNANPACountry('us'));
    }

    public function testGetMetadataForRegion(): void
    {
        $metadata = $this->phoneUtil->getMetadataForRegion('gb');

        $this->assertInstanceOf('\libphonenumber\PhoneMetadata', $metadata);
    }

    public function testConnectsToEmergency(): void
    {
        $this->assertTrue($this->shortInfo->connectsToEmergencyNumber('911', 'us'));
        $this->assertFalse($this->shortInfo->connectsToEmergencyNumber('9111', 'br'));
    }

    public function testGetCountryCodeForRegion(): void
    {
        $this->assertEquals(44, $this->phoneUtil->getCountryCodeForRegion('gb'));
    }

    public function testExampleNumber(): void
    {
        $this->assertSame(
            (string) $this->phoneUtil->parse('+441212345678'),
            (string) $this->phoneUtil->getExampleNumber('gb')
        );
        $this->assertSame(
            (string) $this->phoneUtil->parse('+44121234567'),
            (string) $this->phoneUtil->getInvalidExampleNumber('gb')
        );
        $this->assertSame(
            (string) $this->phoneUtil->parse('+447400123456'),
            (string) $this->phoneUtil->getExampleNumberForType('gb', PhoneNumberType::MOBILE)
        );
    }

    public function testFindNumbers(): void
    {
        $phoneNumberMatcher = $this->phoneUtil->findNumbers('Testing 01212345678', 'gb');

        $phoneNumberMatcher->next();
        $match = $phoneNumberMatcher->current();
        $this->assertNotNull($match);
    }
}
