<?php
/**
 *
 *
 * @author giggsey
 * @created: 02/10/13 17:29
 * @project libphonenumber-for-php
 */

namespace libphonenumber\Tests\carrier;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberUtil;

require __DIR__ . '/../../vendor/autoload.php';

class PhoneNumberToCarrierMapperTest extends \PHPUnit_Framework_TestCase
{
    const TEST_META_DATA_FILE_PREFIX = "/../../Tests/carrier/data/";
    private static $AO_MOBILE1;
    private static $AO_MOBILE2;
    private static $AO_FIXED1;
    private static $AO_FIXED2;
    private static $AO_INVALID_NUMBER;
    private static $UK_MOBILE1;
    private static $UK_MOBILE2;
    private static $UK_FIXED1;
    private static $UK_FIXED2;
    private static $UK_INVALID_NUMBER;
    private static $UK_PAGER;
    private static $US_FIXED_OR_MOBILE;
    private static $NUMBER_WITH_INVALID_COUNTRY_CODE;
    private static $INTERNATIONAL_TOLL_FREE;
    /**
     * @var PhoneNumberToCarrierMapper
     */
    protected $carrierMapper;

    public static function setUpBeforeClass()
    {
        self::$AO_MOBILE1 = new PhoneNumber();
        self::$AO_MOBILE1->setCountryCode(244)->setNationalNumber(917654321);

        self::$AO_MOBILE2 = new PhoneNumber();
        self::$AO_MOBILE2->setCountryCode(244)->setNationalNumber(927654321);

        self::$AO_FIXED1 = new PhoneNumber();
        self::$AO_FIXED1->setCountryCode(244)->setNationalNumber(22254321);

        self::$AO_FIXED2 = new PhoneNumber();
        self::$AO_FIXED2->setCountryCode(244)->setNationalNumber(26254321);

        self::$AO_INVALID_NUMBER = new PhoneNumber();
        self::$AO_INVALID_NUMBER->setCountryCode(244)->setNationalNumber(101234);

        self::$UK_MOBILE1 = new PhoneNumber();
        self::$UK_MOBILE1->setCountryCode(44)->setNationalNumber(7387654321);

        self::$UK_MOBILE2 = new PhoneNumber();
        self::$UK_MOBILE2->setCountryCode(44)->setNationalNumber(7487654321);

        self::$UK_FIXED1 = new PhoneNumber();
        self::$UK_FIXED1->setCountryCode(44)->setNationalNumber(1123456789);

        self::$UK_FIXED2 = new PhoneNumber();
        self::$UK_FIXED2->setCountryCode(44)->setNationalNumber(2987654321);

        self::$UK_INVALID_NUMBER = new PhoneNumber();
        self::$UK_INVALID_NUMBER->setCountryCode(44)->setNationalNumber(7301234);

        self::$UK_PAGER = new PhoneNumber();
        self::$UK_PAGER->setCountryCode(44)->setNationalNumber(7601234567);

        self::$US_FIXED_OR_MOBILE = new PhoneNumber();
        self::$US_FIXED_OR_MOBILE->setCountryCode(1)->setNationalNumber(6502123456);

        self::$NUMBER_WITH_INVALID_COUNTRY_CODE = new PhoneNumber();
        self::$NUMBER_WITH_INVALID_COUNTRY_CODE->setCountryCode(999)->setNationalNumber(2423651234);

        self::$INTERNATIONAL_TOLL_FREE = new PhoneNumber();
        self::$INTERNATIONAL_TOLL_FREE->setCountryCode(800)->setNationalNumber(12345678);
    }

    public function setUp()
    {
        PhoneNumberUtil::resetInstance();
        $this->carrierMapper = PhoneNumberToCarrierMapper::getInstance(self::TEST_META_DATA_FILE_PREFIX);
    }

    public function testGetDescriptionForMobilePortableRegion()
    {
        $this->assertEquals("British carrier", $this->carrierMapper->getDescriptionForNumber(self::$UK_MOBILE1, "en"));
        $this->assertEquals(
            "Brittisk operatör",
            $this->carrierMapper->getDescriptionForNumber(self::$UK_MOBILE1, "sv_SE")
        );
        $this->assertEquals("British carrier", $this->carrierMapper->getDescriptionForNumber(self::$UK_MOBILE1, "fr"));
    }

    public function testGetDescriptionForNonMobilePortableRegion()
    {
        $this->assertEquals("Angolan carrier", $this->carrierMapper->getDescriptionForNumber(self::$AO_MOBILE1, "en"));
    }

    public function testGetDescriptionForFixedLineNumber()
    {
        $this->assertEquals("", $this->carrierMapper->getDescriptionForNumber(self::$AO_FIXED1, "en"));
        $this->assertEquals("", $this->carrierMapper->getDescriptionForNumber(self::$UK_FIXED1, "en"));
        // If the carrier information is present in the files and the method that assumes a valid
        // number is used, a carrier is returned
        $this->assertEquals(
            "Angolan fixed line carrier",
            $this->carrierMapper->getDescriptionForValidNumber(self::$AO_FIXED2, "en")
        );
        $this->assertEquals("", $this->carrierMapper->getDescriptionForValidNumber(self::$UK_FIXED2, "en"));
    }

    public function testGetDescriptionForFixedOrMobileNumber()
    {
        $this->assertEquals(
            "US carrier",
            $this->carrierMapper->getDescriptionForNumber(self::$US_FIXED_OR_MOBILE, "en")
        );
    }

    public function testGetDescriptionForPagerNumber()
    {
        $this->assertEquals("British pager", $this->carrierMapper->getDescriptionForNumber(self::$UK_PAGER, "en"));
    }

    public function testGetDescriptionForNumberWithNoDataFile()
    {
        $this->assertEquals(
            "",
            $this->carrierMapper->getDescriptionForNumber(self::$NUMBER_WITH_INVALID_COUNTRY_CODE, "en")
        );
        $this->assertEquals("", $this->carrierMapper->getDescriptionForNumber(self::$INTERNATIONAL_TOLL_FREE, "en"));

        $this->assertEquals(
            "",
            $this->carrierMapper->getDescriptionForValidNumber(self::$NUMBER_WITH_INVALID_COUNTRY_CODE, "en")
        );
        $this->assertEquals(
            "",
            $this->carrierMapper->getDescriptionForValidNumber(self::$INTERNATIONAL_TOLL_FREE, "en")
        );
    }

    public function testGetDescriptionForNumberWithMissingPrefix()
    {
        $this->assertEquals("", $this->carrierMapper->getDescriptionForNumber(self::$UK_MOBILE2, "en"));
        $this->assertEquals("", $this->carrierMapper->getDescriptionForNumber(self::$AO_MOBILE2, "en"));
    }

    public function testGetDescriptionForInvalidNumber()
    {
        $this->assertEquals("", $this->carrierMapper->getDescriptionForNumber(self::$UK_INVALID_NUMBER, "en"));
        $this->assertEquals("", $this->carrierMapper->getDescriptionForNumber(self::$AO_INVALID_NUMBER, "en"));

    }
}

/* EOF */ 