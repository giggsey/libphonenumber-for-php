<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[1-9]\\d{9,10}',
        'PossibleLength' => [
            10,
            11,
        ],
        'PossibleLengthLocalOnly' => [
            7,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '[2-9]\\d{9}',
        'ExampleNumber' => '2123456789',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [
            7,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '1\\d{10}',
        'ExampleNumber' => '11234567890',
        'PossibleLength' => [
            11,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '800\\d{7}',
        'ExampleNumber' => '8001234567',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '900\\d{7}',
        'ExampleNumber' => '9001234567',
        'PossibleLength' => [
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
    'id' => 'MX',
    'countryCode' => 52,
    'internationalPrefix' => '00',
    'nationalPrefix' => '01',
    'nationalPrefixForParsing' => '01|04[45](\\d{10})',
    'nationalPrefixTransformRule' => '1$1',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[89]00',
            ],
            'nationalPrefixFormattingRule' => '01 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d{3})(\\d{2})(\\d{5})',
            'format' => '$2 $3',
            'leadingDigitsPatterns' => [
                '901',
            ],
            'nationalPrefixFormattingRule' => '01 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d{2})(\\d{4})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '33|55|81',
            ],
            'nationalPrefixFormattingRule' => '01 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[2467]|3[0-24-9]|5[0-46-9]|8[2-9]|9[1-9]',
            ],
            'nationalPrefixFormattingRule' => '01 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d)(\\d{2})(\\d{4})(\\d{4})',
            'format' => '045 $2 $3 $4',
            'leadingDigitsPatterns' => [
                '1(?:33|55|81)',
            ],
            'nationalPrefixFormattingRule' => '$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d)(\\d{3})(\\d{3})(\\d{4})',
            'format' => '045 $2 $3 $4',
            'leadingDigitsPatterns' => [
                '1(?:[124579]|3[0-24-9]|5[0-46-9]|8[02-9])',
            ],
            'nationalPrefixFormattingRule' => '$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
    ],
    'intlNumberFormat' => [
        [
            'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[89]00',
            ],
            'nationalPrefixFormattingRule' => '01 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d{3})(\\d{2})(\\d{5})',
            'format' => '$2 $3',
            'leadingDigitsPatterns' => [
                '901',
            ],
        ],
        [
            'pattern' => '(\\d{2})(\\d{4})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '33|55|81',
            ],
            'nationalPrefixFormattingRule' => '01 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[2467]|3[0-24-9]|5[0-46-9]|8[2-9]|9[1-9]',
            ],
            'nationalPrefixFormattingRule' => '01 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d)(\\d{2})(\\d{4})(\\d{4})',
            'format' => '$1 $2 $3 $4',
            'leadingDigitsPatterns' => [
                '1(?:33|55|81)',
            ],
        ],
        [
            'pattern' => '(\\d)(\\d{3})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3 $4',
            'leadingDigitsPatterns' => [
                '1(?:[124579]|3[0-24-9]|5[0-46-9]|8[02-9])',
            ],
        ],
    ],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
