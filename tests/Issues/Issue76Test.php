<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;

class Issue76Test extends TestCase
{
    public function testIssue76()
    {
        $this->doExpectException(
            '\libphonenumber\NumberParseException',
            "The string supplied did not seem to be a phone number.",
            NumberParseException::NOT_A_NUMBER
        );

        $number = 'Abc811@hotmail.com';
        $region = 'DE';
        $util = PhoneNumberUtil::getInstance();
        $util->parse($number, $region);
    }

    /**
     * Helper function to support older PHPUnit versions
     * @param $class
     * @param string|null $message
     * @param int|null $code
     */
    private function doExpectException($class, $message = null, $code = null)
    {
        if (method_exists($this, 'expectException')
            && method_exists($this, 'expectExceptionMessage')
            && method_exists($this, 'expectExceptionCode')
        ) {
            $this->expectException($class);
            if ($message) {
                $this->expectExceptionMessage($message);
            }
            if ($code) {
                $this->expectExceptionCode($code);
            }
        } else {
            $this->setExpectedException($class, $message, $code);
        }
    }
}
