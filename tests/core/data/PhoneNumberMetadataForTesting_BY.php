<?php

declare(strict_types=1);

/**
 * libphonenumber-for-php-lite data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'generalDesc' => [
        'NationalNumberPattern' => '[1-9]\\d{5}',
        'PossibleLength' => [
            6,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'fixedLine' => [
        'NationalNumberPattern' => '[1-9]\\d{5}',
        'ExampleNumber' => '112345',
        'PossibleLength' => [],
        'PossibleLengthLocalOnly' => [],
    ],
    'mobile' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'tollFree' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'premiumRate' => [
        'PossibleLength' => [
            -1,
        ],
        'PossibleLengthLocalOnly' => [],
    ],
    'sharedCost' => [
        'PossibleLength' => [
            -1,
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
        'PossibleLength' => [
            -1,
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
    'id' => 'BY',
    'countryCode' => 375,
    'internationalPrefix' => '810',
    'nationalPrefix' => '8',
    'nationalPrefixForParsing' => '80?|99999',
    'sameMobileAndFixedLinePattern' => false,
    'numberFormat' => [
        [
            'pattern' => '(\\d{4})',
            'format' => '$1',
            'leadingDigitsPatterns' => [
                '[1-8]',
            ],
            'nationalPrefixFormattingRule' => '8 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{2})(\\d{3})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[1-8]',
            ],
            'nationalPrefixFormattingRule' => '8$1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
        [
            'pattern' => '(\\d{3})(\\d{3})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[1-8]',
            ],
            'nationalPrefixFormattingRule' => '8 $1',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
    'mobileNumberPortableRegion' => false,
];
