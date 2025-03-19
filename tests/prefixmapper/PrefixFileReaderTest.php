<?php

declare(strict_types=1);

namespace libphonenumber\Tests\prefixmapper;

use libphonenumber\PhoneNumber;
use libphonenumber\prefixmapper\PrefixFileReader;
use PHPUnit\Framework\TestCase;

use function pack;

class PrefixFileReaderTest extends TestCase
{
    private static PhoneNumber $KO_NUMBER;
    private static PhoneNumber $US_NUMBER1;
    private static PhoneNumber $US_NUMBER2;
    private static PhoneNumber $US_NUMBER3;
    private static PhoneNumber $SE_NUMBER;
    protected PrefixFileReader $reader;

    public static function setUpBeforeClass(): void
    {
        self::$KO_NUMBER = new PhoneNumber();
        self::$KO_NUMBER->setCountryCode(82)->setNationalNumber('22123456');

        self::$US_NUMBER1 = new PhoneNumber();
        self::$US_NUMBER1->setCountryCode(1)->setNationalNumber('6502530000');

        self::$US_NUMBER2 = new PhoneNumber();
        self::$US_NUMBER2->setCountryCode(1)->setNationalNumber('2128120000');

        self::$US_NUMBER3 = new PhoneNumber();
        self::$US_NUMBER3->setCountryCode(1)->setNationalNumber('6174240000');

        self::$SE_NUMBER = new PhoneNumber();
        self::$SE_NUMBER->setCountryCode(46)->setNationalNumber('81234567');
    }

    public function setUp(): void
    {
        $this->reader = new PrefixFileReader('libphonenumber\\Tests\\prefixmapper\\data\\');
    }

    public function testGetDescriptionForNumberWithMapping(): void
    {
        self::assertSame('Kalifornien', $this->reader->getDescriptionForNumber(self::$US_NUMBER1, 'de', '', 'CH'));
        self::assertSame('CA', $this->reader->getDescriptionForNumber(self::$US_NUMBER1, 'en', '', 'AU'));
        self::assertSame(
            pack('H*', 'ec849c') . pack('H*', 'ec9ab8'),
            $this->reader->getDescriptionForNumber(self::$KO_NUMBER, 'ko', '', '')
        );
        self::assertSame('Seoul', $this->reader->getDescriptionForNumber(self::$KO_NUMBER, 'en', '', ''));
    }

    public function testGetDescriptionForNumberWithMissingMapping(): void
    {
        self::assertSame('', $this->reader->getDescriptionForNumber(self::$US_NUMBER3, 'en', '', ''));
    }

    public function testGetDescriptionUsingFallbackLanguage(): void
    {
        // Mapping file exists but the number isn't present, causing it to fallback.
        self::assertSame('New York, NY', $this->reader->getDescriptionForNumber(self::$US_NUMBER2, 'de', '', 'CH'));
        // No mapping file exists, causing it to fallback.
        self::assertSame('New York, NY', $this->reader->getDescriptionForNumber(self::$US_NUMBER2, 'sv', '', ''));
    }

    public function testGetDescriptionForNonFallbackLanguage(): void
    {
        self::assertSame('', $this->reader->getDescriptionForNumber(self::$US_NUMBER2, 'ko', '', ''));
    }

    public function testGetDescriptionForNumberWithoutMappingFile(): void
    {
        self::assertSame('', $this->reader->getDescriptionForNumber(self::$SE_NUMBER, 'sv', '', ''));
        self::assertSame('', $this->reader->getDescriptionForNumber(self::$SE_NUMBER, 'en', '', ''));
    }
}
