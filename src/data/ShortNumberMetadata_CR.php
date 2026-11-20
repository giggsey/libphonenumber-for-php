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
class ShortNumberMetadata_CR extends PhoneMetadata
{
    protected const ID = 'CR';
    protected const COUNTRY_CODE = 0;

    protected ?string $internationalPrefix = '';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[19]\d{2,3}')
            ->setPossibleLength([3, 4]);
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:02|1)2|911')
            ->setExampleNumber('112');
        $this->emergency = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:02|1)2|911')
            ->setExampleNumber('112');
        $this->short_code = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:0(?:0[0-2]|1[015]|2[0-46-8]|4[08])|1(?:0[015]|1[135-9]|2[125]?|3[2-4]|4[6-9]|55|6[1569]|7[67]|8[07]|9[0-49])|2(?:00|1[235]|2[12]|34)|3(?:11|2[12]|33)|4(?:1[14-6]|21)|5(?:15|20|5[05])|693|7(?:00|1[79]|2[02]|34|67)|818|975)|911')
            ->setExampleNumber('112');
        $this->standard_rate = PhoneNumberDesc::empty();
        $this->carrierSpecific = PhoneNumberDesc::empty();
        $this->smsServices = PhoneNumberDesc::empty();
    }
}
