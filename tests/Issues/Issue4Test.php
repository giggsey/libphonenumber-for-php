<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue4Test extends TestCase
{
    public PhoneNumberUtil $phoneNumberUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }

    public function testParseUSNumber(): void
    {
        $number = $this->phoneNumberUtil->parse('0351-152-303-473', 'AR');

        self::assertSame('+5493512303473', $this->phoneNumberUtil->format($number, PhoneNumberFormat::E164));
    }
}
