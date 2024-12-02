<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[14]\\d{2,6}',
        'PossibleLength' => [
            3,
            4,
            5,
            6,
            7,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1(?:1(?:[2358]|6\\d{3})|87)',
        'ExampleNumber' => '112',
        'PossibleLength' => [
            3,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '(?:12|4(?:[478](?:[0-4]|[5-9]\\d\\d)|55))\\d\\d',
        'ExampleNumber' => '1200',
        'PossibleLength' => [
            4,
            5,
            7,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '11[2358]',
        'ExampleNumber' => '112',
        'PossibleLength' => [
            3,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '1(?:0\\d{2,3}|1(?:[2-57-9]|6(?:000|111))|3[39]|4(?:82|9\\d{1,3})|5(?:00|1[58]|2[25]|3[03]|44|[59])|60|8[67]|9(?:[01]|2[2-9]|4\\d|696))|4(?:2323|5045)|(?:1(?:2|92[01])|4(?:3(?:[01]|[45]\\d\\d)|[478](?:[0-4]|[5-9]\\d\\d)|55))\\d\\d',
        'ExampleNumber' => '112',
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
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'NationalNumberPattern' => '4(?:3(?:[01]|[45]\\d\\d)|[478](?:[0-4]|[5-9]\\d\\d)|5[05])\\d\\d',
        'ExampleNumber' => '43000',
        'PossibleLength' => [
            5,
            7,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'IT',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
