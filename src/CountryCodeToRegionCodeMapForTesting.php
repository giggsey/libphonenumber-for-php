<?php

/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

declare(strict_types=1);

namespace libphonenumber;

/**
 * @internal
 */
class CountryCodeToRegionCodeMapForTesting
{
    /**
     * A mapping from a country code to the region codes which denote the
     * country/region represented by that country code. In the case of multiple
     * countries sharing a calling code, such as the NANPA countries, the one
     * indicated with "isMainCountryForCode" in the metadata should be first.
     * @var array<int,string[]>
     */
    public const COUNTRY_CODE_TO_REGION_CODE_MAP_FOR_TESTING = [
        1 => ['US', 'BB', 'BS', 'CA'],
        7 => ['RU'],
        33 => ['FR'],
        39 => ['IT'],
        44 => ['GB', 'GG'],
        46 => ['SE'],
        48 => ['PL'],
        49 => ['DE'],
        52 => ['MX'],
        54 => ['AR'],
        55 => ['BR'],
        57 => ['CO'],
        61 => ['AU', 'CC', 'CX'],
        64 => ['NZ'],
        65 => ['SG'],
        81 => ['JP'],
        82 => ['KR'],
        86 => ['CN'],
        244 => ['AO'],
        262 => ['RE', 'YT'],
        290 => ['TA'],
        374 => ['AM'],
        375 => ['BY'],
        376 => ['AD'],
        800 => ['001'],
        882 => ['001'],
        971 => ['AE'],
        979 => ['001'],
        998 => ['UZ'],
    ];
}
