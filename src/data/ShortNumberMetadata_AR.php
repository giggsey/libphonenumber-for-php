<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[01389]\\d{1,4}',
        'PossibleLength' => [
            2,
            3,
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '000|1(?:0[0-35-7]|1[0245]|2[015]|3[47]|4[478]|9)|911',
        'ExampleNumber' => '19',
        'PossibleLength' => [
            2,
            3,
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
        'NationalNumberPattern' => '10[017]|911',
        'ExampleNumber' => '100',
        'PossibleLength' => [
            3,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '000|1(?:0[0-35-7]|1[02-5]|2[015]|3[47]|4[478]|9)|3372|89338|911',
        'ExampleNumber' => '19',
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
        'NationalNumberPattern' => '893\\d\\d',
        'ExampleNumber' => '89300',
        'PossibleLength' => [
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'NationalNumberPattern' => '(?:337|893\\d)\\d',
        'ExampleNumber' => '3370',
        'PossibleLength' => [
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'AR',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
