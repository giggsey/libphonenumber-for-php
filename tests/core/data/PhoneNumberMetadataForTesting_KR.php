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
class PhoneNumberMetadataForTesting_KR extends PhoneMetadata
{
    protected const ID = 'KR';
    protected const COUNTRY_CODE = 82;
    protected const NATIONAL_PREFIX = '0';

    protected ?string $nationalPrefixForParsing = '0(8[1-46-8]|85\d{2})?';
    protected ?string $internationalPrefix = '00(?:[124-68]|[37]\d{2})';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[1-7]\d{3,9}|8\d{8}')
            ->setPossibleLength([4, 5, 6, 7, 8, 9, 10]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('1[0-25-9]\d{7,8}')
            ->setExampleNumber('1023456789')
            ->setPossibleLength([9, 10]);
        $this->premiumRate = (new PhoneNumberDesc())
            ->setNationalNumberPattern('60[2-9]\d{6}')
            ->setExampleNumber('602345678')
            ->setPossibleLength([9]);
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('(?:2|[34][1-3]|5[1-5]|6[1-4])(?:1\d{2,3}|[2-9]\d{6,7})')
            ->setExampleNumber('22123456');
        $this->numberFormat = [
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{4})(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['1(?:0|1[19]|[69]9|5[458])|[57]0', '1(?:0|1[19]|[69]9|5(?:44|59|8))|[57]0'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{3})(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['1(?:[169][2-8]|[78]|5[1-4])|[68]0|[3-6][1-9][2-9]', '1(?:[169][2-8]|[78]|5(?:[1-3]|4[56]))|[68]0|[3-6][1-9][2-9]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d)(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['131', '1312'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{2})(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['131', '131[13-9]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{3})(\d{3})(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['13[2-9]'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{2})(\d{3})(\d{4})')
                ->setFormat('$1-$2-$3-$4')
                ->setLeadingDigitsPattern(['30'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{4})(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['2(?:[26]|3[0-467])', '2(?:[26]|3(?:01|1[45]|2[17-9]|39|4|6[67]|7[078]))'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})(\d{4})')
                ->setFormat('$1-$2-$3')
                ->setLeadingDigitsPattern(['2(?:3[0-35-9]|[457-9])', '2(?:3(?:0[02-9]|1[0-36-9]|2[02-6]|3[0-8]|6[0-589]|7[1-69]|[589])|[457-9])'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{3})')
                ->setFormat('$1-$2')
                ->setLeadingDigitsPattern(['21[0-46-9]', '21(?:[0-247-9]|3[124]|6[1269])'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d)(\d{4})')
                ->setFormat('$1-$2')
                ->setLeadingDigitsPattern(['21[36]', '21(?:3[035-9]|6[03-578])'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{3})')
                ->setFormat('$1-$2')
                ->setLeadingDigitsPattern(['[3-6][1-9]1', '[3-6][1-9]1(?:[0-46-9])', '[3-6][1-9]1(?:[0-247-9]|3[124]|6[1269])'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
            (new NumberFormat())
                ->setPattern('(\d{2})(\d{4})')
                ->setFormat('$1-$2')
                ->setLeadingDigitsPattern(['[3-6][1-9]1', '[3-6][1-9]1[36]', '[3-6][1-9]1(?:3[035-9]|6[03-578])'])
                ->setNationalPrefixFormattingRule('0$1')
                ->setNationalPrefixOptionalWhenFormatting(false),
        ];
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('80\d{7}')
            ->setExampleNumber('801234567')
            ->setPossibleLength([9]);
        $this->sharedCost = PhoneNumberDesc::empty();
        $this->personalNumber = (new PhoneNumberDesc())
            ->setNationalNumberPattern('50\d{8}')
            ->setExampleNumber('5012345678')
            ->setPossibleLength([10]);
        $this->voip = (new PhoneNumberDesc())
            ->setNationalNumberPattern('70\d{8}')
            ->setExampleNumber('7012345678')
            ->setPossibleLength([10]);
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
