<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

/**
 * Test E164 formatted numbers with extensions
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/152
 * @package libphonenumber\Tests\Issues
 */
class Issue152Test extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Reset instance each time
        PhoneNumberUtil::resetInstance();
    }

    public function testE164NumberWithExtension()
    {
        $number = new PhoneNumber();
        $number->setCountryCode(44)->setNationalNumber(1174960123)->setExtension(101);

        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->assertEquals('+441174960123', $phoneNumberUtil->format($number, PhoneNumberFormat::E164));
        $this->assertEquals('+44 117 496 0123 x101', $phoneNumberUtil->format($number, PhoneNumberFormat::INTERNATIONAL));
        $this->assertEquals('0117 496 0123 x101', $phoneNumberUtil->format($number, PhoneNumberFormat::NATIONAL));
        $this->assertEquals('tel:+44-117-496-0123;ext=101', $phoneNumberUtil->format($number, PhoneNumberFormat::RFC3966));
    }
}
