<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\CountryCodeSource;
use libphonenumber\CountryCodeToRegionCodeMapForTesting;
use libphonenumber\Leniency;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberMatch;
use libphonenumber\PhoneNumberMatcher;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function array_fill;
use function mb_strlen;
use function mb_substr;
use function str_repeat;

class PhoneNumberMatcherTest extends TestCase
{
    protected PhoneNumberUtil $phoneUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance(
            __NAMESPACE__ . '\data\PhoneNumberMetadataForTesting_',
            CountryCodeToRegionCodeMapForTesting::COUNTRY_CODE_TO_REGION_CODE_MAP_FOR_TESTING
        );
    }

    public function testContainsMoreThanOneSlashInNationalNumber(): void
    {
        // A date should return true.
        $number = new PhoneNumber();
        $number->setCountryCode(1);
        $number->setCountryCodeSource(CountryCodeSource::FROM_DEFAULT_COUNTRY);
        $candidate = '1/05/2013';
        self::assertTrue(PhoneNumberMatcher::containsMoreThanOneSlashInNationalNumber($number, $candidate));

        // Here, the country code source thinks it started with a country calling code, but this is not
        // the same as the part before the slash, so it's still true.
        $number = new PhoneNumber();
        $number->setCountryCode(274);
        $number->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN);
        $candidate = '27/4/2013';
        self::assertTrue(PhoneNumberMatcher::containsMoreThanOneSlashInNationalNumber($number, $candidate));

        // Now it should be false, because the first slash is after the country calling code.
        $number = new PhoneNumber();
        $number->setCountryCode(49);
        $number->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN);
        $candidate = '49/69/2013';
        self::assertFalse(PhoneNumberMatcher::containsMoreThanOneSlashInNationalNumber($number, $candidate));

        $number = new PhoneNumber();
        $number->setCountryCode(49);
        $number->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN);
        $candidate = '+49/69/2013';
        self::assertFalse(PhoneNumberMatcher::containsMoreThanOneSlashInNationalNumber($number, $candidate));

        $candidate = '+ 49/69/2013';
        self::assertFalse(PhoneNumberMatcher::containsMoreThanOneSlashInNationalNumber($number, $candidate));

        $candidate = '+ 49/69/20/13';
        self::assertTrue(PhoneNumberMatcher::containsMoreThanOneSlashInNationalNumber($number, $candidate));

        // Here, the first group is not assumed to be the country calling code, even though it is the
        // same as it, so this should return true.
        $number = new PhoneNumber();
        $number->setCountryCode(49);
        $number->setCountryCodeSource(CountryCodeSource::FROM_DEFAULT_COUNTRY);
        $candidate = '49/69/2013';
        self::assertTrue(PhoneNumberMatcher::containsMoreThanOneSlashInNationalNumber($number, $candidate));
    }

    public function testFindNationalNumber(): void
    {
        // same cases as in testParseNationalNumber
        $this->doTestFindInContext('033316005', RegionCode::NZ);
        // ("33316005", RegionCode.NZ) is omitted since the national prefix is obligatory for these
        // types of numbers in New Zealand.
        // National prefix attached and some formatting present.
        $this->doTestFindInContext('03-331 6005', RegionCode::NZ);
        $this->doTestFindInContext('03 331 6005', RegionCode::NZ);
        // Testing international prefixes.
        // Should strip country code.
        $this->doTestFindInContext('0064 3 331 6005', RegionCode::NZ);
        // Try again, but this time we have an international number with Region Code US. It should
        // recognize the country code and parse accordingly.
        $this->doTestFindInContext('01164 3 331 6005', RegionCode::US);
        $this->doTestFindInContext('+64 3 331 6005', RegionCode::US);

        $this->doTestFindInContext('64(0)64123456', RegionCode::NZ);
        // Check that using a "/" is fine in a phone number.
        // Note that real Polish numbers do *not* start with a 0.
        $this->doTestFindInContext('0123/456789', RegionCode::PL);
        $this->doTestFindInContext('123-456-7890', RegionCode::US);
    }

    public function testFindWithInternationalPrefixes(): void
    {
        $this->doTestFindInContext('+1 (650) 333-6000', RegionCode::NZ);
        $this->doTestFindInContext('1-650-333-6000', RegionCode::US);
        // Calling the US number from Singapore by using different service providers
        // 1st test: calling using SingTel IDD service (IDD is 001)
        $this->doTestFindInContext('0011-650-333-6000', RegionCode::SG);
        // 2nd test: calling using StarHub IDD service (IDD is 008)
        $this->doTestFindInContext('0081-650-333-6000', RegionCode::SG);
        // 3rd test: calling using SingTel V019 service (IDD is 019)
        $this->doTestFindInContext('0191-650-333-6000', RegionCode::SG);
        // Calling the US number from Poland
        $this->doTestFindInContext('0~01-650-333-6000', RegionCode::PL);
        // Using "++" at the start.
        $this->doTestFindInContext('++1 (650) 333-6000', RegionCode::PL);
        // Using a full-width plus sign.
        $this->doTestFindInContext("\xEF\xBC\x8B1 (650) 333-6000", RegionCode::SG);
        // The whole number, including punctuation, is here represented in full-width form.
        $this->doTestFindInContext('＋１ （６５０） ３３３－６０００', RegionCode::SG);
    }

    public function testFindWithLeadingZero(): void
    {
        $this->doTestFindInContext('+39 02-36618 300', RegionCode::NZ);
        $this->doTestFindInContext('02-36618 300', RegionCode::IT);
        $this->doTestFindInContext('312 345 678', RegionCode::IT);
    }

    public function testFindNationalNumberArgentina(): void
    {
        // Test parsing mobile numbers of Argentina.
        $this->doTestFindInContext('+54 9 343 555 1212', RegionCode::AR);
        $this->doTestFindInContext('0343 15 555 1212', RegionCode::AR);

        $this->doTestFindInContext('+54 9 3715 65 4320', RegionCode::AR);
        $this->doTestFindInContext('03715 15 65 4320', RegionCode::AR);

        // Test parsing fixed-line numbers of Argentina.
        $this->doTestFindInContext('+54 11 3797 0000', RegionCode::AR);
        $this->doTestFindInContext('011 3797 0000', RegionCode::AR);

        $this->doTestFindInContext('+54 3715 65 4321', RegionCode::AR);
        $this->doTestFindInContext('03715 65 4321', RegionCode::AR);

        $this->doTestFindInContext('+54 23 1234 0000', RegionCode::AR);
        $this->doTestFindInContext('023 1234 0000', RegionCode::AR);
    }

    public function testFindWithXInNumber(): void
    {
        $this->doTestFindInContext('(0xx) 123456789', RegionCode::AR);
        // A case where x denotes both carrier codes and extension symbol.
        $this->doTestFindInContext('(0xx) 123456789 x 1234', RegionCode::AR);

        // This test is intentionally constructed such that the number of digit after xx is larger than
        // 7, so that the number won't be mistakenly treated as an extension, as we allow extensions up
        // to 7 digits. This assumption is okay for now as all the countries where a carrier selection
        // code is written in the form of xx have a national significant number of length larger than 7.
        $this->doTestFindInContext('011xx5481429712', RegionCode::US);
    }

    public function testFindNumbersMexico(): void
    {
        // Test parsing fixed-line numbers of Mexico.
        $this->doTestFindInContext('+52 (449)978-0001', RegionCode::MX);
        $this->doTestFindInContext('01 (449)978-0001', RegionCode::MX);
        $this->doTestFindInContext('(449)978-0001', RegionCode::MX);

        // Test parsing mobile numbers of Mexico.
        $this->doTestFindInContext('+52 1 33 1234-5678', RegionCode::MX);
        $this->doTestFindInContext('044 (33) 1234-5678', RegionCode::MX);
        $this->doTestFindInContext('045 33 1234-5678', RegionCode::MX);
    }

    public function testFindNumbersWithPlusWithNoRegion(): void
    {
        // RegionCode.ZZ is allowed only if the number starts with a '+' - then the country code can be
        // calculated.
        $this->doTestFindInContext('+64 3 331 6005', RegionCode::ZZ);
        // Null is also allowed for the region code in these cases.
        $this->doTestFindInContext('+64 3 331 6005', null);
    }

    public function testFindExtensions(): void
    {
        $this->doTestFindInContext('03 331 6005 ext 3456', RegionCode::NZ);
        $this->doTestFindInContext('03-3316005x3456', RegionCode::NZ);
        $this->doTestFindInContext('03-3316005 int.3456', RegionCode::NZ);
        $this->doTestFindInContext('03 3316005 #3456', RegionCode::NZ);
        $this->doTestFindInContext('0~0 1800 7493 524', RegionCode::PL);
        $this->doTestFindInContext('(1800) 7493.524', RegionCode::US);
        // Check that the last instance of an extension token is matched.
        $this->doTestFindInContext('0~0 1800 7493 524 ~1234', RegionCode::PL);
        // Verifying bug-fix where the last digit of a number was previously omitted if it was a 0 when
        // extracting the extension. Also verifying a few different cases of extensions.
        $this->doTestFindInContext('+44 2034567890x456', RegionCode::NZ);
        $this->doTestFindInContext('+44 2034567890x456', RegionCode::GB);
        $this->doTestFindInContext('+44 2034567890 x456', RegionCode::GB);
        $this->doTestFindInContext('+44 2034567890 X456', RegionCode::GB);
        $this->doTestFindInContext('+44 2034567890 X 456', RegionCode::GB);
        $this->doTestFindInContext('+44 2034567890 X  456', RegionCode::GB);
        $this->doTestFindInContext('+44 2034567890  X 456', RegionCode::GB);

        $this->doTestFindInContext('(800) 901-3355 x 7246433', RegionCode::US);
        $this->doTestFindInContext('(800) 901-3355 , ext 7246433', RegionCode::US);
        $this->doTestFindInContext('(800) 901-3355 ,extension 7246433', RegionCode::US);
        // The next test differs from PhoneNumberUtil -> when matching we don't consider a lone comma to
        // indicate an extension, although we accept it when parsing.
        $this->doTestFindInContext('(800) 901-3355 ,x 7246433', RegionCode::US);
        $this->doTestFindInContext('(800) 901-3355 ext: 7246433', RegionCode::US);
    }

    public function testFindInterspersedWithSpace(): void
    {
        $this->doTestFindInContext('0 3   3 3 1   6 0 0 5', RegionCode::NZ);
    }

    /**
     * Test matching behaviour when starting in the middle of a phone number.
     */
    public function testIntermediateParsePositions(): void
    {
        $text = 'Call 033316005  or 032316005!';
        //       |    |    |    |    |    |
        //       0    5   10   15   20   25

        // Iterate over all possible indices.
        for ($i = 0; $i <= 5; $i++) {
            $this->assertEqualRange($text, $i, 5, 14);
        }
        // 7 and 8 digits in a row are still parsed as number.
        $this->assertEqualRange($text, 6, 6, 14);
        $this->assertEqualRange($text, 7, 7, 14);
        // Anything smaller is skipped to the second instance.
        for ($i = 8; $i <= 19; $i++) {
            $this->assertEqualRange($text, $i, 19, 28);
        }
    }

    public function testFourMatchesInARow(): void
    {
        $number1 = '415-666-7777';
        $number2 = '800-443-1223';
        $number3 = '212-443-1223';
        $number4 = '650-443-1223';
        $text = $number1 . ' - ' . $number2 . ' - ' . $number3 . ' - ' . $number4;

        $iterator = $this->phoneUtil->findNumbers($text, RegionCode::US);

        $iterator->next();
        $match = $iterator->current();
        $this->assertMatchProperties($match, $text, $number1, RegionCode::US);

        $iterator->next();
        $match = $iterator->current();
        $this->assertMatchProperties($match, $text, $number2, RegionCode::US);

        $iterator->next();
        $match = $iterator->current();
        $this->assertMatchProperties($match, $text, $number3, RegionCode::US);

        $iterator->next();
        $match = $iterator->current();
        $this->assertMatchProperties($match, $text, $number4, RegionCode::US);
    }

    public function testMatchesFoundWithMultipleSpaces(): void
    {
        $number1 = '(415) 666-7777';
        $number2 = '(800) 443-1223';
        $text = $number1 . ' ' . $number2;

        $iterator = $this->phoneUtil->findNumbers($text, RegionCode::US);

        $iterator->next();
        $match = $iterator->current();
        $this->assertMatchProperties($match, $text, $number1, RegionCode::US);

        $iterator->next();
        $match = $iterator->current();
        $this->assertMatchProperties($match, $text, $number2, RegionCode::US);
    }

    public function testMatchWithSurroundingZipcodes(): void
    {
        $number = '415-666-7777';
        $zipPreceding = 'My address is CA 34215 - ' . $number . ' is my number.';

        $iterator = $this->phoneUtil->findNumbers($zipPreceding, RegionCode::US);

        $iterator->next();
        $match = $iterator->current();
        $this->assertMatchProperties($match, $zipPreceding, $number, RegionCode::US);

        // Now repeat, but this time the phone number has spaces in it. It should still be found.
        $number = '(415) 666 7777';

        $zipFollowing = 'My number is ' . $number . '. 34215 is my zip-code.';

        $iterator = $this->phoneUtil->findNumbers($zipFollowing, RegionCode::US);

        $iterator->next();
        $match = $iterator->current();
        $this->assertMatchProperties($match, $zipFollowing, $number, RegionCode::US);
    }

    /**
     * @return array<array{string,bool}>
     */
    public static function dataLatinLetters(): array
    {
        return [
            ['c', true],
            ['C', true],
            ["\xC3\x89", true],
            ["\xCC\x81", true], // Combining acute accent
            // Punctuation, digits and white-space are not considered "latin letters".
            [':', false],
            ['5', false],
            ['-', false],
            ['.', false],
            [' ', false],
            ["\xE6\x88\x91", false],  // Chinese character
            ["\xE3\x81\xAE", false],  // Hiragana letter no
        ];
    }

    #[DataProvider('dataLatinLetters')]
    public function testIsLatinLetter(string $letter, bool $expectedResult): void
    {
        self::assertEquals(
            $expectedResult,
            PhoneNumberMatcher::isLatinLetter($letter),
            "{$letter} should return {$expectedResult}"
        );
    }

    public function testMatchesWithSurroundingLatinChars(): void
    {
        $possibleOnlyContexts = [];
        $possibleOnlyContexts[] = ['abc', 'def'];
        $possibleOnlyContexts[] = ['abc', ''];
        $possibleOnlyContexts[] = ['', 'def'];
        // Latin capital letter e with an acute accent.
        $possibleOnlyContexts[] = ["\xC3\x89", ''];
        // e with an acute accent decomposed (with combining mark).
        $possibleOnlyContexts[] = ["e\xCC\x81", ''];

        // Numbers should not be considered valid, if they are surrounded by Latin characters, but
        // should be considered possible.
        $this->findMatchesInContexts($possibleOnlyContexts, false, true);
    }

    public function testMoneyNotSeenAsPhoneNumber(): void
    {
        $possibleOnlyContexts = [];
        $possibleOnlyContexts[] = ['$', ''];
        $possibleOnlyContexts[] = ['', '$'];
        $possibleOnlyContexts[] = ["\xC2\xA3", ''];  // Pound sign
        $possibleOnlyContexts[] = ["\xC2\xA5", ''];  // Yen sign

        $this->findMatchesInContexts($possibleOnlyContexts, false, true);
    }

    public function testPercentageNotSeenAsPhoneNumber(): void
    {
        $possibleOnlyContexts = [];
        $possibleOnlyContexts[] = ['', '%'];
        // Numbers followed by % should be dropped
        $this->findMatchesInContexts($possibleOnlyContexts, false, true);
    }

    public function testPhoneNumberWithLeadingOrTrailingMoneyMatches(): void
    {
        // Because of the space after the 20 (or before the 100) these dollar amounts should not stop
        // the actual number from being found.
        $contexts = [];
        $contexts[] = ['$20 ', ''];
        $contexts[] = ['', ' 100$'];

        $this->findMatchesInContexts($contexts, true, true);
    }

    public function testMatchesWithSurroundingLatinCharsAndLeadingPunctuation(): void
    {
        // Contexts with trailing characters. Leading characters are okay here since the numbers we will
        // insert start with punctuation, but trailing characters are still not allowed.
        $possibleOnlyContexts = [];
        $possibleOnlyContexts[] = ['abc', 'def'];
        $possibleOnlyContexts[] = ['', 'def'];
        $possibleOnlyContexts[] = ['', "\xC3\x89"];

        // Numbers should not be considered valid, if they have trailing Latin characters, but should be
        // considered possible.
        $numberWithPlus = '+14156667777';
        $numberWithBrackets = '(415)6667777';
        $this->findMatchesInContexts($possibleOnlyContexts, false, true, RegionCode::US, $numberWithPlus);
        $this->findMatchesInContexts($possibleOnlyContexts, false, true, RegionCode::US, $numberWithBrackets);

        $validContexts = [];
        $validContexts[] = ['abc', ''];
        $validContexts[] = ["\xC3\x89", ''];
        $validContexts[] = ["\xC3\x89", '.']; // Trailing punctuation.
        $validContexts[] = ["\xC3\x89", ' def']; // Trailing white space.

        // Numbers should be considered valid, since they start with punctuation.
        $this->findMatchesInContexts($validContexts, true, true, RegionCode::US, $numberWithPlus);
        $this->findMatchesInContexts($validContexts, true, true, RegionCode::US, $numberWithBrackets);
    }

    public function testMatchesWithSurroundingChineseChars(): void
    {
        $validContexts = [];
        $validContexts[] = ['我的电话号码是', ''];
        $validContexts[] = ['', '是我的电话号码'];
        $validContexts[] = ['请拨打', '我在明天'];

        // Numbers should be considered valid, since they are surrounded by Chinese.
        $this->findMatchesInContexts($validContexts, true, true);
    }

    public function testMatchesWithSurroundingPunctuation(): void
    {
        $validContexts = [];
        $validContexts[] = ['My number-', '']; // At end of text
        $validContexts[] = ['', '.Nice day.']; // At start of text
        $validContexts[] = ['Tel:', '.']; // Punctuation surrounds number.
        $validContexts[] = ['Tel: ', ' on Saturdays.']; // White-space is also fine.

        // Numbers should be considered valid, since they are surrounded by punctuation.
        $this->findMatchesInContexts($validContexts, true, true);
    }

    public function testMatchesMultiplePhoneNumbersSeparatedByPhoneNumberPunctuation(): void
    {
        $text = 'Call 650-253-4561 -- 455-234-3451';
        $region = RegionCode::US;

        $number1 = new PhoneNumber();
        $number1->setCountryCode($this->phoneUtil->getCountryCodeForRegion($region));
        $number1->setNationalNumber('6502534561');
        $match1 = new PhoneNumberMatch(5, '650-253-4561', $number1);

        $number2 = new PhoneNumber();
        $number2->setCountryCode($this->phoneUtil->getCountryCodeForRegion($region));
        $number2->setNationalNumber('4552343451');
        $match2 = new PhoneNumberMatch(21, '455-234-3451', $number2);

        $matches = $this->phoneUtil->findNumbers($text, $region);

        $matches->next();
        self::assertEquals($match1, $matches->current());

        $matches->next();
        self::assertEquals($match2, $matches->current());
    }

    public function testDoesNotMatchMultiplePhoneNumbersSeparatedWithNoWhiteSpace(): void
    {
        // No white-space found between numbers - neither is found.
        $text = 'Call 650-253-4561--455-234-3451';
        $region = RegionCode::US;

        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers($text, $region)));
    }

    /**
     * Strings with number-like things that shouldn't be found under any level.
     * @return array<array{string,string}>
     */
    public static function dataImpossibleCases(): array
    {
        return [
            ['12345', RegionCode::US],
            ['23456789', RegionCode::US],
            ['234567890112', RegionCode::US],
            ['650+253+1234', RegionCode::US],
            ['3/10/1984', RegionCode::CA],
            ['03/27/2011', RegionCode::US],
            ['31/8/2011', RegionCode::US],
            ['1/12/2011', RegionCode::US],
            ['10/12/82', RegionCode::DE],
            ['650x2531234', RegionCode::US],
            ['2012-01-02 08:00', RegionCode::US],
            ['2012/01/02 08:00', RegionCode::US],
            ['20120102 08:00', RegionCode::US],
            ['2014-04-12 04:04 PM', RegionCode::US],
            ['2014-04-12 &nbsp;04:04 PM', RegionCode::US],
            ['2014-04-12 &nbsp;04:04 PM', RegionCode::US],
            ['2014-04-12  04:04 PM', RegionCode::US],
        ];
    }

    /**
     * Strings with number-like things that should only be found under "possible".
     * @return array<array{string,string}>
     */
    public static function dataPossibleOnlyCases(): array
    {
        return [
            // US numbers cannot start with 7 in the test metadata to be valid.
            ['7121115678', RegionCode::US],
            // 'X' should not be found in numbers at leniencies stricter than POSSIBLE, unless it represents
            // a carrier code or extension.
            ['1650 x 253 - 1234', RegionCode::US],
            ['650 x 253 - 1234', RegionCode::US],
            ['6502531x234', RegionCode::US],
            ['(20) 3346 1234', RegionCode::GB],  // Non-optional NP omitted
        ];
    }

    /**
     * Strings with number-like things that should only be found up to and including the "valid"
     * leniency level.
     * @return array<array{string,string}>
     */
    public static function dataValidCases(): array
    {
        return [
            ['65 02 53 00 00', RegionCode::US],
            ['6502 538365', RegionCode::US],
            ['650//253-1234', RegionCode::US],  // 2 slashes are illegal at higher levels
            ['650/253/1234', RegionCode::US],
            ['9002309. 158', RegionCode::US],
            ['12 7/8 - 14 12/34 - 5', RegionCode::US],
            ['12.1 - 23.71 - 23.45', RegionCode::US],
            ['800 234 1 111x1111', RegionCode::US],
            ['1979-2011 100', RegionCode::US],
            ['+494949-4-94', RegionCode::DE],  // National number in wrong format
            ['４１５６６６６-７７７', RegionCode::US],
            ['2012-0102 08', RegionCode::US],  // Very strange formatting.
            ['2012-01-02 08', RegionCode::US],
            // Breakdown assistance number with unexpected formatting.
            ['1800-1-0-10 22', RegionCode::AU],
            ['030-3-2 23 12 34', RegionCode::DE],
            ['03 0 -3 2 23 12 34', RegionCode::DE],
            ['(0)3 0 -3 2 23 12 34', RegionCode::DE],
            ['0 3 0 -3 2 23 12 34', RegionCode::DE],
            // Fits an alternate pattern, but the leading digits don't match
            ['+52 332 123 23 23', RegionCode::MX],
        ];
    }

    /**
     * Strings with number-like things that should only be found up to and including the
     * "strict_grouping" leniency level.
     * @return array<array{string,string}>
     */
    public static function dataStrictGroupingCases(): array
    {
        return [
            ['(415) 6667777', RegionCode::US],
            ['415-6667777', RegionCode::US],
            // Should be found by strict grouping but not exact grouping, as the last two groups are
            // formatted together as a block.
            ['0800-2491234', RegionCode::DE],
            // Doesn't match any formatting in the test file, but almost matches an alternate format (the
            // last two groups have been squashed together here).
            ['0900-1 123123', RegionCode::DE],
            ['(0)900-1 123123', RegionCode::DE],
            ['0 900-1 123123', RegionCode::DE],
            // NDC also found as part of the country calling code; this shouldn't ruin the grouping
            // expectations.
            ['+33 3 34 2312', RegionCode::FR],
        ];
    }

    /**
     * Strings with number-like things that should be found at all levels.
     * @return array<array{string,string}>
     */
    public static function dataExactGroupingCases(): array
    {
        return [
            ['４１５６６６７７７７', RegionCode::US],
            ['４１５-６６６-７７７７', RegionCode::US],
            ['4156667777', RegionCode::US],
            ['4156667777 x 123', RegionCode::US],
            ['415-666-7777', RegionCode::US],
            ['415/666-7777', RegionCode::US],
            ['415-666-7777 ext. 503', RegionCode::US],
            ['1 415 666 7777 x 123', RegionCode::US],
            ['+1 415-666-7777', RegionCode::US],
            ['+494949 49', RegionCode::DE],
            ['+49-49-34', RegionCode::DE],
            ['+49-4931-49', RegionCode::DE],
            ['04931-49', RegionCode::DE],  // With National Prefix
            ['+49-494949', RegionCode::DE],  // One group with country code
            ['+49-494949 ext. 49', RegionCode::DE],
            ['+49494949 ext. 49', RegionCode::DE],
            ['0494949', RegionCode::DE],
            ['0494949 ext. 49', RegionCode::DE],
            ['01 (33) 3461 2234', RegionCode::MX],  // Optional NP present
            ['(33) 3461 2234', RegionCode::MX],  // Optional NP omitted
            ['1800-10-10 22', RegionCode::AU],  // Breakdown assistance number.
            // Doesn't match any formatting in the test file, but matches an alternate format exactly.
            ['0900-1 123 123', RegionCode::DE],
            ['(0)900-1 123 123', RegionCode::DE],
            ['0 900-1 123 123', RegionCode::DE],
            ['+33 3 34 23 12', RegionCode::FR],
        ];
    }

    /**
     * @return array<array{string,string}>
     */
    public static function data_testMatchesWithPossibleLeniency(): array
    {
        return self::dataStrictGroupingCases()
        + self::dataExactGroupingCases()
        + self::dataValidCases()
        + self::dataPossibleOnlyCases();
    }

    #[DataProvider('data_testMatchesWithPossibleLeniency')]
    public function testMatchesWithPossibleLeniency(string $rawString, string $region): void
    {
        $this->doTestNumberMatchesForLeniency($rawString, $region, Leniency::POSSIBLE());
    }

    #[DataProvider('dataImpossibleCases')]
    public function testNonMatchesWithPossibleLeniency(string $rawString, string $region): void
    {
        $this->doTestNumberNonMatchesForLeniency($rawString, $region, Leniency::POSSIBLE());
    }

    /**
     * @return array<array{string,string}>
     */
    public static function data_testMatchesWithValidLeniency(): array
    {
        return self::dataStrictGroupingCases()
        + self::dataExactGroupingCases()
        + self::dataValidCases();
    }

    #[DataProvider('data_testMatchesWithValidLeniency')]
    public function testMatchesWithValidLeniency(string $rawString, string $region): void
    {
        $this->doTestNumberMatchesForLeniency($rawString, $region, Leniency::VALID());
    }

    /**
     * @return array<array{string,string}>
     */
    public static function data_testNonMatchesWithValidLeniency(): array
    {
        return self::dataImpossibleCases()
            + self::dataPossibleOnlyCases();
    }

    #[DataProvider('data_testNonMatchesWithValidLeniency')]
    public function testNonMatchesWithValidLeniency(string $rawString, string $region): void
    {
        $this->doTestNumberNonMatchesForLeniency($rawString, $region, Leniency::VALID());
    }

    /**
     * @return array<array{string,string}>
     */
    public static function data_testMatchesWithStrictGroupingLeniency(): array
    {
        return self::dataStrictGroupingCases()
            + self::dataExactGroupingCases();
    }

    #[DataProvider('data_testMatchesWithStrictGroupingLeniency')]
    public function testMatchesWithStrictGroupingLeniency(string $rawString, string $region): void
    {
        $this->doTestNumberMatchesForLeniency($rawString, $region, Leniency::STRICT_GROUPING());
    }

    /**
     * @return array<array{string,string}>
     */
    public static function data_testNonMatchesWithStrictGroupLeniency(): array
    {
        return self::dataImpossibleCases()
            + self::dataPossibleOnlyCases()
            + self::dataValidCases();
    }

    #[DataProvider('data_testNonMatchesWithStrictGroupLeniency')]
    public function testNonMatchesWithStrictGroupLeniency(string $rawString, string $region): void
    {
        $this->doTestNumberNonMatchesForLeniency($rawString, $region, Leniency::STRICT_GROUPING());
    }

    #[DataProvider('dataExactGroupingCases')]
    public function testMatchesWithExactGroupingLeniency(string $rawString, string $region): void
    {
        $this->doTestNumberMatchesForLeniency($rawString, $region, Leniency::EXACT_GROUPING());
    }

    /**
     * @return array<array{string,string}>
     */
    public static function data_testNonMatchesExactGroupLeniency(): array
    {
        return self::dataImpossibleCases()
            + self::dataPossibleOnlyCases()
            + self::dataValidCases()
            + self::dataStrictGroupingCases();
    }

    #[DataProvider('data_testNonMatchesExactGroupLeniency')]
    public function testNonMatchesExactGroupLeniency(string $rawString, string $region): void
    {
        $this->doTestNumberNonMatchesForLeniency($rawString, $region, Leniency::EXACT_GROUPING());
    }

    protected function doTestNumberMatchesForLeniency(string $string, string $region, Leniency\AbstractLeniency $leniency): void
    {
        $iterator = $this->findNumbersForLeniency($string, $region, $leniency);

        $iterator->next();
        $match = $iterator->current();

        self::assertNotNull($match, "No match found in {$string} ({$region}) for leniency {$leniency}");
        self::assertEquals($string, $match->rawString(), "Found wrong match in test {$string} ({$region}). Found {$match->rawString()}");
    }

    protected function doTestNumberNonMatchesForLeniency(string $string, string $region, Leniency\AbstractLeniency $leniency): void
    {
        $iterator = $this->findNumbersForLeniency($string, $region, $leniency);

        $iterator->next();
        $match = $iterator->current();

        self::assertNull($match, "Match found in {$string} ({$region}) for leniency {$leniency}");
    }

    /**
     * Helper method which tests the contexts provided and ensures that:
     * -- if isValid is true, they all find a test number inserted in the middle when leniency of
     *  matching is set to VALID; else no test number should be extracted at that leniency level
     * -- if isPossible is true, they all find a test number inserted in the middle when leniency of
     *  matching is set to POSSIBLE; else no test number should be extracted at that leniency level
     * @param array<array{string,string}> $contexts
     */
    protected function findMatchesInContexts(
        array $contexts,
        bool $isValid,
        bool $isPossible,
        string $region = RegionCode::US,
        string $number = '415-666-7777'
    ): void {
        if ($isValid) {
            $this->doTestInContext($number, $region, $contexts, Leniency::VALID());
        } else {
            foreach ($contexts as $context) {
                $text = $context[0] . $number . $context[1];
                self::assertTrue(
                    $this->hasNoMatches($this->phoneUtil->findNumbers($text, $region)),
                    "Should not have found a number in {$text}"
                );
            }
        }

        if ($isPossible) {
            $this->doTestInContext($number, $region, $contexts, Leniency::POSSIBLE());
        } else {
            foreach ($contexts as $context) {
                $text = $context[0] . $number . $context[1];
                self::assertTrue(
                    $this->hasNoMatches($this->phoneUtil->findNumbers($text, $region)),
                    "Should not have found a number in {$text}"
                );
            }
        }
    }

    public function testNonMatchingBracketsAreInvalid(): void
    {
        // The digits up to the ", " form a valid US number, but it shouldn't be matched as one since
        // there was a non-matching bracket present.
        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers(
            '80.585 [79.964, 81.191]',
            RegionCode::US
        )));

        // The trailing "]" is thrown away before parsing, so the resultant number, while a valid US
        // number, does not have matching brackets.
        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers(
            '80.585 [79.964]',
            RegionCode::US
        )));

        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers(
            '80.585 ((79.964)',
            RegionCode::US
        )));

        // This case has too many sets of brackets to be valid.
        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers(
            '(80).(585) (79).(9)64',
            RegionCode::US
        )));
    }

    public function testNoMatchIfRegionIsNull(): void
    {
        // Fail on non-international prefix if region code is null.
        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers(
            'Random text body - number is 0331 6005, see you there',
            null
        )));
    }

    public function testNoMatchInEmptyString(): void
    {
        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers('', RegionCode::US)));
        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers('  ', RegionCode::US)));
    }

    public function testNoMatchIfNoNumber(): void
    {
        self::assertTrue($this->hasNoMatches($this->phoneUtil->findNumbers(
            'Random text body - number is foobar, see you there',
            RegionCode::US
        )));
    }

    public function testSequences(): void
    {
        // Test multiple occurrences.
        $text = 'Call 033316005  or 032316005!';
        $region = RegionCode::NZ;

        $number1 = new PhoneNumber();
        $number1->setCountryCode($this->phoneUtil->getCountryCodeForRegion($region));
        $number1->setNationalNumber('33316005');
        $match1 = new PhoneNumberMatch(5, '033316005', $number1);

        $number2 = new PhoneNumber();
        $number2->setCountryCode($this->phoneUtil->getCountryCodeForRegion($region));
        $number2->setNationalNumber('32316005');
        $match2 = new PhoneNumberMatch(19, '032316005', $number2);

        $matches = $this->phoneUtil->findNumbers($text, $region, Leniency::POSSIBLE());

        $matches->next();
        self::assertEquals($match1, $matches->current());

        $matches->next();
        self::assertEquals($match2, $matches->current());
    }

    public function testMaxMatches(): void
    {
        // Set up text with 100 valid phone numbers.
        $numbers = str_repeat('My info: 415-666-7777,', 100);

        // Matches all 100. Max only applies to failed cases.
        $number = $this->phoneUtil->parse('+14156667777', null);
        $expected = array_fill(0, 100, $number);

        $iterable = $this->phoneUtil->findNumbers($numbers, RegionCode::US, Leniency::VALID(), 10);
        $actual = [];
        foreach ($iterable as $match) {
            $actual[] = $match->number();
        }

        self::assertEquals($expected, $actual);
    }

    public function testMaxMatchesInvalid(): void
    {
        // Set up text with 10 invalid phone numbers followed by 100 valid.
        $numbers = '';
        for ($i = 0; $i < 10; $i++) {
            $numbers .= 'My address is 949-8945-0';
        }
        for ($i = 0; $i < 100; $i++) {
            $numbers .= 'My info: 415-666-7777,';
        }

        $iterable = $this->phoneUtil->findNumbers($numbers, RegionCode::US, Leniency::VALID(), 10);
        $iterable->next();
        self::assertNull($iterable->current());
    }

    public function testMaxMatchesMixed(): void
    {
        // Set up text with 100 valid numbers inside an invalid number.
        $numbers = '';
        for ($i = 0; $i < 100; $i++) {
            $numbers .= 'My info: 415-666-7777 123 fake street';
        }

        // Only matches the first 10 despite there being 100 numbers due to max matches
        $number = $this->phoneUtil->parse('+14156667777', null);
        $expected = array_fill(0, 10, $number);

        $iterable = $this->phoneUtil->findNumbers($numbers, RegionCode::US, Leniency::VALID(), 10);

        $actual = [];
        foreach ($iterable as $match) {
            $actual[] = $match->number();
        }

        self::assertEquals($expected, $actual);
    }

    public function testNonPlusPrefixedNumbersNotFoundForInvalidRegion(): void
    {
        // Does not start with a "+", we won't match it.
        $iterable = $this->phoneUtil->findNumbers('1 456 764 156', RegionCode::ZZ);

        $iterable->next();
        self::assertFalse($iterable->valid());
    }

    public function testEmptyIteration(): void
    {
        $iterable = $this->phoneUtil->findNumbers('', RegionCode::ZZ);

        $iterable->next();
        self::assertFalse($iterable->valid());
    }

    public function testSingleIteration(): void
    {
        $iterable = $this->phoneUtil->findNumbers('+14156667777', RegionCode::ZZ);

        $iterable->next();
        self::assertTrue($iterable->valid());
        self::assertNotNull($iterable->current());

        $iterable->next();
        self::assertFalse($iterable->valid());
        self::assertNull($iterable->current());
    }

    public function testDoubleIteration(): void
    {
        $iterable = $this->phoneUtil->findNumbers('+14156667777 foobar +14156667777 ', RegionCode::ZZ);

        $iterable->next();
        self::assertTrue($iterable->valid());
        self::assertNotNull($iterable->current());

        $iterable->next();
        self::assertTrue($iterable->valid());
        self::assertNotNull($iterable->current());

        $iterable->next();
        self::assertFalse($iterable->valid());
        self::assertNull($iterable->current());
    }

    /**
     * Asserts that the expected match is non-null, and that the raw string and expected
     * proto buffer are set appropriately
     */
    protected function assertMatchProperties(?PhoneNumberMatch $match, string $text, string $number, string $region): void
    {
        $expectedResult = $this->phoneUtil->parse($number, $region);
        self::assertNotNull($match, "Did not find a number in {$text}; expected {$number}");
        self::assertEquals($expectedResult, $match->number());
        self::assertEquals($number, $match->rawString());
    }

    /**
     * Asserts that another number can be found in $text starting at $index, and that its
     * corresponding range in $start to $end
     */
    protected function assertEqualRange(string $text, int $index, int $start, int $end): void
    {
        $sub = mb_substr($text, $index, mb_strlen($text) - $index);
        $matches = $this->phoneUtil->findNumbers($sub, RegionCode::NZ, Leniency::POSSIBLE(), PHP_INT_MAX);

        $matches->next();
        self::assertTrue($matches->valid());

        $match = $matches->current();
        self::assertNotNull($match);

        self::assertEquals($start - $index, $match->start());
        self::assertEquals($end - $index, $match->end());
        self::assertEquals(mb_substr($sub, $match->start(), $match->end() - $match->start()), $match->rawString());
    }

    /**
     * Tests numbers found by PhoneNumberUtil->findNumbers in various
     * textual contexts
     *
     * @param string $number The number to test
     * @param string|null $defaultCountry The corresponding region code
     */
    protected function doTestFindInContext(string $number, ?string $defaultCountry): void
    {
        $this->findPossibleInContext($number, $defaultCountry);

        $parsed = $this->phoneUtil->parse($number, $defaultCountry);
        if ($this->phoneUtil->isValidNumber($parsed)) {
            $this->findValidInContext($number, $defaultCountry);
        }
    }

    /**
     * Tests valid numbers in contexts that should pass for Leniency::POSSIBLE()
     */
    protected function findPossibleInContext(string $number, ?string $defaultCountry): void
    {
        $contextPairs = [];
        $contextPairs[] = ['', '']; // no content
        $contextPairs[] = ['   ', "\t"];  // whitespace only
        $contextPairs[] = ['Hello ', '']; // no context at end
        $contextPairs[] = ['', ' to call me!']; // no context at start
        $contextPairs[] = ['Hi there, call ', ' to reach me!']; // no context at start
        $contextPairs[] = ['Hi here, call ', " , or don't"]; // with commas
        // Three examples without whitespace around the number
        $contextPairs[] = ['Hi call', ''];
        $contextPairs[] = ['', 'forme'];
        $contextPairs[] = ['Hi call', 'forme'];
        // With other small numbers.
        $contextPairs[] = ["It's cheap! Call ", ' before 6:30'];
        // With a second number later.
        $contextPairs[] = ['Call ', ' or +1800-123-4567!'];
        $contextPairs[] = ['Call me on June 2 at', '']; // with a Month-Day date
        // With publication pages
        $contextPairs[] = ['As quoted by Alfonso 12-15 (2009), you may call me at ', ''];
        $contextPairs[] = ['As quoted by Alfonso et al. 12-15 (2009), you may call me at ', ''];
        // With dates, written in the American style.
        $contextPairs[] = ['As I said on 03/10/2011, you may call be at ', ''];
        // With trailing numbers after a comma. The 45 should not be considered an extension
        $contextPairs[] = ['', ', 45 days a year'];
        // When matching we don't consider semicolon along with legitimate extension symbol to indicate
        // an extension. The 7246433 should not be considered an extension.
        $contextPairs[] = ['', ';x 7246433'];
        // With a postfix stripped off as it looks like the start of another number.
        $contextPairs[] = ['Call ', '/x12 more'];

        $this->doTestInContext($number, $defaultCountry, $contextPairs, Leniency::POSSIBLE());
    }

    /**
     * Tests valid numbers in contexts that fail for Leniency::POSSIBLE() but are valid for
     * Leniency::VALID()
     */
    protected function findValidInContext(string $number, ?string $defaultCountry): void
    {
        $contextPairs = [];
        // With other small numbers
        $contextPairs[] = ["It's only 9.99! Call ", ' to buy'];
        // with a number Day.Month.Year date.
        $contextPairs[] = ['Call me on 21.6.1984 at ', ''];
        // With a number Month/Day date.
        $contextPairs[] = ['Call me on 06/21 at ', ''];
        // With a number Day.Month date.
        $contextPairs[] = ['Call me on 21.6. at ', ''];
        // With a number Month/Day/Year date.
        $contextPairs[] = ['Call me on 06/21/84 at ', ''];

        $this->doTestInContext($number, $defaultCountry, $contextPairs, Leniency::VALID());
    }

    /**
     * @param array<array{string,string}> $contextPairs
     */
    protected function doTestInContext(string $number, ?string $defaultCountry, array $contextPairs, Leniency\AbstractLeniency $leniency): void
    {
        foreach ($contextPairs as $context) {
            $prefix = $context[0];
            $text = $prefix . $number . $context[1];

            $start = mb_strlen($prefix);
            $end = $start + mb_strlen($number);

            $iterator = $this->phoneUtil->findNumbers($text, $defaultCountry, $leniency, PHP_INT_MAX);

            $iterator->next();
            $match = $iterator->current();
            self::assertNotNull($match, "Did not find number in '{$text}'; expected '{$number}'");

            $extracted = mb_substr($text, $match->start(), $match->end() - $match->start());
            self::assertEquals($start, $match->start(), "Unexpected phone region in '{$text}'; extracted '{$extracted}'");
            self::assertEquals($end, $match->end(), "Unexpected phone region in '{$text}'; extracted '{$extracted}'");
            self::assertEquals($number, $extracted);
            self::assertEquals($extracted, $match->rawString());

            $this->ensureTermination($text, $defaultCountry, $leniency);
        }
    }

    protected function ensureTermination(string $text, ?string $defaultCountry, Leniency\AbstractLeniency $leniency): void
    {
        $textLength = mb_strlen($text);
        for ($index = 0; $index <= $textLength; $index++) {
            $sub = mb_substr($text, $index);
            $matches = '';
            // Iterates over all matches.
            foreach ($this->phoneUtil->findNumbers($sub, $defaultCountry, $leniency, PHP_INT_MAX) as $match) {
                $matches .= ', ' . $match;
            }
        }
    }

    protected function findNumbersForLeniency(string $text, string $defaultCountry, Leniency\AbstractLeniency $leniency): PhoneNumberMatcher
    {
        return $this->phoneUtil->findNumbers($text, $defaultCountry, $leniency, PHP_INT_MAX);
    }

    protected function hasNoMatches(PhoneNumberMatcher $match): bool
    {
        return !$match->valid();
    }
}
