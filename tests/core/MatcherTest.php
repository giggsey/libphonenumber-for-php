<?php

namespace libphonenumber\Tests\core;

use libphonenumber\MatcherAPIInterface;
use libphonenumber\PhoneNumberDesc;
use libphonenumber\RegexBasedMatcher;
use PHPUnit\Framework\TestCase;

class MatcherTest extends TestCase
{
    public function testRegexBasedMatcher(): void
    {
        $this->checkMatcherBehavesAsExpected(RegexBasedMatcher::create());
    }

    private function checkMatcherBehavesAsExpected(MatcherAPIInterface $matcher): void
    {
        $desc = $this->createDesc('');

        // Test if there is no matcher data.
        $this->assertInvalid($matcher, '1', $desc);

        $desc = $this->createDesc('9\\d{2}');
        $this->assertInvalid($matcher, '91', $desc);
        $this->assertInvalid($matcher, '81', $desc);
        $this->assertMatched($matcher, '911', $desc);
        $this->assertInvalid($matcher, '811', $desc);
        $this->assertTooLong($matcher, '9111', $desc);
        $this->assertInvalid($matcher, '8111', $desc);

        $desc = $this->createDesc('\\d{1,2}');
        $this->assertMatched($matcher, '2', $desc);
        $this->assertMatched($matcher, '20', $desc);

        $desc = $this->createDesc('20?');
        $this->assertMatched($matcher, '2', $desc);
        $this->assertMatched($matcher, '20', $desc);

        $desc = $this->createDesc('2|20');
        $this->assertMatched($matcher, '2', $desc);
        // Subtle case where lookingAt() and matches() result in different ends().
        $this->assertMatched($matcher, '20', $desc);
    }

    /**
     * Helper method to set national number fields in the PhoneNumberDesc proto. Empty fields won't be
     * set.
     */
    private function createDesc(string $nationalNumberPattern): PhoneNumberDesc
    {
        $desc = new PhoneNumberDesc();
        if (\strlen($nationalNumberPattern) > 0) {
            $desc->setNationalNumberPattern($nationalNumberPattern);
        }

        return $desc;
    }

    private function assertMatched(MatcherAPIInterface $matcher, string $number, PhoneNumberDesc $desc): void
    {
        $this->assertTrue($matcher->matchNationalNumber($number, $desc, false), "{$number} should have matched {$this->descToString($desc)}");
        $this->assertTrue($matcher->matchNationalNumber($number, $desc, true), "{$number} should have matched {$this->descToString($desc)}");
    }

    private function assertInvalid(MatcherAPIInterface $matcher, string $number, PhoneNumberDesc $desc): void
    {
        $this->assertFalse($matcher->matchNationalNumber($number, $desc, false), "{$number} should not have matched {$this->descToString($desc)}");
        $this->assertFalse($matcher->matchNationalNumber($number, $desc, true), "{$number} should  not have matched {$this->descToString($desc)}");
    }

    private function assertTooLong(MatcherAPIInterface $matcher, string $number, PhoneNumberDesc $desc): void
    {
        $this->assertFalse($matcher->matchNationalNumber($number, $desc, false), "{$number} should have been too long for {$this->descToString($desc)}");
        $this->assertTrue($matcher->matchNationalNumber($number, $desc, true), "{$number} should have been too long for {$this->descToString($desc)}");
    }

    private function descToString(PhoneNumberDesc $desc): string
    {
        $string = 'pattern: ';
        if ($desc->hasNationalNumberPattern()) {
            $string .= $desc->getNationalNumberPattern();
        } else {
            $string .= 'none';
        }

        return $string;
    }
}
