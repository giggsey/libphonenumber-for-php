<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[12578]\\d{2,8}',
        'PossibleLength' => [
            3,
            4,
            5,
            6,
            7,
            8,
            9,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '1(?:0[0-248]|1[289]|21|[39][89]|4[01]|6(?:1|6\\d?)|8[12])|777|800|1[05]5\\d|1(?:07|51|94)\\d\\d?|(?:1(?:[05]5\\d|70)\\d|261)\\d|1(?:0[369]|10|29|3[126]|9[0-256])\\d',
        'ExampleNumber' => '100',
        'PossibleLength' => [
            3,
            4,
            5,
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '11[67]\\d{4}|56161561',
        'ExampleNumber' => '1160000',
        'PossibleLength' => [
            7,
            8,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'emergency' => [
        'NationalNumberPattern' => '1(?:0[0-28]|12|298)|2611',
        'ExampleNumber' => '100',
        'PossibleLength' => [
            3,
            4,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'shortCode' => [
        'NationalNumberPattern' => '1(?:0(?:[0-248]|3[39]|5(?:010|6)|6[3468]|7(?:[01357]|[28]0?|4[01])|9[0135-9])|1(?:00|[289])|2(?:1|98)|3(?:11|2[0-2]|63|[89])|4[01]|5(?:1(?:0[0-36]|[127])|54)|6(?:1|6[01]?)|7000|8[12]|9(?:0[013-59]|12|25|4[4-9]\\d?|50|6[1347]|[89]))|2611|5(?:0(?:0(?:0\\d|1|20?)|325|5[2-79]\\d{3,5})|1(?:234|555|717|818|96[49])|2(?:0(?:0[01]|[14]0)|151|555|666|888|9(?:06|99\\d?))|3(?:0[01]0|131|553|(?:66|77)6)|(?:464|55[05])\\d{1,3}|6(?:070|3[68]|43)|717\\d)|777|800|5(?:05(?:0|1\\d)|221|3(?:03|3[23]))\\d{1,4}|5(?:(?:04|88)0|2(?:2[0267]|3[16])|4(?:1[04]|20|3[02])|5(?:3[16]|67)|6(?:06|[67]\\d)|787|9(?:64|90))\\d\\d?|(?:1(?:05[79]|(?:1[67][0-2]|802)\\d|55[23])\\d|5(?:(?:00(?:0\\d|1)|(?:304|616)\\d\\d)\\d|1(?:0[12]|4[2-4])|2(?:2[3589]|3(?:1\\d{3}|2)|4[04]|7[78])|4(?:[02]4|32\\d{4}|4[04]|99)|5(?:1[25]|[36]5|4[45]|93)|7(?:(?:17\\d|57)\\d\\d|[27]7|88)|8(?:3[4-69]|4[01]|5[58]|88(?:8\\d\\d|9)|99)|9(?:0(?:0|2\\d{3})|55|6[67]|77|88)))\\d',
        'ExampleNumber' => '100',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'standardRate' => [
        'NationalNumberPattern' => '5(?:14(?:2[5-9]|[34]\\d)|757555)',
        'ExampleNumber' => '51425',
        'PossibleLength' => [
            5,
            7,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'carrierSpecific' => [
        'NationalNumberPattern' => '1(?:(?:1[67]\\d\\d|70)\\d\\d|55330|909)|5(?:300\\d|6161(?:17[89]|561))|1(?:[19][89]|21|4[01])',
        'ExampleNumber' => '118',
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
    'smsServices' => [
        'NationalNumberPattern' => '1(?:39|90[019])|5(?:14(?:2[5-9]|[34]\\d)|6161(?:17[89]|561)|757555)',
        'ExampleNumber' => '139',
        'PossibleLength' => [
            3,
            4,
            5,
            7,
            8,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'IN',
    'countryCode' => 0,
    'internationalPrefix' => '',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
