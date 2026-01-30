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
class ShortNumberMetadata_PY extends PhoneMetadata
{
    protected const ID = 'PY';
    protected const COUNTRY_CODE = 0;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[12459]\d\d(?:\d{3,4})?')
            ->setPossibleLength([3, 6, 7]);
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('128|911')
            ->setExampleNumber('128')
            ->setPossibleLength([3]);
        $this->emergency = (new PhoneNumberDesc())
            ->setNationalNumberPattern('128|911')
            ->setExampleNumber('128')
            ->setPossibleLength([3]);
        $this->short_code = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1245][01]\d{5}|(?:1[1-9]|[245]0\d{3})\d|911')
            ->setExampleNumber('110');
        $this->standard_rate = PhoneNumberDesc::empty();
        $this->carrierSpecific = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1245][01]\d{5}|[245]0\d{4}')
            ->setExampleNumber('200000')
            ->setPossibleLength([6, 7]);
        $this->smsServices = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1245][01]\d{5}|[245]0\d{4}')
            ->setExampleNumber('200000')
            ->setPossibleLength([6, 7]);
    }
}
