<?php

/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

declare(strict_types=1);

namespace libphonenumber\data;

use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;

/**
 * @internal
 */
class ShortNumberMetadata_GF extends PhoneMetadata
{
    protected const ID = 'GF';
    protected const COUNTRY_CODE = 0;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[13]\d(?:\d\d(?:\d{2})?)?')
            ->setPossibleLength([2, 4, 6]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('3[2469]\d\d')
            ->setExampleNumber('3200')
            ->setPossibleLength([4]);
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1[578]|3(?:0\d|1[0-689])\d')
            ->setExampleNumber('15')
            ->setPossibleLength([2, 4]);
        $this->emergency = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1[578]')
            ->setExampleNumber('15')
            ->setPossibleLength([2]);
        $this->short_code = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1[578]|300[0-79]|(?:118[02-9]\d|3(?:0[1-9]|1[0-689]|[2469]\d))\d')
            ->setExampleNumber('15');
        $this->standard_rate = PhoneNumberDesc::empty();
        $this->carrierSpecific = PhoneNumberDesc::empty();
        $this->smsServices = PhoneNumberDesc::empty();
    }
}
