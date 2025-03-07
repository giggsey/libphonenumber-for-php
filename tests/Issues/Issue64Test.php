<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\TestCase;

class Issue64Test extends TestCase
{
    public function testIssue64WithoutPhoneNumberUtil(): void
    {
        $sortNumberUtil = ShortNumberInfo::getInstance();
        $this->assertTrue($sortNumberUtil->isEmergencyNumber('999', 'GB'));
    }

    public function testIssue64WithoutPhoneNumberUtilgetInstance(): void
    {
        PhoneNumberUtil::getInstance();

        $sortNumberUtil = ShortNumberInfo::getInstance();
        $this->assertTrue($sortNumberUtil->isEmergencyNumber('999', 'GB'));
    }

    public function testIssue64WithoutPhoneNumberUtilresetInstance(): void
    {
        PhoneNumberUtil::resetInstance();

        $sortNumberUtil = ShortNumberInfo::getInstance();
        $this->assertTrue($sortNumberUtil->isEmergencyNumber('999', 'GB'));
    }
}
