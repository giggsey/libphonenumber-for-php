<?php

namespace libphonenumber\Tests\Issues;


use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class Issue3Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PhoneNumberUtil
     */
    public $phoneNumberUtil;

    public function setUp()
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }

    public function testParseUSNumber()
    {
        $number = $this->phoneNumberUtil->parse('011543549480042', 'US');

        $this->assertEquals("+543549480042", $this->phoneNumberUtil->format($number, PhoneNumberFormat::E164));

    }
}
