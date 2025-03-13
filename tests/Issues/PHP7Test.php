<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PHP7Test extends TestCase
{
    private PhoneNumberUtil $phoneUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    #[DataProvider('validPolishNumbers')]
    public function testValidPolishNumbers(string $number): void
    {
        $phoneNumber = $this->phoneUtil->parse($number, 'PL');

        self::assertTrue($this->phoneUtil->isValidNumber($phoneNumber));
        self::assertSame($number, $this->phoneUtil->format($phoneNumber, PhoneNumberFormat::NATIONAL));
    }

    /**
     * @return array<array{string}>
     */
    public static function validPolishNumbers(): array
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
