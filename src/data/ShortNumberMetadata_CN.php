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
class ShortNumberMetadata_CN extends PhoneMetadata
{
    protected const ID = 'CN';
    protected const COUNTRY_CODE = 0;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[19]\d\d(?:\d(?:\d(?:\d(?:\d\d(?:\d{3,4})?)?)?)?)?')
            ->setPossibleLength([3, 4, 5, 6, 8, 11, 12]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('106[26]\d{4}')
            ->setExampleNumber('10620000')
            ->setPossibleLength([8]);
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:1[09]|2(?:[02]|1\d\d|395))')
            ->setExampleNumber('110')
            ->setPossibleLength([3, 5]);
        $this->emergency = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:1[09]|20)')
            ->setExampleNumber('110')
            ->setPossibleLength([3]);
        $this->short_code = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:(?:0(?:[0-2]\d|6(?:(?:[268]\d|[39](?:[0-49]|[5-8]\d{4}))\d\d|5)|8)|2[13]\d)\d|1[0249]|6[08])|9[56]\d{3,4}|1(?:0(?:0|690\d{6})|2[023])')
            ->setExampleNumber('100');
        $this->standard_rate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:0(?:(?:[0-2]\d|8)\d|6[3589]\d(?:\d{3}(?:\d{3,4})?)?)|1[24]|23(?:[0-8]\d|9[0-46-9])?|6[08])|9[56]\d{3,4}|100')
            ->setExampleNumber('100');
        $this->carrierSpecific = PhoneNumberDesc::empty();
        $this->smsServices = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:06\d\d(?:\d{3}(?:\d{3,4})?)?|2110)')
            ->setExampleNumber('10600')
            ->setPossibleLength([5, 8, 11, 12]);
    }
}
