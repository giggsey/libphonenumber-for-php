<?php

namespace libphonenumber\Tests\core;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberMatch;
use PHPUnit\Framework\TestCase;

class PhoneNumberMatchTest extends TestCase
{
    public function testValueTypeSemantics()
    {
        $number = new PhoneNumber();

        $match1 = new PhoneNumberMatch(10, '1 800 234 45 67', $number);
        $match2 = new PhoneNumberMatch(10, '1 800 234 45 67', $number);

        $this->assertEquals($match1, $match2);
        $this->assertEquals($match1->start(), $match2->start());
        $this->assertEquals($match1->end(), $match2->end());
        $this->assertEquals($match1->number(), $match2->number());
        $this->assertEquals($match1->rawString(), $match2->rawString());

        $this->assertEquals('1 800 234 45 67', $match1->rawString());
    }

    public function testIllegalArguments()
    {
        try {
            new PhoneNumberMatch(-110, '1 800 234 45 67', new PhoneNumber());
            $this->fail();
        } catch (\InvalidArgumentException $e) {
            $this->addToAssertionCount(1);
        }

        try {
            new PhoneNumberMatch(10, null, new PhoneNumber());
            $this->fail();
        } catch (\NullPointerException $e) {
            $this->addToAssertionCount(1);
        }
    }
}
