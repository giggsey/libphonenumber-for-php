<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;

class CodeCoverageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    public function setUp()
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
    }

    public function testNullException()
    {
        try {
            $this->phoneUtil->parse(null, null);
        } catch (\Exception $e) {
            $this->assertEquals("libphonenumber\\NumberParseException", get_class($e));
            $this->assertEquals("The phone number supplied was null.", $e->getMessage());

            $this->assertEquals("Error type: 1. The phone number supplied was null.", (string)$e);
        }
    }

    public function testTooShortNumber()
    {
        try {
            $this->phoneUtil->parse("+441", "GB");
        } catch (\Exception $e) {
            $this->assertEquals("libphonenumber\\NumberParseException", get_class($e));
            $this->assertEquals("The string supplied is too short to be a phone number.", $e->getMessage());
            $this->assertEquals(3, $e->getCode());

            $this->assertEquals("Error type: 3. The string supplied is too short to be a phone number.", (string)$e);
        }
    }
}
