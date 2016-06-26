<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumber;

class Issue106Test extends \PHPUnit_Framework_TestCase
{
    private static $TW_Number1;
    protected $geocoder;

    public static function setUpBeforeClass()
    {
        self::$TW_Number1 = new PhoneNumber();
        self::$TW_Number1->setCountryCode(886)->setNationalNumber(223113731);
    }

    public function setUp()
    {
        if (!extension_loaded('intl')) {
            $this->markTestSkipped('The intl extension must be installed');
        }

        PhoneNumberOfflineGeocoder::resetInstance();
        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testGeocoderForZh()
    {
        $this->assertEquals("Taipei", $this->geocoder->getDescriptionForNumber(self::$TW_Number1, "en"));

        $this->assertEquals(
            pack('H*', 'e58fb0') . pack('H*', 'e58c97'),
            $this->geocoder->getDescriptionForNumber(self::$TW_Number1, "zh_CN")
        );

        $this->assertEquals(
            pack('H*', 'e887ba') . pack('H*', 'e58c97'),
            $this->geocoder->getDescriptionForNumber(self::$TW_Number1, "zh_TW")
        );
    }
}
