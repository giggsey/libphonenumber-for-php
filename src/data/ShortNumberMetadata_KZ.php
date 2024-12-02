<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[1-4]\\d{2,4}',
        'PossibleLength' => [
            3,
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1(?:0[1-3]|12)|212\\d',
        'ExampleNumber' => '101',
        'PossibleLength' => [
            3,
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '1(?:0[1-3]|12)',
        'ExampleNumber' => '101',
        'PossibleLength' => [
            3,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '1(?:0[1-4]|12)|2121|(?:3040|404)0',
        'ExampleNumber' => '101',
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
        'NationalNumberPattern' => '(?:304\\d|404)\\d',
        'ExampleNumber' => '4040',
        'PossibleLength' => [
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'NationalNumberPattern' => '(?:304\\d|404)\\d',
        'ExampleNumber' => '4040',
        'PossibleLength' => [
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'KZ',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
