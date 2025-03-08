<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberMatch;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class PhoneNumberMatchTest extends TestCase
{
    public function testValueTypeSemantics(): void
    {
        $number = new PhoneNumber();

        $match1 = new PhoneNumberMatch(10, '1 800 234 45 67', $number);
        $match2 = new PhoneNumberMatch(10, '1 800 234 45 67', $number);

        self::assertEquals($match1, $match2);
        self::assertEquals($match1->start(), $match2->start());
        self::assertEquals($match1->end(), $match2->end());
        self::assertEquals($match1->number(), $match2->number());
        self::assertEquals($match1->rawString(), $match2->rawString());

        self::assertEquals('1 800 234 45 67', $match1->rawString());
    }

    public function testIllegalArguments(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Start index must be >= 0.');

        new PhoneNumberMatch(-110, '1 800 234 45 67', new PhoneNumber());
    }
}
