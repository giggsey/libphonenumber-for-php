<?php

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '1624\\d{6}|(?:[3578]\\d|90)\\d{8}',
        'PossibleLength' => [
            10,
        ],
        'PossibleLengthLocalOnly' => [
            6,
        ],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '1624(?:230|[5-8]\\d\\d)\\d{3}',
        'ExampleNumber' => '1624756789',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [
            6,
        ],
    ],
    'mobile' => [
        'NationalNumberPattern' => '76245[06]\\d{4}|7(?:4576|[59]24\\d|624[0-4689])\\d{5}',
        'ExampleNumber' => '7924123456',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'NationalNumberPattern' => '808162\\d{4}',
        'ExampleNumber' => '8081624567',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'NationalNumberPattern' => '8(?:440[49]06|72299\\d)\\d{3}|(?:8(?:45|70)|90[0167])624\\d{4}',
        'ExampleNumber' => '9016247890',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'sharedCost' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'personalNumber' => [
        'NationalNumberPattern' => '70\\d{8}',
        'ExampleNumber' => '7012345678',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'voip' => [
        'NationalNumberPattern' => '56\\d{8}',
        'ExampleNumber' => '5612345678',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'pager' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'uan' => [
        'NationalNumberPattern' => '3440[49]06\\d{3}|(?:3(?:08162|3\\d{4}|45624|7(?:0624|2299))|55\\d{4})\\d{4}',
        'ExampleNumber' => '5512345678',
        'PossibleLength' => [],
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
    'id' => 'IM',
    'countryCode' => 44,
    'internationalPrefix' => '00',
    'nationalPrefix' => '0',
    'nationalPrefixForParsing' => '([25-8]\\d{5})$|0',
    'nationalPrefixTransformRule' => '1624$1',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'leadingDigits' => '74576|(?:16|7[56])24',
    'mobileNumberPortableRegion' => false,
];
