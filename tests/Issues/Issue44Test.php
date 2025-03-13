<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberToCarrierMapper;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

use function memory_get_usage;

class Issue44Test extends TestCase
{
    private PhoneNumberUtil $phoneUtil;

    private PhoneNumberOfflineGeocoder $geocoder;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();

        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testMemoryUsageOfGeoLocationWithNoResult(): void
    {
        $number = $this->phoneUtil->parse('86-157-9662-1289', 'CN');

        $startMemory = memory_get_usage();
        $location = $this->geocoder->getDescriptionForNumber($number, 'en');
        $endMemory = memory_get_usage();

        self::assertSame('China', $location);

        $memoryUsed = $endMemory - $startMemory;

        self::assertLessThan(5000000, $memoryUsed, 'Memory usage should be below 5MB');
    }

    public function testMemoryUsageOfGeoLocationWithResult(): void
    {
        $number = $this->phoneUtil->parse('86-131-2270-1411', 'CN');

        $startMemory = memory_get_usage();
        $location = $this->geocoder->getDescriptionForNumber($number, 'en');
        $endMemory = memory_get_usage();

        self::assertSame('Shanghai', $location);

        $memoryUsed = $endMemory - $startMemory;

        self::assertLessThan(5000000, $memoryUsed, 'Memory usage should be below 5MB');
    }

    public function testChineseGeolocation(): void
    {
        $number = $this->phoneUtil->parse('+86 150 3657 7264', 'CN');
        $location = $this->geocoder->getDescriptionForNumber($number, 'en');

        self::assertSame('Luoyang, Henan', $location);
    }

    public function testChineseCarrierLookup(): void
    {
        $number = $this->phoneUtil->parse('+86 150 3657 7264', 'CN');

        $carrier = PhoneNumberToCarrierMapper::getInstance();

        $location = $carrier->getNameForNumber($number, 'en');

        self::assertSame('China Mobile', $location);
    }
}
