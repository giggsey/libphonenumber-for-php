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
class PhoneNumberMetadataForTesting_CN extends PhoneMetadata
{
    protected const ID = 'CN';
    protected const COUNTRY_CODE = 86;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0';
    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1-7]\d{6,11}|8[0-357-9]\d{6,9}|9\d{7,10}')
            ->setPossibleLength([11]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(?:[38]\d|4[57]|5[0-35-9]|7[0136-8])\d{8}')
            ->setExampleNumber('13123456789');
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[2-9]\d{10}')
            ->setExampleNumber('91234567');
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{5,6})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['[3-9]', '[3-9]\d{2}[19]', '[3-9]\d{2}(?:10|95)'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setDomesticCarrierCodeFormattingRule('$CC $1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{8})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['1'])
                ->setNationalPrefixFormattingRule('$1')
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
