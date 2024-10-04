<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class PHP7Test extends TestCase
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    /**
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
        return [
            ['22 222 22 22'],
            ['33 222 22 22'],
            ['46 222 22 22'],
            ['61 222 22 22'],
            ['62 222 22 22'],
            ['642 222 222'],
            ['65 222 22 22'],
            ['512 345 678'],
            ['800 123 456'],
            ['700 000 000'],
            ['801 234 567'],
            ['91 000 00 00'],
        ];
    }
}
