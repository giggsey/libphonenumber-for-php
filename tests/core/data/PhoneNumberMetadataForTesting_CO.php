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
class PhoneNumberMetadataForTesting_CO extends PhoneMetadata
{
    protected const ID = 'CO';
    protected const COUNTRY_CODE = 57;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0(4(?:[14]4|56)|[579])?';
    protected ?string $internationalPrefix = '';
    protected bool $mobileNumberPortableRegion = true;

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('(?:60|3\d)\d{8}')
            ->setPossibleLength([10]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('3(?:0[0-5]|1\d|2[0-3]|5[01]|70)\d{7}')
            ->setExampleNumber('3211234567');
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('60\d{8}')
            ->setExampleNumber('6012345678');
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{7})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['6'])
                ->setNationalPrefixFormattingRule('($1)')
                ->setDomesticCarrierCodeFormattingRule('0$CC $1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{7})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['3'])
                ->setDomesticCarrierCodeFormattingRule('0$CC $1')
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
