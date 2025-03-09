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
class PhoneNumberMetadataForTesting_UZ extends PhoneMetadata
{
    protected const ID = 'UZ';
    protected const COUNTRY_CODE = 998;
    protected const NATIONAL_PREFIX = '8';

    protected ?string $nationalPrefixForParsing = '8';
    protected ?string $internationalPrefix = '810';
    protected ?string $preferredInternationalPrefix = '8~10';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[69]\d{8}')
            ->setPossibleLengthLocalOnly([7])
            ->setPossibleLength([9]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('9[0-57-9]\d{7}')
            ->setExampleNumber('912345678');
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('6122\d{5}')
            ->setExampleNumber('662345678')
            ->setPossibleLengthLocalOnly([7]);
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{3})(\d{2})(\d{2})')
                ->setFormat('$1 $2 $3 $4')
                ->setLeadingDigitsPattern(['[679]'])
                ->setNationalPrefixFormattingRule('8 $1')
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
