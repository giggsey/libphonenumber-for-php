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
class ShortNumberMetadata_KR extends PhoneMetadata
{
    protected const ID = 'KR';
    protected const COUNTRY_CODE = 0;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1\d\d(?:\d(?:\d(?:\d{3})?)?)?')
            ->setPossibleLength([3, 4, 5, 8]);
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:1[27-9]|28|330|82)')
            ->setExampleNumber('112')
            ->setPossibleLength([3, 4]);
        $this->emergency = (new PhoneNumberDesc())
            ->setNationalNumberPattern('11[29]')
            ->setExampleNumber('112')
            ->setPossibleLength([3]);
        $this->short_code = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:[01679]114|3(?:0[01]|2|3[0-35-9]|45?|5[057]|6[569]|7[79]|8[2589]|9[0189])|55[15]\d{4}|8(?:(?:11|44|66)\d{4}|[28]))|1(?:0[015]|1\d|2[01357-9]|41|8114)')
            ->setExampleNumber('100');
        $this->standard_rate = PhoneNumberDesc::empty();
        $this->carrierSpecific = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:0[01]|1[4-6]|41|8114)|1(?:[0679]1\d|111)\d')
            ->setExampleNumber('100')
            ->setPossibleLength([3, 5]);
        $this->smsServices = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:55|8[146])\d{5}')
            ->setExampleNumber('15500000')
            ->setPossibleLength([8]);
    }
}
