<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue14Test extends TestCase
{
    private PhoneNumberUtil $phoneUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function testKWMobileNumber(): void
    {
        $number = '51440519';
        $phoneNumber = $this->phoneUtil->parse($number, 'KW');

        self::assertTrue($this->phoneUtil->isValidNumber($phoneNumber));
        self::assertSame(PhoneNumberType::MOBILE, $this->phoneUtil->getNumberType($phoneNumber));
    }
}
