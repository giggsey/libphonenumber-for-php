<?php
namespace libphonenumber\Tests\Issues;


use libphonenumber\PhoneNumberUtil;

class Issue35Test extends \PHPUnit_Framework_TestCase
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

    public function testSerializingPhoneNumber()
    {
        $number = "+441174900000";
        $region = "GB";
        $phoneNumber = $this->phoneUtil->parse($number, $region);

        $serializedString = serialize($phoneNumber);

        $phoneObject2 = unserialize($serializedString);

        $this->assertTrue($phoneObject2->equals($phoneNumber));
    }
}

/* EOF */
