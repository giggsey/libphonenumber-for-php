<?php

namespace libphonenumber\Tests\Issues;


use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;

class Issue17Test extends \PHPUnit_Framework_TestCase
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
        if(!extension_loaded('intl')) {
            $this->markTestSkipped('The intl extension must be installed');
        }

        PhoneNumberUtil::resetInstance();
        PhoneNumberOfflineGeocoder::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testIsleOfManLocale()
    {
        $number = "447624806000";

        $phoneNumber = $this->phoneUtil->parse($number, 'GB');

        $this->assertEquals("Isle of Man", $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
