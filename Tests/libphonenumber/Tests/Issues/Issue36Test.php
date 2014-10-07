<?php

namespace libphonenumber\Tests\Issues;


use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;

class Issue36Test extends \PHPUnit_Framework_TestCase
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
        $number = "447797752305";

        $phoneNumber = $this->phoneUtil->parse($number, 'GB');

        $this->assertEquals("Jersey", $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
