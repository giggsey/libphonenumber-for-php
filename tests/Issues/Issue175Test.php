<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;

/**
 * Test all public static methods in a new process to ensure that all the static variables are initialised
 * @see https://github.com/giggsey/libphonenumber-for-php/issues/175
 * @package libphonenumber\Tests\Issues
 */
class Issue175Test extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        // Reset instance each time
        PhoneNumberUtil::resetInstance();
    }

    /**
     * @runInSeparateProcess
     */
    public function testIsViablePhoneNumber()
    {
        $ret = PhoneNumberUtil::isViablePhoneNumber('01111');
        $this->assertTrue($ret);
    }
}
