<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[189]\\d{2,5}',
        'PossibleLength' => [
            3,
            4,
            5,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1(?:0[1-3]|1(?:2|6\\d{3}))',
        'ExampleNumber' => '101',
        'PossibleLength' => [
            3,
            6,
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
        'NationalNumberPattern' => '1(?:0[1-49]|1(?:2|6(?:000|1(?:11|23))|8\\d\\d?)|(?:[278]|5\\d)\\d)|[89]00\\d\\d?|151|1(?:06|4\\d|6)\\d\\d',
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
        'NationalNumberPattern' => '(?:118|[89]00)\\d\\d?',
        'ExampleNumber' => '1180',
        'PossibleLength' => [
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'UA',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
