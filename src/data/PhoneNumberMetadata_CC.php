<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '1(?:[0-79]\\d{8}(?:\\d{2})?|8[0-24-9]\\d{7})|[148]\\d{8}|1\\d{5,7}',
        'PossibleLength' => [
            6,
            7,
            8,
            9,
            10,
            12,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '8(?:51(?:0(?:02|31|60|89)|1(?:18|76)|223)|91(?:0(?:1[0-2]|29)|1(?:[28]2|50|79)|2(?:10|64)|3(?:[06]8|22)|4[29]8|62\\d|70[23]|959))\\d{3}',
        'ExampleNumber' => '891621234',
        'PossibleLength' => [
            9,
        ],
        'PossibleLengthLocalOnly' => [
            8,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '4(?:79[01]|83[0-389]|94[0-4])\\d{5}|4(?:[0-36]\\d|4[047-9]|5[0-25-9]|7[02-8]|8[0-24-9]|9[0-37-9])\\d{6}',
        'ExampleNumber' => '412345678',
        'PossibleLength' => [
            9,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '180(?:0\\d{3}|2)\\d{3}',
        'ExampleNumber' => '1800123456',
        'PossibleLength' => [
            7,
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '190[0-26]\\d{6}',
        'ExampleNumber' => '1900123456',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'sharedCost' => [
        'NationalNumberPattern' => '13(?:00\\d{6}(?:\\d{2})?|45[0-4]\\d{3})|13\\d{4}',
        'ExampleNumber' => '1300123456',
        'PossibleLength' => [
            6,
            8,
            10,
            12,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'personalNumber' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'voip' => [
        'NationalNumberPattern' => '14(?:5(?:1[0458]|[23][458])|71\\d)\\d{4}',
        'ExampleNumber' => '147101234',
        'PossibleLength' => [
            9,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'pager' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'uan' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'voicemail' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'noInternationalDialling' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'id' => 'CC',
    'countryCode' => 61,
    'internationalPrefix' => '001[14-689]|14(?:1[14]|34|4[17]|[56]6|7[47]|88)0011',
    'preferredInternationalPrefix' => '0011',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '([59]\\d{7})$|0',
    'nationalPrefixTransformRule' => '8$1',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
