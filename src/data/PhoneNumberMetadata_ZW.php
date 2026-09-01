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
class PhoneNumberMetadata_ZW extends PhoneMetadata
{
    protected const ID = 'ZW';
    protected const COUNTRY_CODE = 263;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0';
    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('(?:13|8\d{4})\d{5}|[235-8]\d{8}|[2-689]\d{6}')
            ->setPossibleLengthLocalOnly([3, 4, 5, 6])
            ->setPossibleLength([7, 9, 10]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('7(?:[1278]\d|3[1-9]|9[01])\d{6}')
            ->setExampleNumber('712345678')
            ->setPossibleLength([9]);
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('(?:2(?:(?:(?:02[014]|72[03])\d|48)\d|2(?:[278]\d|92)|583)|(?:37[56]|6[78]21\d)\d|5(?:483|525\d\d))\d{3}|(?:2(?:0\d|7[1-7])|(?:55|6[78])\d)\d{4}|(?:13|2(?:(?:42|9\d)\d|[56]20)|3(?:123|92\d)|(?:4|542)\d|6(?:[16]21|52[013])|8(?:[1349]28|523)|9[2-9])\d{5}')
            ->setExampleNumber('1312345')
            ->setPossibleLengthLocalOnly([3, 4, 5, 6])
            ->setPossibleLength([7, 9]);
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{3,5})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['1|2(?:0[0-36-9]|29|58)|67[0-46-9]|(?:55|68)[0-69]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3,5})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['2(?:0[45]|[27]|48)|37|675|(?:55|68)[78]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{2,4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[49]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{4})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['80'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{4})(\d{3,5})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['548'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{3})(\d{3,4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['29[013-9]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{7})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['[256]|39|8[13-59]'])
                ->setNationalPrefixFormattingRule('(0$1)')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{3})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['7'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{3,4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['3'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{4})(\d{6})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['8'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('80(?:[01]\d|20|8[0-8])\d{3}')
            ->setExampleNumber('8001234')
            ->setPossibleLength([7]);
        $this->sharedCost = PhoneNumberDesc::empty();
        $this->personalNumber = PhoneNumberDesc::empty();
        $this->voip = (new PhoneNumberDesc())
            ->setNationalNumberPattern('86(?:1[12]|22|30|44|55|77|8[368])\d{6}')
            ->setExampleNumber('8686123456')
            ->setPossibleLength([10]);
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
