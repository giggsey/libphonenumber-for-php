<?php

namespace libphonenumber\geocoding;


class Locale extends \Locale
{
    /**
     * Returns a locale from a country code that is provided.
     * @link http://stackoverflow.com/a/10375234/403165
     * @param string $country_code ISO 3166-2-alpha 2 country code
     * @param string $language_code ISO 639-1-alpha 2 language code
     * @returns string a locale, formatted like en_US, or null if not found
     */
    public static function countryCodeToLocale($country_code, $language_code = '')
    {
        $locale = 'en-' . $country_code;
        $locale_region = locale_get_region($locale);
        $locale_language = locale_get_primary_language($locale);
        $locale_array = array(
            'language' => $locale_language,
            'region' => $locale_region
        );

        if (strtoupper($country_code) == $locale_region && $language_code == '') {
            return locale_compose($locale_array);
        } elseif (strtoupper($country_code) == $locale_region && strtolower($language_code) == $locale_language) {
            return locale_compose($locale_array);
        }

        return null;
    }

}
