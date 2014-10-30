<?php

namespace libphonenumber\Tests\core;

use libphonenumber\CountryCodeSource;
use libphonenumber\CountryCodeToRegionCodeMapForTesting;
use libphonenumber\DefaultMetadataLoader;
use libphonenumber\MatchType;
use libphonenumber\NumberFormat;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberDesc;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;
use libphonenumber\ValidationResult;


class PhoneNumberUtilTest extends \PHPUnit_Framework_TestCase
{

    const TEST_META_DATA_FILE_PREFIX = "../../../Tests/libphonenumber/Tests/core/data/PhoneNumberMetadataForTesting";
    private static $bsNumber = null;
    private static $internationalTollFree = null;
    private static $sgNumber = null;
    private static $usShortByOneNumber = null;
    private static $usTollFree = null;
    private static $usNumber = null;
    private static $usLocalNumber = null;
    private static $usLongNumber = null;
    private static $nzNumber = null;
    private static $usPremium = null;
    private static $usSpoof = null;
    private static $usSpoofWithRawInput = null;
    private static $gbMobile = null;
    private static $bsMobile = null;
    private static $gbNumber = null;
    private static $deShortNumber = null;
    private static $itMobile = null;
    private static $itNumber = null;
    private static $auNumber = null;
    private static $arMobile = null;
    private static $arNumber = null;
    private static $mxMobile1 = null;
    private static $mxNumber1 = null;
    private static $mxMobile2 = null;
    private static $mxNumber2 = null;
    private static $deNumber = null;
    private static $jpStarNumber = null;
    private static $internationalTollFreeTooLong = null;
    private static $universalPremiumRate = null;
    private static $alphaNumericNumber = null;
    private static $aeUAN = null;
    private static $unknownCountryCodeNoRawInput = null;
    /**
     * @var PhoneNumberUtil
     */
    protected $phoneUtil;

    public function __construct()
    {
        $this->phoneUtil = self::initializePhoneUtilForTesting();
    }

    private static function initializePhoneUtilForTesting()
    {
        self::$bsNumber = new PhoneNumber();
        self::$bsNumber->setCountryCode(1)->setNationalNumber(2423651234);
        self::$bsMobile = new PhoneNumber();
        self::$bsMobile->setCountryCode(1)->setNationalNumber(2423591234);
        self::$internationalTollFree = new PhoneNumber();
        self::$internationalTollFree->setCountryCode(800)->setNationalNumber(12345678);
        self::$internationalTollFreeTooLong = new PhoneNumber();
        self::$internationalTollFreeTooLong->setCountryCode(800)->setNationalNumber(123456789);
        self::$universalPremiumRate = new PhoneNumber();
        self::$universalPremiumRate->setCountryCode(979)->setNationalNumber(123456789);
        self::$sgNumber = new PhoneNumber();
        self::$sgNumber->setCountryCode(65)->setNationalNumber(65218000);
        // A too-long and hence invalid US number.
        self::$usLongNumber = new PhoneNumber();
        self::$usLongNumber->setCountryCode(1)->setNationalNumber(65025300001);
        self::$usShortByOneNumber = new PhoneNumber();
        self::$usShortByOneNumber->setCountryCode(1)->setNationalNumber(650253000);
        self::$usTollFree = new PhoneNumber();
        self::$usTollFree->setCountryCode(1)->setNationalNumber(8002530000);
        self::$usNumber = new PhoneNumber();
        self::$usNumber->setCountryCode(1)->setNationalNumber(6502530000);
        self::$usLocalNumber = new PhoneNumber();
        self::$usLocalNumber->setCountryCode(1)->setNationalNumber(2530000);
        self::$nzNumber = new PhoneNumber();
        self::$nzNumber->setCountryCode(64)->setNationalNumber(33316005);
        self::$usPremium = new PhoneNumber();
        self::$usPremium->setCountryCode(1)->setNationalNumber(9002530000);
        self::$usSpoof = new PhoneNumber();
        self::$usSpoof->setCountryCode(1)->setNationalNumber(0);
        self::$usSpoofWithRawInput = new PhoneNumber();
        self::$usSpoofWithRawInput->setCountryCode(1)->setNationalNumber(0)->setRawInput("000-000-0000");
        self::$gbMobile = new PhoneNumber();
        self::$gbMobile->setCountryCode(44)->setNationalNumber(7912345678);
        self::$gbNumber = new PhoneNumber();
        self::$gbNumber->setCountryCode(44)->setNationalNumber(2070313000);
        self::$deShortNumber = new PhoneNumber();
        self::$deShortNumber->setCountryCode(49)->setNationalNumber(1234);
        self::$itMobile = new PhoneNumber();
        self::$itMobile->setCountryCode(39)->setNationalNumber(345678901);
        self::$itNumber = new PhoneNumber();
        self::$itNumber->setCountryCode(39)->setNationalNumber(236618300)->setItalianLeadingZero(true);
        self::$auNumber = new PhoneNumber();
        self::$auNumber->setCountryCode(61)->setNationalNumber(236618300);
        self::$arMobile = new PhoneNumber();
        self::$arMobile->setCountryCode(54)->setNationalNumber(91187654321);
        self::$arNumber = new PhoneNumber();
        self::$arNumber->setCountryCode(54)->setNationalNumber(1187654321);

        self::$mxMobile1 = new PhoneNumber();
        self::$mxMobile1->setCountryCode(52)->setNationalNumber(12345678900);
        self::$mxNumber1 = new PhoneNumber();
        self::$mxNumber1->setCountryCode(52)->setNationalNumber(3312345678);
        self::$mxMobile2 = new PhoneNumber();
        self::$mxMobile2->setCountryCode(52)->setNationalNumber(15512345678);
        self::$mxNumber2 = new PhoneNumber();
        self::$mxNumber2->setCountryCode(52)->setNationalNumber(8211234567);
        // Note that this is the same as the example number for DE in the metadata.
        self::$deNumber = new PhoneNumber();
        self::$deNumber->setCountryCode(49)->setNationalNumber(30123456);
        self::$jpStarNumber = new PhoneNumber();
        self::$jpStarNumber->setCountryCode(81)->setNationalNumber(2345);
        self::$alphaNumericNumber = new PhoneNumber();
        self::$alphaNumericNumber->setCountryCode(1)->setNationalNumber(80074935247);
        self::$aeUAN = new PhoneNumber();
        self::$aeUAN->setCountryCode(971)->setNationalNumber(600123456);
        self::$unknownCountryCodeNoRawInput = new PhoneNumber();
        self::$unknownCountryCodeNoRawInput->setCountryCode(2)->setNationalNumber(12345);

        PhoneNumberUtil::resetInstance();
        return PhoneNumberUtil::getInstance(
            self::TEST_META_DATA_FILE_PREFIX,
            CountryCodeToRegionCodeMapForTesting::$countryCodeToRegionCodeMapForTesting
        );
    }

    public function testGetSupportedRegions()
    {
        $this->assertGreaterThan(0, count($this->phoneUtil->getSupportedRegions()));
    }

    public function testGetSupportedGlobalNetworkCallingCodes()
    {
        $globalNetworkCallingCodes = $this->phoneUtil->getSupportedGlobalNetworkCallingCodes();

        $this->assertGreaterThan(0, count($globalNetworkCallingCodes));

        foreach ($globalNetworkCallingCodes as $callingCode)
        {
            $this->assertGreaterThan(0, $callingCode);
            $this->assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForCountryCode($callingCode));
        }
    }

    public function testGetInstanceLoadBadMetadata()
    {
        $this->assertNull($this->phoneUtil->getMetadataForRegion("No Such Region"));
        $this->assertNull($this->phoneUtil->getMetadataForRegion(-1));
    }

    public function testMissingMetadataFileThrowsRuntimeException()
    {
        // In normal usage we should never get a state where we are asking to load metadata that doesn't
        // exist. However if the library is packaged incorrectly, this could happen and the best we can
        // do is make sure the exception has the file name in it.

        try {
            $this->phoneUtil->loadMetadataFromFile("no/such/file", "XX", -1, new DefaultMetadataLoader());
            $this->fail("Expected Exception");
        } catch (\RuntimeException $e) {
            $this->assertContains('no/such/file_XX', $e->getMessage(), "Unexpected error: " . $e->getMessage());
        }

        try {
            $this->phoneUtil->loadMetadataFromFile(
                "no/such/file",
                PhoneNumberUtil::REGION_CODE_FOR_NON_GEO_ENTITY,
                123,
                new DefaultMetadataLoader()
            );
            $this->fail("Expected Exception");
        } catch (\RuntimeException $e) {
            $this->assertContains('no/such/file_123', $e->getMessage(), "Unexpected error: " . $e->getMessage());
        }
    }

    public function testGetInstanceLoadUSMetadata()
    {
        $metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::US);
        $this->assertEquals("US", $metadata->getId());
        $this->assertEquals(1, $metadata->getCountryCode());
        $this->assertEquals("011", $metadata->getInternationalPrefix());
        $this->assertTrue($metadata->hasNationalPrefix());
        $this->assertEquals(2, $metadata->numberFormatSize());
        $this->assertEquals("(\\d{3})(\\d{3})(\\d{4})", $metadata->getNumberFormat(1)->getPattern());
        $this->assertEquals("$1 $2 $3", $metadata->getNumberFormat(1)->getFormat());
        $this->assertEquals("[13-689]\\d{9}|2[0-35-9]\\d{8}", $metadata->getGeneralDesc()->getNationalNumberPattern());
        $this->assertEquals("\\d{7}(?:\\d{3})?", $metadata->getGeneralDesc()->getPossibleNumberPattern());
        $this->assertTrue($metadata->getGeneralDesc()->exactlySameAs($metadata->getFixedLine()));
        $this->assertEquals("\\d{10}", $metadata->getTollFree()->getPossibleNumberPattern());
        $this->assertEquals("900\\d{7}", $metadata->getPremiumRate()->getNationalNumberPattern());
        // No shared-cost data is available, so it should be initialised to "NA".
        $this->assertEquals("NA", $metadata->getSharedCost()->getNationalNumberPattern());
        $this->assertEquals("NA", $metadata->getSharedCost()->getPossibleNumberPattern());
    }

    public function testGetInstanceLoadDEMetadata()
    {
        $metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::DE);
        $this->assertEquals("DE", $metadata->getId());
        $this->assertEquals(49, $metadata->getCountryCode());
        $this->assertEquals("00", $metadata->getInternationalPrefix());
        $this->assertEquals("0", $metadata->getNationalPrefix());
        $this->assertEquals(6, $metadata->numberFormatSize());
        $this->assertEquals(1, $metadata->getNumberFormat(5)->leadingDigitsPatternSize());
        $this->assertEquals("900", $metadata->getNumberFormat(5)->getLeadingDigitsPattern(0));
        $this->assertEquals("(\\d{3})(\\d{3,4})(\\d{4})", $metadata->getNumberFormat(5)->getPattern());
        $this->assertEquals("$1 $2 $3", $metadata->getNumberFormat(5)->getFormat());
        $this->assertEquals(
            "(?:[24-6]\\d{2}|3[03-9]\\d|[789](?:[1-9]\\d|0[2-9]))\\d{1,8}",
            $metadata->getFixedLine()->getNationalNumberPattern()
        );
        $this->assertEquals("\\d{2,14}", $metadata->getFixedLine()->getPossibleNumberPattern());
        $this->assertEquals("30123456", $metadata->getFixedLine()->getExampleNumber());
        $this->assertEquals("\\d{10}", $metadata->getTollFree()->getPossibleNumberPattern());
        $this->assertEquals("900([135]\\d{6}|9\\d{7})", $metadata->getPremiumRate()->getNationalNumberPattern());
    }

    public function testGetInstanceLoadARMetadata()
    {
        $metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::AR);
        $this->assertEquals("AR", $metadata->getId());
        $this->assertEquals(54, $metadata->getCountryCode());
        $this->assertEquals("00", $metadata->getInternationalPrefix());
        $this->assertEquals("0", $metadata->getNationalPrefix());
        $this->assertEquals("0(?:(11|343|3715)15)?", $metadata->getNationalPrefixForParsing());
        $this->assertEquals("9$1", $metadata->getNationalPrefixTransformRule());
        $this->assertEquals("$2 15 $3-$4", $metadata->getNumberFormat(2)->getFormat());
        $this->assertEquals("(9)(\\d{4})(\\d{2})(\\d{4})", $metadata->getNumberFormat(3)->getPattern());
        $this->assertEquals("(9)(\\d{4})(\\d{2})(\\d{4})", $metadata->getIntlNumberFormat(3)->getPattern());
        $this->assertEquals("$1 $2 $3 $4", $metadata->getIntlNumberFormat(3)->getFormat());
    }

    public function testGetInstanceLoadInternationalTollFreeMetadata()
    {
        $metadata = $this->phoneUtil->getMetadataForNonGeographicalRegion(800);
        $this->assertEquals("001", $metadata->getId());
        $this->assertEquals(800, $metadata->getCountryCode());
        $this->assertEquals("$1 $2", $metadata->getNumberFormat(0)->getFormat());
        $this->assertEquals("(\\d{4})(\\d{4})", $metadata->getNumberFormat(0)->getPattern());
        $this->assertEquals("12345678", $metadata->getGeneralDesc()->getExampleNumber());
        $this->assertEquals("12345678", $metadata->getTollFree()->getExampleNumber());
    }

    public function testIsNumberGeographical()
    {
        $this->assertFalse($this->phoneUtil->isNumberGeographical(self::$bsMobile)); // Bahamas, mobile phone number.
        $this->assertTrue($this->phoneUtil->isNumberGeographical(self::$auNumber)); // Australian fixed line number.
        $this->assertFalse($this->phoneUtil->isNumberGeographical(self::$internationalTollFree)); // International toll
        // free number
    }

    public function testIsLeadingZeroPossible()
    {
        $this->assertTrue($this->phoneUtil->isLeadingZeroPossible(39)); // Italy
        $this->assertFalse($this->phoneUtil->isLeadingZeroPossible(1)); // USA
        $this->assertTrue($this->phoneUtil->isLeadingZeroPossible(800)); // International toll free numbers
        $this->assertFalse($this->phoneUtil->isLeadingZeroPossible(979)); // International premium-rate
        $this->assertFalse(
            $this->phoneUtil->isLeadingZeroPossible(888)
        ); // Not in metadata file, just default to false.
    }

    public function testGetLengthOfGeographicalAreaCode()
    {
        // Google MTV, which has area code "650".
        $this->assertEquals(3, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usNumber));

        // A North America toll-free number, which has no area code.
        $this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usTollFree));

        // Google London, which has area code "20".
        $this->assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$gbNumber));

        // A UK mobile phone, which has no area code.
        $this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$gbMobile));

        // Google Buenos Aires, which has area code "11".
        $this->assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$arNumber));

        // Google Sydney, which has area code "2".
        $this->assertEquals(1, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$auNumber));

        // Italian numbers - there is no national prefix, but it still has an area code.
        $this->assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$itNumber));

        // Google Singapore. Singapore has no area code and no national prefix.
        $this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$sgNumber));

        // An invalid US number (1 digit shorter), which has no area code.
        $this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usShortByOneNumber));

        // An international toll free number, which has no area code.
        $this->assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$internationalTollFree));
    }

    public function testGetLengthOfNationalDestinationCode()
    {
        // Google MTV, which has national destination code (NDC) "650".
        $this->assertEquals(3, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$usNumber));

        // A North America toll-free number, which has NDC "800".
        $this->assertEquals(3, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$usTollFree));

        // Google London, which has NDC "20".
        $this->assertEquals(2, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$gbNumber));

        // A UK mobile phone, which has NDC "7912".
        $this->assertEquals(4, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$gbMobile));

        // Google Buenos Aires, which has NDC "11".
        $this->assertEquals(2, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$arNumber));

        // An Argentinian mobile which has NDC "911".
        $this->assertEquals(3, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$arMobile));

        // Google Sydney, which has NDC "2".
        $this->assertEquals(1, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$auNumber));

        // Google Singapore, which has NDC "6521".
        $this->assertEquals(4, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$sgNumber));

        // An invalid US number (1 digit shorter), which has no NDC.
        $this->assertEquals(0, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$usShortByOneNumber));

        // A number containing an invalid country calling code, which shouldn't have any NDC.
        $number = new PhoneNumber();
        $number->setCountryCode(123)->setNationalNumber(6502530000);
        $this->assertEquals(0, $this->phoneUtil->getLengthOfNationalDestinationCode($number));

        // An international toll free number, which has NDC "1234".
        $this->assertEquals(4, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$internationalTollFree));
    }

    public function testGetCountryMobileToken()
    {
        $this->assertEquals(
            "1",
            $this->phoneUtil->getCountryMobileToken($this->phoneUtil->getCountryCodeForRegion(RegionCode::MX))
        );

        // Country calling code for Sweden, which has no mobile token.
        $this->assertEquals(
            "",
            $this->phoneUtil->getCountryMobileToken($this->phoneUtil->getCountryCodeForRegion(RegionCode::SE))
        );
    }

    public function testGetNationalSignificantNumber()
    {
        $this->assertEquals("6502530000", $this->phoneUtil->getNationalSignificantNumber(self::$usNumber));

        // An Italian mobile number.
        $this->assertEquals("345678901", $this->phoneUtil->getNationalSignificantNumber(self::$itMobile));

        // An Italian fixed line number.
        $this->assertEquals("0236618300", $this->phoneUtil->getNationalSignificantNumber(self::$itNumber));

        $this->assertEquals("12345678", $this->phoneUtil->getNationalSignificantNumber(self::$internationalTollFree));
    }

    public function testGetExampleNumber()
    {
        $this->assertEquals(self::$deNumber, $this->phoneUtil->getExampleNumber(RegionCode::DE));

        $this->assertEquals(
            self::$deNumber,
            $this->phoneUtil->getExampleNumberForType(RegionCode::DE, PhoneNumberType::FIXED_LINE)
        );
        $this->assertEquals(null, $this->phoneUtil->getExampleNumberForType(RegionCode::DE, PhoneNumberType::MOBILE));
        // For the US, the example number is placed under general description, and hence should be used
        // for both fixed line and mobile, so neither of these should return null.
        $this->assertNotNull($this->phoneUtil->getExampleNumberForType(RegionCode::US, PhoneNumberType::FIXED_LINE));
        $this->assertNotNull($this->phoneUtil->getExampleNumberForType(RegionCode::US, PhoneNumberType::MOBILE));
        // CS is an invalid region, so we have no data for it.
        $this->assertNull($this->phoneUtil->getExampleNumberForType(RegionCode::CS, PhoneNumberType::MOBILE));
        // RegionCode 001 is reserved for supporting non-geographical country calling code. We don't
        // support getting an example number for it with this method.
        $this->assertEquals(null, $this->phoneUtil->getExampleNumber(RegionCode::UN001));
    }

    public function testGetExampleNumberForNonGeoEntity()
    {
        $this->assertEquals(self::$internationalTollFree, $this->phoneUtil->getExampleNumberForNonGeoEntity(800));
        $this->assertEquals(self::$universalPremiumRate, $this->phoneUtil->getExampleNumberForNonGeoEntity(979));
    }

    public function testConvertAlphaCharactersInNumber()
    {
        $input = "1800-ABC-DEF";
        // Alpha chars are converted to digits; everything else is left untouched.
        $expectedOutput = "1800-222-333";
        $this->assertEquals($expectedOutput, $this->phoneUtil->convertAlphaCharactersInNumber($input));
    }

    public function testNormaliseRemovePunctuation()
    {
        $inputNumber = "034-56&+#2" . pack('H*', 'c2ad') . "34";
        $expectedOutput = "03456234";
        $this->assertEquals(
            $expectedOutput,
            $this->phoneUtil->normalize($inputNumber),
            "Conversion did not correctly remove punctuation"
        );
    }

    public function testNormaliseReplaceAlphaCharacters()
    {
        $inputNumber = "034-I-am-HUNGRY";
        $expectedOutput = "034426486479";
        $this->assertEquals(
            $expectedOutput,
            $this->phoneUtil->normalize($inputNumber),
            "Conversion did not correctly replace alpha characters"
        );
    }

    public function testNormaliseOtherDigits()
    {
        $inputNumber = "\xEF\xBC\x92" . "5\xD9\xA5" /* "２5٥" */
        ;
        $expectedOutput = "255";
        $this->assertEquals(
            $expectedOutput,
            $this->phoneUtil->normalize($inputNumber),
            "Conversion did not correctly replace non-latin digits"
        );
        // Eastern-Arabic digits.
        $inputNumber = "\xDB\xB5" . "2\xDB\xB0" /* "۵2۰" */
        ;
        $expectedOutput = "520";
        $this->assertEquals(
            $expectedOutput,
            $this->phoneUtil->normalize($inputNumber),
            "Conversion did not correctly replace non-latin digits"
        );
    }

    public function testNormaliseStripAlphaCharacters()
    {
        $inputNumber = "034-56&+a#234";
        $expectedOutput = "03456234";
        $this->assertEquals(
            $expectedOutput,
            $this->phoneUtil->normalizeDigitsOnly($inputNumber),
            "Conversion did not correctly remove alpha character"
        );
    }

    public function testNormaliseStripNonDiallableCharacters()
    {
        $inputNumber = "03*4-56&+a#234";
        $expectedOutput = "03*456+234";
        $this->assertEquals(
            $expectedOutput,
            $this->phoneUtil->normalizeDiallableCharsOnly($inputNumber),
            "Conversion did not correctly remove non-diallable characters"
        );
    }

    public function testFormatUSNumber()
    {
        $this->assertEquals("650 253 0000", $this->phoneUtil->format(self::$usNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+1 650 253 0000",
            $this->phoneUtil->format(self::$usNumber, PhoneNumberFormat::INTERNATIONAL)
        );

        $this->assertEquals("800 253 0000", $this->phoneUtil->format(self::$usTollFree, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+1 800 253 0000",
            $this->phoneUtil->format(self::$usTollFree, PhoneNumberFormat::INTERNATIONAL)
        );

        $this->assertEquals("900 253 0000", $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+1 900 253 0000",
            $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals(
            "tel:+1-900-253-0000",
            $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::RFC3966)
        );
        // Numbers with all zeros in the national number part will be formatted by using the raw_input
        // if that is available no matter which format is specified.
        $this->assertEquals(
            "000-000-0000",
            $this->phoneUtil->format(self::$usSpoofWithRawInput, PhoneNumberFormat::NATIONAL)
        );
        $this->assertEquals("0", $this->phoneUtil->format(self::$usSpoof, PhoneNumberFormat::NATIONAL));
    }

    public function testFormatBSNumber()
    {
        $this->assertEquals("242 365 1234", $this->phoneUtil->format(self::$bsNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+1 242 365 1234",
            $this->phoneUtil->format(self::$bsNumber, PhoneNumberFormat::INTERNATIONAL)
        );
    }

    public function testFormatGBNumber()
    {
        $this->assertEquals("(020) 7031 3000", $this->phoneUtil->format(self::$gbNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+44 20 7031 3000",
            $this->phoneUtil->format(self::$gbNumber, PhoneNumberFormat::INTERNATIONAL)
        );

        $this->assertEquals("(07912) 345 678", $this->phoneUtil->format(self::$gbMobile, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+44 7912 345 678",
            $this->phoneUtil->format(self::$gbMobile, PhoneNumberFormat::INTERNATIONAL)
        );
    }

    public function testFormatDENumber()
    {
        $deNumber = new PhoneNumber();
        $deNumber->setCountryCode(49)->setNationalNumber(301234);
        $this->assertEquals("030/1234", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals("+49 30/1234", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
        $this->assertEquals("tel:+49-30-1234", $this->phoneUtil->format($deNumber, PhoneNumberFormat::RFC3966));

        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber(291123);
        $this->assertEquals("0291 123", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals("+49 291 123", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));

        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber(29112345678);
        $this->assertEquals("0291 12345678", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals("+49 291 12345678", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));

        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber(912312345);
        $this->assertEquals("09123 12345", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals("+49 9123 12345", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber(80212345);
        $this->assertEquals("08021 2345", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals("+49 8021 2345", $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
        // Note this number is correctly formatted without national prefix. Most of the numbers that
        // are treated as invalid numbers by the library are short numbers, and they are usually not
        // dialed with national prefix.
        $this->assertEquals("1234", $this->phoneUtil->format(self::$deShortNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+49 1234",
            $this->phoneUtil->format(self::$deShortNumber, PhoneNumberFormat::INTERNATIONAL)
        );

        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber(41341234);
        $this->assertEquals("04134 1234", $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
    }

    public function testFormatITNumber()
    {
        $this->assertEquals("02 3661 8300", $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+39 02 3661 8300",
            $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+390236618300", $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::E164));

        $this->assertEquals("345 678 901", $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+39 345 678 901",
            $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+39345678901", $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::E164));
    }

    public function testFormatAUNumber()
    {
        $this->assertEquals("02 3661 8300", $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+61 2 3661 8300",
            $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+61236618300", $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::E164));

        $auNumber = new PhoneNumber();
        $auNumber->setCountryCode(61)->setNationalNumber(1800123456);
        $this->assertEquals("1800 123 456", $this->phoneUtil->format($auNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals("+61 1800 123 456", $this->phoneUtil->format($auNumber, PhoneNumberFormat::INTERNATIONAL));
        $this->assertEquals("+611800123456", $this->phoneUtil->format($auNumber, PhoneNumberFormat::E164));
    }

    public function testFormatARNumber()
    {
        $this->assertEquals("011 8765-4321", $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+54 11 8765-4321",
            $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+541187654321", $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::E164));

        $this->assertEquals("011 15 8765-4321", $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+54 9 11 8765 4321",
            $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+5491187654321", $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::E164));
    }

    public function testFormatMXNumber()
    {
        $this->assertEquals(
            "045 234 567 8900",
            $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::NATIONAL)
        );
        $this->assertEquals(
            "+52 1 234 567 8900",
            $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+5212345678900", $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::E164));

        $this->assertEquals(
            "045 55 1234 5678",
            $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::NATIONAL)
        );
        $this->assertEquals(
            "+52 1 55 1234 5678",
            $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+5215512345678", $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::E164));

        $this->assertEquals("01 33 1234 5678", $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+52 33 1234 5678",
            $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+523312345678", $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::E164));

        $this->assertEquals("01 821 123 4567", $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "+52 821 123 4567",
            $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::INTERNATIONAL)
        );
        $this->assertEquals("+528211234567", $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::E164));
    }

    public function testFormatOutOfCountryCallingNumber()
    {
        $this->assertEquals(
            "00 1 900 253 0000",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usPremium, RegionCode::DE)
        );
        $this->assertEquals(
            "1 650 253 0000",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::BS)
        );

        $this->assertEquals(
            "00 1 650 253 0000",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::PL)
        );

        $this->assertEquals(
            "011 44 7912 345 678",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$gbMobile, RegionCode::US)
        );

        $this->assertEquals(
            "00 49 1234",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$deShortNumber, RegionCode::GB)
        );
        // Note this number is correctly formatted without national prefix. Most of the numbers that
        // are treated as invalid numbers by the library are short numbers, and they are usually not
        // dialed with national prefix.
        $this->assertEquals(
            "1234",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$deShortNumber, RegionCode::DE)
        );

        $this->assertEquals(
            "011 39 02 3661 8300",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::US)
        );
        $this->assertEquals(
            "02 3661 8300",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::IT)
        );
        $this->assertEquals(
            "+39 02 3661 8300",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::SG)
        );

        $this->assertEquals(
            "6521 8000",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$sgNumber, RegionCode::SG)
        );

        $this->assertEquals(
            "011 54 9 11 8765 4321",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$arMobile, RegionCode::US)
        );
        $this->assertEquals(
            "011 800 1234 5678",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$internationalTollFree, RegionCode::US)
        );

        $arNumberWithExtn = new PhoneNumber();
        $arNumberWithExtn->mergeFrom(self::$arMobile)->setExtension("1234");
        $this->assertEquals(
            "011 54 9 11 8765 4321 ext. 1234",
            $this->phoneUtil->formatOutOfCountryCallingNumber($arNumberWithExtn, RegionCode::US)
        );
        $this->assertEquals(
            "0011 54 9 11 8765 4321 ext. 1234",
            $this->phoneUtil->formatOutOfCountryCallingNumber($arNumberWithExtn, RegionCode::AU)
        );
        $this->assertEquals(
            "011 15 8765-4321 ext. 1234",
            $this->phoneUtil->formatOutOfCountryCallingNumber($arNumberWithExtn, RegionCode::AR)
        );
    }

    public function testFormatOutOfCountryWithInvalidRegion()
    {
        // AQ/Antarctica isn't a valid region code for phone number formatting,
        // so this falls back to intl formatting.
        $this->assertEquals(
            "+1 650 253 0000",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::AQ)
        );
        // For region code 001, the out-of-country format always turns into the international format.
        $this->assertEquals(
            "+1 650 253 0000",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::UN001)
        );
    }

    public function testFormatOutOfCountryWithPreferredIntlPrefix()
    {
        // This should use 0011, since that is the preferred international prefix (both 0011 and 0012
        // are accepted as possible international prefixes in our test metadta.)
        $this->assertEquals(
            "0011 39 02 3661 8300",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::AU)
        );
    }

    public function testFormatOutOfCountryKeepingAlphaChars()
    {
        $alphaNumericNumber = new PhoneNumber();
        $alphaNumericNumber->setCountryCode(1)->setNationalNumber(8007493524)->setRawInput("1800 six-flag");
        $this->assertEquals(
            "0011 1 800 SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setRawInput("1-800-SIX-flag");
        $this->assertEquals(
            "0011 1 800-SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setRawInput("Call us from UK: 00 1 800 SIX-flag");
        $this->assertEquals(
            "0011 1 800 SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setRawInput("800 SIX-flag");
        $this->assertEquals(
            "0011 1 800 SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        // Formatting from within the NANPA region.
        $this->assertEquals(
            "1 800 SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::US)
        );

        $this->assertEquals(
            "1 800 SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::BS)
        );

        // Testing that if the raw input doesn't exist, it is formatted using
        // formatOutOfCountryCallingNumber.
        $alphaNumericNumber->clearRawInput();
        $this->assertEquals(
            "00 1 800 749 3524",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::DE)
        );

        // Testing AU alpha number formatted from Australia.
        $alphaNumericNumber->setCountryCode(61)->setNationalNumber(827493524)->setRawInput("+61 82749-FLAG");
        // This number should have the national prefix fixed.
        $this->assertEquals(
            "082749-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setRawInput("082749-FLAG");
        $this->assertEquals(
            "082749-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setNationalNumber(18007493524)->setRawInput("1-800-SIX-flag");
        // This number should not have the national prefix prefixed, in accordance with the override for
        // this specific formatting rule.
        $this->assertEquals(
            "1-800-SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        // The metadata should not be permanently changed, since we copied it before modifying patterns.
        // Here we check this.
        $alphaNumericNumber->setNationalNumber(1800749352);
        $this->assertEquals(
            "1800 749 352",
            $this->phoneUtil->formatOutOfCountryCallingNumber($alphaNumericNumber, RegionCode::AU)
        );

        // Testing a region with multiple international prefixes.
        $this->assertEquals(
            "+61 1-800-SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::SG)
        );
        // Testing the case of calling from a non-supported region.
        $this->assertEquals(
            "+61 1-800-SIX-FLAG",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AQ)
        );

        // Testing the case with an invalid country calling code.
        $alphaNumericNumber->setCountryCode(0)->setNationalNumber(18007493524)->setRawInput("1-800-SIX-flag");
        // Uses the raw input only.
        $this->assertEquals(
            "1-800-SIX-flag",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::DE)
        );

        // Testing the case of an invalid alpha number.
        $alphaNumericNumber->setCountryCode(1)->setNationalNumber(80749)->setRawInput("180-SIX");
        // No country-code stripping can be done.
        $this->assertEquals(
            "00 1 180-SIX",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::DE)
        );

        // Testing the case of calling from a non-supported region.
        $alphaNumericNumber->setCountryCode(1)->setNationalNumber(80749)->setRawInput("180-SIX");
        // No country-code stripping can be done since the number is invalid.
        $this->assertEquals(
            "+1 180-SIX",
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AQ)
        );
    }

    public function testFormatWithCarrierCode()
    {
        // We only support this for AR in our test metadata, and only for mobile numbers starting with
        // certain values.
        $arMobile = new PhoneNumber();
        $arMobile->setCountryCode(54)->setNationalNumber(92234654321);
        $this->assertEquals("02234 65-4321", $this->phoneUtil->format($arMobile, PhoneNumberFormat::NATIONAL));
        // Here we force 14 as the carrier code.
        $this->assertEquals(
            "02234 14 65-4321",
            $this->phoneUtil->formatNationalNumberWithCarrierCode($arMobile, "14")
        );
        // Here we force the number to be shown with no carrier code.
        $this->assertEquals(
            "02234 65-4321",
            $this->phoneUtil->formatNationalNumberWithCarrierCode($arMobile, "")
        );
        // Here the international rule is used, so no carrier code should be present.
        $this->assertEquals("+5492234654321", $this->phoneUtil->format($arMobile, PhoneNumberFormat::E164));
        // We don't support this for the US so there should be no change.
        $this->assertEquals(
            "650 253 0000",
            $this->phoneUtil->formatNationalNumberWithCarrierCode(self::$usNumber, "15")
        );

        // Invalid country code should just get the NSN.
        $this->assertEquals(
            "12345",
            $this->phoneUtil->formatNationalNumberWithCarrierCode(self::$unknownCountryCodeNoRawInput, "89")
        );
    }

    public function testFormatWithPreferredCarrierCode()
    {
        // We only support this for AR in our test metadata.
        $arNumber = new PhoneNumber();
        $arNumber->setCountryCode(54)->setNationalNumber(91234125678);
        // Test formatting with no preferred carrier code stored in the number itself.
        $this->assertEquals(
            "01234 15 12-5678",
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, "15")
        );
        $this->assertEquals(
            "01234 12-5678",
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, "")
        );
        // Test formatting with preferred carrier code present.
        $arNumber->setPreferredDomesticCarrierCode("19");
        $this->assertEquals("01234 12-5678", $this->phoneUtil->format($arNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "01234 19 12-5678",
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, "15")
        );
        $this->assertEquals(
            "01234 19 12-5678",
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, "")
        );
        // When the preferred_domestic_carrier_code is present (even when it contains an empty string),
        // use it instead of the default carrier code passed in.
        $arNumber->setPreferredDomesticCarrierCode("");
        $this->assertEquals(
            "01234 12-5678",
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, "15")
        );
        // We don't support this for the US so there should be no change.
        $usNumber = new PhoneNumber();
        $usNumber->setCountryCode(1)->setNationalNumber(4241231234)->setPreferredDomesticCarrierCode("99");
        $this->assertEquals("424 123 1234", $this->phoneUtil->format($usNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(
            "424 123 1234",
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($usNumber, "15")
        );
    }

    public function testFormatNumberForMobileDialing()
    {
        // Numbers are normally dialed in national format in-country, and international format from
        // outside the country.
        $this->assertEquals(
            "030123456",
            $this->phoneUtil->formatNumberForMobileDialing(self::$deNumber, RegionCode::DE, false)
        );
        $this->assertEquals(
            "+4930123456",
            $this->phoneUtil->formatNumberForMobileDialing(self::$deNumber, RegionCode::CH, false)
        );
        $this->assertEquals(
            "+4930123456",
            $this->phoneUtil->formatNumberForMobileDialing(self::$deNumber, RegionCode::CH, false)
        );
        $deNumberWithExtn = new PhoneNumber();
        $deNumberWithExtn->mergeFrom(self::$deNumber)->setExtension("1234");
        $this->assertEquals(
            "030123456",
            $this->phoneUtil->formatNumberForMobileDialing($deNumberWithExtn, RegionCode::DE, false)
        );
        $this->assertEquals(
            "+4930123456",
            $this->phoneUtil->formatNumberForMobileDialing($deNumberWithExtn, RegionCode::CH, false)
        );

        // US toll free numbers are marked as noInternationalDialling in the test metadata for testing
        // purposes. For such numbers, we expect nothing to be returned when the region code is not the
        // same one.
        $this->assertEquals(
            "800 253 0000",
            $this->phoneUtil->formatNumberForMobileDialing(
                self::$usTollFree,
                RegionCode::US,
                true /*  keep formatting */
            )
        );
        $this->assertEquals(
            "",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usTollFree, RegionCode::CN, true)
        );
        $this->assertEquals(
            "+1 650 253 0000",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::US, true)
        );
        $usNumberWithExtn = new PhoneNumber();
        $usNumberWithExtn->mergeFrom(self::$usNumber)->setExtension("1234");
        $this->assertEquals(
            "+1 650 253 0000",
            $this->phoneUtil->formatNumberForMobileDialing($usNumberWithExtn, RegionCode::US, true)
        );

        $this->assertEquals(
            "8002530000",
            $this->phoneUtil->formatNumberForMobileDialing(
                self::$usTollFree,
                RegionCode::US,
                false /* remove formatting */
            )
        );
        $this->assertEquals(
            "",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usTollFree, RegionCode::CN, false)
        );
        $this->assertEquals(
            "+16502530000",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::US, false)
        );
        $this->assertEquals(
            "+16502530000",
            $this->phoneUtil->formatNumberForMobileDialing($usNumberWithExtn, RegionCode::US, false)
        );

        // An invalid US number, which is one digit too long.
        $this->assertEquals(
            "+165025300001",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usLongNumber, RegionCode::US, false)
        );
        $this->assertEquals(
            "+1 65025300001",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usLongNumber, RegionCode::US, true)
        );

        // Star numbers. In real life they appear in Israel, but we have them in JP in our test
        // metadata.
        $this->assertEquals(
            "*2345",
            $this->phoneUtil->formatNumberForMobileDialing(self::$jpStarNumber, RegionCode::JP, false)
        );
        $this->assertEquals(
            "*2345",
            $this->phoneUtil->formatNumberForMobileDialing(self::$jpStarNumber, RegionCode::JP, true)
        );

        $this->assertEquals(
            "+80012345678",
            $this->phoneUtil->formatNumberForMobileDialing(self::$internationalTollFree, RegionCode::JP, false)
        );
        $this->assertEquals(
            "+800 1234 5678",
            $this->phoneUtil->formatNumberForMobileDialing(self::$internationalTollFree, RegionCode::JP, true)
        );

        // UAE numbers beginning with 600 (classified as UAN) need to be dialled without +971 locally.
        $this->assertEquals(
            "+971600123456",
            $this->phoneUtil->formatNumberForMobileDialing(self::$aeUAN, RegionCode::JP, false)
        );
        $this->assertEquals(
            "600123456",
            $this->phoneUtil->formatNumberForMobileDialing(self::$aeUAN, RegionCode::AE, false)
        );

        $this->assertEquals(
            "+523312345678",
            $this->phoneUtil->formatNumberForMobileDialing(self::$mxNumber1, RegionCode::MX, false)
        );
        $this->assertEquals(
            "+523312345678",
            $this->phoneUtil->formatNumberForMobileDialing(self::$mxNumber1, RegionCode::US, false)
        );

        // Non-geographical numbers should always be dialed in international format.
        $this->assertEquals(
            "+80012345678",
            $this->phoneUtil->formatNumberForMobileDialing(self::$internationalTollFree, RegionCode::US, false)
        );
        $this->assertEquals(
            "+80012345678",
            $this->phoneUtil->formatNumberForMobileDialing(self::$internationalTollFree, RegionCode::UN001, false)
        );

        // Test that a short number is formatted correctly for mobile dialing within the region,
        // and is not diallable from outside the region.
        $deShortNumber = new PhoneNumber();
        $deShortNumber->setCountryCode(49)->setNationalNumber(123);
        $this->assertEquals(
            "123",
            $this->phoneUtil->formatNumberForMobileDialing($deShortNumber, RegionCode::DE, false)
        );
        $this->assertEquals("", $this->phoneUtil->formatNumberForMobileDialing($deShortNumber, RegionCode::IT, false));

        // Test the special logic for Hungary, where the national prefix must be added before dialing
        // from a mobile phone for regular length numbers, but not for short numbers.
        $huRegularNumber = new PhoneNumber();
        $huRegularNumber->setCountryCode(36)->setNationalNumber(301234567);
        $this->assertEquals(
            "06301234567",
            $this->phoneUtil->formatNumberForMobileDialing($huRegularNumber, RegionCode::HU, false)
        );
        $this->assertEquals(
            "+36301234567",
            $this->phoneUtil->formatNumberForMobileDialing($huRegularNumber, RegionCode::JP, false)
        );
        $huShortNumber = new PhoneNumber();
        $huShortNumber->setCountryCode(36)->setNationalNumber(104);
        $this->assertEquals(
            "104",
            $this->phoneUtil->formatNumberForMobileDialing($huShortNumber, RegionCode::HU, false)
        );
        $this->assertEquals("", $this->phoneUtil->formatNumberForMobileDialing($huShortNumber, RegionCode::JP, false));

        // Test the special logic for NANPA countries, for which regular length phone numbers are always
        // output in international format, but short numbers are in national format.
        $this->assertEquals(
            "+16502530000",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::US, false)
        );
        $this->assertEquals(
            "+16502530000",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::CA, false)
        );
        $this->assertEquals(
            "+16502530000",
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::BR, false)
        );
        $usShortNumber = new PhoneNumber();
        $usShortNumber->setCountryCode(1)->setNationalNumber(911);
        $this->assertEquals(
            "911",
            $this->phoneUtil->formatNumberForMobileDialing($usShortNumber, RegionCode::US, false)
        );
        $this->assertEquals("", $this->phoneUtil->formatNumberForMobileDialing($usShortNumber, RegionCode::CA, false));
        $this->assertEquals("", $this->phoneUtil->formatNumberForMobileDialing($usShortNumber, RegionCode::BR, false));

        // Test that the Australian emergency number 000 is formatted correctly.
        $auNumber = new PhoneNumber();
        $auNumber->setCountryCode(61)->setNationalNumber(0)->setItalianLeadingZero(true)->setNumberOfLeadingZeros(2);
        $this->assertEquals("000", $this->phoneUtil->formatNumberForMobileDialing($auNumber, RegionCode::AU, false));
        $this->assertEquals("", $this->phoneUtil->formatNumberForMobileDialing($auNumber, RegionCode::NZ, false));
    }

    public function testFormatByPattern()
    {
        $newNumFormat = new NumberFormat();
        $newNumFormat->setPattern("(\\d{3})(\\d{3})(\\d{4})");
        $newNumFormat->setFormat("($1) $2-$3");
        $newNumberFormats = array();
        $newNumberFormats[] = $newNumFormat;

        $this->assertEquals(
            "(650) 253-0000",
            $this->phoneUtil->formatByPattern(
                self::$usNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );
        $this->assertEquals(
            "+1 (650) 253-0000",
            $this->phoneUtil->formatByPattern(
                self::$usNumber,
                PhoneNumberFormat::INTERNATIONAL,
                $newNumberFormats
            )
        );
        $this->assertEquals(
            "tel:+1-650-253-0000",
            $this->phoneUtil->formatByPattern(
                self::$usNumber,
                PhoneNumberFormat::RFC3966,
                $newNumberFormats
            )
        );

        // $NP is set to '1' for the US. Here we check that for other NANPA countries the US rules are
        // followed.
        $newNumFormat->setNationalPrefixFormattingRule('$NP ($FG)');
        $newNumFormat->setFormat("$1 $2-$3");
        $this->assertEquals(
            "1 (242) 365-1234",
            $this->phoneUtil->formatByPattern(
                self::$bsNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );
        $this->assertEquals(
            "+1 242 365-1234",
            $this->phoneUtil->formatByPattern(
                self::$bsNumber,
                PhoneNumberFormat::INTERNATIONAL,
                $newNumberFormats
            )
        );

        $newNumFormat->setPattern("(\\d{2})(\\d{5})(\\d{3})");
        $newNumFormat->setFormat("$1-$2 $3");
        $newNumberFormats[0] = $newNumFormat;

        $this->assertEquals(
            "02-36618 300",
            $this->phoneUtil->formatByPattern(
                self::$itNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );
        $this->assertEquals(
            "+39 02-36618 300",
            $this->phoneUtil->formatByPattern(
                self::$itNumber,
                PhoneNumberFormat::INTERNATIONAL,
                $newNumberFormats
            )
        );

        $newNumFormat->setNationalPrefixFormattingRule('$NP$FG');
        $newNumFormat->setPattern("(\\d{2})(\\d{4})(\\d{4})");
        $newNumFormat->setFormat("$1 $2 $3");
        $newNumberFormats[0] = $newNumFormat;
        $this->assertEquals(
            "020 7031 3000",
            $this->phoneUtil->formatByPattern(
                self::$gbNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );

        $newNumFormat->setNationalPrefixFormattingRule('($NP$FG)');
        $this->assertEquals(
            "(020) 7031 3000",
            $this->phoneUtil->formatByPattern(
                self::$gbNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );

        $newNumFormat->setNationalPrefixFormattingRule("");
        $this->assertEquals(
            "20 7031 3000",
            $this->phoneUtil->formatByPattern(
                self::$gbNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );

        $this->assertEquals(
            "+44 20 7031 3000",
            $this->phoneUtil->formatByPattern(
                self::$gbNumber,
                PhoneNumberFormat::INTERNATIONAL,
                $newNumberFormats
            )
        );
    }

    public function testFormatE164Number()
    {
        $this->assertEquals("+16502530000", $this->phoneUtil->format(self::$usNumber, PhoneNumberFormat::E164));
        $this->assertEquals("+4930123456", $this->phoneUtil->format(self::$deNumber, PhoneNumberFormat::E164));
        $this->assertEquals(
            "+80012345678",
            $this->phoneUtil->format(self::$internationalTollFree, PhoneNumberFormat::E164)
        );
    }

    public function testFormatNumberWithExtension()
    {
        $nzNumber = new PhoneNumber();
        $nzNumber->mergeFrom(self::$nzNumber)->setExtension("1234");
        // Uses default extension prefix:
        $this->assertEquals("03-331 6005 ext. 1234", $this->phoneUtil->format($nzNumber, PhoneNumberFormat::NATIONAL));
        // Uses RFC 3966 syntax.
        $this->assertEquals(
            "tel:+64-3-331-6005;ext=1234",
            $this->phoneUtil->format($nzNumber, PhoneNumberFormat::RFC3966)
        );
        // Extension prefix overridden in the territory information for the US:
        $usNumberWithExtension = new PhoneNumber();
        $usNumberWithExtension->mergeFrom(self::$usNumber)->setExtension("4567");
        $this->assertEquals(
            "650 253 0000 extn. 4567",
            $this->phoneUtil->format($usNumberWithExtension, PhoneNumberFormat::NATIONAL)
        );
    }

    public function testFormatInOriginalFormat()
    {
        $number1 = $this->phoneUtil->parseAndKeepRawInput("+442087654321", RegionCode::GB);
        $this->assertEquals("+44 20 8765 4321", $this->phoneUtil->formatInOriginalFormat($number1, RegionCode::GB));

        $number2 = $this->phoneUtil->parseAndKeepRawInput("02087654321", RegionCode::GB);
        $this->assertEquals("(020) 8765 4321", $this->phoneUtil->formatInOriginalFormat($number2, RegionCode::GB));

        $number3 = $this->phoneUtil->parseAndKeepRawInput("011442087654321", RegionCode::US);
        $this->assertEquals("011 44 20 8765 4321", $this->phoneUtil->formatInOriginalFormat($number3, RegionCode::US));

        $number4 = $this->phoneUtil->parseAndKeepRawInput("442087654321", RegionCode::GB);
        $this->assertEquals("44 20 8765 4321", $this->phoneUtil->formatInOriginalFormat($number4, RegionCode::GB));

        $number5 = $this->phoneUtil->parse("+442087654321", RegionCode::GB);
        $this->assertEquals("(020) 8765 4321", $this->phoneUtil->formatInOriginalFormat($number5, RegionCode::GB));

        // Invalid numbers that we have a formatting pattern for should be formatted properly. Note area
        // codes starting with 7 are intentionally excluded in the test metadata for testing purposes.
        $number6 = $this->phoneUtil->parseAndKeepRawInput("7345678901", RegionCode::US);
        $this->assertEquals("734 567 8901", $this->phoneUtil->formatInOriginalFormat($number6, RegionCode::US));

        // US is not a leading zero country, and the presence of the leading zero leads us to format the
        // number using raw_input.
        $number7 = $this->phoneUtil->parseAndKeepRawInput("0734567 8901", RegionCode::US);
        $this->assertEquals("0734567 8901", $this->phoneUtil->formatInOriginalFormat($number7, RegionCode::US));

        // This number is valid, but we don't have a formatting pattern for it. Fall back to the raw
        // input.
        $number8 = $this->phoneUtil->parseAndKeepRawInput("02-4567-8900", RegionCode::KR);
        $this->assertEquals("02-4567-8900", $this->phoneUtil->formatInOriginalFormat($number8, RegionCode::KR));

        $number9 = $this->phoneUtil->parseAndKeepRawInput("01180012345678", RegionCode::US);
        $this->assertEquals("011 800 1234 5678", $this->phoneUtil->formatInOriginalFormat($number9, RegionCode::US));

        $number10 = $this->phoneUtil->parseAndKeepRawInput("+80012345678", RegionCode::KR);
        $this->assertEquals("+800 1234 5678", $this->phoneUtil->formatInOriginalFormat($number10, RegionCode::KR));

        // US local numbers are formatted correctly, as we have formatting patterns for them.
        $localNumberUS = $this->phoneUtil->parseAndKeepRawInput("2530000", RegionCode::US);
        $this->assertEquals("253 0000", $this->phoneUtil->formatInOriginalFormat($localNumberUS, RegionCode::US));

        $numberWithNationalPrefixUS =
            $this->phoneUtil->parseAndKeepRawInput("18003456789", RegionCode::US);
        $this->assertEquals(
            "1 800 345 6789",
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixUS, RegionCode::US)
        );

        $numberWithoutNationalPrefixGB =
            $this->phoneUtil->parseAndKeepRawInput("2087654321", RegionCode::GB);
        $this->assertEquals(
            "20 8765 4321",
            $this->phoneUtil->formatInOriginalFormat($numberWithoutNationalPrefixGB, RegionCode::GB)
        );
        // Make sure no metadata is modified as a result of the previous function call.
        $this->assertEquals("(020) 8765 4321", $this->phoneUtil->formatInOriginalFormat($number5, RegionCode::GB));

        $numberWithNationalPrefixMX =
            $this->phoneUtil->parseAndKeepRawInput("013312345678", RegionCode::MX);
        $this->assertEquals(
            "01 33 1234 5678",
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixMX, RegionCode::MX)
        );

        $numberWithoutNationalPrefixMX =
            $this->phoneUtil->parseAndKeepRawInput("3312345678", RegionCode::MX);
        $this->assertEquals(
            "33 1234 5678",
            $this->phoneUtil->formatInOriginalFormat($numberWithoutNationalPrefixMX, RegionCode::MX)
        );

        $italianFixedLineNumber =
            $this->phoneUtil->parseAndKeepRawInput("0212345678", RegionCode::IT);
        $this->assertEquals(
            "02 1234 5678",
            $this->phoneUtil->formatInOriginalFormat($italianFixedLineNumber, RegionCode::IT)
        );

        $numberWithNationalPrefixJP =
            $this->phoneUtil->parseAndKeepRawInput("00777012", RegionCode::JP);
        $this->assertEquals(
            "0077-7012",
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixJP, RegionCode::JP)
        );

        $numberWithoutNationalPrefixJP =
            $this->phoneUtil->parseAndKeepRawInput("0777012", RegionCode::JP);
        $this->assertEquals(
            "0777012",
            $this->phoneUtil->formatInOriginalFormat($numberWithoutNationalPrefixJP, RegionCode::JP)
        );

        $numberWithCarrierCodeBR =
            $this->phoneUtil->parseAndKeepRawInput("012 3121286979", RegionCode::BR);
        $this->assertEquals(
            "012 3121286979",
            $this->phoneUtil->formatInOriginalFormat($numberWithCarrierCodeBR, RegionCode::BR)
        );

        // The default national prefix used in this case is 045. When a number with national prefix 044
        // is entered, we return the raw input as we don't want to change the number entered.
        $numberWithNationalPrefixMX1 =
            $this->phoneUtil->parseAndKeepRawInput("044(33)1234-5678", RegionCode::MX);
        $this->assertEquals(
            "044(33)1234-5678",
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixMX1, RegionCode::MX)
        );

        $numberWithNationalPrefixMX2 =
            $this->phoneUtil->parseAndKeepRawInput("045(33)1234-5678", RegionCode::MX);
        $this->assertEquals(
            "045 33 1234 5678",
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixMX2, RegionCode::MX)
        );

        // The default international prefix used in this case is 0011. When a number with international
        // prefix 0012 is entered, we return the raw input as we don't want to change the number
        // entered.
        $outOfCountryNumberFromAU1 =
            $this->phoneUtil->parseAndKeepRawInput("0012 16502530000", RegionCode::AU);
        $this->assertEquals(
            "0012 16502530000",
            $this->phoneUtil->formatInOriginalFormat($outOfCountryNumberFromAU1, RegionCode::AU)
        );

        $outOfCountryNumberFromAU2 =
            $this->phoneUtil->parseAndKeepRawInput("0011 16502530000", RegionCode::AU);
        $this->assertEquals(
            "0011 1 650 253 0000",
            $this->phoneUtil->formatInOriginalFormat($outOfCountryNumberFromAU2, RegionCode::AU)
        );

        // Test the star sign is not removed from or added to the original input by this method.
        $starNumber = $this->phoneUtil->parseAndKeepRawInput("*1234", RegionCode::JP);
        $this->assertEquals("*1234", $this->phoneUtil->formatInOriginalFormat($starNumber, RegionCode::JP));
        $numberWithoutStar = $this->phoneUtil->parseAndKeepRawInput("1234", RegionCode::JP);
        $this->assertEquals("1234", $this->phoneUtil->formatInOriginalFormat($numberWithoutStar, RegionCode::JP));

        // Test an invalid national number without raw input is just formatted as the national number.
        $this->assertEquals(
            "650253000",
            $this->phoneUtil->formatInOriginalFormat(self::$usShortByOneNumber, RegionCode::US)
        );
    }

    public function testIsPremiumRate()
    {
        $this->assertEquals(PhoneNumberType::PREMIUM_RATE, $this->phoneUtil->getNumberType(self::$usPremium));

        $premiumRateNumber = new PhoneNumber();
        $premiumRateNumber->setCountryCode(39)->setNationalNumber(892123);
        $this->assertEquals(
            PhoneNumberType::PREMIUM_RATE,
            $this->phoneUtil->getNumberType($premiumRateNumber)
        );

        $premiumRateNumber->clear();
        $premiumRateNumber->setCountryCode(44)->setNationalNumber(9187654321);
        $this->assertEquals(
            PhoneNumberType::PREMIUM_RATE,
            $this->phoneUtil->getNumberType($premiumRateNumber)
        );

        $premiumRateNumber->clear();
        $premiumRateNumber->setCountryCode(49)->setNationalNumber(9001654321);
        $this->assertEquals(
            PhoneNumberType::PREMIUM_RATE,
            $this->phoneUtil->getNumberType($premiumRateNumber)
        );

        $premiumRateNumber->clear();
        $premiumRateNumber->setCountryCode(49)->setNationalNumber(90091234567);
        $this->assertEquals(
            PhoneNumberType::PREMIUM_RATE,
            $this->phoneUtil->getNumberType($premiumRateNumber)
        );
    }

    public function testIsTollFree()
    {
        $tollFreeNumber = new PhoneNumber();

        $tollFreeNumber->setCountryCode(1)->setNationalNumber(8881234567);
        $this->assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType($tollFreeNumber)
        );

        $tollFreeNumber->clear();
        $tollFreeNumber->setCountryCode(39)->setNationalNumber(803123);
        $this->assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType($tollFreeNumber)
        );

        $tollFreeNumber->clear();
        $tollFreeNumber->setCountryCode(44)->setNationalNumber(8012345678);
        $this->assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType($tollFreeNumber)
        );

        $tollFreeNumber->clear();
        $tollFreeNumber->setCountryCode(49)->setNationalNumber(8001234567);
        $this->assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType($tollFreeNumber)
        );

        $this->assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType(self::$internationalTollFree)
        );
    }

    public function testIsMobile()
    {
        $this->assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType(self::$bsMobile));
        $this->assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType(self::$gbMobile));
        $this->assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType(self::$itMobile));
        $this->assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType(self::$arMobile));

        $mobileNumber = new PhoneNumber();
        $mobileNumber->setCountryCode(49)->setNationalNumber(15123456789);
        $this->assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType($mobileNumber));
    }

    public function testIsFixedLine()
    {
        $this->assertEquals(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getNumberType(self::$bsNumber));
        $this->assertEquals(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getNumberType(self::$itNumber));
        $this->assertEquals(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getNumberType(self::$gbNumber));
        $this->assertEquals(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getNumberType(self::$deNumber));
    }

    public function testIsFixedLineAndMobile()
    {
        $this->assertEquals(PhoneNumberType::FIXED_LINE_OR_MOBILE, $this->phoneUtil->getNumberType(self::$usNumber));

        $fixedLineAndMobileNumber = new PhoneNumber();
        $fixedLineAndMobileNumber->setCountryCode(54)->setNationalNumber(1987654321);
        $this->assertEquals(
            PhoneNumberType::FIXED_LINE_OR_MOBILE,
            $this->phoneUtil->getNumberType($fixedLineAndMobileNumber)
        );
    }

    public function testIsSharedCost()
    {
        $gbNumber = new PhoneNumber();
        $gbNumber->setCountryCode(44)->setNationalNumber(8431231234);
        $this->assertEquals(PhoneNumberType::SHARED_COST, $this->phoneUtil->getNumberType($gbNumber));
    }

    public function testIsVoip()
    {
        $gbNumber = new PhoneNumber();
        $gbNumber->setCountryCode(44)->setNationalNumber(5631231234);
        $this->assertEquals(PhoneNumberType::VOIP, $this->phoneUtil->getNumberType($gbNumber));
    }

    public function testIsPersonalNumber()
    {
        $gbNumber = new PhoneNumber();
        $gbNumber->setCountryCode(44)->setNationalNumber(7031231234);
        $this->assertEquals(PhoneNumberType::PERSONAL_NUMBER, $this->phoneUtil->getNumberType($gbNumber));
    }

    public function testIsUnknown()
    {
        // Invalid numbers should be of type UNKNOWN.
        $this->assertEquals(PhoneNumberType::UNKNOWN, $this->phoneUtil->getNumberType(self::$usLocalNumber));
    }

    public function testIsValidNumber()
    {
        $this->assertTrue($this->phoneUtil->isValidNumber(self::$usNumber));
        $this->assertTrue($this->phoneUtil->isValidNumber(self::$itNumber));
        $this->assertTrue($this->phoneUtil->isValidNumber(self::$gbMobile));
        $this->assertTrue($this->phoneUtil->isValidNumber(self::$internationalTollFree));
        $this->assertTrue($this->phoneUtil->isValidNumber(self::$universalPremiumRate));

        $nzNumber = new PhoneNumber();
        $nzNumber->setCountryCode(64)->setNationalNumber(21387835);
        $this->assertTrue($this->phoneUtil->isValidNumber($nzNumber));
    }

    public function testIsValidForRegion()
    {
        // This number is valid for the Bahamas, but is not a valid US number.
        $this->assertTrue($this->phoneUtil->isValidNumber(self::$bsNumber));
        $this->assertTrue($this->phoneUtil->isValidNumberForRegion(self::$bsNumber, RegionCode::BS));
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion(self::$bsNumber, RegionCode::US));
        $bsInvalidNumber = new PhoneNumber();
        $bsInvalidNumber->setCountryCode(1)->setNationalNumber(2421232345);
        // This number is no longer valid.
        $this->assertFalse($this->phoneUtil->isValidNumber($bsInvalidNumber));

        // La Mayotte and Reunion use 'leadingDigits' to differentiate them.
        $reNumber = new PhoneNumber();
        $reNumber->setCountryCode(262)->setNationalNumber(262123456);
        $this->assertTrue($this->phoneUtil->isValidNumber($reNumber));
        $this->assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
        // Now change the number to be a number for La Mayotte.
        $reNumber->setNationalNumber(269601234);
        $this->assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
        // This number is no longer valid for La Reunion.
        $reNumber->setNationalNumber(269123456);
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
        $this->assertFalse($this->phoneUtil->isValidNumber($reNumber));
        // However, it should be recognised as from La Mayotte, since it is valid for this region.
        $this->assertEquals(RegionCode::YT, $this->phoneUtil->getRegionCodeForNumber($reNumber));
        // This number is valid in both places.
        $reNumber->setNationalNumber(800123456);
        $this->assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
        $this->assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
        $this->assertTrue($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::UN001));
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::US));
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::ZZ));

        $invalidNumber = new PhoneNumber();
        // Invalid country calling codes.
        $invalidNumber->setCountryCode(3923)->setNationalNumber(2366);
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::ZZ));
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::UN001));
        $invalidNumber->setCountryCode(0);
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::UN001));
        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::ZZ));
    }

    public function testIsNotValidNumber()
    {
        $this->assertFalse($this->phoneUtil->isValidNumber(self::$usLocalNumber));

        $invalidNumber = new PhoneNumber();
        $invalidNumber->setCountryCode(39)->setNationalNumber(23661830000)->setItalianLeadingZero(true);
        $this->assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $invalidNumber->clear();
        $invalidNumber->setCountryCode(44)->setNationalNumber(791234567);
        $this->assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $invalidNumber->clear();
        $invalidNumber->setCountryCode(49)->setNationalNumber(1234);
        $this->assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $invalidNumber->clear();
        $invalidNumber->setCountryCode(64)->setNationalNumber(3316005);
        $this->assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $invalidNumber->clear();
        // Invalid country calling codes.
        $invalidNumber->setCountryCode(3923)->setNationalNumber(2366);
        $this->assertFalse($this->phoneUtil->isValidNumber($invalidNumber));
        $invalidNumber->setCountryCode(0);
        $this->assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $this->assertFalse($this->phoneUtil->isValidNumber(self::$internationalTollFreeTooLong));
    }

    public function testGetRegionCodeForCountryCode()
    {
        $this->assertEquals(RegionCode::US, $this->phoneUtil->getRegionCodeForCountryCode(1));
        $this->assertEquals(RegionCode::GB, $this->phoneUtil->getRegionCodeForCountryCode(44));
        $this->assertEquals(RegionCode::DE, $this->phoneUtil->getRegionCodeForCountryCode(49));
        $this->assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForCountryCode(800));
        $this->assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForCountryCode(979));
    }

    public function testGetRegionCodeForNumber()
    {
        $this->assertEquals(RegionCode::BS, $this->phoneUtil->getRegionCodeForNumber(self::$bsNumber));
        $this->assertEquals(RegionCode::US, $this->phoneUtil->getRegionCodeForNumber(self::$usNumber));
        $this->assertEquals(RegionCode::GB, $this->phoneUtil->getRegionCodeForNumber(self::$gbMobile));
        $this->assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForNumber(self::$internationalTollFree));
        $this->assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForNumber(self::$universalPremiumRate));
    }

    public function testGetRegionCodesForCountryCode()
    {
        $regionCodesForNANPA = $this->phoneUtil->getRegionCodesForCountryCode(1);
        $this->assertContains(RegionCode::US, $regionCodesForNANPA);
        $this->assertContains(RegionCode::BS, $regionCodesForNANPA);
        $this->assertContains(RegionCode::GB, $this->phoneUtil->getRegionCodesForCountryCode(44));
        $this->assertContains(RegionCode::DE, $this->phoneUtil->getRegionCodesForCountryCode(49));
        $this->assertContains(RegionCode::UN001, $this->phoneUtil->getRegionCodesForCountryCode(800));
        // Test with invalid country calling code.
        $this->assertEmpty($this->phoneUtil->getRegionCodesForCountryCode(-1));
    }

    public function testGetCountryCodeForRegion()
    {
        $this->assertEquals(1, $this->phoneUtil->getCountryCodeForRegion(RegionCode::US));
        $this->assertEquals(64, $this->phoneUtil->getCountryCodeForRegion(RegionCode::NZ));
        $this->assertEquals(0, $this->phoneUtil->getCountryCodeForRegion(null));
        $this->assertEquals(0, $this->phoneUtil->getCountryCodeForRegion(RegionCode::ZZ));
        $this->assertEquals(0, $this->phoneUtil->getCountryCodeForRegion(RegionCode::UN001));
        // CS is already deprecated so the library doesn't support it
        $this->assertEquals(0, $this->phoneUtil->getCountryCodeForRegion(RegionCode::CS));
    }

    public function testGetNationalDiallingPrefixForRegion()
    {
        $this->assertEquals("1", $this->phoneUtil->getNddPrefixForRegion(RegionCode::US, false));
        // Test non-main country to see it gets the national dialling prefix for the main country with
        // that country calling code.
        $this->assertEquals("1", $this->phoneUtil->getNddPrefixForRegion(RegionCode::BS, false));
        $this->assertEquals("0", $this->phoneUtil->getNddPrefixForRegion(RegionCode::NZ, false));
        // Test case with non digit in the national prefix.
        $this->assertEquals("0~0", $this->phoneUtil->getNddPrefixForRegion(RegionCode::AO, false));
        $this->assertEquals("00", $this->phoneUtil->getNddPrefixForRegion(RegionCode::AO, true));
        // Test cases with invalid regions.
        $this->assertNull($this->phoneUtil->getNddPrefixForRegion(null, false));
        $this->assertNull($this->phoneUtil->getNddPrefixForRegion(RegionCode::ZZ, false));
        $this->assertNull($this->phoneUtil->getNddPrefixForRegion(RegionCode::UN001, false));
        // CS is already deprecated so the library doesn't support it.
        $this->assertNull($this->phoneUtil->getNddPrefixForRegion(RegionCode::CS, false));
    }

    public function testIsNANPACountry()
    {
        $this->assertTrue($this->phoneUtil->isNANPACountry(RegionCode::US));
        $this->assertTrue($this->phoneUtil->isNANPACountry(RegionCode::BS));
        $this->assertFalse($this->phoneUtil->isNANPACountry(RegionCode::DE));
        $this->assertFalse($this->phoneUtil->isNANPACountry(RegionCode::ZZ));
        $this->assertFalse($this->phoneUtil->isNANPACountry(RegionCode::UN001));
        $this->assertFalse($this->phoneUtil->isNANPACountry(null));
    }

    public function testIsPossibleNumber()
    {
        $this->assertTrue($this->phoneUtil->isPossibleNumber(self::$usNumber));
        $this->assertTrue($this->phoneUtil->isPossibleNumber(self::$usLocalNumber));
        $this->assertTrue($this->phoneUtil->isPossibleNumber(self::$gbNumber));
        $this->assertTrue($this->phoneUtil->isPossibleNumber(self::$internationalTollFree));

        $this->assertTrue($this->phoneUtil->isPossibleNumber("+1 650 253 0000", RegionCode::US));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("+1 650 GOO OGLE", RegionCode::US));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("(650) 253-0000", RegionCode::US));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("253-0000", RegionCode::US));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("+1 650 253 0000", RegionCode::GB));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("+44 20 7031 3000", RegionCode::GB));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("(020) 7031 3000", RegionCode::GB));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("7031 3000", RegionCode::GB));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("3331 6005", RegionCode::NZ));
        $this->assertTrue($this->phoneUtil->isPossibleNumber("+800 1234 5678", RegionCode::UN001));
    }

    public function testIsPossibleNumberWithReason()
    {
        // National numbers for country calling code +1 that are within 7 to 10 digits are possible.
        $this->assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberWithReason(self::$usNumber)
        );

        $this->assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberWithReason(self::$usLocalNumber)
        );

        $this->assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberWithReason(self::$usLongNumber)
        );

        $number = new PhoneNumber();
        $number->setCountryCode(0)->setNationalNumber(2530000);
        $this->assertEquals(
            ValidationResult::INVALID_COUNTRY_CODE,
            $this->phoneUtil->isPossibleNumberWithReason($number)
        );

        $number->clear();
        $number->setCountryCode(1)->setNationalNumber(253000);
        $this->assertEquals(ValidationResult::TOO_SHORT, $this->phoneUtil->isPossibleNumberWithReason($number));

        $number->clear();
        $number->setCountryCode(65)->setNationalNumber(1234567890);
        $this->assertEquals(ValidationResult::IS_POSSIBLE, $this->phoneUtil->isPossibleNumberWithReason($number));

        $this->assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberWithReason(self::$internationalTollFreeTooLong)
        );
    }

    public function testIsNotPossibleNumber()
    {
        $this->assertFalse($this->phoneUtil->isPossibleNumber(self::$usLongNumber));
        $this->assertFalse($this->phoneUtil->isPossibleNumber(self::$internationalTollFreeTooLong));

        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber(253000);
        $this->assertFalse($this->phoneUtil->isPossibleNumber($number));

        $number->clear();
        $number->setCountryCode(44)->setNationalNumber(300);
        $this->assertFalse($this->phoneUtil->isPossibleNumber($number));
        $this->assertFalse($this->phoneUtil->isPossibleNumber("+1 650 253 00000", RegionCode::US));
        $this->assertFalse($this->phoneUtil->isPossibleNumber("(650) 253-00000", RegionCode::US));
        $this->assertFalse($this->phoneUtil->isPossibleNumber("I want a Pizza", RegionCode::US));
        $this->assertFalse($this->phoneUtil->isPossibleNumber("253-000", RegionCode::US));
        $this->assertFalse($this->phoneUtil->isPossibleNumber("1 3000", RegionCode::GB));
        $this->assertFalse($this->phoneUtil->isPossibleNumber("+44 300", RegionCode::GB));
        $this->assertFalse($this->phoneUtil->isPossibleNumber("+800 1234 5678 9", RegionCode::UN001));

    }

    public function testTruncateTooLongNumber()
    {
        // GB number 080 1234 5678, but entered with 4 extra digits at the end.
        $tooLongNumber = new PhoneNumber();
        $tooLongNumber->setCountryCode(44)->setNationalNumber(80123456780123);
        $validNumber = new PhoneNumber();
        $validNumber->setCountryCode(44)->setNationalNumber(8012345678);
        $this->assertTrue($this->phoneUtil->truncateTooLongNumber($tooLongNumber));
        $this->assertEquals($validNumber, $tooLongNumber);

        // IT number 022 3456 7890, but entered with 3 extra digits at the end.
        $tooLongNumber->clear();
        $tooLongNumber->setCountryCode(39)->setNationalNumber(2234567890123)->setItalianLeadingZero(true);
        $validNumber->clear();
        $validNumber->setCountryCode(39)->setNationalNumber(2234567890)->setItalianLeadingZero(true);
        $this->assertTrue($this->phoneUtil->truncateTooLongNumber($tooLongNumber));
        $this->assertEquals($validNumber, $tooLongNumber);

        // US number 650-253-0000, but entered with one additional digit at the end.
        $tooLongNumber->clear();
        $tooLongNumber->mergeFrom(self::$usLongNumber);
        $this->assertTrue($this->phoneUtil->truncateTooLongNumber($tooLongNumber));
        $this->assertEquals(self::$usNumber, $tooLongNumber);

        $tooLongNumber->clear();
        $tooLongNumber->mergeFrom(self::$internationalTollFreeTooLong);
        $this->assertTrue($this->phoneUtil->truncateTooLongNumber($tooLongNumber));
        $this->assertEquals(self::$internationalTollFree, $tooLongNumber);

        // Tests what happens when a valid number is passed in.
        $validNumberCopy = new PhoneNumber();
        $validNumberCopy->mergeFrom($validNumber);
        $this->assertTrue($this->phoneUtil->truncateTooLongNumber($validNumber));

        // Tests the number is not modified.
        $this->assertEquals($validNumberCopy, $validNumber);

        // Tests what happens when a number with invalid prefix is passed in.
        $numberWithInvalidPrefix = new PhoneNumber();
        // The test metadata says US numbers cannot have prefix 240.
        $numberWithInvalidPrefix->setCountryCode(1)->setNationalNumber(2401234567);
        $invalidNumberCopy = new PhoneNumber();
        $invalidNumberCopy->mergeFrom($numberWithInvalidPrefix);
        $this->assertFalse($this->phoneUtil->truncateTooLongNumber($numberWithInvalidPrefix));
        // Tests the number is not modified.
        $this->assertEquals($invalidNumberCopy, $numberWithInvalidPrefix);

        // Tests what happens when a too short number is passed in.
        $tooShortNumber = new PhoneNumber();
        $tooShortNumber->setCountryCode(1)->setNationalNumber(1234);
        $tooShortNumberCopy = new PhoneNumber();
        $tooShortNumberCopy->mergeFrom($tooShortNumber);
        $this->assertFalse($this->phoneUtil->truncateTooLongNumber($tooShortNumber));
        // Tests the number is not modified.
        $this->assertEquals($tooShortNumberCopy, $tooShortNumber);
    }

    public function testIsViablePhoneNumber()
    {
        $this->assertFalse(PhoneNumberUtil::isViablePhoneNumber("1"));
        // Only one or two digits before strange non-possible punctuation.
        $this->assertFalse(PhoneNumberUtil::isViablePhoneNumber("1+1+1"));
        $this->assertFalse(PhoneNumberUtil::isViablePhoneNumber("80+0"));
        // Two digits is viable.
        $this->assertTrue(PhoneNumberUtil::isViablePhoneNumber("00"));
        $this->assertTrue(PhoneNumberUtil::isViablePhoneNumber("111"));
        // Alpha numbers.
        $this->assertTrue(PhoneNumberUtil::isViablePhoneNumber("0800-4-pizza"));
        $this->assertTrue(PhoneNumberUtil::isViablePhoneNumber("0800-4-PIZZA"));

        // We need at least three digits before any alpha characters.
        $this->assertFalse(PhoneNumberUtil::isViablePhoneNumber("08-PIZZA"));
        $this->assertFalse(PhoneNumberUtil::isViablePhoneNumber("8-PIZZA"));
        $this->assertFalse(PhoneNumberUtil::isViablePhoneNumber("12. March"));
    }

    public function testIsViablePhoneNumberNonAscii()
    {
        // Only one or two digits before possible punctuation followed by more digits.
        $this->assertTrue(PhoneNumberUtil::isViablePhoneNumber("1" . pack('H*', 'e38080') . "34"));
        $this->assertFalse(PhoneNumberUtil::isViablePhoneNumber("1" . pack('H*', 'e38080') . "3+4"));
        // Unicode variants of possible starting character and other allowed punctuation/digits.
        $this->assertTrue(
            PhoneNumberUtil::isViablePhoneNumber(
                pack('H*', 'efbc88') . "1" . pack("H*", 'efbc89') . pack('H*', 'e38080') . "3456789"
            )
        );
        // Testing a leading + is okay.
        $this->assertTrue(
            PhoneNumberUtil::isViablePhoneNumber("+1" . pack("H*", 'efbc89') . pack('H*', 'e38080') . "3456789")
        );
    }

    public function testExtractPossibleNumber()
    {
        // Removes preceding funky punctuation and letters but leaves the rest untouched.
        $this->assertEquals("0800-345-600", PhoneNumberUtil::extractPossibleNumber("Tel:0800-345-600"));
        $this->assertEquals("0800 FOR PIZZA", PhoneNumberUtil::extractPossibleNumber("Tel:0800 FOR PIZZA"));
        // Should not remove plus sign
        $this->assertEquals("+800-345-600", PhoneNumberUtil::extractPossibleNumber("Tel:+800-345-600"));
        // Should recognise wide digits as possible start values.
        $this->assertEquals(
            pack("H*", 'efbc90') . pack("H*", 'efbc92') . pack("H*", 'efbc93'),
            PhoneNumberUtil::extractPossibleNumber(pack("H*", 'efbc90') . pack("H*", 'efbc92') . pack("H*", 'efbc93'))
        );
        // Dashes are not possible start values and should be removed.
        $this->assertEquals(
            pack("H*", 'efbc91') . pack("H*", 'efbc92') . pack("H*", 'efbc93'),
            PhoneNumberUtil::extractPossibleNumber(
                "Num-" . pack("H*", 'efbc91') . pack("H*", 'efbc92') . pack("H*", 'efbc93')
            )
        );
        // If not possible number present, return empty string.
        $this->assertEquals("", PhoneNumberUtil::extractPossibleNumber("Num-...."));
        // Leading brackets are stripped - these are not used when parsing.
        $this->assertEquals("650) 253-0000", PhoneNumberUtil::extractPossibleNumber("(650) 253-0000"));

        // Trailing non-alpha-numeric characters should be removed.
        $this->assertEquals("650) 253-0000", PhoneNumberUtil::extractPossibleNumber("(650) 253-0000..- .."));
        $this->assertEquals("650) 253-0000", PhoneNumberUtil::extractPossibleNumber("(650) 253-0000."));
        // This case has a trailing RTL char.
        $this->assertEquals(
            "650) 253-0000",
            PhoneNumberUtil::extractPossibleNumber("(650) 253-0000" . pack("H*", 'e2808f'))
        );
    }

    public function testMaybeStripNationalPrefix()
    {
        $metadata = new PhoneMetadata();
        $metadata->setNationalPrefixForParsing("34");
        $phoneNumberDesc = new PhoneNumberDesc();
        $phoneNumberDesc->setNationalNumberPattern("\\d{4,8}");
        $metadata->setGeneralDesc($phoneNumberDesc);

        $numberToStrip = "34356778";
        $strippedNumber = "356778";

        $carrierCode = null;

        $this->assertTrue(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        $this->assertEquals($strippedNumber, $numberToStrip, "Should have had national prefix stripped.");
        // Retry stripping - now the number should not start with the national prefix, so no more
        // stripping should occur.
        $carrierCode = null;
        $this->assertFalse(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        $this->assertEquals($strippedNumber, $numberToStrip, "Should have had no change - no national prefix present.");

        // Some countries have no national prefix. Repeat test with none specified.
        $metadata->setNationalPrefixForParsing("");
        $carrierCode = null;
        $this->assertFalse(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        $this->assertEquals($strippedNumber, $numberToStrip, "Should not strip anything with empty national prefix.");

        // If the resultant number doesn't match the national rule, it shouldn't be stripped.
        $metadata->setNationalPrefixForParsing("3");
        $numberToStrip = "3123";
        $strippedNumber = "3123";
        $carrierCode = null;
        $this->assertFalse(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        $this->assertEquals(
            $strippedNumber,
            $numberToStrip,
            "Should have had no change - after stripping, it wouldn't have matched the national rule."
        );

        // Test extracting carrier selection code.
        $metadata->setNationalPrefixForParsing("0(81)?");
        $numberToStrip = "08122123456";
        $strippedNumber = "22123456";
        $carrierCode = "";
        $this->assertTrue(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        $this->assertEquals("81", $carrierCode);
        $this->assertEquals(
            $strippedNumber,
            $numberToStrip,
            "Should have had national prefix and carrier code stripped."
        );

        // If there was a transform rule, check it was applied.
        $metadata->setNationalPrefixTransformRule("5\${1}5");
        // Note that a capturing group is present here.
        $metadata->setNationalPrefixForParsing("0(\\d{2})");
        $numberToStrip = "031123";
        $transformedNumber = "5315123";
        $carrierCode = null;
        $this->assertTrue(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        $this->assertEquals($transformedNumber, $numberToStrip, "Should transform the 031 to a 5315.");
    }

    public function testMaybeStripInternationalPrefix()
    {
        $internationalPrefix = "00[39]";
        $numberToStrip = "0034567700-3898003";
        // Note the dash is removed as part of the normalization.
        $strippedNumber = "45677003898003";
        $this->assertEquals(
            CountryCodeSource::FROM_NUMBER_WITH_IDD,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        $this->assertEquals(
            $strippedNumber,
            $numberToStrip,
            "The number supplied was not stripped of its international prefix."
        );

        // Now the number no longer starts with an IDD prefix, so it should now report
        // FROM_DEFAULT_COUNTRY.
        $this->assertEquals(
            CountryCodeSource::FROM_DEFAULT_COUNTRY,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );

        $numberToStrip = "00945677003898003";
        $this->assertEquals(
            CountryCodeSource::FROM_NUMBER_WITH_IDD,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        $this->assertEquals(
            $strippedNumber,
            $numberToStrip,
            "The number supplied was not stripped of its international prefix."
        );

        // Test it works when the international prefix is broken up by spaces.
        $numberToStrip = "00 9 45677003898003";
        $this->assertEquals(
            CountryCodeSource::FROM_NUMBER_WITH_IDD,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        $this->assertEquals(
            $strippedNumber,
            $numberToStrip,
            "The number supplied was not stripped of its international prefix."
        );

        // Now the number no longer starts with an IDD prefix, so it should now report
        // FROM_DEFAULT_COUNTRY.
        $this->assertEquals(
            CountryCodeSource::FROM_DEFAULT_COUNTRY,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );

        // Test the + symbol is also recognised and stripped.
        $numberToStrip = "+45677003898003";
        $strippedNumber = "45677003898003";
        $this->assertEquals(
            CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        $this->assertEquals(
            $strippedNumber,
            $numberToStrip,
            "The number supplied was not stripped of the plus symbol."
        );

        // If the number afterwards is a zero, we should not strip this - no country calling code begins
        // with 0.
        $numberToStrip = "0090112-3123";
        $strippedNumber = "00901123123";
        $this->assertEquals(
            CountryCodeSource::FROM_DEFAULT_COUNTRY,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        $this->assertEquals(
            $strippedNumber,
            $numberToStrip,
            "The number supplied had a 0 after the match so shouldn't be stripped."
        );

        // Here the 0 is separated by a space from the IDD.
        $numberToStrip = "009 0-112-3123";
        $this->assertEquals(
            CountryCodeSource::FROM_DEFAULT_COUNTRY,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
    }

    public function testMaybeExtractCountryCode()
    {
        $number = new PhoneNumber();
        $metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::US);
        // Note that for the US, the IDD is 011.
        try {
            $phoneNumber = "011112-3456789";
            $strippedNumber = "123456789";
            $countryCallingCode = 1;
            $numberToFill = "";
            $this->assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                "Did not extract country calling code " . $countryCallingCode . " correctly."
            );
            $this->assertEquals(
                CountryCodeSource::FROM_NUMBER_WITH_IDD,
                $number->getCountryCodeSource(),
                "Did not figure out CountryCodeSource correctly"
            );
            // Should strip and normalize national significant number.
            $this->assertEquals(
                $strippedNumber,
                $numberToFill,
                "Did not strip off the country calling code correctly."
            );
        } catch (NumberParseException $e) {
            $this->fail("Should not have thrown an exception: " . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = "+6423456789";
            $countryCallingCode = 64;
            $numberToFill = "";
            $this->assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                "Did not extract country calling code " . $countryCallingCode . " correctly."
            );
            $this->assertEquals(
                CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN,
                $number->getCountryCodeSource(),
                "Did not figure out CountryCodeSource correctly"
            );
        } catch (NumberParseException $e) {
            $this->fail("Should not have thrown an exception: " . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = "+80012345678";
            $countryCallingCode = 800;
            $numberToFill = "";
            $this->assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                "Did not extract country calling code " . $countryCallingCode . " correctly."
            );
            $this->assertEquals(
                CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN,
                $number->getCountryCodeSource(),
                "Did not figure out CountryCodeSource correctly"
            );
        } catch (NumberParseException $e) {
            $this->fail("Should not have thrown an exception: " . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = "2345-6789";
            $numberToFill = "";
            $this->assertEquals(
                0,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                "Should not have extracted a country calling code - no international prefix present."
            );
            $this->assertEquals(
                CountryCodeSource::FROM_DEFAULT_COUNTRY,
                $number->getCountryCodeSource(),
                "Did not figure out CountryCodeSource correctly"
            );
        } catch (NumberParseException $e) {
            $this->fail("Should not have thrown an exception: " . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = "0119991123456789";
            $numberToFill = "";
            $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number);
            $this->fail("Should have thrown an exception, no valid country calling code present.");
        } catch (NumberParseException $e) {
            // Expected.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }
        $number->clear();
        try {
            $phoneNumber = "(1 610) 619 4466";
            $countryCallingCode = 1;
            $numberToFill = "";
            $this->assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                "Should have extracted the country calling code of the region passed in"
            );
            $this->assertEquals(
                CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN,
                $number->getCountryCodeSource(),
                "Did not figure out CountryCodeSource correctly"
            );
        } catch (NumberParseException $e) {
            $this->fail("Should not have thrown an exception: " . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = "(1 610) 619 4466";
            $countryCallingCode = 1;
            $numberToFill = "";
            $this->assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, false, $number),
                "Should have extracted the country calling code of the region passed in"
            );
            $this->assertFalse($number->hasCountryCodeSource(), "Should not contain CountryCodeSource");
        } catch (NumberParseException $e) {
            $this->fail("Should not have thrown an exception: " . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = "(1 610) 619 446";
            $numberToFill = "";
            $this->assertEquals(
                0,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, false, $number),
                "Should not have extracted a country calling code - invalid number after extraction of uncertain country calling code."
            );
            $this->assertFalse($number->hasCountryCodeSource(), "Should not contain CountryCodeSource");
        } catch (NumberParseException $e) {
            $this->fail("Should not have thrown an exception: " . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = "(1 610) 619";
            $numberToFill = "";
            $this->assertEquals(
                0,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                "Should not have extracted a country calling code - too short number both before and after extraction of uncertain country calling code."
            );
            $this->assertEquals(
                CountryCodeSource::FROM_DEFAULT_COUNTRY,
                $number->getCountryCodeSource(),
                "Did not figure out CountryCodeSource correctly"
            );
        } catch (NumberParseException $e) {
            $this->fail("Should not have thrown an exception: " . $e->getMessage());
        }
    }

    public function testParseNationalNumber()
    {
        // National prefix attached.
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("033316005", RegionCode::NZ));
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("33316005", RegionCode::NZ));
        // National prefix attached and some formatting present.
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("03-331 6005", RegionCode::NZ));
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("03 331 6005", RegionCode::NZ));

        // Test parsing RFC3966 format with a phone context.
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("tel:03-331-6005;phone-context=+64", RegionCode::NZ)
        );
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("tel:331-6005;phone-context=+64-3", RegionCode::NZ)
        );
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("tel:331-6005;phone-context=+64-3", RegionCode::US)
        );
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("My number is tel:03-331-6005;phone-context=+64", RegionCode::NZ)
        );
        // Test parsing RFC3966 format with optional user-defined parameters. The parameters will appear
        // after the context if present.
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("tel:03-331-6005;phone-context=+64;a=%A1", RegionCode::NZ)
        );
        // Test parsing RFC3966 with an ISDN subaddress.
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("tel:03-331-6005;isub=12345;phone-context=+64", RegionCode::NZ)
        );
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("tel:+64-3-331-6005;isub=12345", RegionCode::NZ));

        // Test parsing RFC3966 with "tel:" missing
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("03-331-6005;phone-context=+64", RegionCode::NZ));

        // Testing international prefixes.
        // Should strip country calling code.
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("0064 3 331 6005", RegionCode::NZ));
        // Try again, but this time we have an international number with Region Code US. It should
        // recognise the country calling code and parse accordingly.
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("01164 3 331 6005", RegionCode::US));
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("+64 3 331 6005", RegionCode::US));
        // We should ignore the leading plus here, since it is not followed by a valid country code but
        // instead is followed by the IDD for the US.
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("+01164 3 331 6005", RegionCode::US));
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("+0064 3 331 6005", RegionCode::NZ));
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("+ 00 64 3 331 6005", RegionCode::NZ));

        $this->assertEquals(
            self::$usLocalNumber,
            $this->phoneUtil->parse("tel:253-0000;phone-context=www.google.com", RegionCode::US)
        );
        $this->assertEquals(
            self::$usLocalNumber,
            $this->phoneUtil->parse("tel:253-0000;isub=12345;phone-context=www.google.com", RegionCode::US)
        );
        // This is invalid because no "+" sign is present as part of phone-context. The phone context
        // is simply ignored in this case just as if it contains a domain.
        $this->assertEquals(
            self::$usLocalNumber,
            $this->phoneUtil->parse("tel:2530000;isub=12345;phone-context=1-650", RegionCode::US)
        );
        $this->assertEquals(
            self::$usLocalNumber,
            $this->phoneUtil->parse("tel:2530000;isub=12345;phone-context=1234.com", RegionCode::US)
        );

        $nzNumber = new PhoneNumber();
        $nzNumber->setCountryCode(64)->setNationalNumber(64123456);
        $this->assertEquals($nzNumber, $this->phoneUtil->parse("64(0)64123456", RegionCode::NZ));
        // Check that using a "/" is fine in a phone number.
        $this->assertEquals(self::$deNumber, $this->phoneUtil->parse("301/23456", RegionCode::DE));

        $usNumber = new PhoneNumber();
        // Check it doesn't use the '1' as a country calling code when parsing if the phone number was
        // already possible.
        $usNumber->setCountryCode(1)->setNationalNumber(1234567890);
        $this->assertEquals($usNumber, $this->phoneUtil->parse("123-456-7890", RegionCode::US));

        // Test star numbers. Although this is not strictly valid, we would like to make sure we can
        // parse the output we produce when formatting the number.
        $this->assertEquals(self::$jpStarNumber, $this->phoneUtil->parse("+81 *2345", RegionCode::JP));

        $shortNumber = new PhoneNumber();
        $shortNumber->setCountryCode(64)->setNationalNumber(12);
        $this->assertEquals($shortNumber, $this->phoneUtil->parse("12", RegionCode::NZ));
    }

    public function testParseNumberWithAlphaCharacters()
    {
        // Test case with alpha characters.
        $tollFreeNumber = new PhoneNumber();
        $tollFreeNumber->setCountryCode(64)->setNationalNumber(800332005);
        $this->assertEquals($tollFreeNumber, $this->phoneUtil->parse("0800 DDA 005", RegionCode::NZ));

        $premiumNumber = new PhoneNumber();
        $premiumNumber->setCountryCode(64)->setNationalNumber(9003326005);
        $this->assertEquals($premiumNumber, $this->phoneUtil->parse("0900 DDA 6005", RegionCode::NZ));

        // Not enough alpha characters for them to be considered intentional, so they are stripped.
        $this->assertEquals($premiumNumber, $this->phoneUtil->parse("0900 332 6005a", RegionCode::NZ));
        $this->assertEquals($premiumNumber, $this->phoneUtil->parse("0900 332 600a5", RegionCode::NZ));
        $this->assertEquals($premiumNumber, $this->phoneUtil->parse("0900 332 600A5", RegionCode::NZ));
        $this->assertEquals($premiumNumber, $this->phoneUtil->parse("0900 a332 600A5", RegionCode::NZ));
    }

    public function testParseMaliciousInput()
    {
        // Lots of leading + signs before the possible number.
        $maliciousNumber = str_repeat("+", 6000);
        $maliciousNumber .= "12222-33-244 extensioB 343+";

        try {
            $this->phoneUtil->parse($maliciousNumber, RegionCode::US);
            $this->fail("This should not parse without throwing an exception " . $maliciousNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::TOO_LONG,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        $maliciousNumberWithAlmostExt = str_repeat("200", 350);
        $maliciousNumberWithAlmostExt .= " extensiOB 345";
        try {
            $this->phoneUtil->parse($maliciousNumberWithAlmostExt, RegionCode::US);
            $this->fail("This should not parse without throwing an exception " . $maliciousNumberWithAlmostExt);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::TOO_LONG,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }
    }

    public function testParseWithInternationalPrefixes()
    {
        $this->assertEquals(self::$usNumber, $this->phoneUtil->parse("+1 (650) 253-0000", RegionCode::NZ));
        $this->assertEquals(self::$internationalTollFree, $this->phoneUtil->parse("011 800 1234 5678", RegionCode::US));
        $this->assertEquals(self::$usNumber, $this->phoneUtil->parse("1-650-253-0000", RegionCode::US));
        // Calling the US number from Singapore by using different service providers
        // 1st test: calling using SingTel IDD service (IDD is 001)
        $this->assertEquals(self::$usNumber, $this->phoneUtil->parse("0011-650-253-0000", RegionCode::SG));
        // 2nd test: calling using StarHub IDD service (IDD is 008)
        $this->assertEquals(self::$usNumber, $this->phoneUtil->parse("0081-650-253-0000", RegionCode::SG));
        // 3rd test: calling using SingTel V019 service (IDD is 019)
        $this->assertEquals(self::$usNumber, $this->phoneUtil->parse("0191-650-253-0000", RegionCode::SG));
        // Calling the US number from Poland
        $this->assertEquals(self::$usNumber, $this->phoneUtil->parse("0~01-650-253-0000", RegionCode::PL));
        // Using "++" at the start.
        $this->assertEquals(self::$usNumber, $this->phoneUtil->parse("++1 (650) 253-0000", RegionCode::PL));
    }

    public function testParseNonAscii()
    {
        // Using a full-width plus sign.
        $this->assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse(pack("H*", 'efbc8b') . "1 (650) 253-0000", RegionCode::SG)
        );
        // Using a soft hyphen U+00AD.
        $this->assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse("1 (650) 253" . pack("H*", 'c2ad') . "-0000", RegionCode::US)
        );
        // The whole number, including punctuation, is here represented in full-width form.
        $this->assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse(
                pack("H*", 'efbc8b') . pack("H*", 'efbc91') . pack("H*", 'e38080') .
                pack("H*", 'efbc88') . pack("H*", 'efbc96') . pack("H*", 'efbc95') . pack("H*", 'efbc90') . pack(
                    "H*",
                    'efbc89'
                ) .
                pack("H*", 'e38080') . pack("H*", 'efbc92') . pack("H*", 'efbc95') . pack("H*", 'efbc93') . pack(
                    "H*",
                    'efbc8d'
                ) .
                pack("H*", 'efbc90') . pack("H*", 'efbc90') . pack("H*", 'efbc90') . pack("H*", 'efbc90'),
                RegionCode::SG
            )
        );
        // Using U+30FC dash instead.
        $this->assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse(
                pack("H*", 'efbc8b') . pack("H*", 'efbc91') . pack("H*", 'e38080') .
                pack("H*", 'efbc88') . pack("H*", 'efbc96') . pack("H*", 'efbc95') . pack("H*", 'efbc90') . pack(
                    "H*",
                    'efbc89'
                ) .
                pack("H*", 'e38080') . pack("H*", 'efbc92') . pack("H*", 'efbc95') . pack("H*", 'efbc93') . pack(
                    "H*",
                    'e383bc'
                ) .
                pack("H*", 'efbc90') . pack("H*", 'efbc90') . pack("H*", 'efbc90') . pack("H*", 'efbc90'),
                RegionCode::SG
            )
        );
        // Using a very strange decimal digit range (Mongolian digits).
        $this->assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse(
                pack('H*', 'e1a091') . " "
                . pack('H*', 'e1a096') . pack('H*', 'e1a095') . pack('H*', 'e1a090') . " "
                . pack('H*', 'e1a092') . pack('H*', 'e1a095') . pack('H*', 'e1a093') . " "
                . pack('H*', 'e1a090') . pack('H*', 'e1a090') . pack('H*', 'e1a090') . pack('H*', 'e1a090'),
                RegionCode::US
            )
        );
    }

    public function testParseWithLeadingZero()
    {
        $this->assertEquals(self::$itNumber, $this->phoneUtil->parse("+39 02-36618 300", RegionCode::NZ));
        $this->assertEquals(self::$itNumber, $this->phoneUtil->parse("02-36618 300", RegionCode::IT));

        $this->assertEquals(self::$itMobile, $this->phoneUtil->parse("345 678 901", RegionCode::IT));
    }

    public function testParseNationalNumberArgentina()
    {
        // Test parsing mobile numbers of Argentina.
        $arNumber = new PhoneNumber();
        $arNumber->setCountryCode(54)->setNationalNumber(93435551212);
        $this->assertEquals($arNumber, $this->phoneUtil->parse("+54 9 343 555 1212", RegionCode::AR));
        $this->assertEquals($arNumber, $this->phoneUtil->parse("0343 15 555 1212", RegionCode::AR));

        $arNumber->clear();
        $arNumber->setCountryCode(54)->setNationalNumber(93715654320);
        $this->assertEquals($arNumber, $this->phoneUtil->parse("+54 9 3715 65 4320", RegionCode::AR));
        $this->assertEquals($arNumber, $this->phoneUtil->parse("03715 15 65 4320", RegionCode::AR));
        $this->assertEquals(self::$arMobile, $this->phoneUtil->parse("911 876 54321", RegionCode::AR));

        // Test parsing fixed-line numbers of Argentina.
        $this->assertEquals(self::$arNumber, $this->phoneUtil->parse("+54 11 8765 4321", RegionCode::AR));
        $this->assertEquals(self::$arNumber, $this->phoneUtil->parse("011 8765 4321", RegionCode::AR));

        $arNumber->clear();
        $arNumber->setCountryCode(54)->setNationalNumber(3715654321);
        $this->assertEquals($arNumber, $this->phoneUtil->parse("+54 3715 65 4321", RegionCode::AR));
        $this->assertEquals($arNumber, $this->phoneUtil->parse("03715 65 4321", RegionCode::AR));

        $arNumber->clear();
        $arNumber->setCountryCode(54)->setNationalNumber(2312340000);
        $this->assertEquals($arNumber, $this->phoneUtil->parse("+54 23 1234 0000", RegionCode::AR));
        $this->assertEquals($arNumber, $this->phoneUtil->parse("023 1234 0000", RegionCode::AR));
    }

    public function testParseWithXInNumber()
    {
        // Test that having an 'x' in the phone number at the start is ok and that it just gets removed.
        $this->assertEquals(self::$arNumber, $this->phoneUtil->parse("01187654321", RegionCode::AR));
        $this->assertEquals(self::$arNumber, $this->phoneUtil->parse("(0) 1187654321", RegionCode::AR));
        $this->assertEquals(self::$arNumber, $this->phoneUtil->parse("0 1187654321", RegionCode::AR));
        $this->assertEquals(self::$arNumber, $this->phoneUtil->parse("(0xx) 1187654321", RegionCode::AR));

        $arFromUs = new PhoneNumber();
        $arFromUs->setCountryCode(54)->setNationalNumber(81429712);
        // This test is intentionally constructed such that the number of digit after xx is larger than
        // 7, so that the number won't be mistakenly treated as an extension, as we allow extensions up
        // to 7 digits. This assumption is okay for now as all the countries where a carrier selection
        // code is written in the form of xx have a national significant number of length larger than 7.
        $this->assertEquals($arFromUs, $this->phoneUtil->parse("011xx5481429712", RegionCode::US));
    }

    public function testParseNumbersMexico()
    {
        // Test parsing fixed-line numbers of Mexico.
        $mxNumber = new PhoneNumber();
        $mxNumber->setCountryCode(52)->setNationalNumber(4499780001);
        $this->assertEquals($mxNumber, $this->phoneUtil->parse("+52 (449)978-0001", RegionCode::MX));
        $this->assertEquals($mxNumber, $this->phoneUtil->parse("01 (449)978-0001", RegionCode::MX));
        $this->assertEquals($mxNumber, $this->phoneUtil->parse("(449)978-0001", RegionCode::MX));

        // Test parsing mobile numbers of Mexico.
        $mxNumber->clear();
        $mxNumber->setCountryCode(52)->setNationalNumber(13312345678);
        $this->assertEquals($mxNumber, $this->phoneUtil->parse("+52 1 33 1234-5678", RegionCode::MX));
        $this->assertEquals($mxNumber, $this->phoneUtil->parse("044 (33) 1234-5678", RegionCode::MX));
        $this->assertEquals($mxNumber, $this->phoneUtil->parse("045 33 1234-5678", RegionCode::MX));
    }

    public function testFailedParseOnInvalidNumbers()
    {
        try {
            $sentencePhoneNumber = "This is not a phone number";
            $this->phoneUtil->parse($sentencePhoneNumber, RegionCode::NZ);
            $this->fail("This should not parse without throwing an exception " . $sentencePhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $sentencePhoneNumber = "1 Still not a number";
            $this->phoneUtil->parse($sentencePhoneNumber, RegionCode::NZ);
            $this->fail("This should not parse without throwing an exception " . $sentencePhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $sentencePhoneNumber = "1 MICROSOFT";
            $this->phoneUtil->parse($sentencePhoneNumber, RegionCode::NZ);
            $this->fail("This should not parse without throwing an exception " . $sentencePhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $sentencePhoneNumber = "12 MICROSOFT";
            $this->phoneUtil->parse($sentencePhoneNumber, RegionCode::NZ);
            $this->fail("This should not parse without throwing an exception " . $sentencePhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $tooLongPhoneNumber = "01495 72553301873 810104";
            $this->phoneUtil->parse($tooLongPhoneNumber, RegionCode::GB);
            $this->fail("This should not parse without throwing an exception " . $tooLongPhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::TOO_LONG,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $plusMinusPhoneNumber = "+---";
            $this->phoneUtil->parse($plusMinusPhoneNumber, RegionCode::DE);
            $this->fail("This should not parse without throwing an exception " . $plusMinusPhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $plusStar = "+***";
            $this->phoneUtil->parse($plusStar, RegionCode::DE);
            $this->fail("This should not parse without throwing an exception " . $plusStar);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $plusStarPhoneNumber = "+*******91";
            $this->phoneUtil->parse($plusStarPhoneNumber, RegionCode::DE);
            $this->fail("This should not parse without throwing an exception " . $plusStarPhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $tooShortPhoneNumber = "+49 0";
            $this->phoneUtil->parse($tooShortPhoneNumber, RegionCode::DE);
            $this->fail("This should not parse without throwing an exception " . $tooShortPhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::TOO_SHORT_NSN,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $invalidCountryCode = "+210 3456 56789";
            $this->phoneUtil->parse($invalidCountryCode, RegionCode::NZ);
            $this->fail("This is not a recognised region code: should fail: " . $invalidCountryCode);
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $plusAndIddAndInvalidCountryCode = "+ 00 210 3 331 6005";
            $this->phoneUtil->parse($plusAndIddAndInvalidCountryCode, RegionCode::NZ);
            $this->fail("This should not parse without throwing an exception " . $plusAndIddAndInvalidCountryCode);
        } catch (NumberParseException $e) {
            // Expected this exception. 00 is a correct IDD, but 210 is not a valid country code.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $someNumber = "123 456 7890";
            $this->phoneUtil->parse($someNumber, RegionCode::ZZ);
            $this->fail("'Unknown' region code not allowed: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $someNumber = "123 456 7890";
            $this->phoneUtil->parse($someNumber, RegionCode::CS);
            $this->fail("Deprecated region code not allowed: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $someNumber = "123 456 7890";
            $this->phoneUtil->parse($someNumber, null);
            $this->fail("Null region code not allowed: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $someNumber = "0044------";
            $this->phoneUtil->parse($someNumber, RegionCode::GB);
            $this->fail("No number provided, only region code: should fail");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::TOO_SHORT_AFTER_IDD,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $someNumber = "0044";
            $this->phoneUtil->parse($someNumber, RegionCode::GB);
            $this->fail("No number provided, only region code: should fail");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::TOO_SHORT_AFTER_IDD,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $someNumber = "011";
            $this->phoneUtil->parse($someNumber, RegionCode::US);
            $this->fail("Only IDD provided - should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::TOO_SHORT_AFTER_IDD,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $someNumber = "0119";
            $this->phoneUtil->parse($someNumber, RegionCode::US);
            $this->fail("Only IDD provided and then 9 - should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::TOO_SHORT_AFTER_IDD,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $emptyNumber = "";
            // Invalid region.
            $this->phoneUtil->parse($emptyNumber, RegionCode::ZZ);
            $this->fail("Empty string - should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $nullNumber = null;
            // Invalid region.
            $this->phoneUtil->parse($nullNumber, RegionCode::ZZ);
            $this->fail("Null string - should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $nullNumber = null;
            $this->phoneUtil->parse($nullNumber, RegionCode::US);
            $this->fail("Null string - should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            $domainRfcPhoneContext = "tel:555-1234;phone-context=www.google.com";
            $this->phoneUtil->parse($domainRfcPhoneContext, RegionCode::ZZ);
            $this->fail("'Unknown' region code not allowed: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        try {
            // This is invalid because no "+" sign is present as part of phone-context. This should not
            // succeed in being parsed.
            $invalidRfcPhoneContext = "tel:555-1234;phone-context=1-331";
            $this->phoneUtil->parse($invalidRfcPhoneContext, RegionCode::ZZ);
            $this->fail("'Unknown' region code not allowed: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }
    }

    public function testParseNumbersWithPlusWithNoRegion()
    {
        // RegionCode.ZZ is allowed only if the number starts with a '+' - then the country calling code
        // can be calculated.
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("+64 3 331 6005", RegionCode::ZZ));
        // Test with full-width plus.
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("＋64 3 331 6005", RegionCode::ZZ));
        // Test with normal plus but leading characters that need to be stripped.
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("Tel: +64 3 331 6005", RegionCode::ZZ));
        $this->assertEquals(self::$nzNumber, $this->phoneUtil->parse("+64 3 331 6005", null));
        $this->assertEquals(self::$internationalTollFree, $this->phoneUtil->parse("+800 1234 5678", null));
        $this->assertEquals(self::$universalPremiumRate, $this->phoneUtil->parse("+979 123 456 789", null));

        // Test parsing RFC3966 format with a phone context.
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("tel:03-331-6005;phone-context=+64", RegionCode::ZZ)
        );
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("  tel:03-331-6005;phone-context=+64", RegionCode::ZZ)
        );
        $this->assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse("tel:03-331-6005;isub=12345;phone-context=+64", RegionCode::ZZ)
        );

        // It is important that we set the carrier code to an empty string, since we used
        // ParseAndKeepRawInput and no carrier code was found.
        $nzNumberWithRawInput = new PhoneNumber();
        $nzNumberWithRawInput->mergeFrom(self::$nzNumber);
        $nzNumberWithRawInput->setRawInput("+64 3 331 6005");
        $nzNumberWithRawInput->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);
        $nzNumberWithRawInput->setPreferredDomesticCarrierCode("");
        $this->assertEquals(
            $nzNumberWithRawInput,
            $this->phoneUtil->parseAndKeepRawInput("+64 3 331 6005", RegionCode::ZZ)
        );

        // Null is also allowed for the region code in these cases.
        $this->assertEquals($nzNumberWithRawInput, $this->phoneUtil->parseAndKeepRawInput("+64 3 331 6005", null));
    }

    public function testParseNumberTooShortIfNationalPrefixStripped()
    {
        // Test that a number whose first digits happen to coincide with the national prefix does not
        // get them stripped if doing so would result in a number too short to be a possible (regular
        // length) phone number for that region.
        $byNumber = new PhoneNumber();
        $byNumber->setCountryCode(375)->setNationalNumber(8123);
        $this->assertEquals($byNumber, $this->phoneUtil->parse("8123", RegionCode::BY));
        $byNumber->setNationalNumber(81234);
        $this->assertEquals($byNumber, $this->phoneUtil->parse("81234", RegionCode::BY));

        // The prefix doesn't get stripped, since the input is a viable 6-digit number, whereas the
        // result of stripping is only 5 digits.
        $byNumber->setNationalNumber(812345);
        $this->assertEquals($byNumber, $this->phoneUtil->parse("812345", RegionCode::BY));

        // The prefix gets stripped, since only 6-digit numbers are possible.
        $byNumber->setNationalNumber(123456);
        $this->assertEquals($byNumber, $this->phoneUtil->parse("8123456", RegionCode::BY));
    }

    public function testParseExtensions()
    {
        $nzNumber = new PhoneNumber();
        $nzNumber->setCountryCode(64)->setNationalNumber(33316005)->setExtension("3456");
        $this->assertEquals($nzNumber, $this->phoneUtil->parse("03 331 6005 ext 3456", RegionCode::NZ));
        $this->assertEquals($nzNumber, $this->phoneUtil->parse("03-3316005x3456", RegionCode::NZ));
        $this->assertEquals($nzNumber, $this->phoneUtil->parse("03-3316005 int.3456", RegionCode::NZ));
        $this->assertEquals($nzNumber, $this->phoneUtil->parse("03 3316005 #3456", RegionCode::NZ));
        // Test the following do not extract extensions:
        $this->assertEquals(self::$alphaNumericNumber, $this->phoneUtil->parse("1800 six-flags", RegionCode::US));
        $this->assertEquals(self::$alphaNumericNumber, $this->phoneUtil->parse("1800 SIX FLAGS", RegionCode::US));
        $this->assertEquals(self::$alphaNumericNumber, $this->phoneUtil->parse("0~0 1800 7493 5247", RegionCode::PL));
        $this->assertEquals(self::$alphaNumericNumber, $this->phoneUtil->parse("(1800) 7493.5247", RegionCode::US));
        // Check that the last instance of an extension token is matched.
        $extnNumber = new PhoneNumber();
        $extnNumber->mergeFrom(self::$alphaNumericNumber)->setExtension("1234");
        $this->assertEquals($extnNumber, $this->phoneUtil->parse("0~0 1800 7493 5247 ~1234", RegionCode::PL));
        // Verifying bug-fix where the last digit of a number was previously omitted if it was a 0 when
        // extracting the extension. Also verifying a few different cases of extensions.
        $ukNumber = new PhoneNumber();
        $ukNumber->setCountryCode(44)->setNationalNumber(2034567890)->setExtension("456");
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44 2034567890x456", RegionCode::NZ));
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44 2034567890x456", RegionCode::GB));
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44 2034567890 x456", RegionCode::GB));
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44 2034567890 X456", RegionCode::GB));
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44 2034567890 X 456", RegionCode::GB));
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44 2034567890 X  456", RegionCode::GB));
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44 2034567890 x 456  ", RegionCode::GB));
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44 2034567890  X 456", RegionCode::GB));
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+44-2034567890;ext=456", RegionCode::GB));
        $this->assertEquals(
            $ukNumber,
            $this->phoneUtil->parse("tel:2034567890;ext=456;phone-context=+44", RegionCode::ZZ)
        );

        // Full-width extension, "extn" only.
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+442034567890ｅｘｔｎ456", RegionCode::GB));
        // "xtn" only.
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+442034567890ｘｔｎ456", RegionCode::GB));
        // "xt" only.
        $this->assertEquals($ukNumber, $this->phoneUtil->parse("+442034567890ｘｔ456", RegionCode::GB));

        $usWithExtension = new PhoneNumber();
        $usWithExtension->setCountryCode(1)->setNationalNumber(8009013355)->setExtension("7246433");
        $this->assertEquals($usWithExtension, $this->phoneUtil->parse("(800) 901-3355 x 7246433", RegionCode::US));
        $this->assertEquals($usWithExtension, $this->phoneUtil->parse("(800) 901-3355 , ext 7246433", RegionCode::US));
        $this->assertEquals(
            $usWithExtension,
            $this->phoneUtil->parse("(800) 901-3355 ,extension 7246433", RegionCode::US)
        );
        $this->assertEquals(
            $usWithExtension,
            $this->phoneUtil->parse("(800) 901-3355 ,extensi" . pack("H*", 'c3b3') . "n 7246433", RegionCode::US)
        );
        // Repeat with the small letter o with acute accent created by combining characters.
        $this->assertEquals(
            $usWithExtension,
            $this->phoneUtil->parse("(800) 901-3355 ,extensio" . pack('H*', 'cc81') . "n 7246433", RegionCode::US)
        );
        $this->assertEquals($usWithExtension, $this->phoneUtil->parse("(800) 901-3355 , 7246433", RegionCode::US));
        $this->assertEquals($usWithExtension, $this->phoneUtil->parse("(800) 901-3355 ext: 7246433", RegionCode::US));

        // Test that if a number has two extensions specified, we ignore the second.
        $usWithTwoExtensionsNumber = new PhoneNumber();
        $usWithTwoExtensionsNumber->setCountryCode(1)->setNationalNumber(2121231234)->setExtension("508");
        $this->assertEquals(
            $usWithTwoExtensionsNumber,
            $this->phoneUtil->parse("(212)123-1234 x508/x1234", RegionCode::US)
        );
        $this->assertEquals(
            $usWithTwoExtensionsNumber,
            $this->phoneUtil->parse("(212)123-1234 x508/ x1234", RegionCode::US)
        );
        $this->assertEquals(
            $usWithTwoExtensionsNumber,
            $this->phoneUtil->parse("(212)123-1234 x508\\x1234", RegionCode::US)
        );

        // Test parsing numbers in the form (645) 123-1234-910# works, where the last 3 digits before
        // the # are an extension.
        $usWithExtension->clear();
        $usWithExtension->setCountryCode(1)->setNationalNumber(6451231234)->setExtension("910");
        $this->assertEquals($usWithExtension, $this->phoneUtil->parse("+1 (645) 123 1234-910#", RegionCode::US));
        // Retry with the same number in a slightly different format.
        $this->assertEquals($usWithExtension, $this->phoneUtil->parse("+1 (645) 123 1234 ext. 910#", RegionCode::US));
    }

    public function testParseAndKeepRaw()
    {
        $alphaNumericNumber = new PhoneNumber();
        $alphaNumericNumber->mergeFrom(self::$alphaNumericNumber);
        $alphaNumericNumber->setRawInput("800 six-flags");
        $alphaNumericNumber->setCountryCodeSource(CountryCodeSource::FROM_DEFAULT_COUNTRY);
        $alphaNumericNumber->setPreferredDomesticCarrierCode("");
        $this->assertEquals(
            $alphaNumericNumber,
            $this->phoneUtil->parseAndKeepRawInput("800 six-flags", RegionCode::US)
        );

        $shorterAlphaNumber = new PhoneNumber();
        $shorterAlphaNumber->setCountryCode(1)->setNationalNumber(8007493524);
        $shorterAlphaNumber->setRawInput("1800 six-flag")->setCountryCodeSource(
            CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN
        )->setPreferredDomesticCarrierCode("");
        $this->assertEquals(
            $shorterAlphaNumber,
            $this->phoneUtil->parseAndKeepRawInput("1800 six-flag", RegionCode::US)
        );

        $shorterAlphaNumber->setRawInput("+1800 six-flag")->setCountryCodeSource(
            CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN
        );
        $this->assertEquals(
            $shorterAlphaNumber,
            $this->phoneUtil->parseAndKeepRawInput("+1800 six-flag", RegionCode::NZ)
        );

        $shorterAlphaNumber->setRawInput("001800 six-flag")->setCountryCodeSource(
            CountryCodeSource::FROM_NUMBER_WITH_IDD
        );
        $this->assertEquals(
            $shorterAlphaNumber,
            $this->phoneUtil->parseAndKeepRawInput("001800 six-flag", RegionCode::NZ)
        );

        // Invalid region code supplied.
        try {
            $this->phoneUtil->parseAndKeepRawInput("123 456 7890", RegionCode::CS);
            $this->fail("Deprecated region code not allowed: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            $this->assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                "Wrong error type stored in exception."
            );
        }

        $koreanNumber = new PhoneNumber();
        $koreanNumber->setCountryCode(82)->setNationalNumber(22123456)->setRawInput(
            "08122123456"
        )->setCountryCodeSource(CountryCodeSource::FROM_DEFAULT_COUNTRY)->setPreferredDomesticCarrierCode("81");
        $this->assertEquals($koreanNumber, $this->phoneUtil->parseAndKeepRawInput("08122123456", RegionCode::KR));
    }

    public function testParseItalianLeadingZeros()
    {
        // Test the number "011".
        $oneZero = new PhoneNumber();
        $oneZero->setCountryCode(61)->setNationalNumber(11)->setItalianLeadingZero(true);
        $this->assertEquals($oneZero, $this->phoneUtil->parse("011", RegionCode::AU));

        // Test the number "001".
        $twoZeros = new PhoneNumber();
        $twoZeros->setCountryCode(61)->setNationalNumber(1)->setItalianLeadingZero(true)->setNumberOfLeadingZeros(2);
        $this->assertEquals($twoZeros, $this->phoneUtil->parse("001", RegionCode::AU));

        // Test the number "000". This number has 2 leading zeros.
        $stillTwoZeros = new PhoneNumber();
        $stillTwoZeros->setCountryCode(61)->setNationalNumber(0)->setItalianLeadingZero(true)->setNumberOfLeadingZeros(
            2
        );
        $this->assertEquals($stillTwoZeros, $this->phoneUtil->parse("000", RegionCode::AU));

        // Test the number "0000". This number has 3 leading zeros.
        $threeZeros = new PhoneNumber();
        $threeZeros->setCountryCode(61)->setNationalNumber(0)->setItalianLeadingZero(true)->setNumberOfLeadingZeros(3);
        $this->assertEquals($threeZeros, $this->phoneUtil->parse("0000", RegionCode::AU));
    }

    public function testCountryWithNoNumberDesc()
    {
        // Andorra is a country where we don't have PhoneNumberDesc info in the metadata.
        $adNumber = new PhoneNumber();
        $adNumber->setCountryCode(376)->setNationalNumber(12345);

        $this->assertEquals("+376 12345", $this->phoneUtil->format($adNumber, PhoneNumberFormat::INTERNATIONAL));
        $this->assertEquals("+37612345", $this->phoneUtil->format($adNumber, PhoneNumberFormat::E164));
        $this->assertEquals("12345", $this->phoneUtil->format($adNumber, PhoneNumberFormat::NATIONAL));
        $this->assertEquals(PhoneNumberType::UNKNOWN, $this->phoneUtil->getNumberType($adNumber));
        $this->assertFalse($this->phoneUtil->isValidNumber($adNumber));

        // Test dialing a US number from within Andorra.
        $this->assertEquals(
            "00 1 650 253 0000",
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::AD)
        );
    }

    public function testUnknownCountryCallingCode()
    {
        $this->assertFalse($this->phoneUtil->isValidNumber(self::$unknownCountryCodeNoRawInput));
        // It's not very well defined as to what the E164 representation for a number with an invalid
        // country calling code is, but just prefixing the country code and national number is about
        // the best we can do.
        $this->assertEquals(
            "+212345",
            $this->phoneUtil->format(self::$unknownCountryCodeNoRawInput, PhoneNumberFormat::E164)
        );
    }

    public function testIsNumberMatchMatches()
    {
        // Test simple matches where formatting is different, or leading zeros, or country calling code
        // has been specified.
        $this->assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331 6005", "+64 03 331 6005")
        );
        $this->assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch("+800 1234 5678", "+80012345678"));
        $this->assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch("+64 03 331-6005", "+64 03331 6005")
        );
        $this->assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch("+643 331-6005", "+64033316005"));
        $this->assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch("+643 331-6005", "+6433316005"));
        $this->assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch("+64 3 331-6005", "+6433316005"));
        $this->assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005", "tel:+64-3-331-6005;isub=123")
        );
        // Test alpha numbers.
        $this->assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch("+1800 siX-Flags", "+1 800 7493 5247")
        );
        // Test numbers with extensions.
        $this->assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005 extn 1234", "+6433316005#1234")
        );
        // Test proto buffers.
        $this->assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch(self::$nzNumber, "+6403 331 6005"));

        $nzNumber = new PhoneNumber();
        $nzNumber->mergeFrom(self::$nzNumber)->setExtension("3456");
        $this->assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch($nzNumber, "+643 331 6005 ext 3456")
        );

        // Check empty extensions are ignored.
        $nzNumber->setExtension("");
        $this->assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch($nzNumber, "+6403 331 6005"));
        // Check variant with two proto buffers.
        $this->assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch($nzNumber, self::$nzNumber),
            "Number " . (string)$nzNumber . " did not match " . (string)self::$nzNumber
        );

        // Check raw_input, country_code_source and preferred_domestic_carrier_code are ignored.
        $brNumberOne = new PhoneNumber();
        $brNumberTwo = new PhoneNumber();
        $brNumberOne->setCountryCode(55)->setNationalNumber(3121286979)
            ->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN)
            ->setPreferredDomesticCarrierCode("12")->setRawInput("012 3121286979");
        $brNumberTwo->setCountryCode(55)->setNationalNumber(3121286979)
            ->setCountryCodeSource(CountryCodeSource::FROM_DEFAULT_COUNTRY)
            ->setPreferredDomesticCarrierCode("14")->setRawInput("143121286979");

        $this->assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch($brNumberOne, $brNumberTwo));
    }

    public function testIsNumberMatchNonMatches()
    {
        // Non-matches.
        $this->assertEquals(MatchType::NO_MATCH, $this->phoneUtil->isNumberMatch("03 331 6005", "03 331 6006"));
        $this->assertEquals(MatchType::NO_MATCH, $this->phoneUtil->isNumberMatch("+800 1234 5678", "+1 800 1234 5678"));
        // Different country calling code, partial number match.
        $this->assertEquals(MatchType::NO_MATCH, $this->phoneUtil->isNumberMatch("+64 3 331-6005", "+16433316005"));
        // Different country calling code, same number.
        $this->assertEquals(MatchType::NO_MATCH, $this->phoneUtil->isNumberMatch("+64 3 331-6005", "+6133316005"));
        // Extension different, all else the same.
        $this->assertEquals(
            MatchType::NO_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005 extn 1234", "0116433316005#1235")
        );
        $this->assertEquals(
            MatchType::NO_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005 extn 1234", "tel:+64-3-331-6005;ext=1235")
        );
        // NSN matches, but extension is different - not the same number.
        $this->assertEquals(
            MatchType::NO_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005 ext.1235", "3 331 6005#1234")
        );

        // Invalid numbers that can't be parsed.
        $this->assertEquals(MatchType::NOT_A_NUMBER, $this->phoneUtil->isNumberMatch("4", "3 331 6043"));
        $this->assertEquals(MatchType::NOT_A_NUMBER, $this->phoneUtil->isNumberMatch("+43", "+64 3 331 6005"));
        $this->assertEquals(MatchType::NOT_A_NUMBER, $this->phoneUtil->isNumberMatch("+43", "64 3 331 6005"));
        $this->assertEquals(MatchType::NOT_A_NUMBER, $this->phoneUtil->isNumberMatch("Dog", "64 3 331 6005"));
    }

    public function testIsNumberMatchNsnMatches()
    {
        // NSN matches.
        $this->assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch("+64 3 331-6005", "03 331 6005"));
        $this->assertEquals(
            MatchType::NSN_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005", "tel:03-331-6005;isub=1234;phone-context=abc.nz")
        );
        $this->assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch(self::$nzNumber, "03 331 6005"));
        // Here the second number possibly starts with the country calling code for New Zealand,
        // although we are unsure.
        $unchangedNzNumber = new PhoneNumber();
        $unchangedNzNumber->mergeFrom(self::$nzNumber);
        $this->assertEquals(
            MatchType::NSN_MATCH,
            $this->phoneUtil->isNumberMatch($unchangedNzNumber, "(64-3) 331 6005")
        );
        // Check the phone number proto was not edited during the method call.
        $this->assertEquals(self::$nzNumber, $unchangedNzNumber);

        // Here, the 1 might be a national prefix, if we compare it to the US number, so the resultant
        // match is an NSN match.
        $this->assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch(self::$usNumber, "1-650-253-0000"));
        $this->assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch(self::$usNumber, "6502530000"));
        $this->assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch("+1 650-253 0000", "1 650 253 0000"));
        $this->assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch("1 650-253 0000", "1 650 253 0000"));
        $this->assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch("1 650-253 0000", "+1 650 253 0000"));
        // For this case, the match will be a short NSN match, because we cannot assume that the 1 might
        // be a national prefix, so don't remove it when parsing.
        $randomNumber = new PhoneNumber();
        $randomNumber->setCountryCode(41)->setNationalNumber(6502530000);
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch($randomNumber, "1-650-253-0000")
        );
    }

    public function testIsNumberMatchShortNsnMatches()
    {
        // Short NSN matches with the country not specified for either one or both numbers.
        $this->assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch("+64 3 331-6005", "331 6005"));
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005", "tel:331-6005;phone-context=abc.nz")
        );
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005", "tel:331-6005;isub=1234;phone-context=abc.nz")
        );
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005", "tel:331-6005;isub=1234;phone-context=abc.nz;a=%A1")
        );

        // We did not know that the "0" was a national prefix since neither number has a country code,
        // so this is considered a SHORT_NSN_MATCH.
        $this->assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch("3 331-6005", "03 331 6005"));
        $this->assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch("3 331-6005", "331 6005"));
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch("3 331-6005", "tel:331-6005;phone-context=abc.nz")
        );
        $this->assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch("3 331-6005", "+64 331 6005"));

        // Short NSN match with the country specified.
        $this->assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch("03 331-6005", "331 6005"));
        $this->assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch("1 234 345 6789", "345 6789"));
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch("+1 (234) 345 6789", "345 6789")
        );
        // NSN matches, country calling code omitted for one number, extension missing for one.
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch("+64 3 331-6005", "3 331 6005#1234")
        );
        // One has Italian leading zero, one does not.
        $italianNumberOne = new PhoneNumber();
        $italianNumberOne->setCountryCode(39)->setNationalNumber(1234)->setItalianLeadingZero(true);
        $italianNumberTwo = new PhoneNumber();
        $italianNumberTwo->setCountryCode(39)->setNationalNumber(1234);
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch($italianNumberOne, $italianNumberTwo)
        );
        // One has an extension, the other has an extension of "".
        $italianNumberOne->setExtension("1234")->clearItalianLeadingZero();
        $italianNumberTwo->setExtension("");
        $this->assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch($italianNumberOne, $italianNumberTwo)
        );
    }

    public function testCanBeInternationallyDialled()
    {
        // We have no-international-dialling rules for the US in our test metadata that say that
        // toll-free numbers cannot be dialled internationally.
        $this->assertFalse($this->phoneUtil->canBeInternationallyDialled(self::$usTollFree));
        // Normal US numbers can be internationally dialled.
        $this->assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$usNumber));

        // Invalid number.
        $this->assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$usLocalNumber));

        // We have no data for NZ - should return true.
        $this->assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$nzNumber));
        $this->assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$internationalTollFree));
    }

    public function testIsAlphaNumber()
    {
        $this->assertTrue($this->phoneUtil->isAlphaNumber("1800 six-flags"));
        $this->assertTrue($this->phoneUtil->isAlphaNumber("1800 six-flags ext. 1234"));
        $this->assertTrue($this->phoneUtil->isAlphaNumber("+800 six-flags"));
        $this->assertTrue($this->phoneUtil->isAlphaNumber("180 six-flags"));
        $this->assertFalse($this->phoneUtil->isAlphaNumber("1800 123-1234"));
        $this->assertFalse($this->phoneUtil->isAlphaNumber("1 six-flags"));
        $this->assertFalse($this->phoneUtil->isAlphaNumber("18 six-flags"));
        $this->assertFalse($this->phoneUtil->isAlphaNumber("1800 123-1234 extension: 1234"));
        $this->assertFalse($this->phoneUtil->isAlphaNumber("+800 1234-1234"));
    }

    public function testIsMobileNumberPortableRegion()
    {
        $this->assertTrue($this->phoneUtil->isMobileNumberPortableRegion(RegionCode::US));
        $this->assertTrue($this->phoneUtil->isMobileNumberPortableRegion(RegionCode::GB));
        $this->assertFalse($this->phoneUtil->isMobileNumberPortableRegion(RegionCode::AE));
        $this->assertFalse($this->phoneUtil->isMobileNumberPortableRegion(RegionCode::BS));
    }
}
