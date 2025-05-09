<?php

/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

declare(strict_types=1);

namespace libphonenumber\Tests\core\data;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;

/**
 * @internal
 */
class PhoneNumberMetadataForTesting_IT extends PhoneMetadata
{
    protected const ID = 'IT';
    protected const COUNTRY_CODE = 39;

    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[0389]\d{5,10}')
            ->setPossibleLength([6, 9, 10, 11]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('3\d{8,9}')
            ->setExampleNumber('3123456789')
            ->setPossibleLength([9, 10]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('89(?:2\d{3}|9\d{6})')
            ->setExampleNumber('892123')
            ->setPossibleLength([6, 9]);
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('0\d{9,10}')
            ->setExampleNumber('0123456789')
            ->setPossibleLength([10, 11]);
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['0[26]'])
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{4})(\d{3,4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['0[13-57-9]'])
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{3,4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['3'])
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3,6})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['8'])
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('80(?:0\d{6}|3\d{3})')
            ->setExampleNumber('800123456')
            ->setPossibleLength([6, 9]);
        $this->sharedCost = PhoneNumberDesc::empty();
        $this->personalNumber = PhoneNumberDesc::empty();
        $this->voip = PhoneNumberDesc::empty();
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
