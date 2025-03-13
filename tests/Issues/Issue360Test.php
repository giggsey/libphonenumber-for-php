<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

/**
 * Test that you can not pass a string and null to isPossibleNumber
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/360
 * @package libphonenumber\Tests\Issues
 */
class Issue360Test extends TestCase
{
    public function testNullRegion(): void
    {
        self::assertTrue(PhoneNumberUtil::getInstance()->isPossibleNumber('+441174960123', null));
    }
}
