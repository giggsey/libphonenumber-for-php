<?php

declare(strict_types=1);

namespace libphonenumber\Tests\geocoding;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\TestCase;

use function pack;

class PhoneNumberOfflineGeocoderTest extends TestCase
{
    private static PhoneNumber $KO_Number1;
    private static PhoneNumber $KO_Number2;
    private static PhoneNumber $KO_Number3;
    private static PhoneNumber $KO_InvalidNumber;
    private static PhoneNumber $KO_Mobile;
    private static PhoneNumber $US_Number1;
    private static PhoneNumber $US_Number2;
    private static PhoneNumber $US_Number3;
    private static PhoneNumber $US_Number4;
    private static PhoneNumber $US_InvalidNumber;
    private static PhoneNumber $NANPA_TollFree;
    private static PhoneNumber $BS_Number1;
    private static PhoneNumber $AU_Number;
    private static PhoneNumber $AR_MobileNumber;
    private static PhoneNumber $numberWithInvalidCountryCode;
    private static PhoneNumber $internationalTollFree;
    protected PhoneNumberOfflineGeocoder $geocoder;

    public static function setUpBeforeClass(): void
    {
        self::$KO_Number1 = new PhoneNumber();
        self::$KO_Number1->setCountryCode(82)->setNationalNumber('22123456');

        self::$KO_Number2 = new PhoneNumber();
        self::$KO_Number2->setCountryCode(82)->setNationalNumber('322123456');

        self::$KO_Number3 = new PhoneNumber();
        self::$KO_Number3->setCountryCode(82)->setNationalNumber('6421234567');

        self::$KO_InvalidNumber = new PhoneNumber();
        self::$KO_InvalidNumber->setCountryCode(82)->setNationalNumber('1234');

        self::$KO_Mobile = new PhoneNumber();
        self::$KO_Mobile->setCountryCode(82)->setNationalNumber('101234567');

        self::$US_Number1 = new PhoneNumber();
        self::$US_Number1->setCountryCode(1)->setNationalNumber('6502530000');

        self::$US_Number2 = new PhoneNumber();
        self::$US_Number2->setCountryCode(1)->setNationalNumber('6509600000');

        self::$US_Number3 = new PhoneNumber();
        self::$US_Number3->setCountryCode(1)->setNationalNumber('2128120000');

        self::$US_Number4 = new PhoneNumber();
        self::$US_Number4->setCountryCode(1)->setNationalNumber('6174240000');

        self::$US_InvalidNumber = new PhoneNumber();
        self::$US_InvalidNumber->setCountryCode(1)->setNationalNumber('123456789');

        self::$NANPA_TollFree = new PhoneNumber();
        self::$NANPA_TollFree->setCountryCode(1)->setNationalNumber('8002431234');

        self::$BS_Number1 = new PhoneNumber();
        self::$BS_Number1->setCountryCode(1)->setNationalNumber('2423651234');

        self::$AU_Number = new PhoneNumber();
        self::$AU_Number->setCountryCode(61)->setNationalNumber('236618300');

        self::$AR_MobileNumber = new PhoneNumber();
        self::$AR_MobileNumber->setCountryCode(54)->setNationalNumber('92214000000');

        self::$numberWithInvalidCountryCode = new PhoneNumber();
        self::$numberWithInvalidCountryCode->setCountryCode(999)->setNationalNumber('2423651234');

        self::$internationalTollFree = new PhoneNumber();
        self::$internationalTollFree->setCountryCode(800)->setNationalNumber('12345678');
    }

    public function setUp(): void
    {
        PhoneNumberOfflineGeocoder::resetInstance();
        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance('libphonenumber\\Tests\\prefixmapper\\data\\');
    }

    public function testGetDescriptionForNumberWithNoDataFile(): void
    {
        // No data file containing mappings for US numbers is available in Chinese for the unittests. As
        // a result, the country name of United States in simplified Chinese is returned.

        self::assertSame(
            pack('H*', 'e7be8e') . pack('H*', 'e59bbd'),
            $this->geocoder->getDescriptionForNumber(self::$US_Number1, 'zh_CN')
        );
        self::assertSame('Bahamas', $this->geocoder->getDescriptionForNumber(self::$BS_Number1, 'en_US'));
        self::assertSame('Australia', $this->geocoder->getDescriptionForNumber(self::$AU_Number, 'en_US'));
        self::assertSame('', $this->geocoder->getDescriptionForNumber(self::$numberWithInvalidCountryCode, 'en_US'));
        self::assertSame('', $this->geocoder->getDescriptionForNumber(self::$internationalTollFree, 'en_US'));
    }

    public function testGetDescriptionForNumberWithMissingPrefix(): void
    {
        // Test that the name of the country is returned when the number passed in is valid but not
        // covered by the geocoding data file.

        self::assertSame('United States', $this->geocoder->getDescriptionForNumber(self::$US_Number4, 'en_US'));
    }

    public function testGetDescriptionForNumberBelongingToMultipleCountriesIsEmpty(): void
    {
        // Test that nothing is returned when the number passed in is valid but not
        // covered by the geocoding data file and belongs to multiple countries
        self::assertSame('', $this->geocoder->getDescriptionForNumber(self::$NANPA_TollFree, 'en_US'));
    }

    public function testGetDescriptionForNumber_en_US(): void
    {
        $ca = $this->geocoder->getDescriptionForNumber(self::$US_Number1, 'en_US');
        self::assertSame('CA', $ca);
        self::assertSame('Mountain View, CA', $this->geocoder->getDescriptionForNumber(self::$US_Number2, 'en_US'));
        self::assertSame('New York, NY', $this->geocoder->getDescriptionForNumber(self::$US_Number3, 'en_US'));
    }

    public function testGetDescriptionForKoreanNumber(): void
    {
        self::assertSame('Seoul', $this->geocoder->getDescriptionForNumber(self::$KO_Number1, 'en'));
        self::assertSame('Incheon', $this->geocoder->getDescriptionForNumber(self::$KO_Number2, 'en'));
        self::assertSame('Jeju', $this->geocoder->getDescriptionForNumber(self::$KO_Number3, 'en'));

        self::assertSame(
            pack('H*', 'ec849c') . pack('H*', 'ec9ab8'),
            $this->geocoder->getDescriptionForNumber(self::$KO_Number1, 'ko')
        );
        self::assertSame(
            pack('H*', 'ec9db8') . pack('H*', 'ecb29c'),
            $this->geocoder->getDescriptionForNumber(self::$KO_Number2, 'ko')
        );
    }

    public function testGetDescriptionForArgentinianMobileNumber(): void
    {
        self::assertSame('La Plata', $this->geocoder->getDescriptionForNumber(self::$AR_MobileNumber, 'en'));
    }

    public function testGetDescriptionForFallBack(): void
    {
        // No fallback, as the location name for the given phone number is available in the requested
        // language.

        self::assertSame('Kalifornien', $this->geocoder->getDescriptionForNumber(self::$US_Number1, 'de'));

        // German falls back to English.
        self::assertSame('New York, NY', $this->geocoder->getDescriptionForNumber(self::$US_Number3, 'de'));

        // Italian fals back to English.
        self::assertSame('CA', $this->geocoder->getDescriptionForNumber(self::$US_Number1, 'it'));

        // Korean doesn't fall back to English. -
        self::assertSame(
            pack('H*', 'eb8c80') . pack('H*', 'ed959c') . pack('H*', 'ebafbc') . pack('H*', 'eab5ad'),
            $this->geocoder->getDescriptionForNumber(self::$KO_Number3, 'ko')
        );
    }

    public function testGetDescriptionForNumberWithUserRegion(): void
    {
        // User in Italy, American number. We should just show United States, in Spanish, and not more
        // detailed information.
        self::assertSame(
            'Estados Unidos',
            $this->geocoder->getDescriptionForNumber(self::$US_Number1, 'es_ES', 'IT')
        );

        // Unknown region - should just show country name.
        self::assertSame(
            'Estados Unidos',
            $this->geocoder->getDescriptionForNumber(self::$US_Number1, 'es_ES', 'ZZ')
        );

        // User in the States, language German, should show detailed data.
        self::assertSame('Kalifornien', $this->geocoder->getDescriptionForNumber(self::$US_Number1, 'de', 'US'));

        // User in the States, language French, no data for French, so we fallback to English detailed
        // data.
        self::assertSame('CA', $this->geocoder->getDescriptionForNumber(self::$US_Number1, 'fr', 'US'));

        // Invalid number - return an empty string.
        self::assertSame('', $this->geocoder->getDescriptionForNumber(self::$US_InvalidNumber, 'en', 'US'));
    }

    public function testGetDescriptionForInvalidNumber(): void
    {
        self::assertSame('', $this->geocoder->getDescriptionForNumber(self::$KO_InvalidNumber, 'en'));
        self::assertSame('', $this->geocoder->getDescriptionForNumber(self::$US_InvalidNumber, 'en'));
    }

    public function testGetDescriptionForNonGeographicalNumberWithGeocodingPrefix(): void
    {
        // We have a geocoding prefix, but we shouldn't use it since this is not geographical.
        self::assertSame('South Korea', $this->geocoder->getDescriptionForNumber(self::$KO_Mobile, 'en'));
    }
}
