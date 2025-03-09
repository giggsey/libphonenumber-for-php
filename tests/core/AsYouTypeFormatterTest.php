<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\CountryCodeToRegionCodeMapForTesting;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\RegionCode;
use PHPUnit\Framework\TestCase;

class AsYouTypeFormatterTest extends TestCase
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

    public function testInvalidRegion(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::ZZ);
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+4', $formatter->inputDigit('4'));
        self::assertSame('+48 ', $formatter->inputDigit('8'));
        self::assertSame('+48 8', $formatter->inputDigit('8'));
        self::assertSame('+48 88', $formatter->inputDigit('8'));
        self::assertSame('+48 88 1', $formatter->inputDigit('1'));
        self::assertSame('+48 88 12', $formatter->inputDigit('2'));
        self::assertSame('+48 88 123', $formatter->inputDigit('3'));
        self::assertSame('+48 88 123 1', $formatter->inputDigit('1'));
        self::assertSame('+48 88 123 12', $formatter->inputDigit('2'));

        $formatter->clear();
        self::assertSame('6', $formatter->inputDigit('6'));
        self::assertSame('65', $formatter->inputDigit('5'));
        self::assertSame('650', $formatter->inputDigit('0'));
        self::assertSame('6502', $formatter->inputDigit('2'));
        self::assertSame('65025', $formatter->inputDigit('5'));
        self::assertSame('650253', $formatter->inputDigit('3'));
    }

    public function testInvalidPlusSign(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::ZZ);
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+4', $formatter->inputDigit('4'));
        self::assertSame('+48 ', $formatter->inputDigit('8'));
        self::assertSame('+48 8', $formatter->inputDigit('8'));
        self::assertSame('+48 88', $formatter->inputDigit('8'));
        self::assertSame('+48 88 1', $formatter->inputDigit('1'));
        self::assertSame('+48 88 12', $formatter->inputDigit('2'));
        self::assertSame('+48 88 123', $formatter->inputDigit('3'));
        self::assertSame('+48 88 123 1', $formatter->inputDigit('1'));
        // A plus sign can only appear at the beginning of the number; otherwise, no formatting is
        // applied.
        self::assertSame('+48881231+', $formatter->inputDigit('+'));
        self::assertSame('+48881231+2', $formatter->inputDigit('2'));
    }

    public function testTooLongNumberMatchingMultipleLeadingDigits(): void
    {
        // See https://github.com/googlei18n/libphonenumber/issues/36
        // The bug occurred last time for countries which have two formatting rules with exactly the
        // same leading digits pattern but differ in length.
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::ZZ);
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+81 ', $formatter->inputDigit('1'));
        self::assertSame('+81 9', $formatter->inputDigit('9'));
        self::assertSame('+81 90', $formatter->inputDigit('0'));
        self::assertSame('+81 90 1', $formatter->inputDigit('1'));
        self::assertSame('+81 90 12', $formatter->inputDigit('2'));
        self::assertSame('+81 90 123', $formatter->inputDigit('3'));
        self::assertSame('+81 90 1234', $formatter->inputDigit('4'));
        self::assertSame('+81 90 1234 5', $formatter->inputDigit('5'));
        self::assertSame('+81 90 1234 56', $formatter->inputDigit('6'));
        self::assertSame('+81 90 1234 567', $formatter->inputDigit('7'));
        self::assertSame('+81 90 1234 5678', $formatter->inputDigit('8'));
        self::assertSame('+81 90 12 345 6789', $formatter->inputDigit('9'));
        self::assertSame('+81901234567890', $formatter->inputDigit('0'));
        self::assertSame('+819012345678901', $formatter->inputDigit('1'));
    }

    public function testCountryWithSpaceInNationalPrefixFormattingRule(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::BY);
        self::assertSame('8', $formatter->inputDigit('8'));
        self::assertSame('88', $formatter->inputDigit('8'));
        self::assertSame('881', $formatter->inputDigit('1'));
        self::assertSame('8 819', $formatter->inputDigit('9'));
        self::assertSame('8 8190', $formatter->inputDigit('0'));
        // The formatting rule for 5 digit numbers states that no space should be present after the
        // national prefix.
        self::assertSame('881 901', $formatter->inputDigit('1'));
        self::assertSame('8 819 012', $formatter->inputDigit('2'));
        // Too long, no formatting rule applies.
        self::assertSame('88190123', $formatter->inputDigit('3'));
    }

    public function testCountryWithSpaceInNationalPrefixFormattingRuleAndLongNdd(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::BY);
        self::assertSame('9', $formatter->inputDigit('9'));
        self::assertSame('99', $formatter->inputDigit('9'));
        self::assertSame('999', $formatter->inputDigit('9'));
        self::assertSame('9999', $formatter->inputDigit('9'));
        self::assertSame('99999 ', $formatter->inputDigit('9'));
        self::assertSame('99999 1', $formatter->inputDigit('1'));
        self::assertSame('99999 12', $formatter->inputDigit('2'));
        self::assertSame('99999 123', $formatter->inputDigit('3'));
        self::assertSame('99999 1234', $formatter->inputDigit('4'));
        self::assertSame('99999 12 345', $formatter->inputDigit('5'));
    }

    public function testAYTFUS(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::US);
        self::assertSame('6', $formatter->inputDigit('6'));
        self::assertSame('65', $formatter->inputDigit('5'));
        self::assertSame('650', $formatter->inputDigit('0'));
        self::assertSame('650 2', $formatter->inputDigit('2'));
        self::assertSame('650 25', $formatter->inputDigit('5'));
        self::assertSame('650 253', $formatter->inputDigit('3'));
        // Note this is how a US local number (without area code) should be formatted.
        self::assertSame('650 2532', $formatter->inputDigit('2'));
        self::assertSame('650 253 22', $formatter->inputDigit('2'));
        self::assertSame('650 253 222', $formatter->inputDigit('2'));
        self::assertSame('650 253 2222', $formatter->inputDigit('2'));

        $formatter->clear();
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('16', $formatter->inputDigit('6'));
        self::assertSame('1 65', $formatter->inputDigit('5'));
        self::assertSame('1 650', $formatter->inputDigit('0'));
        self::assertSame('1 650 2', $formatter->inputDigit('2'));
        self::assertSame('1 650 25', $formatter->inputDigit('5'));
        self::assertSame('1 650 253', $formatter->inputDigit('3'));
        self::assertSame('1 650 253 2', $formatter->inputDigit('2'));
        self::assertSame('1 650 253 22', $formatter->inputDigit('2'));
        self::assertSame('1 650 253 222', $formatter->inputDigit('2'));
        self::assertSame('1 650 253 2222', $formatter->inputDigit('2'));

        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('01', $formatter->inputDigit('1'));
        self::assertSame('011 ', $formatter->inputDigit('1'));
        self::assertSame('011 4', $formatter->inputDigit('4'));
        self::assertSame('011 44 ', $formatter->inputDigit('4'));
        self::assertSame('011 44 6', $formatter->inputDigit('6'));
        self::assertSame('011 44 61', $formatter->inputDigit('1'));
        self::assertSame('011 44 6 12', $formatter->inputDigit('2'));
        self::assertSame('011 44 6 123', $formatter->inputDigit('3'));
        self::assertSame('011 44 6 123 1', $formatter->inputDigit('1'));
        self::assertSame('011 44 6 123 12', $formatter->inputDigit('2'));
        self::assertSame('011 44 6 123 123', $formatter->inputDigit('3'));
        self::assertSame('011 44 6 123 123 1', $formatter->inputDigit('1'));
        self::assertSame('011 44 6 123 123 12', $formatter->inputDigit('2'));
        self::assertSame('011 44 6 123 123 123', $formatter->inputDigit('3'));

        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('01', $formatter->inputDigit('1'));
        self::assertSame('011 ', $formatter->inputDigit('1'));
        self::assertSame('011 5', $formatter->inputDigit('5'));
        self::assertSame('011 54 ', $formatter->inputDigit('4'));
        self::assertSame('011 54 9', $formatter->inputDigit('9'));
        self::assertSame('011 54 91', $formatter->inputDigit('1'));
        self::assertSame('011 54 9 11', $formatter->inputDigit('1'));
        self::assertSame('011 54 9 11 2', $formatter->inputDigit('2'));
        self::assertSame('011 54 9 11 23', $formatter->inputDigit('3'));
        self::assertSame('011 54 9 11 231', $formatter->inputDigit('1'));
        self::assertSame('011 54 9 11 2312', $formatter->inputDigit('2'));
        self::assertSame('011 54 9 11 2312 1', $formatter->inputDigit('1'));
        self::assertSame('011 54 9 11 2312 12', $formatter->inputDigit('2'));
        self::assertSame('011 54 9 11 2312 123', $formatter->inputDigit('3'));
        self::assertSame('011 54 9 11 2312 1234', $formatter->inputDigit('4'));

        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('01', $formatter->inputDigit('1'));
        self::assertSame('011 ', $formatter->inputDigit('1'));
        self::assertSame('011 2', $formatter->inputDigit('2'));
        self::assertSame('011 24', $formatter->inputDigit('4'));
        self::assertSame('011 244 ', $formatter->inputDigit('4'));
        self::assertSame('011 244 2', $formatter->inputDigit('2'));
        self::assertSame('011 244 28', $formatter->inputDigit('8'));
        self::assertSame('011 244 280', $formatter->inputDigit('0'));
        self::assertSame('011 244 280 0', $formatter->inputDigit('0'));
        self::assertSame('011 244 280 00', $formatter->inputDigit('0'));
        self::assertSame('011 244 280 000', $formatter->inputDigit('0'));
        self::assertSame('011 244 280 000 0', $formatter->inputDigit('0'));
        self::assertSame('011 244 280 000 00', $formatter->inputDigit('0'));
        self::assertSame('011 244 280 000 000', $formatter->inputDigit('0'));

        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+4', $formatter->inputDigit('4'));
        self::assertSame('+48 ', $formatter->inputDigit('8'));
        self::assertSame('+48 8', $formatter->inputDigit('8'));
        self::assertSame('+48 88', $formatter->inputDigit('8'));
        self::assertSame('+48 88 1', $formatter->inputDigit('1'));
        self::assertSame('+48 88 12', $formatter->inputDigit('2'));
        self::assertSame('+48 88 123', $formatter->inputDigit('3'));
        self::assertSame('+48 88 123 1', $formatter->inputDigit('1'));
        self::assertSame('+48 88 123 12', $formatter->inputDigit('2'));
        self::assertSame('+48 88 123 12 1', $formatter->inputDigit('1'));
        self::assertSame('+48 88 123 12 12', $formatter->inputDigit('2'));
    }

    public function testAYTFUSFullWidthCharacters(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::US);
        self::assertSame("\xEF\xBC\x96", $formatter->inputDigit("\xEF\xBC\x96"));
        self::assertSame("\xEF\xBC\x96\xEF\xBC\x95", $formatter->inputDigit("\xEF\xBC\x95"));
        self::assertSame('650', $formatter->inputDigit("\xEF\xBC\x90"));
        self::assertSame('650 2', $formatter->inputDigit("\xEF\xBC\x92"));
        self::assertSame('650 25', $formatter->inputDigit("\xEF\xBC\x95"));
        self::assertSame('650 253', $formatter->inputDigit("\xEF\xBC\x93"));
        self::assertSame('650 2532', $formatter->inputDigit("\xEF\xBC\x92"));
        self::assertSame('650 253 22', $formatter->inputDigit("\xEF\xBC\x92"));
        self::assertSame('650 253 222', $formatter->inputDigit("\xEF\xBC\x92"));
        self::assertSame('650 253 2222', $formatter->inputDigit("\xEF\xBC\x92"));
    }

    public function testAYTFUSMobileShortCode(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::US);
        self::assertSame('*', $formatter->inputDigit('*'));
        self::assertSame('*1', $formatter->inputDigit('1'));
        self::assertSame('*12', $formatter->inputDigit('2'));
        self::assertSame('*121', $formatter->inputDigit('1'));
        self::assertSame('*121#', $formatter->inputDigit('#'));
    }

    public function testAYTFUSVanityNumber(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::US);
        self::assertSame('8', $formatter->inputDigit('8'));
        self::assertSame('80', $formatter->inputDigit('0'));
        self::assertSame('800', $formatter->inputDigit('0'));
        self::assertSame('800 ', $formatter->inputDigit(' '));
        self::assertSame('800 M', $formatter->inputDigit('M'));
        self::assertSame('800 MY', $formatter->inputDigit('Y'));
        self::assertSame('800 MY ', $formatter->inputDigit(' '));
        self::assertSame('800 MY A', $formatter->inputDigit('A'));
        self::assertSame('800 MY AP', $formatter->inputDigit('P'));
        self::assertSame('800 MY APP', $formatter->inputDigit('P'));
        self::assertSame('800 MY APPL', $formatter->inputDigit('L'));
        self::assertSame('800 MY APPLE', $formatter->inputDigit('E'));
    }

    public function testAYTFAndRememberPositionUS(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::US);
        self::assertSame('1', $formatter->inputDigitAndRememberPosition('1'));
        self::assertSame(1, $formatter->getRememberedPosition());
        self::assertSame('16', $formatter->inputDigit('6'));
        self::assertSame('1 65', $formatter->inputDigit('5'));
        self::assertSame(1, $formatter->getRememberedPosition());
        self::assertSame('1 650', $formatter->inputDigitAndRememberPosition('0'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('1 650 2', $formatter->inputDigit('2'));
        self::assertSame('1 650 25', $formatter->inputDigit('5'));
        // Note the remembered position for digit "0" changes from 4 to 5, because a space is now
        // inserted in the front.
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('1 650 253', $formatter->inputDigit('3'));
        self::assertSame('1 650 253 2', $formatter->inputDigit('2'));
        self::assertSame('1 650 253 22', $formatter->inputDigit('2'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('1 650 253 222', $formatter->inputDigitAndRememberPosition('2'));
        self::assertSame(13, $formatter->getRememberedPosition());
        self::assertSame('1 650 253 2222', $formatter->inputDigit('2'));
        self::assertSame(13, $formatter->getRememberedPosition());
        self::assertSame('165025322222', $formatter->inputDigit('2'));
        self::assertSame(10, $formatter->getRememberedPosition());
        self::assertSame('1650253222222', $formatter->inputDigit('2'));
        self::assertSame(10, $formatter->getRememberedPosition());

        $formatter->clear();
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('16', $formatter->inputDigitAndRememberPosition('6'));
        self::assertSame(2, $formatter->getRememberedPosition());
        self::assertSame('1 65', $formatter->inputDigit('5'));
        self::assertSame('1 650', $formatter->inputDigit('0'));
        self::assertSame(3, $formatter->getRememberedPosition());
        self::assertSame('1 650 2', $formatter->inputDigit('2'));
        self::assertSame('1 650 25', $formatter->inputDigit('5'));
        self::assertSame(3, $formatter->getRememberedPosition());
        self::assertSame('1 650 253', $formatter->inputDigit('3'));
        self::assertSame('1 650 253 2', $formatter->inputDigit('2'));
        self::assertSame('1 650 253 22', $formatter->inputDigit('2'));
        self::assertSame(3, $formatter->getRememberedPosition());
        self::assertSame('1 650 253 222', $formatter->inputDigit('2'));
        self::assertSame('1 650 253 2222', $formatter->inputDigit('2'));
        self::assertSame('165025322222', $formatter->inputDigit('2'));
        self::assertSame(2, $formatter->getRememberedPosition());
        self::assertSame('1650253222222', $formatter->inputDigit('2'));
        self::assertSame(2, $formatter->getRememberedPosition());

        $formatter->clear();
        self::assertSame('6', $formatter->inputDigit('6'));
        self::assertSame('65', $formatter->inputDigit('5'));
        self::assertSame('650', $formatter->inputDigit('0'));
        self::assertSame('650 2', $formatter->inputDigit('2'));
        self::assertSame('650 25', $formatter->inputDigit('5'));
        self::assertSame('650 253', $formatter->inputDigit('3'));
        self::assertSame('650 2532', $formatter->inputDigitAndRememberPosition('2'));
        self::assertSame(8, $formatter->getRememberedPosition());
        self::assertSame('650 253 22', $formatter->inputDigit('2'));
        self::assertSame(9, $formatter->getRememberedPosition());
        self::assertSame('650 253 222', $formatter->inputDigit('2'));
        // No more formatting when semicolon is entered.
        self::assertSame('650253222;', $formatter->inputDigit(';'));
        self::assertSame(7, $formatter->getRememberedPosition());
        self::assertSame('650253222;2', $formatter->inputDigit('2'));

        $formatter->clear();
        self::assertSame('6', $formatter->inputDigit('6'));
        self::assertSame('65', $formatter->inputDigit('5'));
        self::assertSame('650', $formatter->inputDigit('0'));
        // No more formatting when users choose to do their own formatting.
        self::assertSame('650-', $formatter->inputDigit('-'));
        self::assertSame('650-2', $formatter->inputDigitAndRememberPosition('2'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('650-25', $formatter->inputDigit('5'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('650-253', $formatter->inputDigit('3'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('650-253-', $formatter->inputDigit('-'));
        self::assertSame('650-253-2', $formatter->inputDigit('2'));
        self::assertSame('650-253-22', $formatter->inputDigit('2'));
        self::assertSame('650-253-222', $formatter->inputDigit('2'));
        self::assertSame('650-253-2222', $formatter->inputDigit('2'));

        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('01', $formatter->inputDigit('1'));
        self::assertSame('011 ', $formatter->inputDigit('1'));
        self::assertSame('011 4', $formatter->inputDigitAndRememberPosition('4'));
        self::assertSame('011 48 ', $formatter->inputDigit('8'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('011 48 8', $formatter->inputDigit('8'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('011 48 88', $formatter->inputDigit('8'));
        self::assertSame('011 48 88 1', $formatter->inputDigit('1'));
        self::assertSame('011 48 88 12', $formatter->inputDigit('2'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('011 48 88 123', $formatter->inputDigit('3'));
        self::assertSame('011 48 88 123 1', $formatter->inputDigit('1'));
        self::assertSame('011 48 88 123 12', $formatter->inputDigit('2'));
        self::assertSame('011 48 88 123 12 1', $formatter->inputDigit('1'));
        self::assertSame('011 48 88 123 12 12', $formatter->inputDigit('2'));

        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+1', $formatter->inputDigit('1'));
        self::assertSame('+1 6', $formatter->inputDigitAndRememberPosition('6'));
        self::assertSame('+1 65', $formatter->inputDigit('5'));
        self::assertSame('+1 650', $formatter->inputDigit('0'));
        self::assertSame(4, $formatter->getRememberedPosition());
        self::assertSame('+1 650 2', $formatter->inputDigit('2'));
        self::assertSame(4, $formatter->getRememberedPosition());
        self::assertSame('+1 650 25', $formatter->inputDigit('5'));
        self::assertSame('+1 650 253', $formatter->inputDigitAndRememberPosition('3'));
        self::assertSame('+1 650 253 2', $formatter->inputDigit('2'));
        self::assertSame('+1 650 253 22', $formatter->inputDigit('2'));
        self::assertSame('+1 650 253 222', $formatter->inputDigit('2'));
        self::assertSame(10, $formatter->getRememberedPosition());

        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+1', $formatter->inputDigit('1'));
        self::assertSame('+1 6', $formatter->inputDigitAndRememberPosition('6'));
        self::assertSame('+1 65', $formatter->inputDigit('5'));
        self::assertSame('+1 650', $formatter->inputDigit('0'));
        self::assertSame(4, $formatter->getRememberedPosition());
        self::assertSame('+1 650 2', $formatter->inputDigit('2'));
        self::assertSame(4, $formatter->getRememberedPosition());
        self::assertSame('+1 650 25', $formatter->inputDigit('5'));
        self::assertSame('+1 650 253', $formatter->inputDigit('3'));
        self::assertSame('+1 650 253 2', $formatter->inputDigit('2'));
        self::assertSame('+1 650 253 22', $formatter->inputDigit('2'));
        self::assertSame('+1 650 253 222', $formatter->inputDigit('2'));
        self::assertSame('+1650253222;', $formatter->inputDigit(';'));
        self::assertSame(3, $formatter->getRememberedPosition());
    }

    public function testAYTFGBFixedLine(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::GB);
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('02', $formatter->inputDigit('2'));
        self::assertSame('020', $formatter->inputDigit('0'));
        self::assertSame('020 7', $formatter->inputDigitAndRememberPosition('7'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('020 70', $formatter->inputDigit('0'));
        self::assertSame('020 703', $formatter->inputDigit('3'));
        self::assertSame(5, $formatter->getRememberedPosition());
        self::assertSame('020 7031', $formatter->inputDigit('1'));
        self::assertSame('020 7031 3', $formatter->inputDigit('3'));
        self::assertSame('020 7031 30', $formatter->inputDigit('0'));
        self::assertSame('020 7031 300', $formatter->inputDigit('0'));
        self::assertSame('020 7031 3000', $formatter->inputDigit('0'));
    }

    public function testAYTFGBTollFree(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::GB);
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('08', $formatter->inputDigit('8'));
        self::assertSame('080', $formatter->inputDigit('0'));
        self::assertSame('080 7', $formatter->inputDigit('7'));
        self::assertSame('080 70', $formatter->inputDigit('0'));
        self::assertSame('080 703', $formatter->inputDigit('3'));
        self::assertSame('080 7031', $formatter->inputDigit('1'));
        self::assertSame('080 7031 3', $formatter->inputDigit('3'));
        self::assertSame('080 7031 30', $formatter->inputDigit('0'));
        self::assertSame('080 7031 300', $formatter->inputDigit('0'));
        self::assertSame('080 7031 3000', $formatter->inputDigit('0'));
    }

    public function testAYTFGBPremiumRate(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::GB);
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('09', $formatter->inputDigit('9'));
        self::assertSame('090', $formatter->inputDigit('0'));
        self::assertSame('090 7', $formatter->inputDigit('7'));
        self::assertSame('090 70', $formatter->inputDigit('0'));
        self::assertSame('090 703', $formatter->inputDigit('3'));
        self::assertSame('090 7031', $formatter->inputDigit('1'));
        self::assertSame('090 7031 3', $formatter->inputDigit('3'));
        self::assertSame('090 7031 30', $formatter->inputDigit('0'));
        self::assertSame('090 7031 300', $formatter->inputDigit('0'));
        self::assertSame('090 7031 3000', $formatter->inputDigit('0'));
    }

    public function testAYTFNZMobile(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::NZ);
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('02', $formatter->inputDigit('2'));
        self::assertSame('021', $formatter->inputDigit('1'));
        self::assertSame('02-11', $formatter->inputDigit('1'));
        self::assertSame('02-112', $formatter->inputDigit('2'));
        // Note the unittest is using fake metadata which might produce non-ideal results.
        self::assertSame('02-112 3', $formatter->inputDigit('3'));
        self::assertSame('02-112 34', $formatter->inputDigit('4'));
        self::assertSame('02-112 345', $formatter->inputDigit('5'));
        self::assertSame('02-112 3456', $formatter->inputDigit('6'));
    }

    public function testAYTFDE(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::DE);
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('03', $formatter->inputDigit('3'));
        self::assertSame('030', $formatter->inputDigit('0'));
        self::assertSame('030/1', $formatter->inputDigit('1'));
        self::assertSame('030/12', $formatter->inputDigit('2'));
        self::assertSame('030/123', $formatter->inputDigit('3'));
        self::assertSame('030/1234', $formatter->inputDigit('4'));

        // 04134 1234
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('04', $formatter->inputDigit('4'));
        self::assertSame('041', $formatter->inputDigit('1'));
        self::assertSame('041 3', $formatter->inputDigit('3'));
        self::assertSame('041 34', $formatter->inputDigit('4'));
        self::assertSame('04134 1', $formatter->inputDigit('1'));
        self::assertSame('04134 12', $formatter->inputDigit('2'));
        self::assertSame('04134 123', $formatter->inputDigit('3'));
        self::assertSame('04134 1234', $formatter->inputDigit('4'));

        // 08021 2345
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('08', $formatter->inputDigit('8'));
        self::assertSame('080', $formatter->inputDigit('0'));
        self::assertSame('080 2', $formatter->inputDigit('2'));
        self::assertSame('080 21', $formatter->inputDigit('1'));
        self::assertSame('08021 2', $formatter->inputDigit('2'));
        self::assertSame('08021 23', $formatter->inputDigit('3'));
        self::assertSame('08021 234', $formatter->inputDigit('4'));
        self::assertSame('08021 2345', $formatter->inputDigit('5'));

        // 00 1 650 253 2250
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('00', $formatter->inputDigit('0'));
        self::assertSame('00 1 ', $formatter->inputDigit('1'));
        self::assertSame('00 1 6', $formatter->inputDigit('6'));
        self::assertSame('00 1 65', $formatter->inputDigit('5'));
        self::assertSame('00 1 650', $formatter->inputDigit('0'));
        self::assertSame('00 1 650 2', $formatter->inputDigit('2'));
        self::assertSame('00 1 650 25', $formatter->inputDigit('5'));
        self::assertSame('00 1 650 253', $formatter->inputDigit('3'));
        self::assertSame('00 1 650 253 2', $formatter->inputDigit('2'));
        self::assertSame('00 1 650 253 22', $formatter->inputDigit('2'));
        self::assertSame('00 1 650 253 222', $formatter->inputDigit('2'));
        self::assertSame('00 1 650 253 2222', $formatter->inputDigit('2'));
    }

    public function testAYTFAR(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::AR);
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('01', $formatter->inputDigit('1'));
        self::assertSame('011', $formatter->inputDigit('1'));
        self::assertSame('011 7', $formatter->inputDigit('7'));
        self::assertSame('011 70', $formatter->inputDigit('0'));
        self::assertSame('011 703', $formatter->inputDigit('3'));
        self::assertSame('011 7031', $formatter->inputDigit('1'));
        self::assertSame('011 7031-3', $formatter->inputDigit('3'));
        self::assertSame('011 7031-30', $formatter->inputDigit('0'));
        self::assertSame('011 7031-300', $formatter->inputDigit('0'));
        self::assertSame('011 7031-3000', $formatter->inputDigit('0'));
    }

    public function testAYTFARMobile(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::AR);
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+5', $formatter->inputDigit('5'));
        self::assertSame('+54 ', $formatter->inputDigit('4'));
        self::assertSame('+54 9', $formatter->inputDigit('9'));
        self::assertSame('+54 91', $formatter->inputDigit('1'));
        self::assertSame('+54 9 11', $formatter->inputDigit('1'));
        self::assertSame('+54 9 11 2', $formatter->inputDigit('2'));
        self::assertSame('+54 9 11 23', $formatter->inputDigit('3'));
        self::assertSame('+54 9 11 231', $formatter->inputDigit('1'));
        self::assertSame('+54 9 11 2312', $formatter->inputDigit('2'));
        self::assertSame('+54 9 11 2312 1', $formatter->inputDigit('1'));
        self::assertSame('+54 9 11 2312 12', $formatter->inputDigit('2'));
        self::assertSame('+54 9 11 2312 123', $formatter->inputDigit('3'));
        self::assertSame('+54 9 11 2312 1234', $formatter->inputDigit('4'));
    }

    public function testAYTFKR(): void
    {
        // +82 51 234 5678
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::KR);
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+82 ', $formatter->inputDigit('2'));
        self::assertSame('+82 5', $formatter->inputDigit('5'));
        self::assertSame('+82 51', $formatter->inputDigit('1'));
        self::assertSame('+82 51-2', $formatter->inputDigit('2'));
        self::assertSame('+82 51-23', $formatter->inputDigit('3'));
        self::assertSame('+82 51-234', $formatter->inputDigit('4'));
        self::assertSame('+82 51-234-5', $formatter->inputDigit('5'));
        self::assertSame('+82 51-234-56', $formatter->inputDigit('6'));
        self::assertSame('+82 51-234-567', $formatter->inputDigit('7'));
        self::assertSame('+82 51-234-5678', $formatter->inputDigit('8'));

        // +82 2 531 5678
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+82 ', $formatter->inputDigit('2'));
        self::assertSame('+82 2', $formatter->inputDigit('2'));
        self::assertSame('+82 25', $formatter->inputDigit('5'));
        self::assertSame('+82 2-53', $formatter->inputDigit('3'));
        self::assertSame('+82 2-531', $formatter->inputDigit('1'));
        self::assertSame('+82 2-531-5', $formatter->inputDigit('5'));
        self::assertSame('+82 2-531-56', $formatter->inputDigit('6'));
        self::assertSame('+82 2-531-567', $formatter->inputDigit('7'));
        self::assertSame('+82 2-531-5678', $formatter->inputDigit('8'));

        // +82 2 3665 5678
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+82 ', $formatter->inputDigit('2'));
        self::assertSame('+82 2', $formatter->inputDigit('2'));
        self::assertSame('+82 23', $formatter->inputDigit('3'));
        self::assertSame('+82 2-36', $formatter->inputDigit('6'));
        self::assertSame('+82 2-366', $formatter->inputDigit('6'));
        self::assertSame('+82 2-3665', $formatter->inputDigit('5'));
        self::assertSame('+82 2-3665-5', $formatter->inputDigit('5'));
        self::assertSame('+82 2-3665-56', $formatter->inputDigit('6'));
        self::assertSame('+82 2-3665-567', $formatter->inputDigit('7'));
        self::assertSame('+82 2-3665-5678', $formatter->inputDigit('8'));

        // 02-114
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('02', $formatter->inputDigit('2'));
        self::assertSame('021', $formatter->inputDigit('1'));
        self::assertSame('02-11', $formatter->inputDigit('1'));
        self::assertSame('02-114', $formatter->inputDigit('4'));

        // 02-1300
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('02', $formatter->inputDigit('2'));
        self::assertSame('021', $formatter->inputDigit('1'));
        self::assertSame('02-13', $formatter->inputDigit('3'));
        self::assertSame('02-130', $formatter->inputDigit('0'));
        self::assertSame('02-1300', $formatter->inputDigit('0'));

        // 011-456-7890
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('01', $formatter->inputDigit('1'));
        self::assertSame('011', $formatter->inputDigit('1'));
        self::assertSame('011-4', $formatter->inputDigit('4'));
        self::assertSame('011-45', $formatter->inputDigit('5'));
        self::assertSame('011-456', $formatter->inputDigit('6'));
        self::assertSame('011-456-7', $formatter->inputDigit('7'));
        self::assertSame('011-456-78', $formatter->inputDigit('8'));
        self::assertSame('011-456-789', $formatter->inputDigit('9'));
        self::assertSame('011-456-7890', $formatter->inputDigit('0'));

        // 011-9876-7890
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('01', $formatter->inputDigit('1'));
        self::assertSame('011', $formatter->inputDigit('1'));
        self::assertSame('011-9', $formatter->inputDigit('9'));
        self::assertSame('011-98', $formatter->inputDigit('8'));
        self::assertSame('011-987', $formatter->inputDigit('7'));
        self::assertSame('011-9876', $formatter->inputDigit('6'));
        self::assertSame('011-9876-7', $formatter->inputDigit('7'));
        self::assertSame('011-9876-78', $formatter->inputDigit('8'));
        self::assertSame('011-9876-789', $formatter->inputDigit('9'));
        self::assertSame('011-9876-7890', $formatter->inputDigit('0'));
    }

    public function testAYTF_MX(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::MX);

        // +52 800 123 4567
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+5', $formatter->inputDigit('5'));
        self::assertSame('+52 ', $formatter->inputDigit('2'));
        self::assertSame('+52 8', $formatter->inputDigit('8'));
        self::assertSame('+52 80', $formatter->inputDigit('0'));
        self::assertSame('+52 800', $formatter->inputDigit('0'));
        self::assertSame('+52 800 1', $formatter->inputDigit('1'));
        self::assertSame('+52 800 12', $formatter->inputDigit('2'));
        self::assertSame('+52 800 123', $formatter->inputDigit('3'));
        self::assertSame('+52 800 123 4', $formatter->inputDigit('4'));
        self::assertSame('+52 800 123 45', $formatter->inputDigit('5'));
        self::assertSame('+52 800 123 456', $formatter->inputDigit('6'));
        self::assertSame('+52 800 123 4567', $formatter->inputDigit('7'));

        // +529011234567, proactively ensuring that no formatting is applied, where a format is chosen
        // that would otherwise have led to some digits being dropped.
        $formatter->clear();
        self::assertSame('9', $formatter->inputDigit('9'));
        self::assertSame('90', $formatter->inputDigit('0'));
        self::assertSame('901', $formatter->inputDigit('1'));
        self::assertSame('9011', $formatter->inputDigit('1'));
        self::assertSame('90112', $formatter->inputDigit('2'));
        self::assertSame('901123', $formatter->inputDigit('3'));
        self::assertSame('9011234', $formatter->inputDigit('4'));
        self::assertSame('90112345', $formatter->inputDigit('5'));
        self::assertSame('901123456', $formatter->inputDigit('6'));
        self::assertSame('9011234567', $formatter->inputDigit('7'));

        // +52 55 1234 5678
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+5', $formatter->inputDigit('5'));
        self::assertSame('+52 ', $formatter->inputDigit('2'));
        self::assertSame('+52 5', $formatter->inputDigit('5'));
        self::assertSame('+52 55', $formatter->inputDigit('5'));
        self::assertSame('+52 55 1', $formatter->inputDigit('1'));
        self::assertSame('+52 55 12', $formatter->inputDigit('2'));
        self::assertSame('+52 55 123', $formatter->inputDigit('3'));
        self::assertSame('+52 55 1234', $formatter->inputDigit('4'));
        self::assertSame('+52 55 1234 5', $formatter->inputDigit('5'));
        self::assertSame('+52 55 1234 56', $formatter->inputDigit('6'));
        self::assertSame('+52 55 1234 567', $formatter->inputDigit('7'));
        self::assertSame('+52 55 1234 5678', $formatter->inputDigit('8'));

        // +52 212 345 6789
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+5', $formatter->inputDigit('5'));
        self::assertSame('+52 ', $formatter->inputDigit('2'));
        self::assertSame('+52 2', $formatter->inputDigit('2'));
        self::assertSame('+52 21', $formatter->inputDigit('1'));
        self::assertSame('+52 212', $formatter->inputDigit('2'));
        self::assertSame('+52 212 3', $formatter->inputDigit('3'));
        self::assertSame('+52 212 34', $formatter->inputDigit('4'));
        self::assertSame('+52 212 345', $formatter->inputDigit('5'));
        self::assertSame('+52 212 345 6', $formatter->inputDigit('6'));
        self::assertSame('+52 212 345 67', $formatter->inputDigit('7'));
        self::assertSame('+52 212 345 678', $formatter->inputDigit('8'));
        self::assertSame('+52 212 345 6789', $formatter->inputDigit('9'));

        // +52 1 55 1234 5678
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+5', $formatter->inputDigit('5'));
        self::assertSame('+52 ', $formatter->inputDigit('2'));
        self::assertSame('+52 1', $formatter->inputDigit('1'));
        self::assertSame('+52 15', $formatter->inputDigit('5'));
        self::assertSame('+52 1 55', $formatter->inputDigit('5'));
        self::assertSame('+52 1 55 1', $formatter->inputDigit('1'));
        self::assertSame('+52 1 55 12', $formatter->inputDigit('2'));
        self::assertSame('+52 1 55 123', $formatter->inputDigit('3'));
        self::assertSame('+52 1 55 1234', $formatter->inputDigit('4'));
        self::assertSame('+52 1 55 1234 5', $formatter->inputDigit('5'));
        self::assertSame('+52 1 55 1234 56', $formatter->inputDigit('6'));
        self::assertSame('+52 1 55 1234 567', $formatter->inputDigit('7'));
        self::assertSame('+52 1 55 1234 5678', $formatter->inputDigit('8'));

        // +52 1 541 234 5678
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+5', $formatter->inputDigit('5'));
        self::assertSame('+52 ', $formatter->inputDigit('2'));
        self::assertSame('+52 1', $formatter->inputDigit('1'));
        self::assertSame('+52 15', $formatter->inputDigit('5'));
        self::assertSame('+52 1 54', $formatter->inputDigit('4'));
        self::assertSame('+52 1 541', $formatter->inputDigit('1'));
        self::assertSame('+52 1 541 2', $formatter->inputDigit('2'));
        self::assertSame('+52 1 541 23', $formatter->inputDigit('3'));
        self::assertSame('+52 1 541 234', $formatter->inputDigit('4'));
        self::assertSame('+52 1 541 234 5', $formatter->inputDigit('5'));
        self::assertSame('+52 1 541 234 56', $formatter->inputDigit('6'));
        self::assertSame('+52 1 541 234 567', $formatter->inputDigit('7'));
        self::assertSame('+52 1 541 234 5678', $formatter->inputDigit('8'));
    }

    public function testAYTF_International_Toll_Free(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::US);
        // +800 1234 5678
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+80', $formatter->inputDigit('0'));
        self::assertSame('+800 ', $formatter->inputDigit('0'));
        self::assertSame('+800 1', $formatter->inputDigit('1'));
        self::assertSame('+800 12', $formatter->inputDigit('2'));
        self::assertSame('+800 123', $formatter->inputDigit('3'));
        self::assertSame('+800 1234', $formatter->inputDigit('4'));
        self::assertSame('+800 1234 5', $formatter->inputDigit('5'));
        self::assertSame('+800 1234 56', $formatter->inputDigit('6'));
        self::assertSame('+800 1234 567', $formatter->inputDigit('7'));
        self::assertSame('+800 1234 5678', $formatter->inputDigit('8'));
        self::assertSame('+800123456789', $formatter->inputDigit('9'));
    }

    public function testAYTFMultipleLeadingDigitPatterns(): void
    {
        // +81 50 2345 6789
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::JP);
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+81 ', $formatter->inputDigit('1'));
        self::assertSame('+81 5', $formatter->inputDigit('5'));
        self::assertSame('+81 50', $formatter->inputDigit('0'));
        self::assertSame('+81 50 2', $formatter->inputDigit('2'));
        self::assertSame('+81 50 23', $formatter->inputDigit('3'));
        self::assertSame('+81 50 234', $formatter->inputDigit('4'));
        self::assertSame('+81 50 2345', $formatter->inputDigit('5'));
        self::assertSame('+81 50 2345 6', $formatter->inputDigit('6'));
        self::assertSame('+81 50 2345 67', $formatter->inputDigit('7'));
        self::assertSame('+81 50 2345 678', $formatter->inputDigit('8'));
        self::assertSame('+81 50 2345 6789', $formatter->inputDigit('9'));

        // +81 222 12 5678
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+81 ', $formatter->inputDigit('1'));
        self::assertSame('+81 2', $formatter->inputDigit('2'));
        self::assertSame('+81 22', $formatter->inputDigit('2'));
        self::assertSame('+81 22 2', $formatter->inputDigit('2'));
        self::assertSame('+81 22 21', $formatter->inputDigit('1'));
        self::assertSame('+81 2221 2', $formatter->inputDigit('2'));
        self::assertSame('+81 222 12 5', $formatter->inputDigit('5'));
        self::assertSame('+81 222 12 56', $formatter->inputDigit('6'));
        self::assertSame('+81 222 12 567', $formatter->inputDigit('7'));
        self::assertSame('+81 222 12 5678', $formatter->inputDigit('8'));

        // 011113
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('01', $formatter->inputDigit('1'));
        self::assertSame('011', $formatter->inputDigit('1'));
        self::assertSame('011 1', $formatter->inputDigit('1'));
        self::assertSame('011 11', $formatter->inputDigit('1'));
        self::assertSame('011113', $formatter->inputDigit('3'));

        // +81 3332 2 5678
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+81 ', $formatter->inputDigit('1'));
        self::assertSame('+81 3', $formatter->inputDigit('3'));
        self::assertSame('+81 33', $formatter->inputDigit('3'));
        self::assertSame('+81 33 3', $formatter->inputDigit('3'));
        self::assertSame('+81 3332', $formatter->inputDigit('2'));
        self::assertSame('+81 3332 2', $formatter->inputDigit('2'));
        self::assertSame('+81 3332 2 5', $formatter->inputDigit('5'));
        self::assertSame('+81 3332 2 56', $formatter->inputDigit('6'));
        self::assertSame('+81 3332 2 567', $formatter->inputDigit('7'));
        self::assertSame('+81 3332 2 5678', $formatter->inputDigit('8'));
    }

    public function testAYTFLongIDD_AU(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::AU);
        // 0011 1 650 253 2250
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('00', $formatter->inputDigit('0'));
        self::assertSame('001', $formatter->inputDigit('1'));
        self::assertSame('0011', $formatter->inputDigit('1'));
        self::assertSame('0011 1 ', $formatter->inputDigit('1'));
        self::assertSame('0011 1 6', $formatter->inputDigit('6'));
        self::assertSame('0011 1 65', $formatter->inputDigit('5'));
        self::assertSame('0011 1 650', $formatter->inputDigit('0'));
        self::assertSame('0011 1 650 2', $formatter->inputDigit('2'));
        self::assertSame('0011 1 650 25', $formatter->inputDigit('5'));
        self::assertSame('0011 1 650 253', $formatter->inputDigit('3'));
        self::assertSame('0011 1 650 253 2', $formatter->inputDigit('2'));
        self::assertSame('0011 1 650 253 22', $formatter->inputDigit('2'));
        self::assertSame('0011 1 650 253 222', $formatter->inputDigit('2'));
        self::assertSame('0011 1 650 253 2222', $formatter->inputDigit('2'));

        // 0011 81 3332 2 5678
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('00', $formatter->inputDigit('0'));
        self::assertSame('001', $formatter->inputDigit('1'));
        self::assertSame('0011', $formatter->inputDigit('1'));
        self::assertSame('00118', $formatter->inputDigit('8'));
        self::assertSame('0011 81 ', $formatter->inputDigit('1'));
        self::assertSame('0011 81 3', $formatter->inputDigit('3'));
        self::assertSame('0011 81 33', $formatter->inputDigit('3'));
        self::assertSame('0011 81 33 3', $formatter->inputDigit('3'));
        self::assertSame('0011 81 3332', $formatter->inputDigit('2'));
        self::assertSame('0011 81 3332 2', $formatter->inputDigit('2'));
        self::assertSame('0011 81 3332 2 5', $formatter->inputDigit('5'));
        self::assertSame('0011 81 3332 2 56', $formatter->inputDigit('6'));
        self::assertSame('0011 81 3332 2 567', $formatter->inputDigit('7'));
        self::assertSame('0011 81 3332 2 5678', $formatter->inputDigit('8'));

        // 0011 244 250 253 222
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('00', $formatter->inputDigit('0'));
        self::assertSame('001', $formatter->inputDigit('1'));
        self::assertSame('0011', $formatter->inputDigit('1'));
        self::assertSame('00112', $formatter->inputDigit('2'));
        self::assertSame('001124', $formatter->inputDigit('4'));
        self::assertSame('0011 244 ', $formatter->inputDigit('4'));
        self::assertSame('0011 244 2', $formatter->inputDigit('2'));
        self::assertSame('0011 244 25', $formatter->inputDigit('5'));
        self::assertSame('0011 244 250', $formatter->inputDigit('0'));
        self::assertSame('0011 244 250 2', $formatter->inputDigit('2'));
        self::assertSame('0011 244 250 25', $formatter->inputDigit('5'));
        self::assertSame('0011 244 250 253', $formatter->inputDigit('3'));
        self::assertSame('0011 244 250 253 2', $formatter->inputDigit('2'));
        self::assertSame('0011 244 250 253 22', $formatter->inputDigit('2'));
        self::assertSame('0011 244 250 253 222', $formatter->inputDigit('2'));
    }

    public function testAYTFLongIDD_KR(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::KR);
        // 00300 1 650 253 2222
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('00', $formatter->inputDigit('0'));
        self::assertSame('003', $formatter->inputDigit('3'));
        self::assertSame('0030', $formatter->inputDigit('0'));
        self::assertSame('00300', $formatter->inputDigit('0'));
        self::assertSame('00300 1 ', $formatter->inputDigit('1'));
        self::assertSame('00300 1 6', $formatter->inputDigit('6'));
        self::assertSame('00300 1 65', $formatter->inputDigit('5'));
        self::assertSame('00300 1 650', $formatter->inputDigit('0'));
        self::assertSame('00300 1 650 2', $formatter->inputDigit('2'));
        self::assertSame('00300 1 650 25', $formatter->inputDigit('5'));
        self::assertSame('00300 1 650 253', $formatter->inputDigit('3'));
        self::assertSame('00300 1 650 253 2', $formatter->inputDigit('2'));
        self::assertSame('00300 1 650 253 22', $formatter->inputDigit('2'));
        self::assertSame('00300 1 650 253 222', $formatter->inputDigit('2'));
        self::assertSame('00300 1 650 253 2222', $formatter->inputDigit('2'));
    }

    public function testAYTFLongNDD_KR(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::KR);
        // 08811-9876-7890
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('08', $formatter->inputDigit('8'));
        self::assertSame('088', $formatter->inputDigit('8'));
        self::assertSame('0881', $formatter->inputDigit('1'));
        self::assertSame('08811', $formatter->inputDigit('1'));
        self::assertSame('08811-9', $formatter->inputDigit('9'));
        self::assertSame('08811-98', $formatter->inputDigit('8'));
        self::assertSame('08811-987', $formatter->inputDigit('7'));
        self::assertSame('08811-9876', $formatter->inputDigit('6'));
        self::assertSame('08811-9876-7', $formatter->inputDigit('7'));
        self::assertSame('08811-9876-78', $formatter->inputDigit('8'));
        self::assertSame('08811-9876-789', $formatter->inputDigit('9'));
        self::assertSame('08811-9876-7890', $formatter->inputDigit('0'));

        // 08500 11-9876-7890
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('08', $formatter->inputDigit('8'));
        self::assertSame('085', $formatter->inputDigit('5'));
        self::assertSame('0850', $formatter->inputDigit('0'));
        self::assertSame('08500 ', $formatter->inputDigit('0'));
        self::assertSame('08500 1', $formatter->inputDigit('1'));
        self::assertSame('08500 11', $formatter->inputDigit('1'));
        self::assertSame('08500 11-9', $formatter->inputDigit('9'));
        self::assertSame('08500 11-98', $formatter->inputDigit('8'));
        self::assertSame('08500 11-987', $formatter->inputDigit('7'));
        self::assertSame('08500 11-9876', $formatter->inputDigit('6'));
        self::assertSame('08500 11-9876-7', $formatter->inputDigit('7'));
        self::assertSame('08500 11-9876-78', $formatter->inputDigit('8'));
        self::assertSame('08500 11-9876-789', $formatter->inputDigit('9'));
        self::assertSame('08500 11-9876-7890', $formatter->inputDigit('0'));
    }

    public function testAYTFLongNDD_SG(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::SG);
        // 777777 9876 7890
        self::assertSame('7', $formatter->inputDigit('7'));
        self::assertSame('77', $formatter->inputDigit('7'));
        self::assertSame('777', $formatter->inputDigit('7'));
        self::assertSame('7777', $formatter->inputDigit('7'));
        self::assertSame('77777', $formatter->inputDigit('7'));
        self::assertSame('777777 ', $formatter->inputDigit('7'));
        self::assertSame('777777 9', $formatter->inputDigit('9'));
        self::assertSame('777777 98', $formatter->inputDigit('8'));
        self::assertSame('777777 987', $formatter->inputDigit('7'));
        self::assertSame('777777 9876', $formatter->inputDigit('6'));
        self::assertSame('777777 9876 7', $formatter->inputDigit('7'));
        self::assertSame('777777 9876 78', $formatter->inputDigit('8'));
        self::assertSame('777777 9876 789', $formatter->inputDigit('9'));
        self::assertSame('777777 9876 7890', $formatter->inputDigit('0'));
    }

    public function testAYTFShortNumberFormattingFix_AU(): void
    {
        // For Australia, the national prefix is not optional when formatting.
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::AU);

        // 1234567890 - For leading digit 1, the national prefix formatting rule has first group only.
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('12', $formatter->inputDigit('2'));
        self::assertSame('123', $formatter->inputDigit('3'));
        self::assertSame('1234', $formatter->inputDigit('4'));
        self::assertSame('1234 5', $formatter->inputDigit('5'));
        self::assertSame('1234 56', $formatter->inputDigit('6'));
        self::assertSame('1234 567', $formatter->inputDigit('7'));
        self::assertSame('1234 567 8', $formatter->inputDigit('8'));
        self::assertSame('1234 567 89', $formatter->inputDigit('9'));
        self::assertSame('1234 567 890', $formatter->inputDigit('0'));

        // +61 1234 567 890 - Test the same number, but with the country code.
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+6', $formatter->inputDigit('6'));
        self::assertSame('+61 ', $formatter->inputDigit('1'));
        self::assertSame('+61 1', $formatter->inputDigit('1'));
        self::assertSame('+61 12', $formatter->inputDigit('2'));
        self::assertSame('+61 123', $formatter->inputDigit('3'));
        self::assertSame('+61 1234', $formatter->inputDigit('4'));
        self::assertSame('+61 1234 5', $formatter->inputDigit('5'));
        self::assertSame('+61 1234 56', $formatter->inputDigit('6'));
        self::assertSame('+61 1234 567', $formatter->inputDigit('7'));
        self::assertSame('+61 1234 567 8', $formatter->inputDigit('8'));
        self::assertSame('+61 1234 567 89', $formatter->inputDigit('9'));
        self::assertSame('+61 1234 567 890', $formatter->inputDigit('0'));

        // 212345678 - For leading digit 2, the national prefix formatting rule puts the national prefix
        // before the first group.
        $formatter->clear();
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('02', $formatter->inputDigit('2'));
        self::assertSame('021', $formatter->inputDigit('1'));
        self::assertSame('02 12', $formatter->inputDigit('2'));
        self::assertSame('02 123', $formatter->inputDigit('3'));
        self::assertSame('02 1234', $formatter->inputDigit('4'));
        self::assertSame('02 1234 5', $formatter->inputDigit('5'));
        self::assertSame('02 1234 56', $formatter->inputDigit('6'));
        self::assertSame('02 1234 567', $formatter->inputDigit('7'));
        self::assertSame('02 1234 5678', $formatter->inputDigit('8'));

        // 212345678 - Test the same number, but without the leading 0.
        $formatter->clear();
        self::assertSame('2', $formatter->inputDigit('2'));
        self::assertSame('21', $formatter->inputDigit('1'));
        self::assertSame('212', $formatter->inputDigit('2'));
        self::assertSame('2123', $formatter->inputDigit('3'));
        self::assertSame('21234', $formatter->inputDigit('4'));
        self::assertSame('212345', $formatter->inputDigit('5'));
        self::assertSame('2123456', $formatter->inputDigit('6'));
        self::assertSame('21234567', $formatter->inputDigit('7'));
        self::assertSame('212345678', $formatter->inputDigit('8'));

        // +61 2 1234 5678 - Test the same number, but with the country code.
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+6', $formatter->inputDigit('6'));
        self::assertSame('+61 ', $formatter->inputDigit('1'));
        self::assertSame('+61 2', $formatter->inputDigit('2'));
        self::assertSame('+61 21', $formatter->inputDigit('1'));
        self::assertSame('+61 2 12', $formatter->inputDigit('2'));
        self::assertSame('+61 2 123', $formatter->inputDigit('3'));
        self::assertSame('+61 2 1234', $formatter->inputDigit('4'));
        self::assertSame('+61 2 1234 5', $formatter->inputDigit('5'));
        self::assertSame('+61 2 1234 56', $formatter->inputDigit('6'));
        self::assertSame('+61 2 1234 567', $formatter->inputDigit('7'));
        self::assertSame('+61 2 1234 5678', $formatter->inputDigit('8'));
    }

    public function testAYTFShortNumberFormattingFix_KR(): void
    {
        // For Korea, the national prefix is not optional when formatting, and the national prefix
        // formatting rule doesn't consist of only the first group.
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::KR);

        // 111
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('11', $formatter->inputDigit('1'));
        self::assertSame('111', $formatter->inputDigit('1'));

        // 114
        $formatter->clear();
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('11', $formatter->inputDigit('1'));
        self::assertSame('114', $formatter->inputDigit('4'));

        // 13121234 - Test a mobile number without the national prefix. Even though it is not an
        // emergency number, it should be formatted as a block.
        $formatter->clear();
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('13', $formatter->inputDigit('3'));
        self::assertSame('131', $formatter->inputDigit('1'));
        self::assertSame('1312', $formatter->inputDigit('2'));
        self::assertSame('13121', $formatter->inputDigit('1'));
        self::assertSame('131212', $formatter->inputDigit('2'));
        self::assertSame('1312123', $formatter->inputDigit('3'));
        self::assertSame('13121234', $formatter->inputDigit('4'));

        // +82 131-2-1234 - Test the same number, but with the country code.
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+82 ', $formatter->inputDigit('2'));
        self::assertSame('+82 1', $formatter->inputDigit('1'));
        self::assertSame('+82 13', $formatter->inputDigit('3'));
        self::assertSame('+82 131', $formatter->inputDigit('1'));
        self::assertSame('+82 131-2', $formatter->inputDigit('2'));
        self::assertSame('+82 131-2-1', $formatter->inputDigit('1'));
        self::assertSame('+82 131-2-12', $formatter->inputDigit('2'));
        self::assertSame('+82 131-2-123', $formatter->inputDigit('3'));
        self::assertSame('+82 131-2-1234', $formatter->inputDigit('4'));
    }

    public function testAYTFShortNumberFormattingFix_MX(): void
    {
        // For Mexico, the national prefix is optional when formatting.
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::MX);

        // 911
        self::assertSame('9', $formatter->inputDigit('9'));
        self::assertSame('91', $formatter->inputDigit('1'));
        self::assertSame('911', $formatter->inputDigit('1'));

        // 800 123 4567 - Test a toll-free number, which should have a formatting rule applied to it
        // even though it doesn't begin with the national prefix.
        $formatter->clear();
        self::assertSame('8', $formatter->inputDigit('8'));
        self::assertSame('80', $formatter->inputDigit('0'));
        self::assertSame('800', $formatter->inputDigit('0'));
        self::assertSame('800 1', $formatter->inputDigit('1'));
        self::assertSame('800 12', $formatter->inputDigit('2'));
        self::assertSame('800 123', $formatter->inputDigit('3'));
        self::assertSame('800 123 4', $formatter->inputDigit('4'));
        self::assertSame('800 123 45', $formatter->inputDigit('5'));
        self::assertSame('800 123 456', $formatter->inputDigit('6'));
        self::assertSame('800 123 4567', $formatter->inputDigit('7'));

        // +52 800 123 4567 - Test the same number, but with the country code.
        $formatter->clear();
        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+5', $formatter->inputDigit('5'));
        self::assertSame('+52 ', $formatter->inputDigit('2'));
        self::assertSame('+52 8', $formatter->inputDigit('8'));
        self::assertSame('+52 80', $formatter->inputDigit('0'));
        self::assertSame('+52 800', $formatter->inputDigit('0'));
        self::assertSame('+52 800 1', $formatter->inputDigit('1'));
        self::assertSame('+52 800 12', $formatter->inputDigit('2'));
        self::assertSame('+52 800 123', $formatter->inputDigit('3'));
        self::assertSame('+52 800 123 4', $formatter->inputDigit('4'));
        self::assertSame('+52 800 123 45', $formatter->inputDigit('5'));
        self::assertSame('+52 800 123 456', $formatter->inputDigit('6'));
        self::assertSame('+52 800 123 4567', $formatter->inputDigit('7'));
    }

    public function testAYTFNoNationalPrefix(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::IT);

        self::assertSame('3', $formatter->inputDigit('3'));
        self::assertSame('33', $formatter->inputDigit('3'));
        self::assertSame('333', $formatter->inputDigit('3'));
        self::assertSame('333 3', $formatter->inputDigit('3'));
        self::assertSame('333 33', $formatter->inputDigit('3'));
        self::assertSame('333 333', $formatter->inputDigit('3'));
    }

    public function testAYTFNoNationalPrefixFormattingRule(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::AO);

        self::assertSame('3', $formatter->inputDigit('3'));
        self::assertSame('33', $formatter->inputDigit('3'));
        self::assertSame('333', $formatter->inputDigit('3'));
        self::assertSame('333 3', $formatter->inputDigit('3'));
        self::assertSame('333 33', $formatter->inputDigit('3'));
        self::assertSame('333 333', $formatter->inputDigit('3'));
    }

    public function testAYTFShortNumberFormattingFix_US(): void
    {
        // For the US, an initial 1 is treated specially.
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::US);

        // 101 - Test that the initial 1 is not treated as a national prefix.
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('10', $formatter->inputDigit('0'));
        self::assertSame('101', $formatter->inputDigit('1'));

        // 112 - Test that the initial 1 is not treated as a national prefix.
        $formatter->clear();
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('11', $formatter->inputDigit('1'));
        self::assertSame('112', $formatter->inputDigit('2'));

        // 122 - Test that the initial 1 is treated as a national prefix.
        $formatter->clear();
        self::assertSame('1', $formatter->inputDigit('1'));
        self::assertSame('12', $formatter->inputDigit('2'));
        self::assertSame('1 22', $formatter->inputDigit('2'));
    }

    public function testAYTFClearNDDAfterIDDExtraction(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::KR);

        // Check that when we have successfully extracted an IDD, the previously extracted NDD is
        // cleared since it is no longer valid.
        self::assertSame('0', $formatter->inputDigit('0'));
        self::assertSame('00', $formatter->inputDigit('0'));
        self::assertSame('007', $formatter->inputDigit('7'));
        self::assertSame('0070', $formatter->inputDigit('0'));
        self::assertSame('00700', $formatter->inputDigit('0'));
        self::assertSame('0', $formatter->getExtractedNationalPrefix());

        // Once the IDD "00700" has been extracted, it no longer makes sense for the initial "0" to be
        // treated as an NDD.
        self::assertSame('00700 1 ', $formatter->inputDigit('1'));
        self::assertSame('', $formatter->getExtractedNationalPrefix());

        self::assertSame('00700 1 2', $formatter->inputDigit('2'));
        self::assertSame('00700 1 23', $formatter->inputDigit('3'));
        self::assertSame('00700 1 234', $formatter->inputDigit('4'));
        self::assertSame('00700 1 234 5', $formatter->inputDigit('5'));
        self::assertSame('00700 1 234 56', $formatter->inputDigit('6'));
        self::assertSame('00700 1 234 567', $formatter->inputDigit('7'));
        self::assertSame('00700 1 234 567 8', $formatter->inputDigit('8'));
        self::assertSame('00700 1 234 567 89', $formatter->inputDigit('9'));
        self::assertSame('00700 1 234 567 890', $formatter->inputDigit('0'));
        self::assertSame('00700 1 234 567 8901', $formatter->inputDigit('1'));
        self::assertSame('00700123456789012', $formatter->inputDigit('2'));
        self::assertSame('007001234567890123', $formatter->inputDigit('3'));
        self::assertSame('0070012345678901234', $formatter->inputDigit('4'));
        self::assertSame('00700123456789012345', $formatter->inputDigit('5'));
        self::assertSame('007001234567890123456', $formatter->inputDigit('6'));
        self::assertSame('0070012345678901234567', $formatter->inputDigit('7'));
    }

    public function testAYTFNumberPatternsBecomingInvalidShouldNotResultInDigitLoss(): void
    {
        $formatter = $this->phoneUtil->getAsYouTypeFormatter(RegionCode::CN);

        self::assertSame('+', $formatter->inputDigit('+'));
        self::assertSame('+8', $formatter->inputDigit('8'));
        self::assertSame('+86 ', $formatter->inputDigit('6'));
        self::assertSame('+86 9', $formatter->inputDigit('9'));
        self::assertSame('+86 98', $formatter->inputDigit('8'));
        self::assertSame('+86 988', $formatter->inputDigit('8'));
        self::assertSame('+86 988 1', $formatter->inputDigit('1'));
        // Now the number pattern is no longer valid because there are multiple leading digit patterns;
        // when we try again to extract a country code we should ensure we use the last leading digit
        // pattern, rather than the first one such that it *thinks* it's found a valid formatting rule
        // again.
        // https://github.com/googlei18n/libphonenumber/issues/437
        self::assertSame('+8698812', $formatter->inputDigit('2'));
        self::assertSame('+86988123', $formatter->inputDigit('3'));
        self::assertSame('+869881234', $formatter->inputDigit('4'));
        self::assertSame('+8698812345', $formatter->inputDigit('5'));
    }
}
