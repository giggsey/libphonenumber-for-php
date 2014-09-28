<?php
namespace libphonenumber\Tests\Issues;


use libphonenumber\PhoneNumber;
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

    public function testSerializingPhoneNumber2()
    {
        $phoneNumber = new PhoneNumber();
        $phoneNumber->setCountryCode(1);
        $phoneNumber->setNationalNumber(1);
        $phoneNumber->setExtension(1);
        $phoneNumber->setItalianLeadingZero(1);
        $phoneNumber->setNumberOfLeadingZeros(1);
        $phoneNumber->setRawInput(1);
        $phoneNumber->setCountryCodeSource(1);
        $phoneNumber->setPreferredDomesticCarrierCode(1);

        $serializedString = serialize($phoneNumber);
        $phoneObject2 = unserialize($serializedString);

        $this->assertTrue($phoneObject2->equals($phoneNumber));
    }
}
