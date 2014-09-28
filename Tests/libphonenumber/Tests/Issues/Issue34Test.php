<?php
namespace libphonenumber\Tests\Issues;


use libphonenumber\PhoneNumberUtil;

class Issue34Test extends \PHPUnit_Framework_TestCase
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

    public function testIsValidNumberForRegion()
    {
        $number = "+33 6 76 83 51 85";
        $region = "DE";
        $phoneNumber = $this->phoneUtil->parse($number, $region);

        $this->assertFalse($this->phoneUtil->isValidNumberForRegion($phoneNumber, "DE"));
    }
}
