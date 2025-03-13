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
class PhoneNumberMetadataForTesting_NZ extends PhoneMetadata
{
    protected const ID = 'NZ';
    protected const COUNTRY_CODE = 64;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0';
    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[289]\d{7,9}|[3-7]\d{7}')
            ->setPossibleLength([7, 8, 9, 10]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('2(?:[027]\d{7}|9\d{6,7}|1(?:0\d{5,7}|[12]\d{5,6}|[3-9]\d{5})|4[1-9]\d{6}|8\d{7,8})')
            ->setExampleNumber('201234567')
            ->setPossibleLength([8, 9, 10]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('900\d{6,7}')
            ->setExampleNumber('9001234567')
            ->setPossibleLength([9, 10]);
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('24099\d{3}|(?:3[2-79]|[479][2-689]|6[235-9])\d{6}')
            ->setExampleNumber('24099123')
            ->setPossibleLength([7, 8]);
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{4})')
                ->setFormat('$1-$2 $3')
                ->setLeadingDigitsPattern(['24|[34679]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{3,5})')
                ->setFormat('$1-$2 $3')
                ->setLeadingDigitsPattern(['2[179]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{3,4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[89]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('800\d{6,7}')
            ->setExampleNumber('8001234567')
            ->setPossibleLength([9, 10]);
        $this->sharedCost = PhoneNumberDesc::empty();
        $this->personalNumber = PhoneNumberDesc::empty();
        $this->voip = PhoneNumberDesc::empty();
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
