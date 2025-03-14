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
        'NationalNumberPattern' => '[6-9]\\d{6}|[1-6]\\d{4}',
        'PossibleLength' => [
            5,
            7,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '(?:1[4-79]|[23]\\d|4[0-2]|5[03]|6[0-37])\\d{3}',
        'ExampleNumber' => '40123',
        'PossibleLength' => [
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'mobile' => [
        'NationalNumberPattern' => '48\\d{3}|(?:(?:6[89]|7[1-9]|8[4-9])\\d|9(?:1[2-9]|2[013-9]|3[0-2]|[46]\\d|5[0-46-9]|7[0-689]|8[0-79]|9[0-8]))\\d{4}',
        'ExampleNumber' => '7421234',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1[38]\\d{3}',
        'ExampleNumber' => '18123',
        'PossibleLength' => [
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'PossibleLength' => [
            -1,
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
        'NationalNumberPattern' => '5[12]\\d{3}',
        'ExampleNumber' => '51123',
        'PossibleLength' => [
            5,
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
    'id' => 'SB',
    'countryCode' => 677,
    'internationalPrefix' => '0[01]',
    'numberFormat' => [
        [
            'pattern' => '(\\d{2})(\\d{5})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '6[89]|7|8[4-9]|9(?:[1-8]|9[0-8])',
            ],
            'nationalPrefixFormattingRule' => '',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
];
