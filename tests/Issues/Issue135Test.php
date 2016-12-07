<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\Tests\core\PhoneNumberUtilTest;

/**
 * Test calling public static methods without an instance of PhoneNumberUtil being created
 *
 * @package libphonenumber\Tests\Issues
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/135
 */
class Issue135Test extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Reset instance each time
        PhoneNumberUtil::resetInstance();
    }

    /**
     * @see PhoneNumberUtilTest::testConvertAlphaCharactersInNumber()
     * @runInSeparateProcess
     */
    public function testConvertAlphaCharactersInNumber()
    {
        $input = "1800-ABC-DEF";
        // Alpha chars are converted to digits; everything else is left untouched.
        $expectedOutput = "1800-222-333";
        $this->assertEquals($expectedOutput, PhoneNumberUtil::convertAlphaCharactersInNumber($input));
    }

    /**
     * @see PhoneNumberUtilTest::testGetCountryMobileToken()
     * @runInSeparateProcess
     */
    public function testGetCountryMobileToken()
    {
        // MX
        $this->assertEquals("1", PhoneNumberUtil::getCountryMobileToken(52));

        // Country calling code for Sweden, which has no mobile token.
        $this->assertEquals("", PhoneNumberUtil::getCountryMobileToken(46));
    }

    /**
     * @see PhoneNumberUtilTest::testIsViablePhoneNumber()
     * @runInSeparateProcess
     */
    public function testIsViablePhoneNumber()
    {
        $this->assertFalse(PhoneNumberUtil::isViablePhoneNumber("1"));
    }

    /**
     * @see PhoneNumberUtilTest::testExtractPossibleNumber()
     * @runInSeparateProcess
     */
    public function testExtractPossibleNumber()
    {
        $this->assertEquals("0800-345-600", PhoneNumberUtil::extractPossibleNumber("Tel:0800-345-600"));
    }

    /**
     * @see PhoneNumberUtilTest::testNormaliseOtherDigits()
     * @runInSeparateProcess
     */
    public function testNormaliseReplaceAlphaCharacters()
    {
        $inputNumber = "034-I-am-HUNGRY";
        $expectedOutput = "034426486479";
        $this->assertEquals(
            $expectedOutput,
            PhoneNumberUtil::normalize($inputNumber),
            "Conversion did not correctly replace alpha characters"
        );
    }

    /**
     * @see PhoneNumberUtilTest::testNormaliseStripNonDiallableCharacters()
     * @runInSeparateProcess
     */
    public function testNormalizeDiallableCharsOnly()
    {
        $inputNumber = "03*4-56&+a#234";
        $expectedOutput = "03*456+#234";
        $this->assertEquals($expectedOutput, PhoneNumberUtil::normalizeDiallableCharsOnly($inputNumber),
            "Conversion did not correctly remove non-diallable characters");
    }
}
