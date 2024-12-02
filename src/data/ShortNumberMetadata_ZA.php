<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[134]\\d{2,4}',
        'PossibleLength' => [
            3,
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1(?:01\\d\\d|12)',
        'ExampleNumber' => '112',
        'PossibleLength' => [
            3,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '41(?:348|851)',
        'ExampleNumber' => '41348',
        'PossibleLength' => [
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '1(?:01(?:11|77)|12)',
        'ExampleNumber' => '112',
        'PossibleLength' => [
            3,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '1(?:0(?:1(?:11|77)|20|7)|1[12]|77(?:3[237]|[45]7|6[279]|9[26]))|[34]\\d{4}',
        'ExampleNumber' => '107',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'standardRate' => [
        'NationalNumberPattern' => '3(?:078[23]|7(?:064|567)|8126)|4(?:394[16]|7751|8837)|4[23]699',
        'ExampleNumber' => '30782',
        'PossibleLength' => [
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'carrierSpecific' => [
        'NationalNumberPattern' => '111',
        'ExampleNumber' => '111',
        'PossibleLength' => [
            3,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'NationalNumberPattern' => '[34]\\d{4}',
        'ExampleNumber' => '30000',
        'PossibleLength' => [
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'ZA',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
