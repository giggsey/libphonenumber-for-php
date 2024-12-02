<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[13]\\d(?:\\d\\d(?:\\d{2})?)?',
        'PossibleLength' => [
            2,
            4,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1[578]|3(?:0\\d|1[689])\\d',
        'ExampleNumber' => '15',
        'PossibleLength' => [
            2,
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '3[2469]\\d\\d',
        'ExampleNumber' => '3200',
        'PossibleLength' => [
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '1[578]',
        'ExampleNumber' => '15',
        'PossibleLength' => [
            2,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '1[578]|31(?:03|[689]\\d)|(?:118[02-9]|3[02469])\\d\\d',
        'ExampleNumber' => '15',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'standardRate' => [
        'NationalNumberPattern' => '118\\d{3}',
        'ExampleNumber' => '118000',
        'PossibleLength' => [
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'carrierSpecific' => [
        'NationalNumberPattern' => '310\\d',
        'ExampleNumber' => '3100',
        'PossibleLength' => [
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'PM',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
