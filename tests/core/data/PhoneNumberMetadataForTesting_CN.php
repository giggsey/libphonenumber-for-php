<?php
/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[1-7]\\d{6,11}|8[0-357-9]\\d{6,9}|9\\d{7,10}',
        'PossibleLength' => [
            11,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '[2-9]\\d{10}',
        'ExampleNumber' => '91234567',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'mobile' => [
        'NationalNumberPattern' => '1(?:[38]\\d|4[57]|5[0-35-9]|7[0136-8])\\d{8}',
        'ExampleNumber' => '13123456789',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
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
    'id' => 'CN',
    'countryCode' => 86,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{3})(\\d{5,6})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[3-9]',
                '[3-9]\\d{2}[19]',
                '[3-9]\\d{2}(?:10|95)',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '$CC $1',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{8})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '1',
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
