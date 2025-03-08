<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\MatcherAPIInterface;
use libphonenumber\PhoneNumberDesc;
use libphonenumber\RegexBasedMatcher;
use PHPUnit\Framework\TestCase;

use function strlen;

class MatcherTest extends TestCase
{
    public function testRegexBasedMatcher(): void
    {
        $this->checkMatcherBehavesAsExpected(new RegexBasedMatcher());
    }

    private function checkMatcherBehavesAsExpected(MatcherAPIInterface $matcher): void
    {
        $desc = $this->createDesc('');

        // Test if there is no matcher data.
        self::assertInvalid($matcher, '1', $desc);

        $desc = $this->createDesc('9\\d{2}');
        self::assertInvalid($matcher, '91', $desc);
        self::assertInvalid($matcher, '81', $desc);
        self::assertMatched($matcher, '911', $desc);
        self::assertInvalid($matcher, '811', $desc);
        self::assertTooLong($matcher, '9111', $desc);
        self::assertInvalid($matcher, '8111', $desc);

        $desc = $this->createDesc('\\d{1,2}');
        self::assertMatched($matcher, '2', $desc);
        self::assertMatched($matcher, '20', $desc);

        $desc = $this->createDesc('20?');
        self::assertMatched($matcher, '2', $desc);
        self::assertMatched($matcher, '20', $desc);

        $desc = $this->createDesc('2|20');
        self::assertMatched($matcher, '2', $desc);
        // Subtle case where lookingAt() and matches() result in different ends().
        self::assertMatched($matcher, '20', $desc);
    }

    /**
     * Helper method to set national number fields in the PhoneNumberDesc proto. Empty fields won't be
     * set.
     */
    private function createDesc(string $nationalNumberPattern): PhoneNumberDesc
    {
        $desc = new PhoneNumberDesc();
        if (strlen($nationalNumberPattern) > 0) {
            $desc->setNationalNumberPattern($nationalNumberPattern);
        }

        return $desc;
    }

    private function assertMatched(MatcherAPIInterface $matcher, string $number, PhoneNumberDesc $desc): void
    {
        self::assertTrue($matcher->matchNationalNumber($number, $desc, false), "{$number} should have matched {$this->descToString($desc)}");
        self::assertTrue($matcher->matchNationalNumber($number, $desc, true), "{$number} should have matched {$this->descToString($desc)}");
    }

    private function assertInvalid(MatcherAPIInterface $matcher, string $number, PhoneNumberDesc $desc): void
    {
        self::assertFalse($matcher->matchNationalNumber($number, $desc, false), "{$number} should not have matched {$this->descToString($desc)}");
        self::assertFalse($matcher->matchNationalNumber($number, $desc, true), "{$number} should  not have matched {$this->descToString($desc)}");
    }

    private function assertTooLong(MatcherAPIInterface $matcher, string $number, PhoneNumberDesc $desc): void
    {
        self::assertFalse($matcher->matchNationalNumber($number, $desc, false), "{$number} should have been too long for {$this->descToString($desc)}");
        self::assertTrue($matcher->matchNationalNumber($number, $desc, true), "{$number} should have been too long for {$this->descToString($desc)}");
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
