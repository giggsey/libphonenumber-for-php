<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[235-7]\\d{8}|[1-9]\\d{7}',
        'PossibleLength' => [
            8,
            9,
        ],
        'PossibleLengthLocalOnly' => [
            6,
            7,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '(?:1\\d|[27][2-9]|3[2-7]|4[24-9]|5[2-79]|6[23689]|8[2-57-9]|9[2-69])\\d{6}',
        'ExampleNumber' => '12345678',
        'PossibleLength' => [
            8,
        ],
        'PossibleLengthLocalOnly' => [
            6,
            7,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '(?:[257]0|3[01])\\d{7}',
        'ExampleNumber' => '201234567',
        'PossibleLength' => [
            9,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '(?:[48]0\\d|680[29])\\d{5}',
        'ExampleNumber' => '80123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '9[01]\\d{6}',
        'ExampleNumber' => '90123456',
        'PossibleLength' => [
            8,
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
        'NationalNumberPattern' => '21\\d{7}',
        'ExampleNumber' => '211234567',
        'PossibleLength' => [
            9,
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
        'NationalNumberPattern' => '38\\d{7}',
        'ExampleNumber' => '381234567',
        'PossibleLength' => [
            9,
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
        'NationalNumberPattern' => '(?:[48]0\\d|680[29])\\d{5}',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'HU',
    'countryCode' => 36,
    'internationalPrefix' => '00',
    'nationalPrefix' => '06',
    'nationalPrefixForParsing' => '06',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d)(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '1',
            ],
            'nationalPrefixFormattingRule' => '(06 $1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{3})(\\d{3})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[27][2-9]|3[2-7]|4[24-9]|5[2-79]|6|8[2-57-9]|9[2-69]',
            ],
            'nationalPrefixFormattingRule' => '(06 $1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{3})(\\d{3,4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[2-9]',
            ],
            'nationalPrefixFormattingRule' => '06 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => true,
];
