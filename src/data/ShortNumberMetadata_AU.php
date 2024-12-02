<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[0-27]\\d{2,7}',
        'PossibleLength' => [
            3,
            4,
            5,
            6,
            7,
            8,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '000|1(?:06|12|258885|55\\d)|733',
        'ExampleNumber' => '000',
        'PossibleLength' => [
            3,
            4,
            7,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '1(?:2(?:34|456)|9\\d{4,6})',
        'ExampleNumber' => '1234',
        'PossibleLength' => [
            4,
            5,
            6,
            7,
            8,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '000|1(?:06|12)',
        'ExampleNumber' => '000',
        'PossibleLength' => [
            3,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '000|1(?:06|1(?:00|2|9[46])|2(?:014[1-3]|[23]\\d|(?:4|5\\d)\\d{2,3}|68[689]|72(?:20|3\\d\\d)|8(?:[013-9]\\d|2))|555|9\\d{4,6})|225|7(?:33|67)',
        'ExampleNumber' => '000',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'standardRate' => [
        'NationalNumberPattern' => '1(?:1[09]\\d|24733)|225|767',
        'ExampleNumber' => '225',
        'PossibleLength' => [
            3,
            4,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'carrierSpecific' => [
        'NationalNumberPattern' => '1(?:258885|55\\d)',
        'ExampleNumber' => '1550',
        'PossibleLength' => [
            4,
            7,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'NationalNumberPattern' => '19\\d{4,6}',
        'ExampleNumber' => '190000',
        'PossibleLength' => [
            6,
            7,
            8,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'AU',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
