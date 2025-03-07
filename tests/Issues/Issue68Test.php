<?php

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\TestCase;

class Issue68Test extends TestCase
{
    public function testShortNumberInfoIsPossibleShortNumberWithRegionMissingFromCodeSet(): void
    {
        $exampleNumber = $this->getExampleNumber('NE');

        $shortNumberInfo = ShortNumberInfo::getInstance();

        $this->assertFalse($shortNumberInfo->isPossibleShortNumber($exampleNumber));
    }

    public function testShortNumberInfoIsPossibleShortNumberForRegionWithRegionMissingFromCodeSet(): void
    {
        $exampleNumber = $this->getExampleNumber('NE');

        $shortNumberInfo = ShortNumberInfo::getInstance();

        $this->assertFalse($shortNumberInfo->isPossibleShortNumberForRegion($exampleNumber, 'NE'));
    }

    private function getExampleNumber(string $region): PhoneNumber
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        $exampleNumber = $phoneUtil->getExampleNumber($region);

        // Reset PhoneNumberUtil just to make sure that doesn't interfere
        PhoneNumberUtil::resetInstance();

        return $exampleNumber;
    }
}
