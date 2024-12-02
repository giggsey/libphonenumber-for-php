<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '\\d{4,14}',
        'PossibleLength' => [
            4,
            5,
            6,
            7,
            8,
            9,
            10,
            11,
        ],
        'PossibleLengthLocalOnly' => [
            2,
            3,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '(?:[24-6]\\d{2}|3[03-9]\\d|[789](?:0[2-9]|[1-9]\\d))\\d{1,8}',
        'ExampleNumber' => '30123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [
            2,
            3,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '1(5\\d{9}|7\\d{8}|6[02]\\d{8}|63\\d{7})',
        'ExampleNumber' => '15123456789',
        'PossibleLength' => [
            10,
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
        'NationalNumberPattern' => '900([135]\\d{6}|9\\d{7})',
        'ExampleNumber' => '9001234567',
        'PossibleLength' => [
            10,
            11,
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
    'id' => 'DE',
    'countryCode' => 49,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{3})(\\d{3,8})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '2|3[3-9]|906|[4-9][1-9]1',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{4,11})',
            'format' => '$1/$2',
            'leadingDigitsPatterns' => [
                '[34]0|[68]9',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{2})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[4-9]',
                '[4-6]|[7-9](?:\\d[1-9]|[1-9]\\d)',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{4})(\\d{2,7})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[4-9]',
                '[4-6]|[7-9](?:\\d[1-9]|[1-9]\\d)',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{1})(\\d{6})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '800',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{3,4})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '900',
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
