<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;
use PHPUnit\Framework\TestCase;

class Issue23Test extends TestCase
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;
    /**
     * @var PhoneNumberOfflineGeocoder|null
     */
    private $geocoder;

    public function setUp()
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();

        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testTKGeoLocation()
    {
        $number = '+6903010';

        $phoneNumber = $this->phoneUtil->parse($number, RegionCode::ZZ);

        $this->assertEquals('TK', $this->phoneUtil->getRegionCodeForNumber($phoneNumber));

        $this->assertEquals('Fakaofo Atoll', $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
