<?php


namespace libphonenumber\Tests\Issues;


use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PHP7Test extends \PHPUnit_Framework_TestCase
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

    /**
     * @param $number
     * @dataProvider validPolishNumbers
     */
    public function testValidPolishNumbers($number)
    {
        $phoneNumber = $this->phoneUtil->parse($number, 'PL');

        $this->assertTrue($this->phoneUtil->isValidNumber($phoneNumber));
        $this->assertEquals($number, $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::NATIONAL));
    }

    public function validPolishNumbers()
    {
        return array(
            array('22 222 22 22'),
            array('33 222 22 22'),
            array('46 222 22 22'),
            array('61 222 22 22'),
            array('62 222 22 22'),
            array('642 222 222'),
            array('65 222 22 22'),
            array('512 345 678'),
            array('800 123 456'),
            array('700 000 000'),
            array('801 234 567'),
            array('91 000 00 00'),
        );
    }
}
