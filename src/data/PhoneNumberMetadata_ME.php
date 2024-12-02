<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '(?:20|[3-79]\\d)\\d{6}|80\\d{6,7}',
        'PossibleLength' => [
            8,
            9,
        ],
        'PossibleLengthLocalOnly' => [
            6,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '(?:20[2-8]|3(?:[0-2][2-7]|3[24-7])|4(?:0[2-467]|1[2467])|5(?:0[2467]|1[24-7]|2[2-467]))\\d{5}',
        'ExampleNumber' => '30234567',
        'PossibleLength' => [
            8,
        ],
        'PossibleLengthLocalOnly' => [
            6,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '6(?:[07-9]\\d|3[024]|6[0-25])\\d{5}',
        'ExampleNumber' => '67622901',
        'PossibleLength' => [
            8,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '80(?:[0-2578]|9\\d)\\d{5}',
        'ExampleNumber' => '80080002',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '9(?:4[1568]|5[178])\\d{5}',
        'ExampleNumber' => '94515151',
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
        'NationalNumberPattern' => '78[1-49]\\d{5}',
        'ExampleNumber' => '78108780',
        'PossibleLength' => [
            8,
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
        'NationalNumberPattern' => '77[1-9]\\d{5}',
        'ExampleNumber' => '77273012',
        'PossibleLength' => [
            8,
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
    'id' => 'ME',
    'countryCode' => 382,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{2})(\\d{3})(\\d{3,4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[2-9]',
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
