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
class PhoneNumberMetadataForTesting_MX extends PhoneMetadata
{
    protected const ID = 'MX';
    protected const COUNTRY_CODE = 52;
    protected const NATIONAL_PREFIX = '01';

    protected ?string $nationalPrefixForParsing = '01|04[45](\d{10})';
    protected ?string $internationalPrefix = '00';
    protected ?string $nationalPrefixTransformRule = '1$1';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1-9]\d{9,10}')
            ->setPossibleLengthLocalOnly([7])
            ->setPossibleLength([10, 11]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1\d{10}')
            ->setExampleNumber('11234567890')
            ->setPossibleLength([11]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('900\d{7}')
            ->setExampleNumber('9001234567')
            ->setPossibleLength([10]);
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[2-9]\d{9}')
            ->setExampleNumber('2123456789')
            ->setPossibleLengthLocalOnly([7])
            ->setPossibleLength([10]);
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[89]00'])
                ->setNationalPrefixFormattingRule('01 $1')
                ->setNationalPrefixOptionalWhenFormatting(true),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{2})(\d{5})')
                ->setFormat('$2 $3')
                ->setLeadingDigitsPattern(['901'])
                ->setNationalPrefixFormattingRule('01 $1')
                ->setNationalPrefixOptionalWhenFormatting(true),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['33|55|81'])
                ->setNationalPrefixFormattingRule('01 $1')
                ->setNationalPrefixOptionalWhenFormatting(true),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[2467]|3[0-24-9]|5[0-46-9]|8[2-9]|9[1-9]'])
                ->setNationalPrefixFormattingRule('01 $1')
                ->setNationalPrefixOptionalWhenFormatting(true),
            (new NumberFormat())
                ->setPattern('(\d)(\d{2})(\d{4})(\d{4})')
                ->setFormat('045 $2 $3 $4')
                ->setLeadingDigitsPattern(['1(?:33|55|81)'])
                ->setNationalPrefixFormattingRule('$1')
                ->setNationalPrefixOptionalWhenFormatting(true),
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{3})(\d{4})')
                ->setFormat('045 $2 $3 $4')
                ->setLeadingDigitsPattern(['1(?:[124579]|3[0-24-9]|5[0-46-9]|8[02-9])'])
                ->setNationalPrefixFormattingRule('$1')
                ->setNationalPrefixOptionalWhenFormatting(true),
        ];
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('800\d{7}')
            ->setExampleNumber('8001234567')
            ->setPossibleLength([10]);
        $this->sharedCost = PhoneNumberDesc::empty();
        $this->personalNumber = PhoneNumberDesc::empty();
        $this->voip = PhoneNumberDesc::empty();
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
        $this->intlNumberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[89]00'])
                ->setNationalPrefixFormattingRule('01 $1')
                ->setNationalPrefixOptionalWhenFormatting(true),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{2})(\d{5})')
                ->setFormat('$2 $3')
                ->setLeadingDigitsPattern(['901']),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['33|55|81'])
                ->setNationalPrefixFormattingRule('01 $1')
                ->setNationalPrefixOptionalWhenFormatting(true),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[2467]|3[0-24-9]|5[0-46-9]|8[2-9]|9[1-9]'])
                ->setNationalPrefixFormattingRule('01 $1')
                ->setNationalPrefixOptionalWhenFormatting(true),
            (new NumberFormat())
                ->setPattern('(\d)(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1 $2 $3 $4')
                ->setLeadingDigitsPattern(['1(?:33|55|81)']),
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1 $2 $3 $4')
                ->setLeadingDigitsPattern(['1(?:[124579]|3[0-24-9]|5[0-46-9]|8[02-9])']),
        ];
    }
}
