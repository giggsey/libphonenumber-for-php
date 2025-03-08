<?php

declare(strict_types=1);

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[289]\\d{7,9}|[3-7]\\d{7}',
        'PossibleLength' => [
            7,
            8,
            9,
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '24099\\d{3}|(?:3[2-79]|[479][2-689]|6[235-9])\\d{6}',
        'ExampleNumber' => '24099123',
        'PossibleLength' => [
            7,
            8,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'mobile' => [
        'NationalNumberPattern' => '2(?:[027]\\d{7}|9\\d{6,7}|1(?:0\\d{5,7}|[12]\\d{5,6}|[3-9]\\d{5})|4[1-9]\\d{6}|8\\d{7,8})',
        'ExampleNumber' => '201234567',
        'PossibleLength' => [
            8,
            9,
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '800\\d{6,7}',
        'ExampleNumber' => '8001234567',
        'PossibleLength' => [
            9,
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '900\\d{6,7}',
        'ExampleNumber' => '9001234567',
        'PossibleLength' => [
            9,
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'sharedCost' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'personalNumber' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'voip' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'pager' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'uan' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'voicemail' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'noInternationalDialling' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'NZ',
    'countryCode' => 64,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d)(\\d{3})(\\d{4})',
            'format' => '$1-$2 $3',
            'leadingDigitsPatterns' => [
                '24|[34679]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d)(\\d{3})(\\d{3,5})',
            'format' => '$1-$2 $3',
            'leadingDigitsPatterns' => [
                '2[179]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{3})(\\d{3,4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[89]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
