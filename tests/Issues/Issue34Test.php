<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue34Test extends TestCase
{
    private PhoneNumberUtil $phoneUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function testIsValidNumberForRegion(): void
    {
        $number = '+33 6 76 83 51 85';
        $region = 'DE';
        $phoneNumber = $this->phoneUtil->parse($number, $region);

        self::assertFalse($this->phoneUtil->isValidNumberForRegion($phoneNumber, 'DE'));
    }
}
