<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue3Test extends TestCase
{
    public PhoneNumberUtil $phoneNumberUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }

    public function testParseUSNumber(): void
    {
        $number = $this->phoneNumberUtil->parse('011543549480042', 'US');

        self::assertSame('+543549480042', $this->phoneNumberUtil->format($number, PhoneNumberFormat::E164));
    }
}
