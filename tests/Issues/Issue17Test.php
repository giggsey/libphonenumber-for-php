<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue17Test extends TestCase
{
    private PhoneNumberOfflineGeocoder $geocoder;

    private PhoneNumberUtil $phoneUtil;

    public function setUp(): void
    {
        PhoneNumberUtil::resetInstance();
        PhoneNumberOfflineGeocoder::resetInstance();
        $this->phoneUtil = PhoneNumberUtil::getInstance();
        $this->geocoder = PhoneNumberOfflineGeocoder::getInstance();
    }

    public function testIsleOfManLocale(): void
    {
        $number = '447624206000';

        $phoneNumber = $this->phoneUtil->parse($number, 'GB');

        self::assertSame('Isle of Man', $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
