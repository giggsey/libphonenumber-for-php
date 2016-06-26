<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;

class Issue68Test extends \PHPUnit_Framework_TestCase
{
    public function testShortNumberInfoIsPossibleShortNumberWithRegionMissingFromCodeSet()
    {
        $exampleNumber = $this->getExampleNumber('NE');

        $shortNumberInfo = ShortNumberInfo::getInstance();

        $this->assertFalse($shortNumberInfo->isPossibleShortNumber($exampleNumber));
    }

    public function testShortNumberInfoIsPossibleShortNumberForRegionWithRegionMissingFromCodeSet()
    {
        $exampleNumber = $this->getExampleNumber('NE');

        $shortNumberInfo = ShortNumberInfo::getInstance();

        $this->assertFalse($shortNumberInfo->isPossibleShortNumberForRegion($exampleNumber, 'NE'));
    }

    private function getExampleNumber($region)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        $exampleNumber = $phoneUtil->getExampleNumber($region);

        // Reset PhoneNumberUtil just to make sure that doesn't interfere
        PhoneNumberUtil::resetInstance();

        return $exampleNumber;
    }
}
