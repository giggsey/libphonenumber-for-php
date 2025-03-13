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
class PhoneNumberMetadataForTesting_AR extends PhoneMetadata
{
    protected const ID = 'AR';
    protected const COUNTRY_CODE = 54;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0(?:(11|343|3715)15)?';
    protected ?string $internationalPrefix = '00';
    protected ?string $nationalPrefixTransformRule = '9$1';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1-3689]\d{9,10}')
            ->setPossibleLength([6, 7, 8, 9, 10, 11]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('9\d{10}|[1-3]\d{9}')
            ->setExampleNumber('9234567890')
            ->setPossibleLength([10, 11]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('6(0\d|10)\d{7}')
            ->setExampleNumber('6234567890')
            ->setPossibleLength([10]);
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1-3]\d{5,9}')
            ->setExampleNumber('1234567890')
            ->setPossibleLength([6, 7, 8, 9, 10]);
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1 $2-$3')
                ->setLeadingDigitsPattern(['11'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{4})(\d{2})(\d{4})')
                ->setFormat('$1 $2-$3')
                ->setLeadingDigitsPattern(['1[02-9]|[23]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{2})(\d{4})(\d{4})')
                ->setFormat('$2 15 $3-$4')
                ->setLeadingDigitsPattern(['911'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{4})(\d{2})(\d{4})')
                ->setFormat('$2 $3-$4')
                ->setLeadingDigitsPattern(['9(?:1[02-9]|[23])'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setDomesticCarrierCodeFormattingRule('0$1 $CC')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['[68]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('80\d{8}')
            ->setExampleNumber('8034567890')
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
                ->setPattern('(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1 $2-$3')
                ->setLeadingDigitsPattern(['11'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{4})(\d{2})(\d{4})')
                ->setFormat('$1 $2-$3')
                ->setLeadingDigitsPattern(['1[02-9]|[23]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1 $2 $3 $4')
                ->setLeadingDigitsPattern(['911']),
            (new NumberFormat())
                ->setPattern('(\d)(\d{4})(\d{2})(\d{4})')
                ->setFormat('$1 $2 $3 $4')
                ->setLeadingDigitsPattern(['9(?:1[02-9]|[23])']),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['[68]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
    }
}
