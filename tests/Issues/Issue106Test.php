<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\TestCase;

class Issue106Test extends TestCase
{
    private static $TW_Number1;
    /**
     * @var PhoneNumberOfflineGeocoder
     */
    protected $geocoder;

    public static function setUpBeforeClass(): void
    {
        self::$TW_Number1 = new PhoneNumber();
        self::$TW_Number1->setCountryCode(886)->setNationalNumber(223113731);
    }

    public function setUp(): void
    {
        PhoneNumberOfflineGeocoder::resetInstance();
        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testGeocoderForZh()
    {
        $this->assertEquals('Taipei', $this->geocoder->getDescriptionForNumber(self::$TW_Number1, 'en'));

        $this->assertEquals(
            \pack('H*', 'e58fb0') . \pack('H*', 'e58c97'),
            $this->geocoder->getDescriptionForNumber(self::$TW_Number1, 'zh_CN')
        );

        $this->assertEquals(
            \pack('H*', 'e887ba') . \pack('H*', 'e58c97'),
            $this->geocoder->getDescriptionForNumber(self::$TW_Number1, 'zh_TW')
        );
    }
}
