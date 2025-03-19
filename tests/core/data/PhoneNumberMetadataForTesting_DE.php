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
class PhoneNumberMetadataForTesting_DE extends PhoneMetadata
{
    protected const ID = 'DE';
    protected const COUNTRY_CODE = 49;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0';
    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('\d{4,14}')
            ->setPossibleLengthLocalOnly([2, 3])
            ->setPossibleLength([4, 5, 6, 7, 8, 9, 10, 11]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1(5\d{9}|7\d{8}|6[02]\d{8}|63\d{7})')
            ->setExampleNumber('15123456789')
            ->setPossibleLength([10, 11]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('900([135]\d{6}|9\d{7})')
            ->setExampleNumber('9001234567')
            ->setPossibleLength([10, 11]);
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('(?:[24-6]\d{2}|3[03-9]\d|[789](?:0[2-9]|[1-9]\d))\d{1,8}')
            ->setExampleNumber('30123456')
            ->setPossibleLengthLocalOnly([2, 3]);
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3,8})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['2|3[3-9]|906|[4-9][1-9]1'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{4,11})')
                ->setFormat('$1/$2')
                ->setLeadingDigitsPattern(['[34]0|[68]9'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{2})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['[4-9]', '[4-6]|[7-9](?:\d[1-9]|[1-9]\d)'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{4})(\d{2,7})')
                ->setFormat('$1 $2')
                ->setLeadingDigitsPattern(['[4-9]', '[4-6]|[7-9](?:\d[1-9]|[1-9]\d)'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{1})(\d{6})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['800'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3,4})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['900'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
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
    }
}
