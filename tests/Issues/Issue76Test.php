<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue76Test extends TestCase
{
    public function testIssue76(): void
    {
        $this->expectException(NumberParseException::class);
        $this->expectExceptionMessage('The string supplied did not seem to be a phone number.');

        $number = 'Abc811@hotmail.com';
        $region = 'DE';
        $util = PhoneNumberUtil::getInstance();
        $util->parse($number, $region);
    }
}
