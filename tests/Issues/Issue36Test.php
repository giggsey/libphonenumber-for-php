<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\geocoding\PhoneNumberOfflineGeocoder;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue36Test extends TestCase
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
        $number = '447797752305';

        $phoneNumber = $this->phoneUtil->parse($number, 'GB');

        self::assertSame('Jersey', $this->geocoder->getDescriptionForNumber($phoneNumber, 'en'));
    }
}
