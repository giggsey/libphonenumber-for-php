<?php

declare(strict_types=1);
/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '1\\d{2,3}',
        'PossibleLength' => [
            3,
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1(?:1(?:00|2[03]|3[3479]|7[67]|9[0246])|578|6(?:44|6[79]|88|9[16])|88\\d|9[19])|1[15]55',
        'ExampleNumber' => '191',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '1(?:113|2[23]\\d|5(?:09|56))',
        'ExampleNumber' => '1113',
        'PossibleLength' => [
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '1(?:669|9[19])',
        'ExampleNumber' => '191',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '1(?:0[0-2]|1(?:0[03]|1[1-35]|2[0358]|3[03-79]|4[02-489]|5[04-9]|6[04-79]|7[03-9]|8[027-9]|9[02-9])|2(?:22|3[89]|66)|3(?:18|2[23]|3[013]|5[56]|6[45]|73)|477|5(?:0\\d|4[0-37-9]|5[1-8]|6[01679]|7[12568]|8[0-24589]|9[013589])|6(?:0[0-29]|2[03]|4[3-6]|6[1-9]|7[0257-9]|8[0158]|9[014-9])|7(?:[14]9|7[27]|90)|888|9[19])',
        'ExampleNumber' => '100',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'standardRate' => [
        'NationalNumberPattern' => '1(?:1(?:03|1[15]|2[58]|3[056]|4[02-49]|5[046-9]|7[03-589]|9[57-9])|5(?:0[0-8]|4[0-378]|5[1-478]|7[156])|6(?:20|4[356]|6[1-68]|7[057-9]|8[015]|9[0457-9]))|1(?:1[68]|26|3[1-35]|5[689]|60|7[17])\\d',
        'ExampleNumber' => '1103',
        'PossibleLength' => [
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'carrierSpecific' => [
        'NationalNumberPattern' => '114[89]',
        'ExampleNumber' => '1148',
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
    'id' => 'TH',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
];
