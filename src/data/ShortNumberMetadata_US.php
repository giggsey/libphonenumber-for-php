<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[1-9]\\d{2,5}',
        'PossibleLength' => [
            3,
            4,
            5,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '112|611|9(?:11|33|88)',
        'ExampleNumber' => '112',
        'PossibleLength' => [
            3,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '24280|(?:381|968)35|4(?:3355|7553|8221)|5(?:(?:489|934)2|5928)|72078|(?:323|960)40|(?:276|414)63|(?:2(?:520|744)|7390|9968)9|(?:693|732|976)88|(?:3(?:556|825)|5294|8623|9729)4|(?:3378|4136|7642|8961|9979)6|(?:4(?:6(?:15|32)|827)|(?:591|720)8|9529)7',
        'ExampleNumber' => '24280',
        'PossibleLength' => [
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '112|911',
        'ExampleNumber' => '112',
        'PossibleLength' => [
            3,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '11(?:2|5[1-47]|[68]\\d|7[0-57]|98)|[2-9]\\d{3,5}|[2-8]11|9(?:11|33|88)',
        'ExampleNumber' => '112',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'standardRate' => [
        'NationalNumberPattern' => '2(?:3333|(?:4224|7562|900)2|56447|6688)|3(?:1010|2665|7404)|40404|560560|6(?:0060|22639|5246|7622)|7(?:0701|3822|4666)|8(?:(?:3825|7226)5|4816)|99099',
        'ExampleNumber' => '23333',
        'PossibleLength' => [
            5,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'carrierSpecific' => [
        'NationalNumberPattern' => '336\\d\\d|[2-9]\\d{3}|[2356]11',
        'ExampleNumber' => '211',
        'PossibleLength' => [
            3,
            4,
            5,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'smsServices' => [
        'NationalNumberPattern' => '[2-9]\\d{4,5}',
        'ExampleNumber' => '20000',
        'PossibleLength' => [
            5,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'US',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
