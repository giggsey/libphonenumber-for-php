<?php
/**
 * Created by PhpStorm.
 * User: giggsey
 * Date: 14/10/13
 * Time: 19:58
 */

namespace libphonenumber\Tests\timezone;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberToTimeZonesMapper;

class UKTest extends \PHPUnit_Framework_TestCase {

    public function testGBNumber() {
        $number = new PhoneNumber();
        $number->setCountryCode(44)->setNationalNumber(1614960000);

        $timeZone = PhoneNumberToTimeZonesMapper::getInstance();
        $this->assertEquals(array("Europe/London"), $timeZone->getTimeZonesForNumber($number));
    }
}
 