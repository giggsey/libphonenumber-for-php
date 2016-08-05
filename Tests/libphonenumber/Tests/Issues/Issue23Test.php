<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;

class Issue23Test extends \PHPUnit_Framework_TestCase
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

        $this->assertEquals('Tokelau', $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
