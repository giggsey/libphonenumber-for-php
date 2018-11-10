<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue36Test extends TestCase
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
        $number = '447797752305';

        $phoneNumber = $this->phoneUtil->parse($number, 'GB');

        $this->assertEquals('Jersey', $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
