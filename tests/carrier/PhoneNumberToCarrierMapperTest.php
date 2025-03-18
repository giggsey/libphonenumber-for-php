<?php

declare(strict_types=1);

namespace libphonenumber\Tests\carrier;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

use function pack;

class PhoneNumberToCarrierMapperTest extends TestCase
{
    private static PhoneNumber $AO_MOBILE1;
    private static PhoneNumber $AO_MOBILE2;
    private static PhoneNumber $AO_FIXED1;
    private static PhoneNumber $AO_FIXED2;
    private static PhoneNumber $AO_INVALID_NUMBER;
    private static PhoneNumber $UK_MOBILE1;
    private static PhoneNumber $UK_MOBILE2;
    private static PhoneNumber $UK_FIXED1;
    private static PhoneNumber $UK_FIXED2;
    private static PhoneNumber $UK_INVALID_NUMBER;
    private static PhoneNumber $UK_PAGER;
    private static PhoneNumber $US_FIXED_OR_MOBILE;
    private static PhoneNumber $NUMBER_WITH_INVALID_COUNTRY_CODE;
    private static PhoneNumber $INTERNATIONAL_TOLL_FREE;
    protected PhoneNumberToCarrierMapper $carrierMapper;

    public static function setUpBeforeClass(): void
    {
        PhoneNumberUtil::resetInstance();

        self::$AO_MOBILE1 = new PhoneNumber();
        self::$AO_MOBILE1->setCountryCode(244)->setNationalNumber('917654321');

        self::$AO_MOBILE2 = new PhoneNumber();
        self::$AO_MOBILE2->setCountryCode(244)->setNationalNumber('927654321');

        self::$AO_FIXED1 = new PhoneNumber();
        self::$AO_FIXED1->setCountryCode(244)->setNationalNumber('22254321');

        self::$AO_FIXED2 = new PhoneNumber();
        self::$AO_FIXED2->setCountryCode(244)->setNationalNumber('26254321');

        self::$AO_INVALID_NUMBER = new PhoneNumber();
        self::$AO_INVALID_NUMBER->setCountryCode(244)->setNationalNumber('101234');

        self::$UK_MOBILE1 = new PhoneNumber();
        self::$UK_MOBILE1->setCountryCode(44)->setNationalNumber('7387654321');

        self::$UK_MOBILE2 = new PhoneNumber();
        self::$UK_MOBILE2->setCountryCode(44)->setNationalNumber('7487654321');

        self::$UK_FIXED1 = new PhoneNumber();
        self::$UK_FIXED1->setCountryCode(44)->setNationalNumber('1123456789');

        self::$UK_FIXED2 = new PhoneNumber();
        self::$UK_FIXED2->setCountryCode(44)->setNationalNumber('2987654321');

        self::$UK_INVALID_NUMBER = new PhoneNumber();
        self::$UK_INVALID_NUMBER->setCountryCode(44)->setNationalNumber('7301234');

        self::$UK_PAGER = new PhoneNumber();
        self::$UK_PAGER->setCountryCode(44)->setNationalNumber('7601234567');

        self::$US_FIXED_OR_MOBILE = new PhoneNumber();
        self::$US_FIXED_OR_MOBILE->setCountryCode(1)->setNationalNumber('6502123456');

        self::$NUMBER_WITH_INVALID_COUNTRY_CODE = new PhoneNumber();
        self::$NUMBER_WITH_INVALID_COUNTRY_CODE->setCountryCode(999)->setNationalNumber('2423651234');

        self::$INTERNATIONAL_TOLL_FREE = new PhoneNumber();
        self::$INTERNATIONAL_TOLL_FREE->setCountryCode(800)->setNationalNumber('12345678');
    }

    public function setUp(): void
    {
        $this->carrierMapper = PhoneNumberToCarrierMapper::getInstance(__NAMESPACE__ . '\\data\\');
    }

    public function testGetNameForMobilePortableRegion(): void
    {
        self::assertSame('British carrier', $this->carrierMapper->getNameForNumber(self::$UK_MOBILE1, 'en'));
        self::assertSame('Brittisk operat' . pack('H*', 'c3b6') . 'r', $this->carrierMapper->getNameForNumber(
            self::$UK_MOBILE1,
            'sv_SE'
        ));
        self::assertSame('British carrier', $this->carrierMapper->getNameForNumber(self::$UK_MOBILE1, 'fr'));
        // Returns an empty string because the UK implements mobile number portability.
        self::assertSame('', $this->carrierMapper->getSafeDisplayName(self::$UK_MOBILE1, 'en'));
    }

    public function testGetNameForNonMobilePortableRegion(): void
    {
        self::assertSame('Angolan carrier', $this->carrierMapper->getNameForNumber(self::$AO_MOBILE1, 'en'));
        self::assertSame('Angolan carrier', $this->carrierMapper->getSafeDisplayName(self::$AO_MOBILE1, 'en'));
    }

    public function testGetNameForFixedLineNumber(): void
    {
        self::assertSame('', $this->carrierMapper->getNameForNumber(self::$AO_FIXED1, 'en'));
        self::assertSame('', $this->carrierMapper->getNameForNumber(self::$UK_FIXED1, 'en'));
        // If the carrier information is present in the files and the method that assumes a valid
        // number is used, a carrier is returned
        self::assertSame('Angolan fixed line carrier', $this->carrierMapper->getNameForValidNumber(
            self::$AO_FIXED2,
            'en'
        ));
        self::assertSame('', $this->carrierMapper->getNameForValidNumber(self::$UK_FIXED2, 'en'));
    }

    public function testGetNameForFixedOrMobileNumber(): void
    {
        self::assertSame('US carrier', $this->carrierMapper->getNameForNumber(self::$US_FIXED_OR_MOBILE, 'en'));
    }

    public function testGetNameForPagerNumber(): void
    {
        self::assertSame('British pager', $this->carrierMapper->getNameForNumber(self::$UK_PAGER, 'en'));
    }

    public function testGetNameForNumberWithNoDataFile(): void
    {
        self::assertSame('', $this->carrierMapper->getNameForNumber(self::$NUMBER_WITH_INVALID_COUNTRY_CODE, 'en'));
        self::assertSame('', $this->carrierMapper->getNameForNumber(self::$INTERNATIONAL_TOLL_FREE, 'en'));

        self::assertSame('', $this->carrierMapper->getNameForValidNumber(
            self::$NUMBER_WITH_INVALID_COUNTRY_CODE,
            'en'
        ));
        self::assertSame('', $this->carrierMapper->getNameForValidNumber(self::$INTERNATIONAL_TOLL_FREE, 'en'));
    }

    public function testGetNameForNumberWithMissingPrefix(): void
    {
        self::assertSame('', $this->carrierMapper->getNameForNumber(self::$UK_MOBILE2, 'en'));
        self::assertSame('', $this->carrierMapper->getNameForNumber(self::$AO_MOBILE2, 'en'));
    }

    public function testGetNameForInvalidNumber(): void
    {
        self::assertSame('', $this->carrierMapper->getNameForNumber(self::$UK_INVALID_NUMBER, 'en'));
        self::assertSame('', $this->carrierMapper->getNameForNumber(self::$AO_INVALID_NUMBER, 'en'));
    }
}
