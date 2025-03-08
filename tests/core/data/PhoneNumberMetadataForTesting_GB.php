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
        'NationalNumberPattern' => '\\d{10}',
        'PossibleLength' => [
            9,
            10,
        ],
        'PossibleLengthLocalOnly' => [
            6,
            7,
            8,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '[1-6]\\d{9}',
        'ExampleNumber' => '3123456789',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [
            6,
            7,
            8,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '7[1-57-9]\\d{8}',
        'ExampleNumber' => '7123456789',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '80\\d{8}',
        'ExampleNumber' => '8023456789',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '9[018]\\d{8}',
        'ExampleNumber' => '9023456789',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'sharedCost' => [
        'NationalNumberPattern' => '8(?:4[3-5]|7[0-2])\\d{7}',
        'ExampleNumber' => '8433456789',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'personalNumber' => [
        'NationalNumberPattern' => '70\\d{8}',
        'ExampleNumber' => '7033456789',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'voip' => [
        'NationalNumberPattern' => '56\\d{8}',
        'ExampleNumber' => '5633456789',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'pager' => [
        'NationalNumberPattern' => '76\\d{8}',
        'ExampleNumber' => '7623456789',
        'PossibleLength' => [
            10,
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
    'id' => 'GB',
    'countryCode' => 44,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{2})(\\d{4})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[1-59]|[78]0',
            ],
            'nationalPrefixFormattingRule' => '(0$1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d)(\\d{3})(\\d{3})(\\d{3})',
            'format' => '$1 $2 $3 $4',
            'leadingDigitsPatterns' => [
                '6',
            ],
            'nationalPrefixFormattingRule' => '(0$1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{4})(\\d{3})(\\d{3})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '7[1-57-9]',
            ],
            'nationalPrefixFormattingRule' => '(0$1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '8[47]',
            ],
            'nationalPrefixFormattingRule' => '(0$1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => true,
];
