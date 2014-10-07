<?php

namespace libphonenumber\Tests\core;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberToCarrierMapper;

/**
 * Verifies that classes which require the Intl extension cannot be instantiated.
 */
class IntlTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        if (extension_loaded('intl')) {
            $this->markTestSkipped('The intl extension must not be installed');
        }
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The intl extension must be installed
     */
    public function testPhoneNumberOfflineGeocoder()
    {
        PhoneNumberOfflineGeocoder::getInstance();
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage The intl extension must be installed
     */
    public function testPhoneNumberToCarrierMapper()
    {
        PhoneNumberToCarrierMapper::getInstance();
    }
}
