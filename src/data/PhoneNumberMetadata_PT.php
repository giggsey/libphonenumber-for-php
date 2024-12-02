<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '1693\\d{5}|(?:[26-9]\\d|30)\\d{7}',
        'PossibleLength' => [
            9,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '2(?:[12]\\d|3[1-689]|4[1-59]|[57][1-9]|6[1-35689]|8[1-69]|9[1256])\\d{6}',
        'ExampleNumber' => '212345678',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'mobile' => [
        'NationalNumberPattern' => '6(?:[06]92(?:30|9\\d)|[35]92(?:[049]\\d|3[034]))\\d{3}|(?:(?:16|6[0356])93|9(?:[1-36]\\d\\d|480))\\d{5}',
        'ExampleNumber' => '912345678',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '80[02]\\d{6}',
        'ExampleNumber' => '800123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '(?:6(?:0[178]|4[68])\\d|76(?:0[1-57]|1[2-47]|2[237]))\\d{5}',
        'ExampleNumber' => '760123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'sharedCost' => [
        'NationalNumberPattern' => '80(?:8\\d|9[1579])\\d{5}',
        'ExampleNumber' => '808123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'personalNumber' => [
        'NationalNumberPattern' => '884[0-4689]\\d{5}',
        'ExampleNumber' => '884123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'voip' => [
        'NationalNumberPattern' => '30\\d{7}',
        'ExampleNumber' => '301234567',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'pager' => [
        'NationalNumberPattern' => '6(?:222\\d|8988)\\d{4}',
        'ExampleNumber' => '622212345',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'uan' => [
        'NationalNumberPattern' => '70(?:38[01]|596|(?:7\\d|8[17])\\d)\\d{4}',
        'ExampleNumber' => '707123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'voicemail' => [
        'NationalNumberPattern' => '600\\d{6}|6[06]92(?:0\\d|3[349]|49)\\d{3}',
        'ExampleNumber' => '600110000',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'noInternationalDialling' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'PT',
    'countryCode' => 351,
    'internationalPrefix' => '00',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{2})(\\d{3})(\\d{4})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '2[12]',
            ],
            'nationalPrefixFormattingRule' => '',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{3})(\\d{3})',
            'format' => '$1 $2 $3',
            'leadingDigitsPatterns' => [
                '16|[236-9]',
            ],
            'nationalPrefixFormattingRule' => '',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => true,
];
