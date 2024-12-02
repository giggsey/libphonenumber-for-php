<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[13]\\d{5}',
        'PossibleLength' => [
            6,
        ],
        'PossibleLengthLocalOnly' => [
            5,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '(?:1(?:06|17|28|39)|3[0-2]\\d)\\d{3}',
        'ExampleNumber' => '106609',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [
            5,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '(?:14|3[58])\\d{4}',
        'ExampleNumber' => '381234',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [
            5,
        ],
    ],
    'tollFree' => [
        'PossibleLength' => [
            -1,
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
    'id' => 'NF',
    'countryCode' => 672,
    'internationalPrefix' => '00',
    'nationalPrefixForParsing' => '([0-258]\\d{4})$',
    'nationalPrefixTransformRule' => '3$1',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{2})(\\d{4})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '1[0-3]',
            ],
            'nationalPrefixFormattingRule' => '',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d)(\\d{5})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[13]',
            ],
            'nationalPrefixFormattingRule' => '',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
