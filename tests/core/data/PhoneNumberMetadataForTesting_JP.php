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
        'NationalNumberPattern' => '07\\d{5}|[1-357-9]\\d{3,10}',
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
        'PossibleLengthLocalOnly' => [],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '07\\d{5}|[1-357-9]\\d{3,10}',
        'ExampleNumber' => '0712345',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'mobile' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '0777[01]\\d{2}',
        'ExampleNumber' => '0777012',
        'PossibleLength' => [
            7,
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
        'NationalNumberPattern' => '[23]\\d{3}',
        'ExampleNumber' => '2123',
        'PossibleLength' => [
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'JP',
    'countryCode' => 81,
    'internationalPrefix' => '010',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{2})(\\d{4})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[57-9]0',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{2})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3 $4',
            'leadingDigitsPatterns' => [
                '[57-9]0',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '111|222|333',
                '(?:111|222|333)1',
                '(?:111|222|333)11',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{4})(\\d)(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '222|333',
                '2221|3332',
                '22212|3332',
                '222120|3332',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{2})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[23]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{4})',
            'format' => '$1-$2',
            'leadingDigitsPatterns' => [
                '077',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{4})',
            'format' => '*$1',
            'leadingDigitsPatterns' => [
                '[23]',
            ],
            'nationalPrefixFormattingRule' => '$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
