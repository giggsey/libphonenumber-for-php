<?php

declare(strict_types=1);
/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

return [
    'id' => '',
    'countryCode' => 55,
    'internationalPrefix' => '',
    'numberFormat' => [
        [
            'pattern' => '(\\d{2})(\\d{8})',
            'format' => '$1 $2',
            'leadingDigitsPatterns' => [
                '[12467]|3[1-578]|5[13-5]|[89][1-9]',
            ],
            'nationalPrefixFormattingRule' => '',
            'domesticCarrierCodeFormattingRule' => '',
            'nationalPrefixOptionalWhenFormatting' => false,
        ],
    ],
    'intlNumberFormat' => [],
    'mainCountryForCode' => false,
];
