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
class PhoneNumberMetadataForTesting_GB extends PhoneMetadata
{
    protected const ID = 'GB';
    protected const COUNTRY_CODE = 44;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0';
    protected ?string $internationalPrefix = '00';
    protected bool $mobileNumberPortableRegion = true;

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('\d{10}')
            ->setPossibleLengthLocalOnly([6, 7, 8])
            ->setPossibleLength([9, 10]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('7[1-57-9]\d{8}')
            ->setExampleNumber('7123456789')
            ->setPossibleLength([10]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('9[018]\d{8}')
            ->setExampleNumber('9023456789')
            ->setPossibleLength([10]);
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1-6]\d{9}')
            ->setExampleNumber('3123456789')
            ->setPossibleLengthLocalOnly([6, 7, 8]);
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['[1-59]|[78]0'])
                ->setNationalPrefixFormattingRule('(0$1)')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{3})(\d{3})')
                ->setFormat('$1 $2 $3 $4')
                ->setLeadingDigitsPattern(['6'])
                ->setNationalPrefixFormattingRule('(0$1)')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{4})(\d{3})(\d{3})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['7[1-57-9]'])
                ->setNationalPrefixFormattingRule('(0$1)')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1 $2 $3')
                ->setLeadingDigitsPattern(['8[47]'])
                ->setNationalPrefixFormattingRule('(0$1)')
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('80\d{8}')
            ->setExampleNumber('8023456789')
            ->setPossibleLength([10]);
        $this->sharedCost = (new PhoneNumberDesc())
            ->setNationalNumberPattern('8(?:4[3-5]|7[0-2])\d{7}')
            ->setExampleNumber('8433456789')
            ->setPossibleLength([10]);
        $this->personalNumber = (new PhoneNumberDesc())
            ->setNationalNumberPattern('70\d{8}')
            ->setExampleNumber('7033456789')
            ->setPossibleLength([10]);
        $this->voip = (new PhoneNumberDesc())
            ->setNationalNumberPattern('56\d{8}')
            ->setExampleNumber('5633456789')
            ->setPossibleLength([10]);
        $this->pager = (new PhoneNumberDesc())
            ->setNationalNumberPattern('76\d{8}')
            ->setExampleNumber('7623456789')
            ->setPossibleLength([10]);
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
