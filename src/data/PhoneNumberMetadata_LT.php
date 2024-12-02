<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '(?:[3469]\\d|52|[78]0)\\d{6}',
        'PossibleLength' => [
            8,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '(?:3[1478]|4[124-6]|52)\\d{6}',
        'ExampleNumber' => '31234567',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'mobile' => [
        'NationalNumberPattern' => '6\\d{7}',
        'ExampleNumber' => '61234567',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '80[02]\\d{5}',
        'ExampleNumber' => '80012345',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '9(?:0[0239]|10)\\d{5}',
        'ExampleNumber' => '90012345',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'sharedCost' => [
        'NationalNumberPattern' => '808\\d{5}',
        'ExampleNumber' => '80812345',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'personalNumber' => [
        'NationalNumberPattern' => '70[05]\\d{5}',
        'ExampleNumber' => '70012345',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'voip' => [
        'NationalNumberPattern' => '[89]01\\d{5}',
        'ExampleNumber' => '80123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'pager' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'uan' => [
        'NationalNumberPattern' => '70[67]\\d{5}',
        'ExampleNumber' => '70712345',
        'PossibleLength' => [],
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
    'id' => 'LT',
    'countryCode' => 370,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '[08]',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d)(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '52[0-7]',
            ],
            'nationalPrefixFormattingRule' => '(0-$1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d{3})(\\d{2})(\\d{3})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '[7-9]',
            ],
            'nationalPrefixFormattingRule' => '0 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d{2})(\\d{6})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '37|4(?:[15]|6[1-8])',
            ],
            'nationalPrefixFormattingRule' => '(0-$1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
        [
            'pattern' => '(\\d{3})(\\d{5})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[3-6]',
            ],
            'nationalPrefixFormattingRule' => '(0-$1)',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => true,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => true,
];
