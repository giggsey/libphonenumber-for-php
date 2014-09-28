<?php

namespace libphonenumber\Tests\prefixmapper;

use libphonenumber\PhoneNumber;
use libphonenumber\prefixmapper\PrefixFileReader;


class PrefixFileReaderTest extends \PHPUnit_Framework_TestCase
{
    const TEST_META_DATA_FILE_PREFIX = "/data/";
    private static $KO_NUMBER;
    private static $US_NUMBER1;
    private static $US_NUMBER2;
    private static $US_NUMBER3;
    private static $SE_NUMBER;
    /**
     * @var PrefixFileReader
     */
    protected $reader;

    public static function setUpBeforeClass()
    {
        self::$KO_NUMBER = new PhoneNumber();
        self::$KO_NUMBER->setCountryCode(82)->setNationalNumber(22123456);

        self::$US_NUMBER1 = new PhoneNumber();
        self::$US_NUMBER1->setCountryCode(1)->setNationalNumber(6502530000);

        self::$US_NUMBER2 = new PhoneNumber();
        self::$US_NUMBER2->setCountryCode(1)->setNationalNumber(2128120000);

        self::$US_NUMBER3 = new PhoneNumber();
        self::$US_NUMBER3->setCountryCode(1)->setNationalNumber(6174240000);

        self::$SE_NUMBER = new PhoneNumber();
        self::$SE_NUMBER->setCountryCode(46)->setNationalNumber(81234567);
    }

    public function setUp()
    {
        $this->reader = new PrefixFileReader(__DIR__ . DIRECTORY_SEPARATOR . self::TEST_META_DATA_FILE_PREFIX);
    }

    public function testGetDescriptionForNumberWithMapping()
    {
        $this->assertEquals("Kalifornien", $this->reader->getDescriptionForNumber(self::$US_NUMBER1, "de", "", "CH"));
        $this->assertEquals("CA", $this->reader->getDescriptionForNumber(self::$US_NUMBER1, "en", "", "AU"));
        $this->assertEquals(
            pack('H*', 'ec849c') . pack('H*', 'ec9ab8'),
            $this->reader->getDescriptionForNumber(self::$KO_NUMBER, "ko", "", "")
        );
        $this->assertEquals("Seoul", $this->reader->getDescriptionForNumber(self::$KO_NUMBER, "en", "", ""));
    }

    public function testGetDescriptionForNumberWithMissingMapping()
    {
        $this->assertEquals("", $this->reader->getDescriptionForNumber(self::$US_NUMBER3, "en", "", ""));
    }

    public function testGetDescriptionUsingFallbackLanguage()
    {
        // Mapping file exists but the number isn't present, causing it to fallback.
        $this->assertEquals("New York, NY", $this->reader->getDescriptionForNumber(self::$US_NUMBER2, "de", "", "CH"));
        // No mapping file exists, causing it to fallback.
        $this->assertEquals("New York, NY", $this->reader->getDescriptionForNumber(self::$US_NUMBER2, "sv", "", ""));
    }

    public function testGetDescriptionForNonFallbackLanguage()
    {
        $this->assertEquals("", $this->reader->getDescriptionForNumber(self::$US_NUMBER2, "ko", "", ""));
    }

    public function testGetDescriptionForNumberWithoutMappingFile()
    {
        $this->assertEquals("", $this->reader->getDescriptionForNumber(self::$SE_NUMBER, "sv", "", ""));
        $this->assertEquals("", $this->reader->getDescriptionForNumber(self::$SE_NUMBER, "en", "", ""));
    }
}
