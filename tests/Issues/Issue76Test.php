<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue76Test extends TestCase
{
    /**
     * @expectedException \libphonenumber\NumberParseException
     * @expectedExceptionCode 1
     * @expectedExceptionMessage The string supplied did not seem to be a phone number.
     */
    public function testIssue76()
    {
        $number = 'Abc811@hotmail.com';
        $region = 'DE';
        $util = PhoneNumberUtil::getInstance();
        $util->parse($number, $region);
    }
}
