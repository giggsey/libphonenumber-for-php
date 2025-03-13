<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

/**
 * Test all public static methods in a new process to ensure that all the static variables are initialised
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/175
 * @package libphonenumber\Tests\Issues
 */
class Issue175Test extends TestCase
{
    public function setUp(): void
    {
        // Reset instance each time
        PhoneNumberUtil::resetInstance();
    }

    #[\PHPUnit\Framework\Attributes\RunInSeparateProcess]
    public function testIsViablePhoneNumber(): void
    {
        $ret = PhoneNumberUtil::isViablePhoneNumber('01111');
        self::assertTrue($ret);
    }
}
