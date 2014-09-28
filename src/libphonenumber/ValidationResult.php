<?php

namespace libphonenumber;

/**
 * Possible outcomes when testing if a PhoneNumber is possible.
 */
class ValidationResult
{
    const IS_POSSIBLE = 0;
    const INVALID_COUNTRY_CODE = 1;
    const TOO_SHORT = 2;
    const TOO_LONG = 3;
}
