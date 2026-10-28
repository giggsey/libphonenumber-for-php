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
class ShortNumberMetadata_BW extends PhoneMetadata
{
    protected const ID = 'BW';
    protected const COUNTRY_CODE = 0;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[19]\d{2,4}')
            ->setPossibleLength([3, 4, 5]);
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('11[0-246]|9(?:1[0-4]|2[02-69]|9[06-9])')
            ->setExampleNumber('110')
            ->setPossibleLength([3]);
        $this->emergency = (new PhoneNumberDesc())
            ->setNationalNumberPattern('11[12]|9(?:11|9[7-9])')
            ->setExampleNumber('111')
            ->setPossibleLength([3]);
        $this->short_code = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:(?:[02]|[6-9]\d\d)\d|1[0-2469]|3123)|9(?:1[0-4]|2[02-69]|9\d)|1[0-28]\d\d')
            ->setExampleNumber('100');
        $this->standard_rate = PhoneNumberDesc::empty();
        $this->carrierSpecific = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:[0-2]|31)\d\d|9(?:1[02-4]|2[02-69]|9[0-3])|1(?:[02]\d|1[49])')
            ->setExampleNumber('100');
        $this->smsServices = (new PhoneNumberDesc())
            ->setNationalNumberPattern('131\d\d')
            ->setExampleNumber('13100')
            ->setPossibleLength([5]);
    }
}
