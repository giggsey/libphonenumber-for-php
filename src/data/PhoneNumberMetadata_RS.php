<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '38[02-9]\\d{6,9}|6\\d{7,9}|90\\d{4,8}|38\\d{5,6}|(?:7\\d\\d|800)\\d{3,9}|(?:[12]\\d|3[0-79])\\d{5,10}',
        'PossibleLength' => [
            6,
            7,
            8,
            9,
            10,
            11,
            12,
        ],
        'PossibleLengthLocalOnly' => [
            4,
            5,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '(?:11[1-9]\\d|(?:2[389]|39)(?:0[2-9]|[2-9]\\d))\\d{3,8}|(?:1[02-9]|2[0-24-7]|3[0-8])[2-9]\\d{4,9}',
        'ExampleNumber' => '10234567',
        'PossibleLength' => [
            7,
            8,
            9,
            10,
            11,
            12,
        ],
        'PossibleLengthLocalOnly' => [
            4,
            5,
            6,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '6(?:[0-689]|7\\d)\\d{6,7}',
        'ExampleNumber' => '601234567',
        'PossibleLength' => [
            8,
            9,
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '800\\d{3,9}',
        'ExampleNumber' => '80012345',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '(?:78\\d|90[0169])\\d{3,7}',
        'ExampleNumber' => '90012345',
        'PossibleLength' => [
            6,
            7,
            8,
            9,
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
        'NationalNumberPattern' => '7[06]\\d{4,10}',
        'ExampleNumber' => '700123456',
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
    'id' => 'RS',
    'countryCode' => 381,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '0',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{3})(\\d{3,9})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '(?:2[389]|39)0|[7-9]',
            ],
            'nationalPrefixFormattingRule' => '0$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{5,10})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[1-36]',
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
