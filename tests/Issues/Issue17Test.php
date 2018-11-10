<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue17Test extends TestCase
{
    /**
     * @var PhoneNumberOfflineGeocoder
     */
    private $geocoder;

    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    public function setUp()
    {
        PhoneNumberUtil::resetInstance();
        PhoneNumberOfflineGeocoder::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testIsleOfManLocale()
    {
        $number = '447624206000';

        $phoneNumber = $this->phoneUtil->parse($number, 'GB');

        $this->assertEquals('Isle of Man', $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
