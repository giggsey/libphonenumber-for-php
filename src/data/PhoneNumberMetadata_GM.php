<?php

/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

declare(strict_types=1);

namespace libphonenumber\data;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;

/**
 * @internal
 */
class PhoneNumberMetadata_GM extends PhoneMetadata
{
    protected const ID = 'GM';
    protected const COUNTRY_CODE = 220;

    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[48]\d{8}|[2-9]\d{6}')
            ->setPossibleLength([7, 9]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('(?:(?:[23679]\d|4[015]|8(?:(?:3[35]|6[68]|99)\d|7(?:[27]\d|4[015])))\d|5(?:[0-489]\d|56))\d{4}|8[4-7]\d{5}')
            ->setExampleNumber('3012345');
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('44(?:44[6-9]|8[0-389]\d)\d{4}|44[6-9]\d{4}|(?:4(?:[23]|44[23])|8[0-389])\d{5}|44(?:1|441)[024679]\d{3}|(?:445|5)(?:5(?:3\d|4[0-7])|6[67]\d|7(?:1[04]|2[035]|3[58]|48))\d{3}')
            ->setExampleNumber('5661234');
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{4})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['[235-9]|4(?:[0-35]|4[16-9])'])
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{3})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[48]'])
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
        $this->tollFree = PhoneNumberDesc::empty();
        $this->sharedCost = PhoneNumberDesc::empty();
        $this->personalNumber = PhoneNumberDesc::empty();
        $this->voip = PhoneNumberDesc::empty();
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
