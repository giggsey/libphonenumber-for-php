<?php

namespace libphonenumber;

/**
 * Country code source from number
 */
class CountryCodeSource
{
    const FROM_NUMBER_WITH_PLUS_SIGN = 0;
    const FROM_NUMBER_WITH_IDD = 1;
    const FROM_NUMBER_WITHOUT_PLUS_SIGN = 2;
    const FROM_DEFAULT_COUNTRY = 3;
}
