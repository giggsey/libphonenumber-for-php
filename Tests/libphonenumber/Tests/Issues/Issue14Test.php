<?php

namespace libphonenumber\Tests\Issues;


use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;

class Issue14Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    public function setUp()
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function testKWMobileNumber()
    {
        $number = "51440519";
        $phoneNumber = $this->phoneUtil->parse($number, "KW");

        $this->assertTrue($this->phoneUtil->isValidNumber($phoneNumber));
        $this->assertEquals(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType($phoneNumber));
    }
}
