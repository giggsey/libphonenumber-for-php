<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\CountryCodeSource;
use libphonenumber\CountryCodeToRegionCodeMapForTesting;
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
use PHPUnit\Framework\TestCase;

use function count;
use function pack;
use function str_repeat;

class PhoneNumberUtilTest extends TestCase
{
    private static PhoneNumber $bsNumber;
    private static PhoneNumber $coFixedLine;
    private static PhoneNumber $internationalTollFree;
    private static PhoneNumber $sgNumber;
    private static PhoneNumber $usShortByOneNumber;
    private static PhoneNumber $usTollFree;
    private static PhoneNumber $usNumber;
    private static PhoneNumber $usLocalNumber;
    private static PhoneNumber $usLongNumber;
    private static PhoneNumber $nzNumber;
    private static PhoneNumber $usPremium;
    private static PhoneNumber $usSpoof;
    private static PhoneNumber $usSpoofWithRawInput;
    private static PhoneNumber $uzFixedLine;
    private static PhoneNumber $uzMobile;
    private static PhoneNumber $gbMobile;
    private static PhoneNumber $bsMobile;
    private static PhoneNumber $gbNumber;
    private static PhoneNumber $deShortNumber;
    private static PhoneNumber $itMobile;
    private static PhoneNumber $itNumber;
    private static PhoneNumber $auNumber;
    private static PhoneNumber $arMobile;
    private static PhoneNumber $arNumber;
    private static PhoneNumber $mxMobile1;
    private static PhoneNumber $mxNumber1;
    private static PhoneNumber $mxMobile2;
    private static PhoneNumber $mxNumber2;
    private static PhoneNumber $deNumber;
    private static PhoneNumber $jpStarNumber;
    private static PhoneNumber $internationalTollFreeTooLong;
    private static PhoneNumber $universalPremiumRate;
    private static PhoneNumber $alphaNumericNumber;
    private static PhoneNumber $aeUAN;
    private static PhoneNumber $unknownCountryCodeNoRawInput;
    protected PhoneNumberUtil $phoneUtil;

    public function setUp(): void
    {
        $this->phoneUtil = self::initializePhoneUtilForTesting();
    }

    private static function initializePhoneUtilForTesting(): PhoneNumberUtil
    {
        self::$bsNumber = new PhoneNumber();
        self::$bsNumber->setCountryCode(1)->setNationalNumber('2423651234');
        self::$coFixedLine = new PhoneNumber();
        self::$coFixedLine->setCountryCode(57)->setNationalNumber('6012345678');
        self::$bsMobile = new PhoneNumber();
        self::$bsMobile->setCountryCode(1)->setNationalNumber('2423591234');
        self::$internationalTollFree = new PhoneNumber();
        self::$internationalTollFree->setCountryCode(800)->setNationalNumber('12345678');
        self::$internationalTollFreeTooLong = new PhoneNumber();
        self::$internationalTollFreeTooLong->setCountryCode(800)->setNationalNumber('123456789');
        self::$universalPremiumRate = new PhoneNumber();
        self::$universalPremiumRate->setCountryCode(979)->setNationalNumber('123456789');
        self::$sgNumber = new PhoneNumber();
        self::$sgNumber->setCountryCode(65)->setNationalNumber('65218000');
        // A too-long and hence invalid US number.
        self::$usLongNumber = new PhoneNumber();
        self::$usLongNumber->setCountryCode(1)->setNationalNumber('65025300001');
        self::$usShortByOneNumber = new PhoneNumber();
        self::$usShortByOneNumber->setCountryCode(1)->setNationalNumber('650253000');
        self::$usTollFree = new PhoneNumber();
        self::$usTollFree->setCountryCode(1)->setNationalNumber('8002530000');
        self::$usNumber = new PhoneNumber();
        self::$usNumber->setCountryCode(1)->setNationalNumber('6502530000');
        self::$usLocalNumber = new PhoneNumber();
        self::$usLocalNumber->setCountryCode(1)->setNationalNumber('2530000');
        self::$nzNumber = new PhoneNumber();
        self::$nzNumber->setCountryCode(64)->setNationalNumber('33316005');
        self::$usPremium = new PhoneNumber();
        self::$usPremium->setCountryCode(1)->setNationalNumber('9002530000');
        self::$usSpoof = new PhoneNumber();
        self::$usSpoof->setCountryCode(1)->setNationalNumber('0');
        self::$usSpoofWithRawInput = new PhoneNumber();
        self::$usSpoofWithRawInput->setCountryCode(1)->setNationalNumber('0')->setRawInput('000-000-0000');
        self::$uzFixedLine = new PhoneNumber();
        self::$uzFixedLine->setCountryCode(998)->setNationalNumber('612201234');
        self::$uzMobile = new PhoneNumber();
        self::$uzMobile->setCountryCode(998)->setNationalNumber('950123456');
        self::$gbMobile = new PhoneNumber();
        self::$gbMobile->setCountryCode(44)->setNationalNumber('7912345678');
        self::$gbNumber = new PhoneNumber();
        self::$gbNumber->setCountryCode(44)->setNationalNumber('2070313000');
        self::$deShortNumber = new PhoneNumber();
        self::$deShortNumber->setCountryCode(49)->setNationalNumber('1234');
        self::$itMobile = new PhoneNumber();
        self::$itMobile->setCountryCode(39)->setNationalNumber('345678901');
        self::$itNumber = new PhoneNumber();
        self::$itNumber->setCountryCode(39)->setNationalNumber('236618300')->setItalianLeadingZero(true);
        self::$auNumber = new PhoneNumber();
        self::$auNumber->setCountryCode(61)->setNationalNumber('236618300');
        self::$arMobile = new PhoneNumber();
        self::$arMobile->setCountryCode(54)->setNationalNumber('91187654321');
        self::$arNumber = new PhoneNumber();
        self::$arNumber->setCountryCode(54)->setNationalNumber('1187654321');

        self::$mxMobile1 = new PhoneNumber();
        self::$mxMobile1->setCountryCode(52)->setNationalNumber('12345678900');
        self::$mxNumber1 = new PhoneNumber();
        self::$mxNumber1->setCountryCode(52)->setNationalNumber('3312345678');
        self::$mxMobile2 = new PhoneNumber();
        self::$mxMobile2->setCountryCode(52)->setNationalNumber('15512345678');
        self::$mxNumber2 = new PhoneNumber();
        self::$mxNumber2->setCountryCode(52)->setNationalNumber('8211234567');
        // Note that this is the same as the example number for DE in the metadata.
        self::$deNumber = new PhoneNumber();
        self::$deNumber->setCountryCode(49)->setNationalNumber('30123456');
        self::$jpStarNumber = new PhoneNumber();
        self::$jpStarNumber->setCountryCode(81)->setNationalNumber('2345');
        self::$alphaNumericNumber = new PhoneNumber();
        self::$alphaNumericNumber->setCountryCode(1)->setNationalNumber('80074935247');
        self::$aeUAN = new PhoneNumber();
        self::$aeUAN->setCountryCode(971)->setNationalNumber('600123456');
        self::$unknownCountryCodeNoRawInput = new PhoneNumber();
        self::$unknownCountryCodeNoRawInput->setCountryCode(2)->setNationalNumber('12345');

        PhoneNumberUtil::resetInstance();
        return PhoneNumberUtil::getInstance(
            __NAMESPACE__ . '\data\PhoneNumberMetadataForTesting_',
            CountryCodeToRegionCodeMapForTesting::COUNTRY_CODE_TO_REGION_CODE_MAP_FOR_TESTING
        );
    }

    public function testGetSupportedRegions(): void
    {
        self::assertGreaterThan(0, count($this->phoneUtil->getSupportedRegions()));
    }

    public function testGetSupportedGlobalNetworkCallingCodes(): void
    {
        $globalNetworkCallingCodes = $this->phoneUtil->getSupportedGlobalNetworkCallingCodes();

        self::assertGreaterThan(0, count($globalNetworkCallingCodes));

        foreach ($globalNetworkCallingCodes as $callingCode) {
            self::assertGreaterThan(0, $callingCode);
            self::assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForCountryCode($callingCode));
        }
    }

    public function testGetSupportedCallingCodes(): void
    {
        $callingCodes = $this->phoneUtil->getSupportedCallingCodes();

        self::assertGreaterThan(0, count($callingCodes));

        foreach ($callingCodes as $callingCode) {
            self::assertGreaterThan(0, $callingCode);
            self::assertNotEquals(RegionCode::ZZ, $this->phoneUtil->getRegionCodeForCountryCode($callingCode));
        }

        // There should be more than just the global network calling codes in this set.
        self::assertGreaterThan(count($this->phoneUtil->getSupportedGlobalNetworkCallingCodes()), count($callingCodes));
        // But they should be includes. Tested one of them
        self::assertContains(979, $callingCodes);
    }

    public function testGetInstanceLoadBadMetadata(): void
    {
        self::assertNull($this->phoneUtil->getMetadataForRegion('No Such Region'));
        self::assertNull($this->phoneUtil->getMetadataForRegion('-1'));
    }

    public function testGetSupportedTypesForRegion(): void
    {
        self::assertContains(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getSupportedTypesForRegion(RegionCode::BR));
        // Our test data has no mobile numbers for Brazil.
        self::assertNotContains(PhoneNumberType::MOBILE, $this->phoneUtil->getSupportedTypesForRegion(RegionCode::BR));
        // UNKNOWN should never be returned.
        self::assertNotContains(PhoneNumberType::UNKNOWN, $this->phoneUtil->getSupportedTypesForRegion(RegionCode::BR));

        // In the US, many numbers are classified as FIXED_LINE_OR_MOBILE; but we don't want to expose
        // this as a supported type, instead we say FIXED_LINE and MOBILE are both present
        self::assertContains(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getSupportedTypesForRegion(RegionCode::US));
        self::assertContains(PhoneNumberType::MOBILE, $this->phoneUtil->getSupportedTypesForRegion(RegionCode::US));
        self::assertNotContains(PhoneNumberType::FIXED_LINE_OR_MOBILE, $this->phoneUtil->getSupportedTypesForRegion(RegionCode::US));

        // Test the invalid region code.
        self::assertCount(0, $this->phoneUtil->getSupportedTypesForRegion(RegionCode::ZZ));
    }

    public function testGetSupportedTypesForNonGeoEntity(): void
    {
        // No data exists for 999 at all, no types should be returned.
        self::assertCount(0, $this->phoneUtil->getSupportedTypesForNonGeoEntity(999));

        $typesFor979 = $this->phoneUtil->getSupportedTypesForNonGeoEntity(979);
        self::assertContains(PhoneNumberType::PREMIUM_RATE, $typesFor979);
        self::assertNotContains(PhoneNumberType::MOBILE, $typesFor979);
        self::assertNotContains(PhoneNumberType::UNKNOWN, $typesFor979);
    }

    public function testGetInstanceLoadUSMetadata(): void
    {
        $metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::US);
        self::assertNotNull($metadata);
        self::assertEquals('US', $metadata->getId());
        self::assertEquals(1, $metadata->getCountryCode());
        self::assertEquals('011', $metadata->getInternationalPrefix());
        self::assertTrue($metadata->hasNationalPrefix());
        self::assertEquals(2, $metadata->numberFormatSize());
        self::assertEquals('(\\d{3})(\\d{3})(\\d{4})', $metadata->getNumberFormat(1)->getPattern());
        self::assertEquals('$1 $2 $3', $metadata->getNumberFormat(1)->getFormat());
        self::assertNotNull($metadata->getGeneralDesc());
        self::assertEquals('[13-689]\\d{9}|2[0-35-9]\\d{8}', $metadata->getGeneralDesc()->getNationalNumberPattern());
        self::assertEquals('[13-689]\\d{9}|2[0-35-9]\\d{8}', $metadata->getFixedLine()?->getNationalNumberPattern());
        self::assertCount(1, $metadata->getGeneralDesc()->getPossibleLength());
        $possibleLength = $metadata->getGeneralDesc()->getPossibleLength();
        self::assertEquals(10, $possibleLength[0]);
        // Possible lengths are the same as the general description, so aren't stored separately in the
        // toll free element as well.
        self::assertNotNull($metadata->getTollFree());
        self::assertCount(0, $metadata->getTollFree()->getPossibleLength());
        self::assertEquals('900\\d{7}', $metadata->getPremiumRate()?->getNationalNumberPattern());
        // No shared-cost data is available, so its national number data should not be set.
        self::assertNotNull($metadata->getSharedCost());
        self::assertFalse($metadata->getSharedCost()->hasNationalNumberPattern());
    }

    public function testGetInstanceLoadDEMetadata(): void
    {
        $metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::DE);
        self::assertNotNull($metadata);
        self::assertEquals('DE', $metadata->getId());
        self::assertEquals(49, $metadata->getCountryCode());
        self::assertEquals('00', $metadata->getInternationalPrefix());
        self::assertEquals('0', $metadata->getNationalPrefix());
        self::assertEquals(6, $metadata->numberFormatSize());
        self::assertEquals(1, $metadata->getNumberFormat(5)->leadingDigitsPatternSize());
        self::assertEquals('900', $metadata->getNumberFormat(5)->getLeadingDigitsPattern(0));
        self::assertEquals('(\\d{3})(\\d{3,4})(\\d{4})', $metadata->getNumberFormat(5)->getPattern());
        self::assertEquals('$1 $2 $3', $metadata->getNumberFormat(5)->getFormat());
        self::assertNotNull($metadata->getGeneralDesc());
        self::assertCount(2, $metadata->getGeneralDesc()->getPossibleLengthLocalOnly());
        self::assertCount(8, $metadata->getGeneralDesc()->getPossibleLength());
        // Nothing is present for fixed-line, since it is the same as the general desc, so for
        // efficiency reasons we don't store an extra value.
        self::assertNotNull($metadata->getFixedLine());
        self::assertCount(0, $metadata->getFixedLine()->getPossibleLength());
        self::assertNotNull($metadata->getMobile());
        self::assertCount(2, $metadata->getMobile()->getPossibleLength());

        self::assertEquals(
            '(?:[24-6]\\d{2}|3[03-9]\\d|[789](?:0[2-9]|[1-9]\\d))\\d{1,8}',
            $metadata->getFixedLine()->getNationalNumberPattern()
        );
        self::assertEquals('30123456', $metadata->getFixedLine()->getExampleNumber());
        self::assertNotNull($metadata->getTollFree());
        self::assertContains(10, $metadata->getTollFree()->getPossibleLength());
        self::assertEquals('900([135]\\d{6}|9\\d{7})', $metadata->getPremiumRate()?->getNationalNumberPattern());
    }

    public function testGetInstanceLoadARMetadata(): void
    {
        $metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::AR);
        self::assertNotNull($metadata);
        self::assertEquals('AR', $metadata->getId());
        self::assertEquals(54, $metadata->getCountryCode());
        self::assertEquals('00', $metadata->getInternationalPrefix());
        self::assertEquals('0', $metadata->getNationalPrefix());
        self::assertEquals('0(?:(11|343|3715)15)?', $metadata->getNationalPrefixForParsing());
        self::assertEquals('9$1', $metadata->getNationalPrefixTransformRule());
        self::assertEquals('$2 15 $3-$4', $metadata->getNumberFormat(2)->getFormat());
        self::assertEquals('(\\d)(\\d{4})(\\d{2})(\\d{4})', $metadata->getNumberFormat(3)->getPattern());
        self::assertEquals('(\\d)(\\d{4})(\\d{2})(\\d{4})', $metadata->getIntlNumberFormat(3)->getPattern());
        self::assertEquals('$1 $2 $3 $4', $metadata->getIntlNumberFormat(3)->getFormat());
    }

    public function testGetInstanceLoadInternationalTollFreeMetadata(): void
    {
        $metadata = $this->phoneUtil->getMetadataForNonGeographicalRegion(800);
        self::assertNotNull($metadata);
        self::assertEquals('001', $metadata->getId());
        self::assertEquals(800, $metadata->getCountryCode());
        self::assertEquals('$1 $2', $metadata->getNumberFormat(0)->getFormat());
        self::assertEquals('(\\d{4})(\\d{4})', $metadata->getNumberFormat(0)->getPattern());
        self::assertNotNull($metadata->getGeneralDesc());
        self::assertCount(0, $metadata->getGeneralDesc()->getPossibleLengthLocalOnly());
        self::assertCount(1, $metadata->getGeneralDesc()->getPossibleLength());
        self::assertEquals('12345678', $metadata->getTollFree()?->getExampleNumber());
    }

    public function testIsNumberGeographical(): void
    {
        self::assertFalse($this->phoneUtil->isNumberGeographical(self::$bsMobile)); // Bahamas, mobile phone number.
        self::assertTrue($this->phoneUtil->isNumberGeographical(self::$auNumber)); // Australian fixed line number.
        self::assertFalse($this->phoneUtil->isNumberGeographical(self::$internationalTollFree)); // International toll
        // free number
    }

    public function testGetLengthOfGeographicalAreaCode(): void
    {
        // Google MTV, which has area code "650".
        self::assertEquals(3, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usNumber));

        // A North America toll-free number, which has no area code.
        self::assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usTollFree));

        // Google London, which has area code "20".
        self::assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$gbNumber));

        // A mobile number in the UK does not have an area code (by default, mobile numbers do not,
        // unless they have been added to our list of exceptions).
        self::assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$gbMobile));

        // A UK mobile phone, which has no area code.
        self::assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$gbMobile));

        // Google Buenos Aires, which has area code "11".
        self::assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$arNumber));

        // A mobile number in Argentina also has an area code.
        self::assertEquals(3, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$arMobile));

        // Google Sydney, which has area code "2".
        self::assertEquals(1, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$auNumber));

        // Italian numbers - there is no national prefix, but it still has an area code.
        self::assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$mxNumber1));

        // Mexico numbers - there is no national prefix, but it still has an area code.
        self::assertEquals(2, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$itNumber));

        // Google Singapore. Singapore has no area code and no national prefix.
        self::assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$sgNumber));

        // An invalid US number (1 digit shorter), which has no area code.
        self::assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$usShortByOneNumber));

        // An international toll free number, which has no area code.
        self::assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode(self::$internationalTollFree));

        // A mobile number from China is geographical, but does not have an area code.
        $cnMobile = new PhoneNumber();
        $cnMobile->setCountryCode(86)->setNationalNumber('18912341234');

        self::assertEquals(0, $this->phoneUtil->getLengthOfGeographicalAreaCode($cnMobile));
    }

    public function testGetLengthOfNationalDestinationCode(): void
    {
        // Google MTV, which has national destination code (NDC) "650".
        self::assertEquals(3, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$usNumber));

        // A North America toll-free number, which has NDC "800".
        self::assertEquals(3, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$usTollFree));

        // Google London, which has NDC "20".
        self::assertEquals(2, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$gbNumber));

        // A UK mobile phone, which has NDC "7912".
        self::assertEquals(4, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$gbMobile));

        // Google Buenos Aires, which has NDC "11".
        self::assertEquals(2, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$arNumber));

        // An Argentinian mobile which has NDC "911".
        self::assertEquals(3, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$arMobile));

        // Google Sydney, which has NDC "2".
        self::assertEquals(1, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$auNumber));

        // Google Singapore, which has NDC "6521".
        self::assertEquals(4, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$sgNumber));

        // An invalid US number (1 digit shorter), which has no NDC.
        self::assertEquals(0, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$usShortByOneNumber));

        // A number containing an invalid country calling code, which shouldn't have any NDC.
        $number = new PhoneNumber();
        $number->setCountryCode(123)->setNationalNumber('6502530000');
        self::assertEquals(0, $this->phoneUtil->getLengthOfNationalDestinationCode($number));

        // An international toll free number, which has NDC "1234".
        self::assertEquals(4, $this->phoneUtil->getLengthOfNationalDestinationCode(self::$internationalTollFree));

        // A mobile number from China is geographical, but does not have an area code: however it still
        // can be considered to have a national destination code.
        $cnMobile = new PhoneNumber();
        $cnMobile->setCountryCode(86)->setNationalNumber('18912341234');

        self::assertEquals(3, $this->phoneUtil->getLengthOfNationalDestinationCode($cnMobile));
    }

    public function testGetCountryMobileToken(): void
    {
        self::assertEquals(
            '9',
            PhoneNumberUtil::getCountryMobileToken($this->phoneUtil->getCountryCodeForRegion(RegionCode::AR))
        );

        // Country calling code for Sweden, which has no mobile token.
        self::assertEquals(
            '',
            PhoneNumberUtil::getCountryMobileToken($this->phoneUtil->getCountryCodeForRegion(RegionCode::SE))
        );
    }

    public function testGetNationalSignificantNumber(): void
    {
        self::assertEquals('6502530000', $this->phoneUtil->getNationalSignificantNumber(self::$usNumber));

        // An Italian mobile number.
        self::assertEquals('345678901', $this->phoneUtil->getNationalSignificantNumber(self::$itMobile));

        // An Italian fixed line number.
        self::assertEquals('0236618300', $this->phoneUtil->getNationalSignificantNumber(self::$itNumber));

        self::assertEquals('12345678', $this->phoneUtil->getNationalSignificantNumber(self::$internationalTollFree));
    }

    public function testGetNationalSignificantNumber_ManyLeadingZeros(): void
    {
        $number = new PhoneNumber();
        $number->setCountryCode(1);
        $number->setNationalNumber('650');
        $number->setItalianLeadingZero(true);
        $number->setNumberOfLeadingZeros(2);

        self::assertEquals('00650', $this->phoneUtil->getNationalSignificantNumber($number));

        // Set a bad value; we shouldn't crash; we shouldn't output any leading zeros at all;
        $number->setNumberOfLeadingZeros(-3);
        self::assertEquals('650', $this->phoneUtil->getNationalSignificantNumber($number));
    }

    public function testGetExampleNumber(): void
    {
        self::assertEquals(self::$deNumber, $this->phoneUtil->getExampleNumber(RegionCode::DE));

        self::assertEquals(
            self::$deNumber,
            $this->phoneUtil->getExampleNumberForType(RegionCode::DE, PhoneNumberType::FIXED_LINE)
        );
        // Should return the sample response if asked for FIXED_LINE_OR_MOBILE too.
        self::assertEquals(
            self::$deNumber,
            $this->phoneUtil->getExampleNumberForType(RegionCode::DE, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );
        self::assertNotNull($this->phoneUtil->getExampleNumberForType(RegionCode::US, PhoneNumberType::FIXED_LINE));
        self::assertNotNull($this->phoneUtil->getExampleNumberForType(RegionCode::US, PhoneNumberType::MOBILE));
        // We have data for the US, but no data for VOICEMAIL, so return null
        self::assertNull($this->phoneUtil->getExampleNumberForType(RegionCode::US, PhoneNumberType::VOICEMAIL));
        // CS is an invalid region, so we have no data for it.
        self::assertNull($this->phoneUtil->getExampleNumberForType(RegionCode::CS, PhoneNumberType::MOBILE));
        // RegionCode 001 is reserved for supporting non-geographical country calling code. We don't
        // support getting an example number for it with this method.
        self::assertNull($this->phoneUtil->getExampleNumber(RegionCode::UN001));
    }

    public function testGetExampleNumberForNonGeoEntity(): void
    {
        self::assertEquals(self::$internationalTollFree, $this->phoneUtil->getExampleNumberForNonGeoEntity(800));
        self::assertEquals(self::$universalPremiumRate, $this->phoneUtil->getExampleNumberForNonGeoEntity(979));
    }

    public function testGetExampleNumberWithoutRegion(): void
    {
        // In our test metadata we don't cover all types: in our real metadata, we do.
        self::assertNotNull($this->phoneUtil->getExampleNumberForType(PhoneNumberType::FIXED_LINE));
        self::assertNotNull($this->phoneUtil->getExampleNumberForType(PhoneNumberType::MOBILE));
        self::assertNotNull($this->phoneUtil->getExampleNumberForType(PhoneNumberType::PREMIUM_RATE));
    }

    public function testConvertAlphaCharactersInNumber(): void
    {
        $input = '1800-ABC-DEF';
        // Alpha chars are converted to digits; everything else is left untouched.
        $expectedOutput = '1800-222-333';
        self::assertEquals($expectedOutput, PhoneNumberUtil::convertAlphaCharactersInNumber($input));
    }

    public function testNormaliseRemovePunctuation(): void
    {
        $inputNumber = '034-56&+#2' . pack('H*', 'c2ad') . '34';
        $expectedOutput = '03456234';
        self::assertEquals(
            $expectedOutput,
            PhoneNumberUtil::normalize($inputNumber),
            'Conversion did not correctly remove punctuation'
        );
    }

    public function testNormaliseReplaceAlphaCharacters(): void
    {
        $inputNumber = '034-I-am-HUNGRY';
        $expectedOutput = '034426486479';
        self::assertEquals(
            $expectedOutput,
            PhoneNumberUtil::normalize($inputNumber),
            'Conversion did not correctly replace alpha characters'
        );
    }

    public function testNormaliseOtherDigits(): void
    {
        $inputNumber = "\xEF\xBC\x92" . "5\xD9\xA5" /* "２5٥" */
        ;
        $expectedOutput = '255';
        self::assertEquals(
            $expectedOutput,
            PhoneNumberUtil::normalize($inputNumber),
            'Conversion did not correctly replace non-latin digits'
        );
        // Eastern-Arabic digits.
        $inputNumber = "\xDB\xB5" . "2\xDB\xB0" /* "۵2۰" */
        ;
        $expectedOutput = '520';
        self::assertEquals(
            $expectedOutput,
            PhoneNumberUtil::normalize($inputNumber),
            'Conversion did not correctly replace non-latin digits'
        );
    }

    public function testNormaliseStripAlphaCharacters(): void
    {
        $inputNumber = '034-56&+a#234';
        $expectedOutput = '03456234';
        self::assertEquals(
            $expectedOutput,
            PhoneNumberUtil::normalizeDigitsOnly($inputNumber),
            'Conversion did not correctly remove alpha character'
        );
    }

    public function testNormaliseStripNonDiallableCharacters(): void
    {
        $inputNumber = '03*4-56&+1a#234';
        $expectedOutput = '03*456+1#234';
        self::assertEquals(
            $expectedOutput,
            PhoneNumberUtil::normalizeDiallableCharsOnly($inputNumber),
            'Conversion did not correctly remove non-diallable characters'
        );
    }

    public function testFormatUSNumber(): void
    {
        self::assertEquals('650 253 0000', $this->phoneUtil->format(self::$usNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+1 650 253 0000',
            $this->phoneUtil->format(self::$usNumber, PhoneNumberFormat::INTERNATIONAL)
        );

        self::assertEquals('800 253 0000', $this->phoneUtil->format(self::$usTollFree, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+1 800 253 0000',
            $this->phoneUtil->format(self::$usTollFree, PhoneNumberFormat::INTERNATIONAL)
        );

        self::assertEquals('900 253 0000', $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+1 900 253 0000',
            $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals(
            'tel:+1-900-253-0000',
            $this->phoneUtil->format(self::$usPremium, PhoneNumberFormat::RFC3966)
        );
        // Numbers with all zeros in the national number part will be formatted by using the raw_input
        // if that is available no matter which format is specified.
        self::assertEquals(
            '000-000-0000',
            $this->phoneUtil->format(self::$usSpoofWithRawInput, PhoneNumberFormat::NATIONAL)
        );
        self::assertEquals('0', $this->phoneUtil->format(self::$usSpoof, PhoneNumberFormat::NATIONAL));
    }

    public function testFormatBSNumber(): void
    {
        self::assertEquals('242 365 1234', $this->phoneUtil->format(self::$bsNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+1 242 365 1234',
            $this->phoneUtil->format(self::$bsNumber, PhoneNumberFormat::INTERNATIONAL)
        );
    }

    public function testFormatGBNumber(): void
    {
        self::assertEquals('(020) 7031 3000', $this->phoneUtil->format(self::$gbNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+44 20 7031 3000',
            $this->phoneUtil->format(self::$gbNumber, PhoneNumberFormat::INTERNATIONAL)
        );

        self::assertEquals('(07912) 345 678', $this->phoneUtil->format(self::$gbMobile, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+44 7912 345 678',
            $this->phoneUtil->format(self::$gbMobile, PhoneNumberFormat::INTERNATIONAL)
        );
    }

    public function testFormatDENumber(): void
    {
        $deNumber = new PhoneNumber();
        $deNumber->setCountryCode(49)->setNationalNumber('301234');
        self::assertEquals('030/1234', $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals('+49 30/1234', $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
        self::assertEquals('tel:+49-30-1234', $this->phoneUtil->format($deNumber, PhoneNumberFormat::RFC3966));

        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber('291123');
        self::assertEquals('0291 123', $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals('+49 291 123', $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));

        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber('29112345678');
        self::assertEquals('0291 12345678', $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals('+49 291 12345678', $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));

        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber('912312345');
        self::assertEquals('09123 12345', $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals('+49 9123 12345', $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber('80212345');
        self::assertEquals('08021 2345', $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals('+49 8021 2345', $this->phoneUtil->format($deNumber, PhoneNumberFormat::INTERNATIONAL));
        // Note this number is correctly formatted without national prefix. Most of the numbers that
        // are treated as invalid numbers by the library are short numbers, and they are usually not
        // dialed with national prefix.
        self::assertEquals('1234', $this->phoneUtil->format(self::$deShortNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+49 1234',
            $this->phoneUtil->format(self::$deShortNumber, PhoneNumberFormat::INTERNATIONAL)
        );

        $deNumber->clear();
        $deNumber->setCountryCode(49)->setNationalNumber('41341234');
        self::assertEquals('04134 1234', $this->phoneUtil->format($deNumber, PhoneNumberFormat::NATIONAL));
    }

    public function testFormatITNumber(): void
    {
        self::assertEquals('02 3661 8300', $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+39 02 3661 8300',
            $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+390236618300', $this->phoneUtil->format(self::$itNumber, PhoneNumberFormat::E164));

        self::assertEquals('345 678 901', $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+39 345 678 901',
            $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+39345678901', $this->phoneUtil->format(self::$itMobile, PhoneNumberFormat::E164));
    }

    public function testFormatAUNumber(): void
    {
        self::assertEquals('02 3661 8300', $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+61 2 3661 8300',
            $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+61236618300', $this->phoneUtil->format(self::$auNumber, PhoneNumberFormat::E164));

        $auNumber = new PhoneNumber();
        $auNumber->setCountryCode(61)->setNationalNumber('1800123456');
        self::assertEquals('1800 123 456', $this->phoneUtil->format($auNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals('+61 1800 123 456', $this->phoneUtil->format($auNumber, PhoneNumberFormat::INTERNATIONAL));
        self::assertEquals('+611800123456', $this->phoneUtil->format($auNumber, PhoneNumberFormat::E164));
    }

    public function testFormatARNumber(): void
    {
        self::assertEquals('011 8765-4321', $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+54 11 8765-4321',
            $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+541187654321', $this->phoneUtil->format(self::$arNumber, PhoneNumberFormat::E164));

        self::assertEquals('011 15 8765-4321', $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+54 9 11 8765 4321',
            $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+5491187654321', $this->phoneUtil->format(self::$arMobile, PhoneNumberFormat::E164));
    }

    public function testFormatMXNumber(): void
    {
        self::assertEquals(
            '045 234 567 8900',
            $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::NATIONAL)
        );
        self::assertEquals(
            '+52 1 234 567 8900',
            $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+5212345678900', $this->phoneUtil->format(self::$mxMobile1, PhoneNumberFormat::E164));

        self::assertEquals(
            '045 55 1234 5678',
            $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::NATIONAL)
        );
        self::assertEquals(
            '+52 1 55 1234 5678',
            $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+5215512345678', $this->phoneUtil->format(self::$mxMobile2, PhoneNumberFormat::E164));

        self::assertEquals('01 33 1234 5678', $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+52 33 1234 5678',
            $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+523312345678', $this->phoneUtil->format(self::$mxNumber1, PhoneNumberFormat::E164));

        self::assertEquals('01 821 123 4567', $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '+52 821 123 4567',
            $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::INTERNATIONAL)
        );
        self::assertEquals('+528211234567', $this->phoneUtil->format(self::$mxNumber2, PhoneNumberFormat::E164));
    }

    public function testFormatOutOfCountryCallingNumber(): void
    {
        self::assertEquals(
            '00 1 900 253 0000',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usPremium, RegionCode::DE)
        );
        self::assertEquals(
            '1 650 253 0000',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::BS)
        );

        self::assertEquals(
            '00 1 650 253 0000',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::PL)
        );

        self::assertEquals(
            '011 44 7912 345 678',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$gbMobile, RegionCode::US)
        );

        self::assertEquals(
            '00 49 1234',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$deShortNumber, RegionCode::GB)
        );
        // Note this number is correctly formatted without national prefix. Most of the numbers that
        // are treated as invalid numbers by the library are short numbers, and they are usually not
        // dialed with national prefix.
        self::assertEquals(
            '1234',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$deShortNumber, RegionCode::DE)
        );

        self::assertEquals(
            '011 39 02 3661 8300',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::US)
        );
        self::assertEquals(
            '02 3661 8300',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::IT)
        );
        self::assertEquals(
            '+39 02 3661 8300',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::SG)
        );

        self::assertEquals(
            '6521 8000',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$sgNumber, RegionCode::SG)
        );

        self::assertEquals(
            '011 54 9 11 8765 4321',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$arMobile, RegionCode::US)
        );
        self::assertEquals(
            '011 800 1234 5678',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$internationalTollFree, RegionCode::US)
        );

        $arNumberWithExtn = new PhoneNumber();
        $arNumberWithExtn->mergeFrom(self::$arMobile)->setExtension('1234');
        self::assertEquals(
            '011 54 9 11 8765 4321 ext. 1234',
            $this->phoneUtil->formatOutOfCountryCallingNumber($arNumberWithExtn, RegionCode::US)
        );
        self::assertEquals(
            '0011 54 9 11 8765 4321 ext. 1234',
            $this->phoneUtil->formatOutOfCountryCallingNumber($arNumberWithExtn, RegionCode::AU)
        );
        self::assertEquals(
            '011 15 8765-4321 ext. 1234',
            $this->phoneUtil->formatOutOfCountryCallingNumber($arNumberWithExtn, RegionCode::AR)
        );
    }

    public function testFormatOutOfCountryWithInvalidRegion(): void
    {
        // AQ/Antarctica isn't a valid region code for phone number formatting,
        // so this falls back to intl formatting.
        self::assertEquals(
            '+1 650 253 0000',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::AQ)
        );
        // For region code 001, the out-of-country format always turns into the international format.
        self::assertEquals(
            '+1 650 253 0000',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::UN001)
        );
    }

    public function testFormatOutOfCountryWithPreferredIntlPrefix(): void
    {
        // This should use 0011, since that is the preferred international prefix (both 0011 and 0012
        // are accepted as possible international prefixes in our test metadata.)
        self::assertEquals(
            '0011 39 02 3661 8300',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::AU)
        );

        // Testing preferred international prefixes with ~ are supported (designates waiting).
        self::assertEquals(
            '8~10 39 02 3661 8300',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$itNumber, RegionCode::UZ)
        );
    }

    public function testFormatOutOfCountryKeepingAlphaChars(): void
    {
        $alphaNumericNumber = new PhoneNumber();
        $alphaNumericNumber->setCountryCode(1)->setNationalNumber('8007493524')->setRawInput('1800 six-flag');
        self::assertEquals(
            '0011 1 800 SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setRawInput('1-800-SIX-flag');
        self::assertEquals(
            '0011 1 800-SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setRawInput('Call us from UK: 00 1 800 SIX-flag');
        self::assertEquals(
            '0011 1 800 SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setRawInput('800 SIX-flag');
        self::assertEquals(
            '0011 1 800 SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        // Formatting from within the NANPA region.
        self::assertEquals(
            '1 800 SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::US)
        );

        self::assertEquals(
            '1 800 SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::BS)
        );

        // Testing a number with extension.
        $alphaNumericNumberWithExtn = $this->phoneUtil->parseAndKeepRawInput('800 SIX-flag ext. 1234', RegionCode::US);
        self::assertEquals(
            '0011 1 800 SIX-FLAG extn. 1234',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumberWithExtn, RegionCode::AU)
        );

        // Testing that if the raw input doesn't exist, it is formatted using
        // formatOutOfCountryCallingNumber.
        $alphaNumericNumber->clearRawInput();
        self::assertEquals(
            '00 1 800 749 3524',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::DE)
        );

        // Testing AU alpha number formatted from Australia.
        $alphaNumericNumber->setCountryCode(61)->setNationalNumber('827493524')->setRawInput('+61 82749-FLAG');
        // This number should have the national prefix fixed.
        self::assertEquals(
            '082749-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setRawInput('082749-FLAG');
        self::assertEquals(
            '082749-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        $alphaNumericNumber->setNationalNumber('18007493524')->setRawInput('1-800-SIX-flag');
        // This number should not have the national prefix prefixed, in accordance with the override for
        // this specific formatting rule.
        self::assertEquals(
            '1-800-SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AU)
        );

        // The metadata should not be permanently changed, since we copied it before modifying patterns.
        // Here we check this.
        $alphaNumericNumber->setNationalNumber('1800749352');
        self::assertEquals(
            '1800 749 352',
            $this->phoneUtil->formatOutOfCountryCallingNumber($alphaNumericNumber, RegionCode::AU)
        );

        // Testing a region with multiple international prefixes.
        self::assertEquals(
            '+61 1-800-SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::SG)
        );
        // Testing the case of calling from a non-supported region.
        self::assertEquals(
            '+61 1-800-SIX-FLAG',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AQ)
        );

        // Testing the case with an invalid country calling code.
        $alphaNumericNumber->setCountryCode(0)->setNationalNumber('18007493524')->setRawInput('1-800-SIX-flag');
        // Uses the raw input only.
        self::assertEquals(
            '1-800-SIX-flag',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::DE)
        );

        // Testing the case of an invalid alpha number.
        $alphaNumericNumber->setCountryCode(1)->setNationalNumber('80749')->setRawInput('180-SIX');
        // No country-code stripping can be done.
        self::assertEquals(
            '00 1 180-SIX',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::DE)
        );

        // Testing the case of calling from a non-supported region.
        $alphaNumericNumber->setCountryCode(1)->setNationalNumber('80749')->setRawInput('180-SIX');
        // No country-code stripping can be done since the number is invalid.
        self::assertEquals(
            '+1 180-SIX',
            $this->phoneUtil->formatOutOfCountryKeepingAlphaChars($alphaNumericNumber, RegionCode::AQ)
        );
    }

    public function testFormatWithCarrierCode(): void
    {
        // We only support this for AR in our test metadata, and only for mobile numbers starting with
        // certain values.
        $arMobile = new PhoneNumber();
        $arMobile->setCountryCode(54)->setNationalNumber('92234654321');
        self::assertEquals('02234 65-4321', $this->phoneUtil->format($arMobile, PhoneNumberFormat::NATIONAL));
        // Here we force 14 as the carrier code.
        self::assertEquals(
            '02234 14 65-4321',
            $this->phoneUtil->formatNationalNumberWithCarrierCode($arMobile, '14')
        );
        // Here we force the number to be shown with no carrier code.
        self::assertEquals(
            '02234 65-4321',
            $this->phoneUtil->formatNationalNumberWithCarrierCode($arMobile, '')
        );
        // Here the international rule is used, so no carrier code should be present.
        self::assertEquals('+5492234654321', $this->phoneUtil->format($arMobile, PhoneNumberFormat::E164));
        // We don't support this for the US so there should be no change.
        self::assertEquals(
            '650 253 0000',
            $this->phoneUtil->formatNationalNumberWithCarrierCode(self::$usNumber, '15')
        );

        // Invalid country code should just get the NSN.
        self::assertEquals(
            '12345',
            $this->phoneUtil->formatNationalNumberWithCarrierCode(self::$unknownCountryCodeNoRawInput, '89')
        );
    }

    public function testFormatWithPreferredCarrierCode(): void
    {
        // We only support this for AR in our test metadata.
        $arNumber = new PhoneNumber();
        $arNumber->setCountryCode(54)->setNationalNumber('91234125678');
        // Test formatting with no preferred carrier code stored in the number itself.
        self::assertEquals(
            '01234 15 12-5678',
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, '15')
        );
        self::assertEquals(
            '01234 12-5678',
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, '')
        );
        // Test formatting with preferred carrier code present.
        $arNumber->setPreferredDomesticCarrierCode('19');
        self::assertEquals('01234 12-5678', $this->phoneUtil->format($arNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '01234 19 12-5678',
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, '15')
        );
        self::assertEquals(
            '01234 19 12-5678',
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, '')
        );
        // When the preferred_domestic_carrier_code is present (even when it is just a space), use it
        // instead of the default carrier code passed in.
        $arNumber->setPreferredDomesticCarrierCode(' ');
        self::assertEquals(
            '01234   12-5678',
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, '15')
        );
        // When the preferred_domestic_carrier_code is present but empty, treat it as unset and use
        // instead of the default carrier code passed in.
        $arNumber->setPreferredDomesticCarrierCode('');
        self::assertEquals(
            '01234 15 12-5678',
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($arNumber, '15')
        );
        // We don't support this for the US so there should be no change.
        $usNumber = new PhoneNumber();
        $usNumber->setCountryCode(1)->setNationalNumber('4241231234')->setPreferredDomesticCarrierCode('99');
        self::assertEquals('424 123 1234', $this->phoneUtil->format($usNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(
            '424 123 1234',
            $this->phoneUtil->formatNationalNumberWithPreferredCarrierCode($usNumber, '15')
        );
    }

    public function testFormatNumberForMobileDialing(): void
    {
        // Numbers are normally dialed in national format in-country, and international format from
        // outside the country.
        self::assertEquals(
            '6012345678',
            $this->phoneUtil->formatNumberForMobileDialing(self::$coFixedLine, RegionCode::CO, false)
        );
        self::assertEquals(
            '030123456',
            $this->phoneUtil->formatNumberForMobileDialing(self::$deNumber, RegionCode::DE, false)
        );
        self::assertEquals(
            '+4930123456',
            $this->phoneUtil->formatNumberForMobileDialing(self::$deNumber, RegionCode::CH, false)
        );
        self::assertEquals(
            '+4930123456',
            $this->phoneUtil->formatNumberForMobileDialing(self::$deNumber, RegionCode::CH, false)
        );
        $deNumberWithExtn = new PhoneNumber();
        $deNumberWithExtn->mergeFrom(self::$deNumber)->setExtension('1234');
        self::assertEquals(
            '030123456',
            $this->phoneUtil->formatNumberForMobileDialing($deNumberWithExtn, RegionCode::DE, false)
        );
        self::assertEquals(
            '+4930123456',
            $this->phoneUtil->formatNumberForMobileDialing($deNumberWithExtn, RegionCode::CH, false)
        );

        // US toll free numbers are marked as noInternationalDialling in the test metadata for testing
        // purposes. For such numbers, we expect nothing to be returned when the region code is not the
        // same one.
        self::assertEquals(
            '800 253 0000',
            $this->phoneUtil->formatNumberForMobileDialing(
                self::$usTollFree,
                RegionCode::US,
                true /*  keep formatting */
            )
        );
        self::assertEquals(
            '',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usTollFree, RegionCode::CN, true)
        );
        self::assertEquals(
            '+1 650 253 0000',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::US, true)
        );
        $usNumberWithExtn = new PhoneNumber();
        $usNumberWithExtn->mergeFrom(self::$usNumber)->setExtension('1234');
        self::assertEquals(
            '+1 650 253 0000',
            $this->phoneUtil->formatNumberForMobileDialing($usNumberWithExtn, RegionCode::US, true)
        );

        self::assertEquals(
            '8002530000',
            $this->phoneUtil->formatNumberForMobileDialing(
                self::$usTollFree,
                RegionCode::US,
                false /* remove formatting */
            )
        );
        self::assertEquals(
            '',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usTollFree, RegionCode::CN, false)
        );
        self::assertEquals(
            '+16502530000',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::US, false)
        );
        self::assertEquals(
            '+16502530000',
            $this->phoneUtil->formatNumberForMobileDialing($usNumberWithExtn, RegionCode::US, false)
        );

        // An invalid US number, which is one digit too long.
        self::assertEquals(
            '+165025300001',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usLongNumber, RegionCode::US, false)
        );
        self::assertEquals(
            '+1 65025300001',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usLongNumber, RegionCode::US, true)
        );

        // Star numbers. In real life they appear in Israel, but we have them in JP in our test
        // metadata.
        self::assertEquals(
            '*2345',
            $this->phoneUtil->formatNumberForMobileDialing(self::$jpStarNumber, RegionCode::JP, false)
        );
        self::assertEquals(
            '*2345',
            $this->phoneUtil->formatNumberForMobileDialing(self::$jpStarNumber, RegionCode::JP, true)
        );

        self::assertEquals(
            '+80012345678',
            $this->phoneUtil->formatNumberForMobileDialing(self::$internationalTollFree, RegionCode::JP, false)
        );
        self::assertEquals(
            '+800 1234 5678',
            $this->phoneUtil->formatNumberForMobileDialing(self::$internationalTollFree, RegionCode::JP, true)
        );

        // UAE numbers beginning with 600 (classified as UAN) need to be dialled without +971 locally.
        self::assertEquals(
            '+971600123456',
            $this->phoneUtil->formatNumberForMobileDialing(self::$aeUAN, RegionCode::JP, false)
        );
        self::assertEquals(
            '600123456',
            $this->phoneUtil->formatNumberForMobileDialing(self::$aeUAN, RegionCode::AE, false)
        );

        self::assertEquals(
            '+523312345678',
            $this->phoneUtil->formatNumberForMobileDialing(self::$mxNumber1, RegionCode::MX, false)
        );
        self::assertEquals(
            '+523312345678',
            $this->phoneUtil->formatNumberForMobileDialing(self::$mxNumber1, RegionCode::US, false)
        );

        // Test whether Uzbek phone numbers are returned in international format even when dialled from
        // same region or other regions.
        self::assertEquals(
            '+998612201234',
            $this->phoneUtil->formatNumberForMobileDialing(self::$uzFixedLine, RegionCode::UZ, false)
        );
        self::assertEquals(
            '+998950123456',
            $this->phoneUtil->formatNumberForMobileDialing(self::$uzMobile, RegionCode::UZ, false)
        );
        self::assertEquals(
            '+998950123456',
            $this->phoneUtil->formatNumberForMobileDialing(self::$uzMobile, RegionCode::US, false)
        );


        // Non-geographical numbers should always be dialed in international format.
        self::assertEquals(
            '+80012345678',
            $this->phoneUtil->formatNumberForMobileDialing(self::$internationalTollFree, RegionCode::US, false)
        );
        self::assertEquals(
            '+80012345678',
            $this->phoneUtil->formatNumberForMobileDialing(self::$internationalTollFree, RegionCode::UN001, false)
        );

        // Test that a short number is formatted correctly for mobile dialing within the region,
        // and is not diallable from outside the region.
        $deShortNumber = new PhoneNumber();
        $deShortNumber->setCountryCode(49)->setNationalNumber('123');
        self::assertEquals(
            '123',
            $this->phoneUtil->formatNumberForMobileDialing($deShortNumber, RegionCode::DE, false)
        );
        self::assertEquals('', $this->phoneUtil->formatNumberForMobileDialing($deShortNumber, RegionCode::IT, false));

        // Test the special logic for NANPA countries, for which regular length phone numbers are always
        // output in international format, but short numbers are in national format.
        self::assertEquals(
            '+16502530000',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::US, false)
        );
        self::assertEquals(
            '+16502530000',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::CA, false)
        );
        self::assertEquals(
            '+16502530000',
            $this->phoneUtil->formatNumberForMobileDialing(self::$usNumber, RegionCode::BR, false)
        );
        $usShortNumber = new PhoneNumber();
        $usShortNumber->setCountryCode(1)->setNationalNumber('911');
        self::assertEquals(
            '911',
            $this->phoneUtil->formatNumberForMobileDialing($usShortNumber, RegionCode::US, false)
        );
        self::assertEquals('', $this->phoneUtil->formatNumberForMobileDialing($usShortNumber, RegionCode::CA, false));
        self::assertEquals('', $this->phoneUtil->formatNumberForMobileDialing($usShortNumber, RegionCode::BR, false));

        // Test that the Australian emergency number 000 is formatted correctly.
        $auNumber = new PhoneNumber();
        $auNumber->setCountryCode(61)->setNationalNumber('0')->setItalianLeadingZero(true)->setNumberOfLeadingZeros(2);
        self::assertEquals('000', $this->phoneUtil->formatNumberForMobileDialing($auNumber, RegionCode::AU, false));
        self::assertEquals('', $this->phoneUtil->formatNumberForMobileDialing($auNumber, RegionCode::NZ, false));
    }

    public function testFormatByPattern(): void
    {
        $newNumFormat = new NumberFormat();
        $newNumFormat->setPattern('(\\d{3})(\\d{3})(\\d{4})');
        $newNumFormat->setFormat('($1) $2-$3');
        $newNumberFormats = [];
        $newNumberFormats[] = $newNumFormat;

        self::assertEquals(
            '(650) 253-0000',
            $this->phoneUtil->formatByPattern(
                self::$usNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );
        self::assertEquals(
            '+1 (650) 253-0000',
            $this->phoneUtil->formatByPattern(
                self::$usNumber,
                PhoneNumberFormat::INTERNATIONAL,
                $newNumberFormats
            )
        );
        self::assertEquals(
            'tel:+1-650-253-0000',
            $this->phoneUtil->formatByPattern(
                self::$usNumber,
                PhoneNumberFormat::RFC3966,
                $newNumberFormats
            )
        );

        // $NP is set to '1' for the US. Here we check that for other NANPA countries the US rules are
        // followed.
        $newNumFormat->setNationalPrefixFormattingRule('$NP ($FG)');
        $newNumFormat->setFormat('$1 $2-$3');
        self::assertEquals(
            '1 (242) 365-1234',
            $this->phoneUtil->formatByPattern(
                self::$bsNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );
        self::assertEquals(
            '+1 242 365-1234',
            $this->phoneUtil->formatByPattern(
                self::$bsNumber,
                PhoneNumberFormat::INTERNATIONAL,
                $newNumberFormats
            )
        );

        $newNumFormat->setPattern('(\\d{2})(\\d{5})(\\d{3})');
        $newNumFormat->setFormat('$1-$2 $3');
        $newNumberFormats[0] = $newNumFormat;

        self::assertEquals(
            '02-36618 300',
            $this->phoneUtil->formatByPattern(
                self::$itNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );
        self::assertEquals(
            '+39 02-36618 300',
            $this->phoneUtil->formatByPattern(
                self::$itNumber,
                PhoneNumberFormat::INTERNATIONAL,
                $newNumberFormats
            )
        );

        $newNumFormat->setNationalPrefixFormattingRule('$NP$FG');
        $newNumFormat->setPattern('(\\d{2})(\\d{4})(\\d{4})');
        $newNumFormat->setFormat('$1 $2 $3');
        $newNumberFormats[0] = $newNumFormat;
        self::assertEquals(
            '020 7031 3000',
            $this->phoneUtil->formatByPattern(
                self::$gbNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );

        $newNumFormat->setNationalPrefixFormattingRule('($NP$FG)');
        self::assertEquals(
            '(020) 7031 3000',
            $this->phoneUtil->formatByPattern(
                self::$gbNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );

        $newNumFormat->setNationalPrefixFormattingRule('');
        self::assertEquals(
            '20 7031 3000',
            $this->phoneUtil->formatByPattern(
                self::$gbNumber,
                PhoneNumberFormat::NATIONAL,
                $newNumberFormats
            )
        );

        self::assertEquals(
            '+44 20 7031 3000',
            $this->phoneUtil->formatByPattern(
                self::$gbNumber,
                PhoneNumberFormat::INTERNATIONAL,
                $newNumberFormats
            )
        );
    }

    public function testFormatE164Number(): void
    {
        self::assertEquals('+16502530000', $this->phoneUtil->format(self::$usNumber, PhoneNumberFormat::E164));
        self::assertEquals('+4930123456', $this->phoneUtil->format(self::$deNumber, PhoneNumberFormat::E164));
        self::assertEquals(
            '+80012345678',
            $this->phoneUtil->format(self::$internationalTollFree, PhoneNumberFormat::E164)
        );
    }

    public function testFormatNumberWithExtension(): void
    {
        $nzNumber = new PhoneNumber();
        $nzNumber->mergeFrom(self::$nzNumber)->setExtension('1234');
        // Uses default extension prefix:
        self::assertEquals('03-331 6005 ext. 1234', $this->phoneUtil->format($nzNumber, PhoneNumberFormat::NATIONAL));
        // Uses RFC 3966 syntax.
        self::assertEquals(
            'tel:+64-3-331-6005;ext=1234',
            $this->phoneUtil->format($nzNumber, PhoneNumberFormat::RFC3966)
        );
        // Extension prefix overridden in the territory information for the US:
        $usNumberWithExtension = new PhoneNumber();
        $usNumberWithExtension->mergeFrom(self::$usNumber)->setExtension('4567');
        self::assertEquals(
            '650 253 0000 extn. 4567',
            $this->phoneUtil->format($usNumberWithExtension, PhoneNumberFormat::NATIONAL)
        );
    }

    public function testFormatInOriginalFormat(): void
    {
        $number1 = $this->phoneUtil->parseAndKeepRawInput('+442087654321', RegionCode::GB);
        self::assertEquals('+44 20 8765 4321', $this->phoneUtil->formatInOriginalFormat($number1, RegionCode::GB));

        $number2 = $this->phoneUtil->parseAndKeepRawInput('02087654321', RegionCode::GB);
        self::assertEquals('(020) 8765 4321', $this->phoneUtil->formatInOriginalFormat($number2, RegionCode::GB));

        $number3 = $this->phoneUtil->parseAndKeepRawInput('011442087654321', RegionCode::US);
        self::assertEquals('011 44 20 8765 4321', $this->phoneUtil->formatInOriginalFormat($number3, RegionCode::US));

        $number4 = $this->phoneUtil->parseAndKeepRawInput('442087654321', RegionCode::GB);
        self::assertEquals('44 20 8765 4321', $this->phoneUtil->formatInOriginalFormat($number4, RegionCode::GB));

        $number5 = $this->phoneUtil->parse('+442087654321', RegionCode::GB);
        self::assertEquals('(020) 8765 4321', $this->phoneUtil->formatInOriginalFormat($number5, RegionCode::GB));

        // Invalid numbers that we have a formatting pattern for should be formatted properly. Note area
        // codes starting with 7 are intentionally excluded in the test metadata for testing purposes.
        $number6 = $this->phoneUtil->parseAndKeepRawInput('7345678901', RegionCode::US);
        self::assertEquals('734 567 8901', $this->phoneUtil->formatInOriginalFormat($number6, RegionCode::US));

        // US is not a leading zero country, and the presence of the leading zero leads us to format the
        // number using raw_input.
        $number7 = $this->phoneUtil->parseAndKeepRawInput('0734567 8901', RegionCode::US);
        self::assertEquals('0734567 8901', $this->phoneUtil->formatInOriginalFormat($number7, RegionCode::US));

        // This number is valid, but we don't have a formatting pattern for it. Fall back to the raw
        // input.
        $number8 = $this->phoneUtil->parseAndKeepRawInput('02-4567-8900', RegionCode::KR);
        self::assertEquals('02-4567-8900', $this->phoneUtil->formatInOriginalFormat($number8, RegionCode::KR));

        $number9 = $this->phoneUtil->parseAndKeepRawInput('01180012345678', RegionCode::US);
        self::assertEquals('011 800 1234 5678', $this->phoneUtil->formatInOriginalFormat($number9, RegionCode::US));

        $number10 = $this->phoneUtil->parseAndKeepRawInput('+80012345678', RegionCode::KR);
        self::assertEquals('+800 1234 5678', $this->phoneUtil->formatInOriginalFormat($number10, RegionCode::KR));

        // US local numbers are formatted correctly, as we have formatting patterns for them.
        $localNumberUS = $this->phoneUtil->parseAndKeepRawInput('2530000', RegionCode::US);
        self::assertEquals('253 0000', $this->phoneUtil->formatInOriginalFormat($localNumberUS, RegionCode::US));

        $numberWithNationalPrefixUS =
            $this->phoneUtil->parseAndKeepRawInput('18003456789', RegionCode::US);
        self::assertEquals(
            '1 800 345 6789',
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixUS, RegionCode::US)
        );

        $numberWithoutNationalPrefixGB =
            $this->phoneUtil->parseAndKeepRawInput('2087654321', RegionCode::GB);
        self::assertEquals(
            '20 8765 4321',
            $this->phoneUtil->formatInOriginalFormat($numberWithoutNationalPrefixGB, RegionCode::GB)
        );
        // Make sure no metadata is modified as a result of the previous function call.
        self::assertEquals('(020) 8765 4321', $this->phoneUtil->formatInOriginalFormat($number5, RegionCode::GB));

        $numberWithNationalPrefixMX =
            $this->phoneUtil->parseAndKeepRawInput('013312345678', RegionCode::MX);
        self::assertEquals(
            '01 33 1234 5678',
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixMX, RegionCode::MX)
        );

        $numberWithoutNationalPrefixMX =
            $this->phoneUtil->parseAndKeepRawInput('3312345678', RegionCode::MX);
        self::assertEquals(
            '33 1234 5678',
            $this->phoneUtil->formatInOriginalFormat($numberWithoutNationalPrefixMX, RegionCode::MX)
        );

        $italianFixedLineNumber =
            $this->phoneUtil->parseAndKeepRawInput('0212345678', RegionCode::IT);
        self::assertEquals(
            '02 1234 5678',
            $this->phoneUtil->formatInOriginalFormat($italianFixedLineNumber, RegionCode::IT)
        );

        $numberWithNationalPrefixJP =
            $this->phoneUtil->parseAndKeepRawInput('00777012', RegionCode::JP);
        self::assertEquals(
            '0077-7012',
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixJP, RegionCode::JP)
        );

        $numberWithoutNationalPrefixJP =
            $this->phoneUtil->parseAndKeepRawInput('0777012', RegionCode::JP);
        self::assertEquals(
            '0777012',
            $this->phoneUtil->formatInOriginalFormat($numberWithoutNationalPrefixJP, RegionCode::JP)
        );

        $numberWithCarrierCodeBR =
            $this->phoneUtil->parseAndKeepRawInput('012 3121286979', RegionCode::BR);
        self::assertEquals(
            '012 3121286979',
            $this->phoneUtil->formatInOriginalFormat($numberWithCarrierCodeBR, RegionCode::BR)
        );

        // The default national prefix used in this case is 045. When a number with national prefix 044
        // is entered, we return the raw input as we don't want to change the number entered.
        $numberWithNationalPrefixMX1 =
            $this->phoneUtil->parseAndKeepRawInput('044(33)1234-5678', RegionCode::MX);
        self::assertEquals(
            '044(33)1234-5678',
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixMX1, RegionCode::MX)
        );

        $numberWithNationalPrefixMX2 =
            $this->phoneUtil->parseAndKeepRawInput('045(33)1234-5678', RegionCode::MX);
        self::assertEquals(
            '045 33 1234 5678',
            $this->phoneUtil->formatInOriginalFormat($numberWithNationalPrefixMX2, RegionCode::MX)
        );

        // The default international prefix used in this case is 0011. When a number with international
        // prefix 0012 is entered, we return the raw input as we don't want to change the number
        // entered.
        $outOfCountryNumberFromAU1 =
            $this->phoneUtil->parseAndKeepRawInput('0012 16502530000', RegionCode::AU);
        self::assertEquals(
            '0012 16502530000',
            $this->phoneUtil->formatInOriginalFormat($outOfCountryNumberFromAU1, RegionCode::AU)
        );

        $outOfCountryNumberFromAU2 =
            $this->phoneUtil->parseAndKeepRawInput('0011 16502530000', RegionCode::AU);
        self::assertEquals(
            '0011 1 650 253 0000',
            $this->phoneUtil->formatInOriginalFormat($outOfCountryNumberFromAU2, RegionCode::AU)
        );

        // Test the star sign is not removed from or added to the original input by this method.
        $starNumber = $this->phoneUtil->parseAndKeepRawInput('*1234', RegionCode::JP);
        self::assertEquals('*1234', $this->phoneUtil->formatInOriginalFormat($starNumber, RegionCode::JP));
        $numberWithoutStar = $this->phoneUtil->parseAndKeepRawInput('1234', RegionCode::JP);
        self::assertEquals('1234', $this->phoneUtil->formatInOriginalFormat($numberWithoutStar, RegionCode::JP));

        // Test an invalid national number without raw input is just formatted as the national number.
        self::assertEquals(
            '650253000',
            $this->phoneUtil->formatInOriginalFormat(self::$usShortByOneNumber, RegionCode::US)
        );
    }

    public function testIsPremiumRate(): void
    {
        self::assertEquals(PhoneNumberType::PREMIUM_RATE, $this->phoneUtil->getNumberType(self::$usPremium));

        $premiumRateNumber = new PhoneNumber();
        $premiumRateNumber->setCountryCode(39)->setNationalNumber('892123');
        self::assertEquals(
            PhoneNumberType::PREMIUM_RATE,
            $this->phoneUtil->getNumberType($premiumRateNumber)
        );

        $premiumRateNumber->clear();
        $premiumRateNumber->setCountryCode(44)->setNationalNumber('9187654321');
        self::assertEquals(
            PhoneNumberType::PREMIUM_RATE,
            $this->phoneUtil->getNumberType($premiumRateNumber)
        );

        $premiumRateNumber->clear();
        $premiumRateNumber->setCountryCode(49)->setNationalNumber('9001654321');
        self::assertEquals(
            PhoneNumberType::PREMIUM_RATE,
            $this->phoneUtil->getNumberType($premiumRateNumber)
        );

        $premiumRateNumber->clear();
        $premiumRateNumber->setCountryCode(49)->setNationalNumber('90091234567');
        self::assertEquals(
            PhoneNumberType::PREMIUM_RATE,
            $this->phoneUtil->getNumberType($premiumRateNumber)
        );
    }

    public function testIsTollFree(): void
    {
        $tollFreeNumber = new PhoneNumber();

        $tollFreeNumber->setCountryCode(1)->setNationalNumber('8881234567');
        self::assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType($tollFreeNumber)
        );

        $tollFreeNumber->clear();
        $tollFreeNumber->setCountryCode(39)->setNationalNumber('803123');
        self::assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType($tollFreeNumber)
        );

        $tollFreeNumber->clear();
        $tollFreeNumber->setCountryCode(44)->setNationalNumber('8012345678');
        self::assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType($tollFreeNumber)
        );

        $tollFreeNumber->clear();
        $tollFreeNumber->setCountryCode(49)->setNationalNumber('8001234567');
        self::assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType($tollFreeNumber)
        );

        self::assertEquals(
            PhoneNumberType::TOLL_FREE,
            $this->phoneUtil->getNumberType(self::$internationalTollFree)
        );
    }

    public function testIsMobile(): void
    {
        self::assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType(self::$bsMobile));
        self::assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType(self::$gbMobile));
        self::assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType(self::$itMobile));
        self::assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType(self::$arMobile));

        $mobileNumber = new PhoneNumber();
        $mobileNumber->setCountryCode(49)->setNationalNumber('15123456789');
        self::assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType($mobileNumber));
    }

    public function testIsFixedLine(): void
    {
        self::assertEquals(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getNumberType(self::$bsNumber));
        self::assertEquals(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getNumberType(self::$itNumber));
        self::assertEquals(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getNumberType(self::$gbNumber));
        self::assertEquals(PhoneNumberType::FIXED_LINE, $this->phoneUtil->getNumberType(self::$deNumber));
    }

    public function testIsFixedLineAndMobile(): void
    {
        self::assertEquals(PhoneNumberType::FIXED_LINE_OR_MOBILE, $this->phoneUtil->getNumberType(self::$usNumber));

        $fixedLineAndMobileNumber = new PhoneNumber();
        $fixedLineAndMobileNumber->setCountryCode(54)->setNationalNumber('1987654321');
        self::assertEquals(
            PhoneNumberType::FIXED_LINE_OR_MOBILE,
            $this->phoneUtil->getNumberType($fixedLineAndMobileNumber)
        );
    }

    public function testIsSharedCost(): void
    {
        $gbNumber = new PhoneNumber();
        $gbNumber->setCountryCode(44)->setNationalNumber('8431231234');
        self::assertEquals(PhoneNumberType::SHARED_COST, $this->phoneUtil->getNumberType($gbNumber));
    }

    public function testIsVoip(): void
    {
        $gbNumber = new PhoneNumber();
        $gbNumber->setCountryCode(44)->setNationalNumber('5631231234');
        self::assertEquals(PhoneNumberType::VOIP, $this->phoneUtil->getNumberType($gbNumber));
    }

    public function testIsPersonalNumber(): void
    {
        $gbNumber = new PhoneNumber();
        $gbNumber->setCountryCode(44)->setNationalNumber('7031231234');
        self::assertEquals(PhoneNumberType::PERSONAL_NUMBER, $this->phoneUtil->getNumberType($gbNumber));
    }

    public function testIsUnknown(): void
    {
        // Invalid numbers should be of type UNKNOWN.
        self::assertEquals(PhoneNumberType::UNKNOWN, $this->phoneUtil->getNumberType(self::$usLocalNumber));
    }

    public function testIsValidNumber(): void
    {
        self::assertTrue($this->phoneUtil->isValidNumber(self::$usNumber));
        self::assertTrue($this->phoneUtil->isValidNumber(self::$itNumber));
        self::assertTrue($this->phoneUtil->isValidNumber(self::$gbMobile));
        self::assertTrue($this->phoneUtil->isValidNumber(self::$internationalTollFree));
        self::assertTrue($this->phoneUtil->isValidNumber(self::$universalPremiumRate));

        $nzNumber = new PhoneNumber();
        $nzNumber->setCountryCode(64)->setNationalNumber('21387835');
        self::assertTrue($this->phoneUtil->isValidNumber($nzNumber));
    }

    public function testIsValidForRegion(): void
    {
        // This number is valid for the Bahamas, but is not a valid US number.
        self::assertTrue($this->phoneUtil->isValidNumber(self::$bsNumber));
        self::assertTrue($this->phoneUtil->isValidNumberForRegion(self::$bsNumber, RegionCode::BS));
        self::assertFalse($this->phoneUtil->isValidNumberForRegion(self::$bsNumber, RegionCode::US));
        $bsInvalidNumber = new PhoneNumber();
        $bsInvalidNumber->setCountryCode(1)->setNationalNumber('2421232345');
        // This number is no longer valid.
        self::assertFalse($this->phoneUtil->isValidNumber($bsInvalidNumber));

        // La Mayotte and Reunion use 'leadingDigits' to differentiate them.
        $reNumber = new PhoneNumber();
        $reNumber->setCountryCode(262)->setNationalNumber('262123456');
        self::assertTrue($this->phoneUtil->isValidNumber($reNumber));
        self::assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
        self::assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
        // Now change the number to be a number for La Mayotte.
        $reNumber->setNationalNumber('269601234');
        self::assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
        self::assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
        // This number is no longer valid for La Reunion.
        $reNumber->setNationalNumber('269123456');
        self::assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
        self::assertFalse($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
        self::assertFalse($this->phoneUtil->isValidNumber($reNumber));
        // However, it should be recognised as from La Mayotte, since it is valid for this region.
        self::assertEquals(RegionCode::YT, $this->phoneUtil->getRegionCodeForNumber($reNumber));
        // This number is valid in both places.
        $reNumber->setNationalNumber('800123456');
        self::assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::YT));
        self::assertTrue($this->phoneUtil->isValidNumberForRegion($reNumber, RegionCode::RE));
        self::assertTrue($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::UN001));
        self::assertFalse($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::US));
        self::assertFalse($this->phoneUtil->isValidNumberForRegion(self::$internationalTollFree, RegionCode::ZZ));

        $invalidNumber = new PhoneNumber();
        // Invalid country calling codes.
        $invalidNumber->setCountryCode(3923)->setNationalNumber('2366');
        self::assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::ZZ));
        self::assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::UN001));
        $invalidNumber->setCountryCode(0);
        self::assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::UN001));
        self::assertFalse($this->phoneUtil->isValidNumberForRegion($invalidNumber, RegionCode::ZZ));
    }

    public function testIsNotValidNumber(): void
    {
        self::assertFalse($this->phoneUtil->isValidNumber(self::$usLocalNumber));

        $invalidNumber = new PhoneNumber();
        $invalidNumber->setCountryCode(39)->setNationalNumber('23661830000')->setItalianLeadingZero(true);
        self::assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $invalidNumber->clear();
        $invalidNumber->setCountryCode(44)->setNationalNumber('791234567');
        self::assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $invalidNumber->clear();
        $invalidNumber->setCountryCode(49)->setNationalNumber('1234');
        self::assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $invalidNumber->clear();
        $invalidNumber->setCountryCode(64)->setNationalNumber('3316005');
        self::assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        $invalidNumber->clear();
        // Invalid country calling codes.
        $invalidNumber->setCountryCode(3923)->setNationalNumber('2366');
        self::assertFalse($this->phoneUtil->isValidNumber($invalidNumber));
        $invalidNumber->setCountryCode(0);
        self::assertFalse($this->phoneUtil->isValidNumber($invalidNumber));

        self::assertFalse($this->phoneUtil->isValidNumber(self::$internationalTollFreeTooLong));
    }

    public function testGetRegionCodeForCountryCode(): void
    {
        self::assertEquals(RegionCode::US, $this->phoneUtil->getRegionCodeForCountryCode(1));
        self::assertEquals(RegionCode::GB, $this->phoneUtil->getRegionCodeForCountryCode(44));
        self::assertEquals(RegionCode::DE, $this->phoneUtil->getRegionCodeForCountryCode(49));
        self::assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForCountryCode(800));
        self::assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForCountryCode(979));
    }

    public function testGetRegionCodeForNumber(): void
    {
        self::assertEquals(RegionCode::BS, $this->phoneUtil->getRegionCodeForNumber(self::$bsNumber));
        self::assertEquals(RegionCode::US, $this->phoneUtil->getRegionCodeForNumber(self::$usNumber));
        self::assertEquals(RegionCode::GB, $this->phoneUtil->getRegionCodeForNumber(self::$gbMobile));
        self::assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForNumber(self::$internationalTollFree));
        self::assertEquals(RegionCode::UN001, $this->phoneUtil->getRegionCodeForNumber(self::$universalPremiumRate));
    }

    public function testGetRegionCodesForCountryCode(): void
    {
        $regionCodesForNANPA = $this->phoneUtil->getRegionCodesForCountryCode(1);
        self::assertContains(RegionCode::US, $regionCodesForNANPA);
        self::assertContains(RegionCode::BS, $regionCodesForNANPA);
        self::assertContains(RegionCode::GB, $this->phoneUtil->getRegionCodesForCountryCode(44));
        self::assertContains(RegionCode::DE, $this->phoneUtil->getRegionCodesForCountryCode(49));
        self::assertContains(RegionCode::UN001, $this->phoneUtil->getRegionCodesForCountryCode(800));
        // Test with invalid country calling code.
        self::assertEmpty($this->phoneUtil->getRegionCodesForCountryCode(-1));
    }

    public function testGetCountryCodeForRegion(): void
    {
        self::assertEquals(1, $this->phoneUtil->getCountryCodeForRegion(RegionCode::US));
        self::assertEquals(64, $this->phoneUtil->getCountryCodeForRegion(RegionCode::NZ));
        self::assertEquals(0, $this->phoneUtil->getCountryCodeForRegion(RegionCode::ZZ));
        self::assertEquals(0, $this->phoneUtil->getCountryCodeForRegion(RegionCode::UN001));
        // CS is already deprecated so the library doesn't support it
        self::assertEquals(0, $this->phoneUtil->getCountryCodeForRegion(RegionCode::CS));
    }

    public function testGetNationalDiallingPrefixForRegion(): void
    {
        self::assertEquals('1', $this->phoneUtil->getNddPrefixForRegion(RegionCode::US, false));
        // Test non-main country to see it gets the national dialling prefix for the main country with
        // that country calling code.
        self::assertEquals('1', $this->phoneUtil->getNddPrefixForRegion(RegionCode::BS, false));
        self::assertEquals('0', $this->phoneUtil->getNddPrefixForRegion(RegionCode::NZ, false));
        // Test case with non digit in the national prefix.
        self::assertEquals('0~0', $this->phoneUtil->getNddPrefixForRegion(RegionCode::AO, false));
        self::assertEquals('00', $this->phoneUtil->getNddPrefixForRegion(RegionCode::AO, true));
        // Test cases with invalid regions.
        self::assertNull($this->phoneUtil->getNddPrefixForRegion(RegionCode::ZZ, false));
        self::assertNull($this->phoneUtil->getNddPrefixForRegion(RegionCode::UN001, false));
        // CS is already deprecated so the library doesn't support it.
        self::assertNull($this->phoneUtil->getNddPrefixForRegion(RegionCode::CS, false));
    }

    public function testIsNANPACountry(): void
    {
        self::assertTrue($this->phoneUtil->isNANPACountry(RegionCode::US));
        self::assertTrue($this->phoneUtil->isNANPACountry(RegionCode::BS));
        self::assertFalse($this->phoneUtil->isNANPACountry(RegionCode::DE));
        self::assertFalse($this->phoneUtil->isNANPACountry(RegionCode::ZZ));
        self::assertFalse($this->phoneUtil->isNANPACountry(RegionCode::UN001));
    }

    public function testIsPossibleNumber(): void
    {
        self::assertTrue($this->phoneUtil->isPossibleNumber(self::$usNumber));
        self::assertTrue($this->phoneUtil->isPossibleNumber(self::$usLocalNumber));
        self::assertTrue($this->phoneUtil->isPossibleNumber(self::$gbNumber));
        self::assertTrue($this->phoneUtil->isPossibleNumber(self::$internationalTollFree));

        self::assertTrue($this->phoneUtil->isPossibleNumber('+1 650 253 0000', RegionCode::US));
        self::assertTrue($this->phoneUtil->isPossibleNumber('+1 650 GOO OGLE', RegionCode::US));
        self::assertTrue($this->phoneUtil->isPossibleNumber('(650) 253-0000', RegionCode::US));
        self::assertTrue($this->phoneUtil->isPossibleNumber('253-0000', RegionCode::US));
        self::assertTrue($this->phoneUtil->isPossibleNumber('+1 650 253 0000', RegionCode::GB));
        self::assertTrue($this->phoneUtil->isPossibleNumber('+44 20 7031 3000', RegionCode::GB));
        self::assertTrue($this->phoneUtil->isPossibleNumber('(020) 7031 300', RegionCode::GB));
        self::assertTrue($this->phoneUtil->isPossibleNumber('7031 3000', RegionCode::GB));
        self::assertTrue($this->phoneUtil->isPossibleNumber('3331 6005', RegionCode::NZ));
        self::assertTrue($this->phoneUtil->isPossibleNumber('+800 1234 5678', RegionCode::UN001));
    }

    public function testIsPossibleNumberForType_DifferentTypeLengths(): void
    {
        // We use Argentinian numbers since they have different possible lengths for different types.
        $number = new PhoneNumber();
        $number->setCountryCode(54)->setNationalNumber('12345');

        // Too short for any Argentinian number, including fixed-line.
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::UNKNOWN));

        // 6-digit numbers are oaky for fixed-line.
        $number->setNationalNumber('1234567');
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::UNKNOWN));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
        // But too short for mobile.
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::MOBILE));
        // And too short for toll-free
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::TOLL_FREE));

        // The same applies for 9-digit numbers
        $number->setNationalNumber('123456789');
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::UNKNOWN));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::MOBILE));
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::TOLL_FREE));

        // 10-digit numbers are universally possible.
        $number->setNationalNumber('1234567890');
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::UNKNOWN));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::MOBILE));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::TOLL_FREE));

        // 11-digit numbers are only possible for mobile numbers. Note we don't require the leading 9,
        // which all mobile numbers start with, and would be required for a valid mobile number.
        $number->setNationalNumber('12345678901');
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::UNKNOWN));
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::MOBILE));
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::TOLL_FREE));
    }

    public function testIsPossibleNumberForType_LocalOnly(): void
    {
        $number = new PhoneNumber();
        // Here we test a number length which matches a local-only length.
        $number->setCountryCode(49)->setNationalNumber('12');
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::UNKNOWN));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
        // Mobile numbers must be 10 or 11 digits, and there are no local-only lengths.
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::MOBILE));
    }

    public function testIsPossibleNumberForType_DataMissingForSizeReasons(): void
    {
        $number = new PhoneNumber();
        // Here we test something where the possible lengths match the possible lengths of the country
        // as a whole, and hence aren't present in the binary for size reasons - this should still work.
        // Local-only number.
        $number->setCountryCode(55)->setNationalNumber('12345678');
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::UNKNOWN));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));

        $number->setNationalNumber('1234567890');
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::UNKNOWN));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
    }

    public function testIsPossibleNumberForType_NumberTypeNotSupportedForRegion(): void
    {
        $number = new PhoneNumber();
        // There are *no* mobile numbers for this region at all, so we return false.
        $number->setCountryCode(55)->setNationalNumber('12345678');
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::MOBILE));
        // This matches a fixed-line length though.
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE_OR_MOBILE));

        // There are *no* fixed-line OR mobile numbers for this country calling code at all, so we
        // return false for these
        $number->setCountryCode(979)->setNationalNumber('123456789');
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::MOBILE));
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE));
        self::assertFalse($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::FIXED_LINE_OR_MOBILE));
        self::assertTrue($this->phoneUtil->isPossibleNumberForType($number, PhoneNumberType::PREMIUM_RATE));
    }

    public function testIsPossibleNumberWithReason(): void
    {
        // National numbers for country calling code +1 that are within 7 to 10 digits are possible.
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberWithReason(self::$usNumber)
        );

        self::assertEquals(
            ValidationResult::IS_POSSIBLE_LOCAL_ONLY,
            $this->phoneUtil->isPossibleNumberWithReason(self::$usLocalNumber)
        );

        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberWithReason(self::$usLongNumber)
        );

        $number = new PhoneNumber();
        $number->setCountryCode(0)->setNationalNumber('2530000');
        self::assertEquals(
            ValidationResult::INVALID_COUNTRY_CODE,
            $this->phoneUtil->isPossibleNumberWithReason($number)
        );

        $number->clear();
        $number->setCountryCode(1)->setNationalNumber('253000');
        self::assertEquals(ValidationResult::TOO_SHORT, $this->phoneUtil->isPossibleNumberWithReason($number));

        $number->clear();
        $number->setCountryCode(65)->setNationalNumber('1234567890');
        self::assertEquals(ValidationResult::IS_POSSIBLE, $this->phoneUtil->isPossibleNumberWithReason($number));

        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberWithReason(self::$internationalTollFreeTooLong)
        );
    }

    public function testIsPossibleNumberForTypeWithReason_DifferentTypeLengths(): void
    {
        // We use Argentinian numbers since they have different possible lengths for different types.
        $number = new PhoneNumber();
        $number->setCountryCode(54)->setNationalNumber('12345');
        // Too short for any Argentinian number.
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::UNKNOWN)
        );
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );

        // 6-digit numbers are okay for fixed-line.
        $number->setNationalNumber('123456');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::UNKNOWN)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        // But too short for mobile.
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        // And too short for toll-free.
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::TOLL_FREE)
        );

        // The same applies to 9-digit numbers.
        $number->setNationalNumber('123456789');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::UNKNOWN)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::TOLL_FREE)
        );

        // 10-digit numbers are universally possible.
        $number->setNationalNumber('1234567890');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::UNKNOWN)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::TOLL_FREE)
        );

        // 11-digit numbers are only possible for mobile numbers. Note we don't require the leading 9,
        // which all mobile numbers start with, and would be required for a valid mobile number.
        $number->setNationalNumber('12345678901');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::UNKNOWN)
        );
        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::TOLL_FREE)
        );
    }

    public function testIsPossibleNumberForTypeWithReason_LocalOnly(): void
    {
        $number = new PhoneNumber();
        // Here we test a number length which matches a local-only length.
        $number->setCountryCode(49)->setNationalNumber('12');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE_LOCAL_ONLY,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::UNKNOWN)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE_LOCAL_ONLY,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        // Mobile numbers must be 10 or 11 digits, and there are no local-only lengths.
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
    }

    public function testIsPossibleNumberForTypeWithReason_DataMissingForSizeReasons(): void
    {
        $number = new PhoneNumber();
        // Here we test something where the possible lengths match the possible lengths of the country
        // as a whole, and hence aren't present in the binary for size reasons - this should still work.
        // Local-only number.
        $number->setCountryCode(55)->setNationalNumber('12345678');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE_LOCAL_ONLY,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::UNKNOWN)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE_LOCAL_ONLY,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );

        // Normal-length number.
        $number->setNationalNumber('1234567890');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::UNKNOWN)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
    }

    public function testIsPossibleNumberForTypeWithReason_NumberTypeNotSupportedForRegion(): void
    {
        $number = new PhoneNumber();
        // There are *no* mobile numbers for this region at all, so we return INVALID_LENGTH.
        $number->setCountryCode(55)->setNationalNumber('12345678');
        self::assertEquals(
            ValidationResult::INVALID_LENGTH,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        // This matches a fixed-line length though.
        self::assertEquals(
            ValidationResult::IS_POSSIBLE_LOCAL_ONLY,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );
        // This is too short for fixed-line, and no mobile numbers exist.
        $number->setCountryCode(55)->setNationalNumber('1234567');
        self::assertEquals(
            ValidationResult::INVALID_LENGTH,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );

        // This is too short for mobile, and no fixed-line numbers exist.
        $number->setCountryCode(882)->setNationalNumber('1234567');
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );
        self::assertEquals(
            ValidationResult::INVALID_LENGTH,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );

        // There are *no* fixed-line OR mobile numbers for this country calling code at all, so we
        // return INVALID_LENGTH.
        $number->setCountryCode(979)->setNationalNumber('123456789');
        self::assertEquals(
            ValidationResult::INVALID_LENGTH,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::INVALID_LENGTH,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        self::assertEquals(
            ValidationResult::INVALID_LENGTH,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::PREMIUM_RATE)
        );
    }

    public function testIsPossibleNumberForTypeWithReason_FixedLineOrMobile(): void
    {
        $number = new PhoneNumber();
        // For FIXED_LINE_OR_MOBILE, a number should be considered valid if it matches the possible
        // lengths for mobile *or* fixed-line numbers.
        $number->setCountryCode(290)->setNationalNumber('1234');
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );

        $number->setNationalNumber('12345');
        self::assertEquals(
            ValidationResult::TOO_SHORT,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::INVALID_LENGTH,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );

        $number->setNationalNumber('123456');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );

        $number->setNationalNumber('1234567');
        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE)
        );
        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::MOBILE)
        );
        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );

        // 8-digit numbers are possible for toll-free and premium-rate numbers only.
        $number->setNationalNumber('12345678');
        self::assertEquals(
            ValidationResult::IS_POSSIBLE,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::TOLL_FREE)
        );
        self::assertEquals(
            ValidationResult::TOO_LONG,
            $this->phoneUtil->isPossibleNumberForTypeWithReason($number, PhoneNumberType::FIXED_LINE_OR_MOBILE)
        );
    }

    public function testIsNotPossibleNumber(): void
    {
        self::assertFalse($this->phoneUtil->isPossibleNumber(self::$usLongNumber));
        self::assertFalse($this->phoneUtil->isPossibleNumber(self::$internationalTollFreeTooLong));

        $number = new PhoneNumber();
        $number->setCountryCode(1)->setNationalNumber('253000');
        self::assertFalse($this->phoneUtil->isPossibleNumber($number));

        $number->clear();
        $number->setCountryCode(44)->setNationalNumber('300');
        self::assertFalse($this->phoneUtil->isPossibleNumber($number));
        self::assertFalse($this->phoneUtil->isPossibleNumber('+1 650 253 00000', RegionCode::US));
        self::assertFalse($this->phoneUtil->isPossibleNumber('(650) 253-00000', RegionCode::US));
        self::assertFalse($this->phoneUtil->isPossibleNumber('I want a Pizza', RegionCode::US));
        self::assertFalse($this->phoneUtil->isPossibleNumber('253-000', RegionCode::US));
        self::assertFalse($this->phoneUtil->isPossibleNumber('1 3000', RegionCode::GB));
        self::assertFalse($this->phoneUtil->isPossibleNumber('+44 300', RegionCode::GB));
        self::assertFalse($this->phoneUtil->isPossibleNumber('+800 1234 5678 9', RegionCode::UN001));
    }

    public function testTruncateTooLongNumber(): void
    {
        // GB number 080 1234 5678, but entered with 4 extra digits at the end.
        $tooLongNumber = new PhoneNumber();
        $tooLongNumber->setCountryCode(44)->setNationalNumber('80123456780123');
        $validNumber = new PhoneNumber();
        $validNumber->setCountryCode(44)->setNationalNumber('8012345678');
        self::assertTrue($this->phoneUtil->truncateTooLongNumber($tooLongNumber));
        self::assertEquals($validNumber, $tooLongNumber);

        // IT number 022 3456 7890, but entered with 3 extra digits at the end.
        $tooLongNumber->clear();
        $tooLongNumber->setCountryCode(39)->setNationalNumber('2234567890123')->setItalianLeadingZero(true);
        $validNumber->clear();
        $validNumber->setCountryCode(39)->setNationalNumber('2234567890')->setItalianLeadingZero(true);
        self::assertTrue($this->phoneUtil->truncateTooLongNumber($tooLongNumber));
        self::assertEquals($validNumber, $tooLongNumber);

        // US number 650-253-0000, but entered with one additional digit at the end.
        $tooLongNumber->clear();
        $tooLongNumber->mergeFrom(self::$usLongNumber);
        self::assertTrue($this->phoneUtil->truncateTooLongNumber($tooLongNumber));
        self::assertEquals(self::$usNumber, $tooLongNumber);

        $tooLongNumber->clear();
        $tooLongNumber->mergeFrom(self::$internationalTollFreeTooLong);
        self::assertTrue($this->phoneUtil->truncateTooLongNumber($tooLongNumber));
        self::assertEquals(self::$internationalTollFree, $tooLongNumber);

        // Tests what happens when a valid number is passed in.
        $validNumberCopy = new PhoneNumber();
        $validNumberCopy->mergeFrom($validNumber);
        self::assertTrue($this->phoneUtil->truncateTooLongNumber($validNumber));

        // Tests the number is not modified.
        self::assertEquals($validNumberCopy, $validNumber);

        // Tests what happens when a number with invalid prefix is passed in.
        $numberWithInvalidPrefix = new PhoneNumber();
        // The test metadata says US numbers cannot have prefix 240.
        $numberWithInvalidPrefix->setCountryCode(1)->setNationalNumber('2401234567');
        $invalidNumberCopy = new PhoneNumber();
        $invalidNumberCopy->mergeFrom($numberWithInvalidPrefix);
        self::assertFalse($this->phoneUtil->truncateTooLongNumber($numberWithInvalidPrefix));
        // Tests the number is not modified.
        self::assertEquals($invalidNumberCopy, $numberWithInvalidPrefix);

        // Tests what happens when a too short number is passed in.
        $tooShortNumber = new PhoneNumber();
        $tooShortNumber->setCountryCode(1)->setNationalNumber('1234');
        $tooShortNumberCopy = new PhoneNumber();
        $tooShortNumberCopy->mergeFrom($tooShortNumber);
        self::assertFalse($this->phoneUtil->truncateTooLongNumber($tooShortNumber));
        // Tests the number is not modified.
        self::assertEquals($tooShortNumberCopy, $tooShortNumber);
    }

    public function testIsViablePhoneNumber(): void
    {
        self::assertFalse(PhoneNumberUtil::isViablePhoneNumber('1'));
        // Only one or two digits before strange non-possible punctuation.
        self::assertFalse(PhoneNumberUtil::isViablePhoneNumber('1+1+1'));
        self::assertFalse(PhoneNumberUtil::isViablePhoneNumber('80+0'));
        // Two digits is viable.
        self::assertTrue(PhoneNumberUtil::isViablePhoneNumber('00'));
        self::assertTrue(PhoneNumberUtil::isViablePhoneNumber('111'));
        // Alpha numbers.
        self::assertTrue(PhoneNumberUtil::isViablePhoneNumber('0800-4-pizza'));
        self::assertTrue(PhoneNumberUtil::isViablePhoneNumber('0800-4-PIZZA'));

        // We need at least three digits before any alpha characters.
        self::assertFalse(PhoneNumberUtil::isViablePhoneNumber('08-PIZZA'));
        self::assertFalse(PhoneNumberUtil::isViablePhoneNumber('8-PIZZA'));
        self::assertFalse(PhoneNumberUtil::isViablePhoneNumber('12. March'));
    }

    public function testIsViablePhoneNumberNonAscii(): void
    {
        // Only one or two digits before possible punctuation followed by more digits.
        self::assertTrue(PhoneNumberUtil::isViablePhoneNumber('1' . pack('H*', 'e38080') . '34'));
        self::assertFalse(PhoneNumberUtil::isViablePhoneNumber('1' . pack('H*', 'e38080') . '3+4'));
        // Unicode variants of possible starting character and other allowed punctuation/digits.
        self::assertTrue(
            PhoneNumberUtil::isViablePhoneNumber(
                pack('H*', 'efbc88') . '1' . pack('H*', 'efbc89') . pack('H*', 'e38080') . '3456789'
            )
        );
        // Testing a leading + is okay.
        self::assertTrue(
            PhoneNumberUtil::isViablePhoneNumber('+1' . pack('H*', 'efbc89') . pack('H*', 'e38080') . '3456789')
        );
    }

    public function testExtractPossibleNumber(): void
    {
        // Removes preceding funky punctuation and letters but leaves the rest untouched.
        self::assertEquals('0800-345-600', PhoneNumberUtil::extractPossibleNumber('Tel:0800-345-600'));
        self::assertEquals('0800 FOR PIZZA', PhoneNumberUtil::extractPossibleNumber('Tel:0800 FOR PIZZA'));
        // Should not remove plus sign
        self::assertEquals('+800-345-600', PhoneNumberUtil::extractPossibleNumber('Tel:+800-345-600'));
        // Should recognise wide digits as possible start values.
        self::assertEquals(
            pack('H*', 'efbc90') . pack('H*', 'efbc92') . pack('H*', 'efbc93'),
            PhoneNumberUtil::extractPossibleNumber(pack('H*', 'efbc90') . pack('H*', 'efbc92') . pack('H*', 'efbc93'))
        );
        // Dashes are not possible start values and should be removed.
        self::assertEquals(
            pack('H*', 'efbc91') . pack('H*', 'efbc92') . pack('H*', 'efbc93'),
            PhoneNumberUtil::extractPossibleNumber(
                'Num-' . pack('H*', 'efbc91') . pack('H*', 'efbc92') . pack('H*', 'efbc93')
            )
        );
        // If not possible number present, return empty string.
        self::assertEquals('', PhoneNumberUtil::extractPossibleNumber('Num-....'));
        // Leading brackets are stripped - these are not used when parsing.
        self::assertEquals('650) 253-0000', PhoneNumberUtil::extractPossibleNumber('(650) 253-0000'));

        // Trailing non-alpha-numeric characters should be removed.
        self::assertEquals('650) 253-0000', PhoneNumberUtil::extractPossibleNumber('(650) 253-0000..- ..'));
        self::assertEquals('650) 253-0000', PhoneNumberUtil::extractPossibleNumber('(650) 253-0000.'));
        // This case has a trailing RTL char.
        self::assertEquals(
            '650) 253-0000',
            PhoneNumberUtil::extractPossibleNumber('(650) 253-0000' . pack('H*', 'e2808f'))
        );
    }

    public function testMaybeStripNationalPrefix(): void
    {
        $metadata = new class extends PhoneMetadata {
            public function setNationalPrefixForParsing(string $value): void
            {
                $this->nationalPrefixForParsing = $value;
            }

            public function setGeneralDesc(PhoneNumberDesc $value): void
            {
                $this->generalDesc = $value;
            }

            public function setNationalPrefixTransformRule(string $value): void
            {
                $this->nationalPrefixTransformRule = $value;
            }
        };
        $metadata->setNationalPrefixForParsing('34');
        $phoneNumberDesc = new PhoneNumberDesc();
        $phoneNumberDesc->setNationalNumberPattern('\\d{4,8}');
        $metadata->setGeneralDesc($phoneNumberDesc);

        $numberToStrip = '34356778';
        $strippedNumber = '356778';

        $carrierCode = '';

        self::assertTrue(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        self::assertEquals($strippedNumber, $numberToStrip, 'Should have had national prefix stripped.');
        // Retry stripping - now the number should not start with the national prefix, so no more
        // stripping should occur.
        $carrierCode = '';
        self::assertFalse(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        self::assertEquals($strippedNumber, $numberToStrip, 'Should have had no change - no national prefix present.');

        // Some countries have no national prefix. Repeat test with none specified.
        $metadata->setNationalPrefixForParsing('');
        $carrierCode = '';
        self::assertFalse(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        self::assertEquals($strippedNumber, $numberToStrip, 'Should not strip anything with empty national prefix.');

        // If the resultant number doesn't match the national rule, it shouldn't be stripped.
        $metadata->setNationalPrefixForParsing('3');
        $numberToStrip = '3123';
        $strippedNumber = '3123';
        $carrierCode = '';
        self::assertFalse(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        self::assertEquals(
            $strippedNumber,
            $numberToStrip,
            "Should have had no change - after stripping, it wouldn't have matched the national rule."
        );

        // Test extracting carrier selection code.
        $metadata->setNationalPrefixForParsing('0(81)?');
        $numberToStrip = '08122123456';
        $strippedNumber = '22123456';
        $carrierCode = '';
        self::assertTrue(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        self::assertEquals('81', $carrierCode);
        self::assertEquals(
            $strippedNumber,
            $numberToStrip,
            'Should have had national prefix and carrier code stripped.'
        );

        // If there was a transform rule, check it was applied.
        $metadata->setNationalPrefixTransformRule('5${1}5');
        // Note that a capturing group is present here.
        $metadata->setNationalPrefixForParsing('0(\\d{2})');
        $numberToStrip = '031123';
        $transformedNumber = '5315123';
        $carrierCode = '';
        self::assertTrue(
            $this->phoneUtil->maybeStripNationalPrefixAndCarrierCode($numberToStrip, $metadata, $carrierCode)
        );
        self::assertEquals($transformedNumber, $numberToStrip, 'Should transform the 031 to a 5315.');
    }

    public function testMaybeStripInternationalPrefix(): void
    {
        $internationalPrefix = '00[39]';
        $numberToStrip = '0034567700-3898003';
        // Note the dash is removed as part of the normalization.
        $strippedNumber = '45677003898003';
        self::assertEquals(
            CountryCodeSource::FROM_NUMBER_WITH_IDD,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        self::assertEquals(
            $strippedNumber,
            $numberToStrip,
            'The number supplied was not stripped of its international prefix.'
        );

        // Now the number no longer starts with an IDD prefix, so it should now report
        // FROM_DEFAULT_COUNTRY.
        self::assertEquals(
            CountryCodeSource::FROM_DEFAULT_COUNTRY,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );

        $numberToStrip = '00945677003898003';
        self::assertEquals(
            CountryCodeSource::FROM_NUMBER_WITH_IDD,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        self::assertEquals(
            $strippedNumber,
            $numberToStrip,
            'The number supplied was not stripped of its international prefix.'
        );

        // Test it works when the international prefix is broken up by spaces.
        $numberToStrip = '00 9 45677003898003';
        self::assertEquals(
            CountryCodeSource::FROM_NUMBER_WITH_IDD,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        self::assertEquals(
            $strippedNumber,
            $numberToStrip,
            'The number supplied was not stripped of its international prefix.'
        );

        // Now the number no longer starts with an IDD prefix, so it should now report
        // FROM_DEFAULT_COUNTRY.
        self::assertEquals(
            CountryCodeSource::FROM_DEFAULT_COUNTRY,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );

        // Test the + symbol is also recognised and stripped.
        $numberToStrip = '+45677003898003';
        $strippedNumber = '45677003898003';
        self::assertEquals(
            CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        self::assertEquals(
            $strippedNumber,
            $numberToStrip,
            'The number supplied was not stripped of the plus symbol.'
        );

        // If the number afterwards is a zero, we should not strip this - no country calling code begins
        // with 0.
        $numberToStrip = '0090112-3123';
        $strippedNumber = '00901123123';
        self::assertEquals(
            CountryCodeSource::FROM_DEFAULT_COUNTRY,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
        self::assertEquals(
            $strippedNumber,
            $numberToStrip,
            "The number supplied had a 0 after the match so shouldn't be stripped."
        );

        // Here the 0 is separated by a space from the IDD.
        $numberToStrip = '009 0-112-3123';
        self::assertEquals(
            CountryCodeSource::FROM_DEFAULT_COUNTRY,
            $this->phoneUtil->maybeStripInternationalPrefixAndNormalize($numberToStrip, $internationalPrefix)
        );
    }

    public function testMaybeExtractCountryCode(): void
    {
        $number = new PhoneNumber();
        $metadata = $this->phoneUtil->getMetadataForRegion(RegionCode::US);
        // Note that for the US, the IDD is 011.
        try {
            $phoneNumber = '011112-3456789';
            $strippedNumber = '123456789';
            $countryCallingCode = 1;
            $numberToFill = '';
            self::assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                'Did not extract country calling code ' . $countryCallingCode . ' correctly.'
            );
            self::assertEquals(
                CountryCodeSource::FROM_NUMBER_WITH_IDD,
                $number->getCountryCodeSource(),
                'Did not figure out CountryCodeSource correctly'
            );
            // Should strip and normalize national significant number.
            self::assertEquals(
                $strippedNumber,
                $numberToFill,
                'Did not strip off the country calling code correctly.'
            );
        } catch (NumberParseException $e) {
            self::fail('Should not have thrown an exception: ' . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = '+6423456789';
            $countryCallingCode = 64;
            $numberToFill = '';
            self::assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                'Did not extract country calling code ' . $countryCallingCode . ' correctly.'
            );
            self::assertEquals(
                CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN,
                $number->getCountryCodeSource(),
                'Did not figure out CountryCodeSource correctly'
            );
        } catch (NumberParseException $e) {
            self::fail('Should not have thrown an exception: ' . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = '+80012345678';
            $countryCallingCode = 800;
            $numberToFill = '';
            self::assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                'Did not extract country calling code ' . $countryCallingCode . ' correctly.'
            );
            self::assertEquals(
                CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN,
                $number->getCountryCodeSource(),
                'Did not figure out CountryCodeSource correctly'
            );
        } catch (NumberParseException $e) {
            self::fail('Should not have thrown an exception: ' . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = '2345-6789';
            $numberToFill = '';
            self::assertEquals(
                0,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                'Should not have extracted a country calling code - no international prefix present.'
            );
            self::assertEquals(
                CountryCodeSource::FROM_DEFAULT_COUNTRY,
                $number->getCountryCodeSource(),
                'Did not figure out CountryCodeSource correctly'
            );
        } catch (NumberParseException $e) {
            self::fail('Should not have thrown an exception: ' . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = '0119991123456789';
            $numberToFill = '';
            $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number);
            self::fail('Should have thrown an exception, no valid country calling code present.');
        } catch (NumberParseException $e) {
            // Expected.
            self::assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }
        $number->clear();
        try {
            $phoneNumber = '(1 610) 619 4466';
            $countryCallingCode = 1;
            $numberToFill = '';
            self::assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                'Should have extracted the country calling code of the region passed in'
            );
            self::assertEquals(
                CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN,
                $number->getCountryCodeSource(),
                'Did not figure out CountryCodeSource correctly'
            );
        } catch (NumberParseException $e) {
            self::fail('Should not have thrown an exception: ' . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = '(1 610) 619 4466';
            $countryCallingCode = 1;
            $numberToFill = '';
            self::assertEquals(
                $countryCallingCode,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, false, $number),
                'Should have extracted the country calling code of the region passed in'
            );
            self::assertFalse($number->hasCountryCodeSource(), 'Should not contain CountryCodeSource');
        } catch (NumberParseException $e) {
            self::fail('Should not have thrown an exception: ' . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = '(1 610) 619 446';
            $numberToFill = '';
            self::assertEquals(
                0,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, false, $number),
                'Should not have extracted a country calling code - invalid number after extraction of uncertain country calling code.'
            );
            self::assertFalse($number->hasCountryCodeSource(), 'Should not contain CountryCodeSource');
        } catch (NumberParseException $e) {
            self::fail('Should not have thrown an exception: ' . $e->getMessage());
        }
        $number->clear();
        try {
            $phoneNumber = '(1 610) 619';
            $numberToFill = '';
            self::assertEquals(
                0,
                $this->phoneUtil->maybeExtractCountryCode($phoneNumber, $metadata, $numberToFill, true, $number),
                'Should not have extracted a country calling code - too short number both before and after extraction of uncertain country calling code.'
            );
            self::assertEquals(
                CountryCodeSource::FROM_DEFAULT_COUNTRY,
                $number->getCountryCodeSource(),
                'Did not figure out CountryCodeSource correctly'
            );
        } catch (NumberParseException $e) {
            self::fail('Should not have thrown an exception: ' . $e->getMessage());
        }
    }

    public function testParseNationalNumber(): void
    {
        // National prefix attached.
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('033316005', RegionCode::NZ));
        // Some fields are not filled in by parse, but only by parseAndKeepRawInput
        self::assertFalse(self::$nzNumber->hasCountryCodeSource());
        self::assertEquals(CountryCodeSource::UNSPECIFIED, self::$nzNumber->getCountryCodeSource());

        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('33316005', RegionCode::NZ));
        // National prefix attached and some formatting present.
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('03-331 6005', RegionCode::NZ));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('03 331 6005', RegionCode::NZ));

        // Test parsing RFC3966 format with a phone context.
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('tel:03-331-6005;phone-context=+64', RegionCode::NZ)
        );
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('tel:331-6005;phone-context=+64-3', RegionCode::NZ)
        );
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('tel:331-6005;phone-context=+64-3', RegionCode::US)
        );
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('My number is tel:03-331-6005;phone-context=+64', RegionCode::NZ)
        );
        // Test parsing RFC3966 format with optional user-defined parameters. The parameters will appear
        // after the context if present.
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('tel:03-331-6005;phone-context=+64;a=%A1', RegionCode::NZ)
        );
        // Test parsing RFC3966 with an ISDN subaddress.
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('tel:03-331-6005;isub=12345;phone-context=+64', RegionCode::NZ)
        );
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('tel:+64-3-331-6005;isub=12345', RegionCode::NZ));

        // Test parsing RFC3966 with "tel:" missing
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('03-331-6005;phone-context=+64', RegionCode::NZ));

        // Testing international prefixes.
        // Should strip country calling code.
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('0064 3 331 6005', RegionCode::NZ));
        // Try again, but this time we have an international number with Region Code US. It should
        // recognise the country calling code and parse accordingly.
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('01164 3 331 6005', RegionCode::US));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('+64 3 331 6005', RegionCode::US));
        // We should ignore the leading plus here, since it is not followed by a valid country code but
        // instead is followed by the IDD for the US.
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('+01164 3 331 6005', RegionCode::US));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('+0064 3 331 6005', RegionCode::NZ));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('+ 00 64 3 331 6005', RegionCode::NZ));

        self::assertEquals(
            self::$usLocalNumber,
            $this->phoneUtil->parse('tel:253-0000;phone-context=www.google.com', RegionCode::US)
        );
        self::assertEquals(
            self::$usLocalNumber,
            $this->phoneUtil->parse('tel:253-0000;isub=12345;phone-context=www.google.com', RegionCode::US)
        );
        self::assertEquals(
            self::$usLocalNumber,
            $this->phoneUtil->parse('tel:2530000;isub=12345;phone-context=1234.com', RegionCode::US)
        );

        $nzNumber = new PhoneNumber();
        $nzNumber->setCountryCode(64)->setNationalNumber('64123456');
        self::assertEquals($nzNumber, $this->phoneUtil->parse('64(0)64123456', RegionCode::NZ));
        // Check that using a "/" is fine in a phone number.
        self::assertEquals(self::$deNumber, $this->phoneUtil->parse('301/23456', RegionCode::DE));

        $usNumber = new PhoneNumber();
        // Check it doesn't use the '1' as a country calling code when parsing if the phone number was
        // already possible.
        $usNumber->setCountryCode(1)->setNationalNumber('1234567890');
        self::assertEquals($usNumber, $this->phoneUtil->parse('123-456-7890', RegionCode::US));

        // Test star numbers. Although this is not strictly valid, we would like to make sure we can
        // parse the output we produce when formatting the number.
        self::assertEquals(self::$jpStarNumber, $this->phoneUtil->parse('+81 *2345', RegionCode::JP));

        $shortNumber = new PhoneNumber();
        $shortNumber->setCountryCode(64)->setNationalNumber('12');
        self::assertEquals($shortNumber, $this->phoneUtil->parse('12', RegionCode::NZ));

        // Test for short-code with leading zero for a country which has 0 as national prefix. Ensure
        // it's not interpreted as national prefix if the remaining number length is local-only in
        // terms of length. Example: In GB, length 6-7 are only possible local-only.
        $shortNumber = new PhoneNumber();
        $shortNumber->setCountryCode(44)->setNationalNumber('123456')->setItalianLeadingZero(true);
        self::assertEquals($shortNumber, $this->phoneUtil->parse('0123456', RegionCode::GB));
    }

    public function testParseNumberWithAlphaCharacters(): void
    {
        // Test case with alpha characters.
        $tollFreeNumber = new PhoneNumber();
        $tollFreeNumber->setCountryCode(64)->setNationalNumber('800332005');
        self::assertEquals($tollFreeNumber, $this->phoneUtil->parse('0800 DDA 005', RegionCode::NZ));

        $premiumNumber = new PhoneNumber();
        $premiumNumber->setCountryCode(64)->setNationalNumber('9003326005');
        self::assertEquals($premiumNumber, $this->phoneUtil->parse('0900 DDA 6005', RegionCode::NZ));

        // Not enough alpha characters for them to be considered intentional, so they are stripped.
        self::assertEquals($premiumNumber, $this->phoneUtil->parse('0900 332 6005a', RegionCode::NZ));
        self::assertEquals($premiumNumber, $this->phoneUtil->parse('0900 332 600a5', RegionCode::NZ));
        self::assertEquals($premiumNumber, $this->phoneUtil->parse('0900 332 600A5', RegionCode::NZ));
        self::assertEquals($premiumNumber, $this->phoneUtil->parse('0900 a332 600A5', RegionCode::NZ));
    }

    public function testParseMaliciousInput(): void
    {
        // Lots of leading + signs before the possible number.
        $maliciousNumber = str_repeat('+', 6000);
        $maliciousNumber .= '12222-33-244 extensioB 343+';

        try {
            $this->phoneUtil->parse($maliciousNumber, RegionCode::US);
            self::fail('This should not parse without throwing an exception ' . $maliciousNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::TOO_LONG,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        $maliciousNumberWithAlmostExt = str_repeat('200', 350);
        $maliciousNumberWithAlmostExt .= ' extensiOB 345';
        try {
            $this->phoneUtil->parse($maliciousNumberWithAlmostExt, RegionCode::US);
            self::fail('This should not parse without throwing an exception ' . $maliciousNumberWithAlmostExt);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::TOO_LONG,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }
    }

    public function testParseWithInternationalPrefixes(): void
    {
        self::assertEquals(self::$usNumber, $this->phoneUtil->parse('+1 (650) 253-0000', RegionCode::NZ));
        self::assertEquals(self::$internationalTollFree, $this->phoneUtil->parse('011 800 1234 5678', RegionCode::US));
        self::assertEquals(self::$usNumber, $this->phoneUtil->parse('1-650-253-0000', RegionCode::US));
        // Calling the US number from Singapore by using different service providers
        // 1st test: calling using SingTel IDD service (IDD is 001)
        self::assertEquals(self::$usNumber, $this->phoneUtil->parse('0011-650-253-0000', RegionCode::SG));
        // 2nd test: calling using StarHub IDD service (IDD is 008)
        self::assertEquals(self::$usNumber, $this->phoneUtil->parse('0081-650-253-0000', RegionCode::SG));
        // 3rd test: calling using SingTel V019 service (IDD is 019)
        self::assertEquals(self::$usNumber, $this->phoneUtil->parse('0191-650-253-0000', RegionCode::SG));
        // Calling the US number from Poland
        self::assertEquals(self::$usNumber, $this->phoneUtil->parse('0~01-650-253-0000', RegionCode::PL));
        // Using "++" at the start.
        self::assertEquals(self::$usNumber, $this->phoneUtil->parse('++1 (650) 253-0000', RegionCode::PL));
    }

    public function testParseNonAscii(): void
    {
        // Using a full-width plus sign.
        self::assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse(pack('H*', 'efbc8b') . '1 (650) 253-0000', RegionCode::SG)
        );
        // Using a soft hyphen U+00AD.
        self::assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse('1 (650) 253' . pack('H*', 'c2ad') . '-0000', RegionCode::US)
        );
        // The whole number, including punctuation, is here represented in full-width form.
        self::assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse(
                pack('H*', 'efbc8b') . pack('H*', 'efbc91') . pack('H*', 'e38080') .
                pack('H*', 'efbc88') . pack('H*', 'efbc96') . pack('H*', 'efbc95') . pack('H*', 'efbc90') . pack(
                    'H*',
                    'efbc89'
                ) .
                pack('H*', 'e38080') . pack('H*', 'efbc92') . pack('H*', 'efbc95') . pack('H*', 'efbc93') . pack(
                    'H*',
                    'efbc8d'
                ) .
                pack('H*', 'efbc90') . pack('H*', 'efbc90') . pack('H*', 'efbc90') . pack('H*', 'efbc90'),
                RegionCode::SG
            )
        );
        // Using U+30FC dash instead.
        self::assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse(
                pack('H*', 'efbc8b') . pack('H*', 'efbc91') . pack('H*', 'e38080') .
                pack('H*', 'efbc88') . pack('H*', 'efbc96') . pack('H*', 'efbc95') . pack('H*', 'efbc90') . pack(
                    'H*',
                    'efbc89'
                ) .
                pack('H*', 'e38080') . pack('H*', 'efbc92') . pack('H*', 'efbc95') . pack('H*', 'efbc93') . pack(
                    'H*',
                    'e383bc'
                ) .
                pack('H*', 'efbc90') . pack('H*', 'efbc90') . pack('H*', 'efbc90') . pack('H*', 'efbc90'),
                RegionCode::SG
            )
        );
        // Using a very strange decimal digit range (Mongolian digits).
        self::assertEquals(
            self::$usNumber,
            $this->phoneUtil->parse(
                pack('H*', 'e1a091') . ' '
                . pack('H*', 'e1a096') . pack('H*', 'e1a095') . pack('H*', 'e1a090') . ' '
                . pack('H*', 'e1a092') . pack('H*', 'e1a095') . pack('H*', 'e1a093') . ' '
                . pack('H*', 'e1a090') . pack('H*', 'e1a090') . pack('H*', 'e1a090') . pack('H*', 'e1a090'),
                RegionCode::US
            )
        );
    }

    public function testParseWithLeadingZero(): void
    {
        self::assertEquals(self::$itNumber, $this->phoneUtil->parse('+39 02-36618 300', RegionCode::NZ));
        self::assertEquals(self::$itNumber, $this->phoneUtil->parse('02-36618 300', RegionCode::IT));

        self::assertEquals(self::$itMobile, $this->phoneUtil->parse('345 678 901', RegionCode::IT));
    }

    public function testParseNationalNumberArgentina(): void
    {
        // Test parsing mobile numbers of Argentina.
        $arNumber = new PhoneNumber();
        $arNumber->setCountryCode(54)->setNationalNumber('93435551212');
        self::assertEquals($arNumber, $this->phoneUtil->parse('+54 9 343 555 1212', RegionCode::AR));
        self::assertEquals($arNumber, $this->phoneUtil->parse('0343 15 555 1212', RegionCode::AR));

        $arNumber->clear();
        $arNumber->setCountryCode(54)->setNationalNumber('93715654320');
        self::assertEquals($arNumber, $this->phoneUtil->parse('+54 9 3715 65 4320', RegionCode::AR));
        self::assertEquals($arNumber, $this->phoneUtil->parse('03715 15 65 4320', RegionCode::AR));
        self::assertEquals(self::$arMobile, $this->phoneUtil->parse('911 876 54321', RegionCode::AR));

        // Test parsing fixed-line numbers of Argentina.
        self::assertEquals(self::$arNumber, $this->phoneUtil->parse('+54 11 8765 4321', RegionCode::AR));
        self::assertEquals(self::$arNumber, $this->phoneUtil->parse('011 8765 4321', RegionCode::AR));

        $arNumber->clear();
        $arNumber->setCountryCode(54)->setNationalNumber('3715654321');
        self::assertEquals($arNumber, $this->phoneUtil->parse('+54 3715 65 4321', RegionCode::AR));
        self::assertEquals($arNumber, $this->phoneUtil->parse('03715 65 4321', RegionCode::AR));

        $arNumber->clear();
        $arNumber->setCountryCode(54)->setNationalNumber('2312340000');
        self::assertEquals($arNumber, $this->phoneUtil->parse('+54 23 1234 0000', RegionCode::AR));
        self::assertEquals($arNumber, $this->phoneUtil->parse('023 1234 0000', RegionCode::AR));
    }

    public function testParseWithXInNumber(): void
    {
        // Test that having an 'x' in the phone number at the start is ok and that it just gets removed.
        self::assertEquals(self::$arNumber, $this->phoneUtil->parse('01187654321', RegionCode::AR));
        self::assertEquals(self::$arNumber, $this->phoneUtil->parse('(0) 1187654321', RegionCode::AR));
        self::assertEquals(self::$arNumber, $this->phoneUtil->parse('0 1187654321', RegionCode::AR));
        self::assertEquals(self::$arNumber, $this->phoneUtil->parse('(0xx) 1187654321', RegionCode::AR));

        $arFromUs = new PhoneNumber();
        $arFromUs->setCountryCode(54)->setNationalNumber('81429712');
        // This test is intentionally constructed such that the number of digit after xx is larger than
        // 7, so that the number won't be mistakenly treated as an extension, as we allow extensions up
        // to 7 digits. This assumption is okay for now as all the countries where a carrier selection
        // code is written in the form of xx have a national significant number of length larger than 7.
        self::assertEquals($arFromUs, $this->phoneUtil->parse('011xx5481429712', RegionCode::US));
    }

    public function testParseNumbersMexico(): void
    {
        // Test parsing fixed-line numbers of Mexico.
        $mxNumber = new PhoneNumber();
        $mxNumber->setCountryCode(52)->setNationalNumber('4499780001');
        self::assertEquals($mxNumber, $this->phoneUtil->parse('+52 (449)978-0001', RegionCode::MX));
        self::assertEquals($mxNumber, $this->phoneUtil->parse('01 (449)978-0001', RegionCode::MX));
        self::assertEquals($mxNumber, $this->phoneUtil->parse('(449)978-0001', RegionCode::MX));

        // Test parsing mobile numbers of Mexico.
        $mxNumber->clear();
        $mxNumber->setCountryCode(52)->setNationalNumber('13312345678');
        self::assertEquals($mxNumber, $this->phoneUtil->parse('+52 1 33 1234-5678', RegionCode::MX));
        self::assertEquals($mxNumber, $this->phoneUtil->parse('044 (33) 1234-5678', RegionCode::MX));
        self::assertEquals($mxNumber, $this->phoneUtil->parse('045 33 1234-5678', RegionCode::MX));
    }

    public function testFailedParseOnInvalidNumbers(): void
    {
        try {
            $sentencePhoneNumber = 'This is not a phone number';
            $this->phoneUtil->parse($sentencePhoneNumber, RegionCode::NZ);
            self::fail('This should not parse without throwing an exception ' . $sentencePhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $sentencePhoneNumber = '1 Still not a number';
            $this->phoneUtil->parse($sentencePhoneNumber, RegionCode::NZ);
            self::fail('This should not parse without throwing an exception ' . $sentencePhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $sentencePhoneNumber = '1 MICROSOFT';
            $this->phoneUtil->parse($sentencePhoneNumber, RegionCode::NZ);
            self::fail('This should not parse without throwing an exception ' . $sentencePhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $sentencePhoneNumber = '12 MICROSOFT';
            $this->phoneUtil->parse($sentencePhoneNumber, RegionCode::NZ);
            self::fail('This should not parse without throwing an exception ' . $sentencePhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $tooLongPhoneNumber = '01495 72553301873 810104';
            $this->phoneUtil->parse($tooLongPhoneNumber, RegionCode::GB);
            self::fail('This should not parse without throwing an exception ' . $tooLongPhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::TOO_LONG,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $plusMinusPhoneNumber = '+---';
            $this->phoneUtil->parse($plusMinusPhoneNumber, RegionCode::DE);
            self::fail('This should not parse without throwing an exception ' . $plusMinusPhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $plusStar = '+***';
            $this->phoneUtil->parse($plusStar, RegionCode::DE);
            self::fail('This should not parse without throwing an exception ' . $plusStar);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $plusStarPhoneNumber = '+*******91';
            $this->phoneUtil->parse($plusStarPhoneNumber, RegionCode::DE);
            self::fail('This should not parse without throwing an exception ' . $plusStarPhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $tooShortPhoneNumber = '+49 0';
            $this->phoneUtil->parse($tooShortPhoneNumber, RegionCode::DE);
            self::fail('This should not parse without throwing an exception ' . $tooShortPhoneNumber);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::TOO_SHORT_NSN,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $invalidCountryCode = '+210 3456 56789';
            $this->phoneUtil->parse($invalidCountryCode, RegionCode::NZ);
            self::fail('This is not a recognised region code: should fail: ' . $invalidCountryCode);
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $plusAndIddAndInvalidCountryCode = '+ 00 210 3 331 6005';
            $this->phoneUtil->parse($plusAndIddAndInvalidCountryCode, RegionCode::NZ);
            self::fail('This should not parse without throwing an exception ' . $plusAndIddAndInvalidCountryCode);
        } catch (NumberParseException $e) {
            // Expected this exception. 00 is a correct IDD, but 210 is not a valid country code.
            self::assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $someNumber = '123 456 7890';
            $this->phoneUtil->parse($someNumber, RegionCode::ZZ);
            self::fail("'Unknown' region code not allowed: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $someNumber = '123 456 7890';
            $this->phoneUtil->parse($someNumber, RegionCode::CS);
            self::fail('Deprecated region code not allowed: should fail.');
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $someNumber = '123 456 7890';
            $this->phoneUtil->parse($someNumber, null);
            self::fail('Null region code not allowed: should fail.');
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $someNumber = '0044------';
            $this->phoneUtil->parse($someNumber, RegionCode::GB);
            self::fail('No number provided, only region code: should fail');
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::TOO_SHORT_AFTER_IDD,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $someNumber = '0044';
            $this->phoneUtil->parse($someNumber, RegionCode::GB);
            self::fail('No number provided, only region code: should fail');
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::TOO_SHORT_AFTER_IDD,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $someNumber = '011';
            $this->phoneUtil->parse($someNumber, RegionCode::US);
            self::fail('Only IDD provided - should fail.');
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::TOO_SHORT_AFTER_IDD,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $someNumber = '0119';
            $this->phoneUtil->parse($someNumber, RegionCode::US);
            self::fail('Only IDD provided and then 9 - should fail.');
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::TOO_SHORT_AFTER_IDD,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $emptyNumber = '';
            // Invalid region.
            $this->phoneUtil->parse($emptyNumber, RegionCode::ZZ);
            self::fail('Empty string - should fail.');
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            $domainRfcPhoneContext = 'tel:555-1234;phone-context=www.google.com';
            $this->phoneUtil->parse($domainRfcPhoneContext, RegionCode::ZZ);
            self::fail("'Unknown' region code not allowed: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            // This is invalid because no "+" sign is present as part of phone-context. This should not
            // succeed in being parsed.
            $invalidRfcPhoneContext = 'tel:555-1234;phone-context=1-331';
            $this->phoneUtil->parse($invalidRfcPhoneContext, RegionCode::ZZ);
            self::fail("phone-context is missing '+' sign: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        try {
            // Only the phone-context symbol is present, but no data.
            $invalidRfcPhoneContext = ';phone-context=';
            $this->phoneUtil->parse($invalidRfcPhoneContext, RegionCode::ZZ);
            self::fail("phone-context can't be empty: should fail.");
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }
    }

    public function testParseNumbersWithPlusWithNoRegion(): void
    {
        // RegionCode.ZZ is allowed only if the number starts with a '+' - then the country calling code
        // can be calculated.
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('+64 3 331 6005', RegionCode::ZZ));
        // Test with full-width plus.
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('＋64 3 331 6005', RegionCode::ZZ));
        // Test with normal plus but leading characters that need to be stripped.
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('Tel: +64 3 331 6005', RegionCode::ZZ));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('+64 3 331 6005', null));
        self::assertEquals(self::$internationalTollFree, $this->phoneUtil->parse('+800 1234 5678', null));
        self::assertEquals(self::$universalPremiumRate, $this->phoneUtil->parse('+979 123 456 789', null));

        // Test parsing RFC3966 format with a phone context.
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('tel:03-331-6005;phone-context=+64', RegionCode::ZZ)
        );
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('  tel:03-331-6005;phone-context=+64', RegionCode::ZZ)
        );
        self::assertEquals(
            self::$nzNumber,
            $this->phoneUtil->parse('tel:03-331-6005;isub=12345;phone-context=+64', RegionCode::ZZ)
        );

        $nzNumberWithRawInput = new PhoneNumber();
        $nzNumberWithRawInput->mergeFrom(self::$nzNumber);
        $nzNumberWithRawInput->setRawInput('+64 3 331 6005');
        $nzNumberWithRawInput->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);
        self::assertEquals(
            $nzNumberWithRawInput,
            $this->phoneUtil->parseAndKeepRawInput('+64 3 331 6005', RegionCode::ZZ)
        );

        // Null is also allowed for the region code in these cases.
        self::assertEquals($nzNumberWithRawInput, $this->phoneUtil->parseAndKeepRawInput('+64 3 331 6005', null));
    }

    public function testParseNumberTooShortIfNationalPrefixStripped(): void
    {
        // Test that a number whose first digits happen to coincide with the national prefix does not
        // get them stripped if doing so would result in a number too short to be a possible (regular
        // length) phone number for that region.
        $byNumber = new PhoneNumber();
        $byNumber->setCountryCode(375)->setNationalNumber('8123');
        self::assertEquals($byNumber, $this->phoneUtil->parse('8123', RegionCode::BY));
        $byNumber->setNationalNumber('81234');
        self::assertEquals($byNumber, $this->phoneUtil->parse('81234', RegionCode::BY));

        // The prefix doesn't get stripped, since the input is a viable 6-digit number, whereas the
        // result of stripping is only 5 digits.
        $byNumber->setNationalNumber('812345');
        self::assertEquals($byNumber, $this->phoneUtil->parse('812345', RegionCode::BY));

        // The prefix gets stripped, since only 6-digit numbers are possible.
        $byNumber->setNationalNumber('123456');
        self::assertEquals($byNumber, $this->phoneUtil->parse('8123456', RegionCode::BY));
    }

    public function testParseExtensions(): void
    {
        $nzNumber = new PhoneNumber();
        $nzNumber->setCountryCode(64)->setNationalNumber('33316005')->setExtension('3456');
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03 331 6005 ext 3456', RegionCode::NZ));
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03-3316005x3456', RegionCode::NZ));
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03-3316005 int.3456', RegionCode::NZ));
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03 3316005 #3456', RegionCode::NZ));
        // Test the following do not extract extensions:
        self::assertEquals(self::$alphaNumericNumber, $this->phoneUtil->parse('1800 six-flags', RegionCode::US));
        self::assertEquals(self::$alphaNumericNumber, $this->phoneUtil->parse('1800 SIX FLAGS', RegionCode::US));
        self::assertEquals(self::$alphaNumericNumber, $this->phoneUtil->parse('0~0 1800 7493 5247', RegionCode::PL));
        self::assertEquals(self::$alphaNumericNumber, $this->phoneUtil->parse('(1800) 7493.5247', RegionCode::US));
        // Check that the last instance of an extension token is matched.
        $extnNumber = new PhoneNumber();
        $extnNumber->mergeFrom(self::$alphaNumericNumber)->setExtension('1234');
        self::assertEquals($extnNumber, $this->phoneUtil->parse('0~0 1800 7493 5247 ~1234', RegionCode::PL));
        // Verifying bug-fix where the last digit of a number was previously omitted if it was a 0 when
        // extracting the extension. Also verifying a few different cases of extensions.
        $ukNumber = new PhoneNumber();
        $ukNumber->setCountryCode(44)->setNationalNumber('2034567890')->setExtension('456');
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44 2034567890x456', RegionCode::NZ));
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44 2034567890x456', RegionCode::GB));
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44 2034567890 x456', RegionCode::GB));
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44 2034567890 X456', RegionCode::GB));
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44 2034567890 X 456', RegionCode::GB));
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44 2034567890 X  456', RegionCode::GB));
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44 2034567890 x 456  ', RegionCode::GB));
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44 2034567890  X 456', RegionCode::GB));
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+44-2034567890;ext=456', RegionCode::GB));
        self::assertEquals(
            $ukNumber,
            $this->phoneUtil->parse('tel:2034567890;ext=456;phone-context=+44', RegionCode::ZZ)
        );

        // Full-width extension, "extn" only.
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+442034567890ｅｘｔｎ456', RegionCode::GB));
        // "xtn" only.
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+442034567890ｘｔｎ456', RegionCode::GB));
        // "xt" only.
        self::assertEquals($ukNumber, $this->phoneUtil->parse('+442034567890ｘｔ456', RegionCode::GB));

        $usWithExtension = new PhoneNumber();
        $usWithExtension->setCountryCode(1)->setNationalNumber('8009013355')->setExtension('7246433');
        self::assertEquals($usWithExtension, $this->phoneUtil->parse('(800) 901-3355 x 7246433', RegionCode::US));
        self::assertEquals($usWithExtension, $this->phoneUtil->parse('(800) 901-3355 , ext 7246433', RegionCode::US));
        self::assertEquals($usWithExtension, $this->phoneUtil->parse('(800) 901-3355 ; 7246433', RegionCode::US));
        // To test an extension character without surrounding spaces.
        self::assertEquals($usWithExtension, $this->phoneUtil->parse('(800) 901-3355;7246433', RegionCode::US));
        self::assertEquals(
            $usWithExtension,
            $this->phoneUtil->parse('(800) 901-3355 ,extension 7246433', RegionCode::US)
        );
        self::assertEquals(
            $usWithExtension,
            $this->phoneUtil->parse('(800) 901-3355 ,extensi' . pack('H*', 'c3b3') . 'n 7246433', RegionCode::US)
        );
        // Repeat with the small letter o with acute accent created by combining characters.
        self::assertEquals(
            $usWithExtension,
            $this->phoneUtil->parse('(800) 901-3355 ,extensio' . pack('H*', 'cc81') . 'n 7246433', RegionCode::US)
        );
        self::assertEquals($usWithExtension, $this->phoneUtil->parse('(800) 901-3355 , 7246433', RegionCode::US));
        self::assertEquals($usWithExtension, $this->phoneUtil->parse('(800) 901-3355 ext: 7246433', RegionCode::US));

        // Testing Russian extension \xB0\xB4\u043E\u0431 with variants found online.
        $ruWithExtension = new PhoneNumber();
        $ruWithExtension->setCountryCode(7)->setNationalNumber('4232022511')->setExtension('100');
        self::assertEquals(
            $ruWithExtension,
            $this->phoneUtil->parse("8 (423) 202-25-11, \xD0\xB4\xD0\xBE\xD0\xB1. 100", RegionCode::RU)
        );
        self::assertEquals(
            $ruWithExtension,
            $this->phoneUtil->parse("8 (423) 202-25-11 \xD0\xB4\xD0\xBE\xD0\xB1. 100", RegionCode::RU)
        );
        self::assertEquals(
            $ruWithExtension,
            $this->phoneUtil->parse("8 (423) 202-25-11, \xD0\xB4\xD0\xBE\xD0\xB1 100", RegionCode::RU)
        );
        self::assertEquals(
            $ruWithExtension,
            $this->phoneUtil->parse("8 (423) 202-25-11 \xD0\xB4\xD0\xBE\xD0\xB1 100", RegionCode::RU)
        );
        self::assertEquals(
            $ruWithExtension,
            $this->phoneUtil->parse("8 (423) 202-25-11\xD0\xB4\xD0\xBE\xD0\xB1100", RegionCode::RU)
        );
        // In upper case
        self::assertEquals(
            $ruWithExtension,
            $this->phoneUtil->parse("8 (423) 202-25-11, \xD0\xB4\xD0\xBE\xD0\xB1. 100", RegionCode::RU)
        );

        // Test that if a number has two extensions specified, we ignore the second.
        $usWithTwoExtensionsNumber = new PhoneNumber();
        $usWithTwoExtensionsNumber->setCountryCode(1)->setNationalNumber('2121231234')->setExtension('508');
        self::assertEquals(
            $usWithTwoExtensionsNumber,
            $this->phoneUtil->parse('(212)123-1234 x508/x1234', RegionCode::US)
        );
        self::assertEquals(
            $usWithTwoExtensionsNumber,
            $this->phoneUtil->parse('(212)123-1234 x508/ x1234', RegionCode::US)
        );
        self::assertEquals(
            $usWithTwoExtensionsNumber,
            $this->phoneUtil->parse('(212)123-1234 x508\\x1234', RegionCode::US)
        );

        // Test parsing numbers in the form (645) 123-1234-910# works, where the last 3 digits before
        // the # are an extension.
        $usWithExtension->clear();
        $usWithExtension->setCountryCode(1)->setNationalNumber('6451231234')->setExtension('910');
        self::assertEquals($usWithExtension, $this->phoneUtil->parse('+1 (645) 123 1234-910#', RegionCode::US));
        // Retry with the same number in a slightly different format.
        self::assertEquals($usWithExtension, $this->phoneUtil->parse('+1 (645) 123 1234 ext. 910#', RegionCode::US));
    }

    public function testParseHandlesLongExtensionsWithExplicitLabels(): void
    {
        // Test lower and upper limits of extension lengths for each type of label.
        $nzNumber = new PhoneNumber();
        $nzNumber
            ->setCountryCode(64)
            ->setNationalNumber('33316005');

        // Firstly, when in RFC format: PhoneNumberUtil.extLimitAfterExplicitLabel
        $nzNumber->setExtension('0');
        self::assertEquals($nzNumber, $this->phoneUtil->parse('tel:+6433316005;ext=0', RegionCode::NZ));
        $nzNumber->setExtension('01234567890123456789');
        self::assertEquals(
            $nzNumber,
            $this->phoneUtil->parse('tel:+6433316005;ext=01234567890123456789', RegionCode::NZ)
        );

        // Extension too long
        try {
            $this->phoneUtil->parse('tel:+6433316005;ext=012345678901234567890', RegionCode::NZ);
            self::fail(
                'This should not parse length as length of extension is higher than allowed: '
                . 'tel:+6433316005;ext=012345678901234567890'
            );
        } catch (NumberParseException $e) {
            // Expect this exception.
            self::assertEquals(NumberParseException::NOT_A_NUMBER, $e->getErrorType());
        }

        // Explicit extension label: PhoneNumberUtil.extLimitAfterExplicitLabel
        $nzNumber->setExtension('1');
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03 3316005ext:1', RegionCode::NZ));

        $nzNumber->setExtension('12345678901234567890');
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03 3316005 xtn:12345678901234567890', RegionCode::NZ));
        self::assertEquals(
            $nzNumber,
            $this->phoneUtil->parse("03 3316005 extension\t12345678901234567890", RegionCode::NZ)
        );
        self::assertEquals(
            $nzNumber,
            $this->phoneUtil->parse('03 3316005 xtensio:12345678901234567890', RegionCode::NZ)
        );
        self::assertEquals(
            $nzNumber,
            $this->phoneUtil->parse("03 3316005 xtensi\xC3\xB3n, 12345678901234567890#", RegionCode::NZ)
        );
        self::assertEquals(
            $nzNumber,
            $this->phoneUtil->parse('03 3316005extension.12345678901234567890', RegionCode::NZ)
        );
        self::assertEquals(
            $nzNumber,
            $this->phoneUtil->parse(
                "03 3316005 \xD0\xB4\xD0\xBE\xD0\xB1:12345678901234567890",
                RegionCode::NZ
            )
        );

        // Extension too long.
        try {
            $this->phoneUtil->parse('03 3316005 extension 123456789012345678901', RegionCode::NZ);
            self::fail(
                'This should not parse as length of extension is higher than allowed: '
                . '03 3316005 extension 123456789012345678901'
            );
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(NumberParseException::TOO_LONG, $e->getErrorType());
        }
    }

    public function testParseHandlesLongExtensionsWithAutoDiallingLabels(): void
    {
        // Secondly, cases of auto-dialling and other standard extension labels,
        // PhoneNumberUtil $extLimitAfterLikelyLabel
        $usNumberUserInput = new PhoneNumber();
        $usNumberUserInput
            ->setCountryCode(1)
            ->setNationalNumber('2679000000');

        $usNumberUserInput->setExtension('123456789012345');
        self::assertEquals(
            $usNumberUserInput,
            $this->phoneUtil->parse('+12679000000,,123456789012345#', RegionCode::US)
        );
        self::assertEquals(
            $usNumberUserInput,
            $this->phoneUtil->parse('+12679000000;123456789012345#', RegionCode::US)
        );

        $ukNumberUserInput = new PhoneNumber();
        $ukNumberUserInput
            ->setCountryCode(44)
            ->setNationalNumber('2034000000')
            ->setExtension('123456789');

        self::assertEquals($ukNumberUserInput, $this->phoneUtil->parse('+442034000000,,123456789#', RegionCode::GB));
        // Extension too long.
        try {
            $this->phoneUtil->parse('+12679000000,,1234567890123456#', RegionCode::US);
            self::fail(
                'This should not parse as length of extension is higher than allowed: '
                . '+12679000000,,1234567890123456#'
            );
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(NumberParseException::NOT_A_NUMBER, $e->getErrorType());
        }
    }

    public function testParseHandlesShortExtensionsWithAmbiguousChar(): void
    {
        $nzNumber = new PhoneNumber();
        $nzNumber
            ->setCountryCode(64)
            ->setNationalNumber('33316005');

        // Thirdly, for single and non-standard cases:
        // PhoneNumberUtil $extLimitAfterAmbiguousChar
        $nzNumber->setExtension('123456789');
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03 3316005 x 123456789', RegionCode::NZ));
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03 3316005 x. 123456789', RegionCode::NZ));
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03 3316005 #123456789#', RegionCode::NZ));
        self::assertEquals($nzNumber, $this->phoneUtil->parse('03 3316005 ~ 123456789', RegionCode::NZ));

        // Extension too long.
        try {
            $this->phoneUtil->parse('03 3316005 ~ 1234567890', RegionCode::NZ);
            self::fail(
                'This should not parse as length of extension is higher than allowed: '
                . '03 3316005 ~ 1234567890'
            );
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(NumberParseException::TOO_LONG, $e->getErrorType());
        }
    }

    public function testParseHandlesShortExtensionsWhenNotSureOfLabel(): void
    {
        // Lastly, when no explicit extension label present, but denoted by tailing #:
        // PhoneNumberUtil $extLimitWhenNotSure
        $usNumber = new PhoneNumber();
        $usNumber
            ->setCountryCode(1)
            ->setNationalNumber('1234567890')
            ->setExtension('666666');

        self::assertEquals($usNumber, $this->phoneUtil->parse('+1123-456-7890 666666#', RegionCode::US));

        $usNumber->setExtension('6');
        self::assertEquals($usNumber, $this->phoneUtil->parse('+11234567890-6#', RegionCode::US));

        // Extension too long.
        try {
            $this->phoneUtil->parse('+1123-456-7890 7777777#', RegionCode::US);
            self::fail(
                'This should not parse as length of extension is higher than allowed: '
                . '+1123-456-7890 7777777#'
            );
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(NumberParseException::NOT_A_NUMBER, $e->getErrorType());
        }
    }

    public function testParseAndKeepRaw(): void
    {
        $alphaNumericNumber = new PhoneNumber();
        $alphaNumericNumber->mergeFrom(self::$alphaNumericNumber);
        $alphaNumericNumber->setRawInput('800 six-flags');
        $alphaNumericNumber->setCountryCodeSource(CountryCodeSource::FROM_DEFAULT_COUNTRY);
        self::assertEquals(
            $alphaNumericNumber,
            $this->phoneUtil->parseAndKeepRawInput('800 six-flags', RegionCode::US)
        );

        $shorterAlphaNumber = new PhoneNumber();
        $shorterAlphaNumber->setCountryCode(1)->setNationalNumber('8007493524');
        $shorterAlphaNumber
            ->setRawInput('1800 six-flag')
            ->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN);
        self::assertEquals(
            $shorterAlphaNumber,
            $this->phoneUtil->parseAndKeepRawInput('1800 six-flag', RegionCode::US)
        );

        $shorterAlphaNumber->setRawInput('+1800 six-flag')->setCountryCodeSource(
            CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN
        );
        self::assertEquals(
            $shorterAlphaNumber,
            $this->phoneUtil->parseAndKeepRawInput('+1800 six-flag', RegionCode::NZ)
        );

        $shorterAlphaNumber->setRawInput('001800 six-flag')->setCountryCodeSource(
            CountryCodeSource::FROM_NUMBER_WITH_IDD
        );
        self::assertEquals(
            $shorterAlphaNumber,
            $this->phoneUtil->parseAndKeepRawInput('001800 six-flag', RegionCode::NZ)
        );

        // Invalid region code supplied.
        try {
            $this->phoneUtil->parseAndKeepRawInput('123 456 7890', RegionCode::CS);
            self::fail('Deprecated region code not allowed: should fail.');
        } catch (NumberParseException $e) {
            // Expected this exception.
            self::assertEquals(
                NumberParseException::INVALID_COUNTRY_CODE,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }

        $koreanNumber = new PhoneNumber();
        $koreanNumber->setCountryCode(82)->setNationalNumber('22123456')->setRawInput(
            '08122123456'
        )->setCountryCodeSource(CountryCodeSource::FROM_DEFAULT_COUNTRY)->setPreferredDomesticCarrierCode('81');
        self::assertEquals($koreanNumber, $this->phoneUtil->parseAndKeepRawInput('08122123456', RegionCode::KR));
    }

    public function testParseItalianLeadingZeros(): void
    {
        // Test the number "011".
        $oneZero = new PhoneNumber();
        $oneZero->setCountryCode(61)->setNationalNumber('11')->setItalianLeadingZero(true);
        self::assertEquals($oneZero, $this->phoneUtil->parse('011', RegionCode::AU));

        // Test the number "001".
        $twoZeros = new PhoneNumber();
        $twoZeros->setCountryCode(61)->setNationalNumber('1')->setItalianLeadingZero(true)->setNumberOfLeadingZeros(2);
        self::assertEquals($twoZeros, $this->phoneUtil->parse('001', RegionCode::AU));

        // Test the number "000". This number has 2 leading zeros.
        $stillTwoZeros = new PhoneNumber();
        $stillTwoZeros->setCountryCode(61)->setNationalNumber('0')->setItalianLeadingZero(true)->setNumberOfLeadingZeros(
            2
        );
        self::assertEquals($stillTwoZeros, $this->phoneUtil->parse('000', RegionCode::AU));

        // Test the number "0000". This number has 3 leading zeros.
        $threeZeros = new PhoneNumber();
        $threeZeros->setCountryCode(61)->setNationalNumber('0')->setItalianLeadingZero(true)->setNumberOfLeadingZeros(3);
        self::assertEquals($threeZeros, $this->phoneUtil->parse('0000', RegionCode::AU));
    }

    public function testParseWithPhoneContext(): void
    {
        // context    = ";phone-context=" descriptor
        // descriptor = domainname / global-number-digits

        // Valid global-phone-digits
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('tel:033316005;phone-context=+64', RegionCode::ZZ));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse("tel:033316005;phone-context=+64;{this isn't part of phone-context anymore!}", RegionCode::ZZ));

        $nzFromPhoneContext = new PhoneNumber();
        $nzFromPhoneContext->setCountryCode(64);
        $nzFromPhoneContext->setNationalNumber('3033316005');

        self::assertEquals($nzFromPhoneContext, $this->phoneUtil->parse('tel:033316005;phone-context=+64-3', RegionCode::ZZ));

        $brFromPhoneContext = new PhoneNumber();
        $brFromPhoneContext->setCountryCode(55);
        $brFromPhoneContext->setNationalNumber('5033316005');

        self::assertEquals($brFromPhoneContext, $this->phoneUtil->parse('tel:033316005;phone-context=+(555)', RegionCode::ZZ));

        $usFromPhoneContext = new PhoneNumber();
        $usFromPhoneContext->setCountryCode(1);
        $usFromPhoneContext->setNationalNumber('23033316005');

        self::assertEquals($usFromPhoneContext, $this->phoneUtil->parse('tel:033316005;phone-context=+-1-2.3()', RegionCode::ZZ));

        // Valid domainname
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('tel:033316005;phone-context=abc.nz', RegionCode::NZ));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('tel:033316005;phone-context=www.PHONE-numb3r.com', RegionCode::NZ));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('tel:033316005;phone-context=a', RegionCode::NZ));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('tel:033316005;phone-context=3phone.J.', RegionCode::NZ));
        self::assertEquals(self::$nzNumber, $this->phoneUtil->parse('tel:033316005;phone-context=a--z', RegionCode::NZ));
    }

    /**
     * @return array<array{string}>
     */
    public static function dataForInvalidPhoneContext(): array
    {
        return [
            ['tel:033316005;phone-context='],
            ['tel:033316005;phone-context=+'],
            ['tel:033316005;phone-context=64'],
            ['tel:033316005;phone-context=++64'],
            ['tel:033316005;phone-context=+abc'],
            ['tel:033316005;phone-context=.'],
            ['tel:033316005;phone-context=3phone'],
            ['tel:033316005;phone-context=a-.nz'],
            ['tel:033316005;phone-context=a{b}c'],
        ];
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('dataForInvalidPhoneContext')]
    public function testThrowForInvalidPhoneContext(string $numberToParse): void
    {
        try {
            $this->phoneUtil->parse($numberToParse, RegionCode::ZZ);
            self::fail('Should have thrown an exception');
        } catch (NumberParseException $e) {
            // Expected.
            self::assertEquals(
                NumberParseException::NOT_A_NUMBER,
                $e->getErrorType(),
                'Wrong error type stored in exception.'
            );
        }
    }

    public function testParseHasDefaultNullRegion(): void
    {
        $ukNumber = '+441174960123';

        $phone = $this->phoneUtil->parse($ukNumber);

        self::assertTrue($this->phoneUtil->isValidNumber($phone));
    }

    public function testCountryWithNoNumberDesc(): void
    {
        // Andorra is a country where we don't have PhoneNumberDesc info in the metadata.
        $adNumber = new PhoneNumber();
        $adNumber->setCountryCode(376)->setNationalNumber('12345');

        self::assertEquals('+376 12345', $this->phoneUtil->format($adNumber, PhoneNumberFormat::INTERNATIONAL));
        self::assertEquals('+37612345', $this->phoneUtil->format($adNumber, PhoneNumberFormat::E164));
        self::assertEquals('12345', $this->phoneUtil->format($adNumber, PhoneNumberFormat::NATIONAL));
        self::assertEquals(PhoneNumberType::UNKNOWN, $this->phoneUtil->getNumberType($adNumber));
        self::assertFalse($this->phoneUtil->isValidNumber($adNumber));

        // Test dialing a US number from within Andorra.
        self::assertEquals(
            '00 1 650 253 0000',
            $this->phoneUtil->formatOutOfCountryCallingNumber(self::$usNumber, RegionCode::AD)
        );
    }

    public function testUnknownCountryCallingCode(): void
    {
        self::assertFalse($this->phoneUtil->isValidNumber(self::$unknownCountryCodeNoRawInput));
        // It's not very well defined as to what the E164 representation for a number with an invalid
        // country calling code is, but just prefixing the country code and national number is about
        // the best we can do.
        self::assertEquals(
            '+212345',
            $this->phoneUtil->format(self::$unknownCountryCodeNoRawInput, PhoneNumberFormat::E164)
        );
    }

    public function testIsNumberMatchMatches(): void
    {
        // Test simple matches where formatting is different, or leading zeros, or country calling code
        // has been specified.
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331 6005', '+64 03 331 6005')
        );
        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch('+800 1234 5678', '+80012345678'));
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch('+64 03 331-6005', '+64 03331 6005')
        );
        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch('+643 331-6005', '+64033316005'));
        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch('+643 331-6005', '+6433316005'));
        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch('+64 3 331-6005', '+6433316005'));
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005', 'tel:+64-3-331-6005;isub=123')
        );
        // Test alpha numbers.
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch('+1800 siX-Flags', '+1 800 7493 5247')
        );
        // Test numbers with extensions.
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005 extn 1234', '+6433316005#1234')
        );
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005 ext. 1234', '+6433316005;1234')
        );
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch('+7 423 202-25-11 ext 100', "+7 4232022511 \xD0\xB4\xD0\xBE\xD0\xB1. 100")
        );

        // Test proto buffers.
        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch(self::$nzNumber, '+6403 331 6005'));

        $nzNumber = new PhoneNumber();
        $nzNumber->mergeFrom(self::$nzNumber)->setExtension('3456');
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch($nzNumber, '+643 331 6005 ext 3456')
        );

        // Check empty extensions are ignored.
        $nzNumber->setExtension('');
        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch($nzNumber, '+6403 331 6005'));
        // Check variant with two proto buffers.
        self::assertEquals(
            MatchType::EXACT_MATCH,
            $this->phoneUtil->isNumberMatch($nzNumber, self::$nzNumber),
            'Number ' . $nzNumber . ' did not match ' . self::$nzNumber
        );
    }

    public function testIsNumberMatchShortMatchIfDiffNumLeadingZeros(): void
    {
        $nzNumberOne = new PhoneNumber();
        $nzNumberTwo = new PhoneNumber();
        $nzNumberOne->setCountryCode(64)->setNationalNumber('33316005')->setItalianLeadingZero(true);
        $nzNumberTwo->setCountryCode(64)->setNationalNumber('33316005')->setItalianLeadingZero(true)->setNumberOfLeadingZeros(2);

        self::assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch($nzNumberOne, $nzNumberTwo));

        $nzNumberOne->setItalianLeadingZero(false)->setNumberOfLeadingZeros(1);
        $nzNumberTwo->setItalianLeadingZero(true)->setNumberOfLeadingZeros(1);

        // Since one doesn't have the Italian leading zero set to true, we ignore the number of leading zeros present
        // (1 is in any case the default value)
        self::assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch($nzNumberOne, $nzNumberTwo));
    }

    public function testIsNumberMatchAcceptsProtoDefaultsAsMatch(): void
    {
        $nzNumberOne = new PhoneNumber();
        $nzNumberTwo = new PhoneNumber();

        $nzNumberOne->setCountryCode(64)->setNationalNumber('33316005')->setItalianLeadingZero(true);
        // The default for number of leading zeros is 1, so it shouldn't normally be set, however if it
        // is it should be considered equivalent.
        $nzNumberTwo->setCountryCode(64)->setNationalNumber('33316005')->setItalianLeadingZero(true)->setNumberOfLeadingZeros(1);

        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch($nzNumberOne, $nzNumberTwo));
    }

    public function testIsNumberMatchMatchesDiffLeadingZerosIfItalianLeadingZeroFalse(): void
    {
        $nzNumberOne = new PhoneNumber();
        $nzNumberTwo = new PhoneNumber();

        $nzNumberOne->setCountryCode(64)->setNationalNumber('33316005');
        // The default for number of leading zeros is 1, so it shouldn't normally be set, however if it
        // is it should be considered equivalent
        $nzNumberTwo->setCountryCode(64)->setNationalNumber('33316005')->setNumberOfLeadingZeros(1);

        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch($nzNumberOne, $nzNumberTwo));

        // Even if it is set to ten, it is still equivalent because in both cases
        // italian leading zero is not true
        $nzNumberTwo->setNumberOfLeadingZeros(10);
        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch($nzNumberOne, $nzNumberTwo));
    }

    public function testIsNumberMatchIgnoresSomeFields(): void
    {
        // Check raw_input, country_code_source and preferred_domestic_carrier_code are ignored.
        $brNumberOne = new PhoneNumber();
        $brNumberTwo = new PhoneNumber();
        $brNumberOne->setCountryCode(55)->setNationalNumber('3121286979')
            ->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN)
            ->setPreferredDomesticCarrierCode('12')->setRawInput('012 3121286979');
        $brNumberTwo->setCountryCode(55)->setNationalNumber('3121286979')
            ->setCountryCodeSource(CountryCodeSource::FROM_DEFAULT_COUNTRY)
            ->setPreferredDomesticCarrierCode('14')->setRawInput('143121286979');

        self::assertEquals(MatchType::EXACT_MATCH, $this->phoneUtil->isNumberMatch($brNumberOne, $brNumberTwo));
    }

    public function testIsNumberMatchNonMatches(): void
    {
        // Non-matches.
        self::assertEquals(MatchType::NO_MATCH, $this->phoneUtil->isNumberMatch('03 331 6005', '03 331 6006'));
        self::assertEquals(MatchType::NO_MATCH, $this->phoneUtil->isNumberMatch('+800 1234 5678', '+1 800 1234 5678'));
        // Different country calling code, partial number match.
        self::assertEquals(MatchType::NO_MATCH, $this->phoneUtil->isNumberMatch('+64 3 331-6005', '+16433316005'));
        // Different country calling code, same number.
        self::assertEquals(MatchType::NO_MATCH, $this->phoneUtil->isNumberMatch('+64 3 331-6005', '+6133316005'));
        // Extension different, all else the same.
        self::assertEquals(
            MatchType::NO_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005 extn 1234', '0116433316005#1235')
        );
        self::assertEquals(
            MatchType::NO_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005 extn 1234', 'tel:+64-3-331-6005;ext=1235')
        );
        // NSN matches, but extension is different - not the same number.
        self::assertEquals(
            MatchType::NO_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005 ext.1235', '3 331 6005#1234')
        );

        // Invalid numbers that can't be parsed.
        self::assertEquals(MatchType::NOT_A_NUMBER, $this->phoneUtil->isNumberMatch('4', '3 331 6043'));
        self::assertEquals(MatchType::NOT_A_NUMBER, $this->phoneUtil->isNumberMatch('+43', '+64 3 331 6005'));
        self::assertEquals(MatchType::NOT_A_NUMBER, $this->phoneUtil->isNumberMatch('+43', '64 3 331 6005'));
        self::assertEquals(MatchType::NOT_A_NUMBER, $this->phoneUtil->isNumberMatch('Dog', '64 3 331 6005'));
    }

    public function testIsNumberMatchNsnMatches(): void
    {
        // NSN matches.
        self::assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch('+64 3 331-6005', '03 331 6005'));
        self::assertEquals(
            MatchType::NSN_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005', 'tel:03-331-6005;isub=1234;phone-context=abc.nz')
        );
        self::assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch(self::$nzNumber, '03 331 6005'));
        // Here the second number possibly starts with the country calling code for New Zealand,
        // although we are unsure.
        $unchangedNzNumber = new PhoneNumber();
        $unchangedNzNumber->mergeFrom(self::$nzNumber);
        self::assertEquals(
            MatchType::NSN_MATCH,
            $this->phoneUtil->isNumberMatch($unchangedNzNumber, '(64-3) 331 6005')
        );
        // Check the phone number proto was not edited during the method call.
        self::assertEquals(self::$nzNumber, $unchangedNzNumber);

        // Here, the 1 might be a national prefix, if we compare it to the US number, so the resultant
        // match is an NSN match.
        self::assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch(self::$usNumber, '1-650-253-0000'));
        self::assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch(self::$usNumber, '6502530000'));
        self::assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch('+1 650-253 0000', '1 650 253 0000'));
        self::assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch('1 650-253 0000', '1 650 253 0000'));
        self::assertEquals(MatchType::NSN_MATCH, $this->phoneUtil->isNumberMatch('1 650-253 0000', '+1 650 253 0000'));
        // For this case, the match will be a short NSN match, because we cannot assume that the 1 might
        // be a national prefix, so don't remove it when parsing.
        $randomNumber = new PhoneNumber();
        $randomNumber->setCountryCode(41)->setNationalNumber('6502530000');
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch($randomNumber, '1-650-253-0000')
        );
    }

    public function testIsNumberMatchShortNsnMatches(): void
    {
        // Short NSN matches with the country not specified for either one or both numbers.
        self::assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch('+64 3 331-6005', '331 6005'));
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005', 'tel:331-6005;phone-context=abc.nz')
        );
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005', 'tel:331-6005;isub=1234;phone-context=abc.nz')
        );
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005', 'tel:331-6005;isub=1234;phone-context=abc.nz;a=%A1')
        );

        // We did not know that the "0" was a national prefix since neither number has a country code,
        // so this is considered a SHORT_NSN_MATCH.
        self::assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch('3 331-6005', '03 331 6005'));
        self::assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch('3 331-6005', '331 6005'));
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch('3 331-6005', 'tel:331-6005;phone-context=abc.nz')
        );
        self::assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch('3 331-6005', '+64 331 6005'));

        // Short NSN match with the country specified.
        self::assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch('03 331-6005', '331 6005'));
        self::assertEquals(MatchType::SHORT_NSN_MATCH, $this->phoneUtil->isNumberMatch('1 234 345 6789', '345 6789'));
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch('+1 (234) 345 6789', '345 6789')
        );
        // NSN matches, country calling code omitted for one number, extension missing for one.
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch('+64 3 331-6005', '3 331 6005#1234')
        );
        // One has Italian leading zero, one does not.
        $italianNumberOne = new PhoneNumber();
        $italianNumberOne->setCountryCode(39)->setNationalNumber('1234')->setItalianLeadingZero(true);
        $italianNumberTwo = new PhoneNumber();
        $italianNumberTwo->setCountryCode(39)->setNationalNumber('1234');
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch($italianNumberOne, $italianNumberTwo)
        );
        // One has an extension, the other has an extension of "".
        $italianNumberOne->setExtension('1234')->clearItalianLeadingZero();
        $italianNumberTwo->setExtension('');
        self::assertEquals(
            MatchType::SHORT_NSN_MATCH,
            $this->phoneUtil->isNumberMatch($italianNumberOne, $italianNumberTwo)
        );
    }

    public function testCanBeInternationallyDialled(): void
    {
        // We have no-international-dialling rules for the US in our test metadata that say that
        // toll-free numbers cannot be dialled internationally.
        self::assertFalse($this->phoneUtil->canBeInternationallyDialled(self::$usTollFree));
        // Normal US numbers can be internationally dialled.
        self::assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$usNumber));

        // Invalid number.
        self::assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$usLocalNumber));

        // We have no data for NZ - should return true.
        self::assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$nzNumber));
        self::assertTrue($this->phoneUtil->canBeInternationallyDialled(self::$internationalTollFree));
    }

    public function testIsAlphaNumber(): void
    {
        self::assertTrue($this->phoneUtil->isAlphaNumber('1800 six-flags'));
        self::assertTrue($this->phoneUtil->isAlphaNumber('1800 six-flags ext. 1234'));
        self::assertTrue($this->phoneUtil->isAlphaNumber('+800 six-flags'));
        self::assertTrue($this->phoneUtil->isAlphaNumber('180 six-flags'));
        self::assertFalse($this->phoneUtil->isAlphaNumber('1800 123-1234'));
        self::assertFalse($this->phoneUtil->isAlphaNumber('1 six-flags'));
        self::assertFalse($this->phoneUtil->isAlphaNumber('18 six-flags'));
        self::assertFalse($this->phoneUtil->isAlphaNumber('1800 123-1234 extension: 1234'));
        self::assertFalse($this->phoneUtil->isAlphaNumber('+800 1234-1234'));
    }

    public function testIsMobileNumberPortableRegion(): void
    {
        self::assertTrue($this->phoneUtil->isMobileNumberPortableRegion(RegionCode::US));
        self::assertTrue($this->phoneUtil->isMobileNumberPortableRegion(RegionCode::GB));
        self::assertFalse($this->phoneUtil->isMobileNumberPortableRegion(RegionCode::AE));
        self::assertFalse($this->phoneUtil->isMobileNumberPortableRegion(RegionCode::BS));
    }
}
