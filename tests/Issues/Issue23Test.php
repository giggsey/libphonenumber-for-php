<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;
use PHPUnit\Framework\TestCase;

class Issue23Test extends TestCase
{
    private PhoneNumberUtil $phoneUtil;
    private PhoneNumberOfflineGeocoder $geocoder;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        PhoneNumberOfflineGeocoder::resetInstance();

        $this->phoneUtil = PhoneNumberUtil::getInstance();

        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testTKGeoLocation(): void
    {
        $number = '+6903010';

        $phoneNumber = $this->phoneUtil->parse($number, RegionCode::ZZ);

        self::assertSame('TK', $this->phoneUtil->getRegionCodeForNumber($phoneNumber));

        self::assertSame('Fakaofo Atoll', $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
