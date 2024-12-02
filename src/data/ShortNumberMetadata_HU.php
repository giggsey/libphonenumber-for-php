<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '1\\d{2,5}',
        'PossibleLength' => [
            3,
            4,
            5,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1(?:0[457]|12|4[0-4]\\d)|1(?:16\\d|37|45)\\d\\d',
        'ExampleNumber' => '104',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '1(?:0[457]|12)',
        'ExampleNumber' => '104',
        'PossibleLength' => [
            3,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '1(?:0[457]|1(?:2|6(?:000|1(?:11|23))|800)|2(?:0[0-4]|1[013489]|2[0-5]|3[0-46]|4[0-24-68]|5[0-2568]|6[06]|7[0-25-7]|8[028]|9[08])|37(?:00|37|7[07])|4(?:0[0-5]|1[013-8]|2[034]|3[23]|4[02-9]|5(?:00|41|67))|777|8(?:1[27-9]|2[04]|40|[589]))',
        'ExampleNumber' => '104',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'standardRate' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'carrierSpecific' => [
        'NationalNumberPattern' => '1(?:4[0-4]|77)\\d|1(?:18|2|45)\\d\\d',
        'ExampleNumber' => '1200',
        'PossibleLength' => [
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'NationalNumberPattern' => '184\\d',
        'ExampleNumber' => '1840',
        'PossibleLength' => [
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'HU',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
