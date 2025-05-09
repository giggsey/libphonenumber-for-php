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
class ShortNumberMetadata_SH extends PhoneMetadata
{
    protected const ID = 'SH';
    protected const COUNTRY_CODE = 0;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[129]\d{2,4}')
            ->setPossibleLength([3, 4, 5]);
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('9(?:11|99)')
            ->setExampleNumber('911')
            ->setPossibleLength([3]);
        $this->emergency = (new PhoneNumberDesc())
            ->setNationalNumberPattern('9(?:11|99)')
            ->setExampleNumber('911')
            ->setPossibleLength([3]);
        $this->short_code = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1\d{2,3}|26[01]\d\d|9(?:11|99)')
            ->setExampleNumber('100');
        $this->standard_rate = PhoneNumberDesc::empty();
        $this->carrierSpecific = PhoneNumberDesc::empty();
        $this->smsServices = PhoneNumberDesc::empty();
    }
}
