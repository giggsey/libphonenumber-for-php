<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\Tests\core\PhoneNumberUtilTest;
use PHPUnit\Framework\TestCase;

/**
 * Test calling public static methods without an instance of PhoneNumberUtil being created
 *
 * @package libphonenumber\Tests\Issues
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/135
 */
class Issue135Test extends TestCase
{
    public function setUp(): void
    {
        // Reset instance each time
        PhoneNumberUtil::resetInstance();
    }

    /**
     * @see PhoneNumberUtilTest::testConvertAlphaCharactersInNumber()
     */
    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    public function testConvertAlphaCharactersInNumber(): void
    {
        $input = '1800-ABC-DEF';
        // Alpha chars are converted to digits; everything else is left untouched.
        $expectedOutput = '1800-222-333';
        self::assertSame($expectedOutput, PhoneNumberUtil::convertAlphaCharactersInNumber($input));
    }

    /**
     * @see PhoneNumberUtilTest::testGetCountryMobileToken()
     */
    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    public function testGetCountryMobileToken(): void
    {
        // AR
        self::assertSame('9', PhoneNumberUtil::getCountryMobileToken(54));

        // Country calling code for Sweden, which has no mobile token.
        self::assertSame('', PhoneNumberUtil::getCountryMobileToken(46));
    }

    /**
     * @see PhoneNumberUtilTest::testIsViablePhoneNumber()
     */
    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    public function testIsViablePhoneNumber(): void
    {
        self::assertFalse(PhoneNumberUtil::isViablePhoneNumber('1'));
    }

    /**
     * @see PhoneNumberUtilTest::testExtractPossibleNumber()
     */
    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    public function testExtractPossibleNumber(): void
    {
        self::assertSame('0800-345-600', PhoneNumberUtil::extractPossibleNumber('Tel:0800-345-600'));
    }

    /**
     * @see PhoneNumberUtilTest::testNormaliseOtherDigits()
     */
    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    public function testNormaliseReplaceAlphaCharacters(): void
    {
        $inputNumber = '034-I-am-HUNGRY';
        $expectedOutput = '034426486479';
        self::assertSame(
            $expectedOutput,
            PhoneNumberUtil::normalize($inputNumber),
            'Conversion did not correctly replace alpha characters'
        );
    }

    /**
     * @see PhoneNumberUtilTest::testNormaliseStripNonDiallableCharacters()
     */
    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    public function testNormalizeDiallableCharsOnly(): void
    {
        $inputNumber = '03*4-56&+a#234';
        $expectedOutput = '03*456+#234';
        self::assertSame(
            $expectedOutput,
            PhoneNumberUtil::normalizeDiallableCharsOnly($inputNumber),
            'Conversion did not correctly remove non-diallable characters'
        );
    }
}
