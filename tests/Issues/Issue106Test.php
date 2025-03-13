<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\TestCase;

use function pack;

class Issue106Test extends TestCase
{
    private static PhoneNumber $TW_Number1;
    protected PhoneNumberOfflineGeocoder $geocoder;

    public static function setUpBeforeClass(): void
    {
        self::$TW_Number1 = new PhoneNumber();
        self::$TW_Number1->setCountryCode(886)->setNationalNumber('223113731');
    }

    public function setUp(): void
    {
        PhoneNumberOfflineGeocoder::resetInstance();
        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testGeocoderForZh(): void
    {
        self::assertSame('Taipei', $this->geocoder->getDescriptionForNumber(self::$TW_Number1, 'en'));

        self::assertSame(
            pack('H*', 'e58fb0') . pack('H*', 'e58c97'),
            $this->geocoder->getDescriptionForNumber(self::$TW_Number1, 'zh_CN')
        );

        self::assertSame(
            pack('H*', 'e887ba') . pack('H*', 'e58c97'),
            $this->geocoder->getDescriptionForNumber(self::$TW_Number1, 'zh_TW')
        );
    }
}
