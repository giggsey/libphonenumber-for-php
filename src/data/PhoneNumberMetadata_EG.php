<?php

declare(strict_types=1);
/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[189]\\d{8,9}|[24-6]\\d{8}|[135]\\d{7}',
        'PossibleLength' => [
            8,
            9,
            10,
        ],
        'PossibleLengthLocalOnly' => [
            6,
            7,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '13[23]\\d{6}|(?:15|57)\\d{6,7}|(?:2\\d|3|4[05-8]|5[05]|6[24-689]|8[2468]|9[235-7])\\d{7}',
        'ExampleNumber' => '234567890',
        'PossibleLength' => [
            8,
            9,
        ],
        'PossibleLengthLocalOnly' => [
            6,
            7,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '1[0-25]\\d{8}',
        'ExampleNumber' => '1001234567',
        'PossibleLength' => [
            10,
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
    'id' => 'EG',
    'countryCode' => 20,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'numberFormat' => [
        [
            'pattern' => '(\\d)(\\d{7,8})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[23]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{6,7})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '1[35]|[4-6]|8[2468]|9[235-7]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[89]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{8})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '1',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => true,
];
