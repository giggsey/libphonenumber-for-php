<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue76Test extends TestCase
{
    public function testIssue76()
    {
        $this->expectExceptionMessage("The string supplied did not seem to be a phone number.");
        $this->expectExceptionCode(1);
        $this->expectException('\libphonenumber\NumberParseException');

        $number = 'Abc811@hotmail.com';
        $region = 'DE';
        $util = PhoneNumberUtil::getInstance();
        $util->parse($number, $region);
    }
}
