<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumber;
use PHPUnit\Framework\TestCase;

class Issue475Test extends TestCase
{
    public function testSerialization()
    {
        $numberA = new PhoneNumber();
        if (PHP_VERSION_ID >= 70000) {
            self::assertSame('O:26:"libphonenumber\PhoneNumber":8:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;i:1;i:5;N;i:6;i:4;i:7;N;}', serialize($numberA));
        } else {
            self::assertSame('C:26:"libphonenumber\PhoneNumber":58:{a:8:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;i:1;i:5;N;i:6;i:4;i:7;N;}}', serialize($numberA));
        }
    }

    public function testDeserializationOldFormat()
    {
        $number = unserialize('C:26:"libphonenumber\PhoneNumber":58:{a:8:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;i:1;i:5;N;i:6;i:4;i:7;N;}}');
        self::assertInstanceOf('libphonenumber\PhoneNumber', $number);
    }

    public function testDeserializationNewFormat()
    {
        $number = unserialize('O:26:"libphonenumber\PhoneNumber":8:{i:0;N;i:1;N;i:2;N;i:3;N;i:4;i:1;i:5;N;i:6;i:4;i:7;N;}');
        self::assertInstanceOf('libphonenumber\PhoneNumber', $number);
    }
}
