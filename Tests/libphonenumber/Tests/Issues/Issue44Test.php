<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberUtil;

class Issue44Test extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneUtil;

    /**
     * @var PhoneNumberOfflineGeocoder
     */
    private $geocoder;

    public function setUp()
    {
        if(!extension_loaded('intl')) {
            $this->markTestSkipped('The intl extension must be installed');
        }

        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();

        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testMemoryUsageOfGeoLocationWithNoResult()
    {
        $number = $this->phoneUtil->parse("86-157-9662-1289", "CN");

        $startMemory = memory_get_usage();
        $location = $this->geocoder->getDescriptionForNumber($number, "en");
        $endMemory = memory_get_usage();

        $this->assertEquals("China", $location);

        $memoryUsed = $endMemory - $startMemory;

        $this->assertLessThan(5000000, $memoryUsed, "Memory usage should be below 5MB");
    }

    public function testMemoryUsageOfGeoLocationWithResult()
    {
        $number = $this->phoneUtil->parse("86-131-2270-1411", "CN");

        $startMemory = memory_get_usage();
        $location = $this->geocoder->getDescriptionForNumber($number, "en");
        $endMemory = memory_get_usage();

        $this->assertEquals("Shanghai", $location);

        $memoryUsed = $endMemory - $startMemory;

        $this->assertLessThan(5000000, $memoryUsed, "Memory usage should be below 5MB");
    }

    public function testChineseGeolocation()
    {
        $number = $this->phoneUtil->parse("+86 150 3657 7264", "CN");
        $location = $this->geocoder->getDescriptionForNumber($number, "en");

        $this->assertEquals("Luoyang, Henan", $location);
    }

    public function testChineseCarrierLookup()
    {
        $number = $this->phoneUtil->parse("+86 150 3657 7264", "CN");

        $carrier = PhoneNumberToCarrierMapper::getInstance();

        $location = $carrier->getNameForNumber($number, "en");

        $this->assertEquals("China Mobile", $location);
    }
}

