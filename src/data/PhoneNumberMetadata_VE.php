<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[68]00\\d{7}|(?:[24]\\d|[59]0)\\d{8}',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [
            7,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '(?:2(?:12|3[457-9]|[467]\\d|[58][1-9]|9[1-6])|[4-6]00)\\d{7}',
        'ExampleNumber' => '2121234567',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [
            7,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '4(?:1[24-8]|2[46])\\d{7}',
        'ExampleNumber' => '4121234567',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '800\\d{7}',
        'ExampleNumber' => '8001234567',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '90[01]\\d{7}',
        'ExampleNumber' => '9001234567',
        'PossibleLength' => [],
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
        'NationalNumberPattern' => '501\\d{7}',
        'ExampleNumber' => '5010123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [
            7,
        ],
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
    'id' => 'VE',
    'countryCode' => 58,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{3})(\\d{7})',
            'format' => '$1-$2',
            'leadingDigitsPatterns' => [
                '[24-689]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '$CC $1',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
