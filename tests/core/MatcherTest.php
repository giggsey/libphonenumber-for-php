<?php

namespace libphonenumber\Tests\core;

use libphonenumber\MatcherAPIInterface;
use libphonenumber\PhoneNumberDesc;
use libphonenumber\RegexBasedMatcher;

class MatcherTest extends \PHPUnit_Framework_TestCase
{
    public function testRegexBasedMatcher()
    {
        $this->checkMatcherBehavesAsExpected(RegexBasedMatcher::create());
    }

    private function checkMatcherBehavesAsExpected(MatcherAPIInterface $matcher)
    {
        $desc = $this->createDesc("");

        // Test if there is no matcher data.
        $this->assertInvalid($matcher, "1", $desc);

        $desc = $this->createDesc("9\\d{2}");
        $this->assertInvalid($matcher, "91", $desc);
        $this->assertInvalid($matcher, "81", $desc);
        $this->assertMatched($matcher, "911", $desc);
        $this->assertInvalid($matcher, "811", $desc);
        $this->assertTooLong($matcher, "9111", $desc);
        $this->assertInvalid($matcher, "8111", $desc);

        $desc = $this->createDesc("\\d{1,2}");
        $this->assertMatched($matcher, "2", $desc);
        $this->assertMatched($matcher, "20", $desc);

        $desc = $this->createDesc("20?");
        $this->assertMatched($matcher, "2", $desc);
        $this->assertMatched($matcher, "20", $desc);

        $desc = $this->createDesc("2|20");
        $this->assertMatched($matcher, "2", $desc);
        // Subtle case where lookingAt() and matches() result in different ends().
        $this->assertMatched($matcher, "20", $desc);
    }

    /**
     * Helper method to set national number fields in the PhoneNumberDesc proto. Empty fields won't be
     * set.
     *
     * @param string $nationalNumberPattern
     * @return PhoneNumberDesc
     */
    private function createDesc($nationalNumberPattern)
    {
        $desc = new PhoneNumberDesc();
        if (strlen($nationalNumberPattern) > 0) {
            $desc->setNationalNumberPattern($nationalNumberPattern);
        }

        return $desc;
    }

    private function assertMatched(MatcherAPIInterface $matcher, $number, PhoneNumberDesc $desc)
    {
        $this->assertTrue($matcher->matchNationalNumber($number, $desc, false));
        $this->assertTrue($matcher->matchNationalNumber($number, $desc, true));
    }

    private function assertInvalid(MatcherAPIInterface $matcher, $number, PhoneNumberDesc $desc)
    {
        $this->assertFalse($matcher->matchNationalNumber($number, $desc, false));
        $this->assertFalse($matcher->matchNationalNumber($number, $desc, true));
    }

    private function assertTooLong(MatcherAPIInterface $matcher, $number, PhoneNumberDesc $desc)
    {
        $this->assertFalse($matcher->matchNationalNumber($number, $desc, false));
        $this->assertTrue($matcher->matchNationalNumber($number, $desc, true));
    }
}
