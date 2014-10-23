<?php

namespace libphonenumber;

class RegexBasedMatcher implements MatcherAPIInterface
{
    public static function create()
    {
        return new static();
    }

    /**
     * Returns whether the given national number (a string containing only decimal digits) matches
     * the national number pattern defined in the given {@code PhoneNumberDesc} message.
     *
     * @param string $nationalNumber
     * @param PhoneNumberDesc $numberDesc
     * @param boolean $allowPrefixMatch
     * @return boolean
     */
    public function matchesNationalNumber($nationalNumber, PhoneNumberDesc $numberDesc, $allowPrefixMatch)
    {
        $nationalNumberPatternMatcher = new Matcher($numberDesc->getNationalNumberPattern(), $nationalNumber);

        return ($nationalNumberPatternMatcher->matches()
            || ($allowPrefixMatch && $nationalNumberPatternMatcher->lookingAt()));
    }

    /**
     * Returns whether the given national number (a string containing only decimal digits) matches
     * the possible number pattern defined in the given {@code PhoneNumberDesc} message.
     *
     * @param string $nationalNumber
     * @param PhoneNumberDesc $numberDesc
     * @return boolean
     */
    public function matchesPossibleNumber($nationalNumber, PhoneNumberDesc $numberDesc)
    {
        $possibleNumberPatternMatcher = new Matcher($numberDesc->getPossibleNumberPattern(), $nationalNumber);

        return $possibleNumberPatternMatcher->matches();
    }
}
