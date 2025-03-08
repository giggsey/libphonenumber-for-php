<?php

declare(strict_types=1);

namespace libphonenumber\Tests\Issues;

use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\TestCase;

class Issue68Test extends TestCase
{
    public function testShortNumberInfoIsPossibleShortNumberWithRegionMissingFromCodeSet(): void
    {
        $exampleNumber = $this->getExampleNumber();

        $shortNumberInfo = ShortNumberInfo::getInstance();

        self::assertFalse($shortNumberInfo->isPossibleShortNumber($exampleNumber));
    }

    public function testShortNumberInfoIsPossibleShortNumberForRegionWithRegionMissingFromCodeSet(): void
    {
        $exampleNumber = $this->getExampleNumber();

        $shortNumberInfo = ShortNumberInfo::getInstance();

        self::assertFalse($shortNumberInfo->isPossibleShortNumberForRegion($exampleNumber, 'NE'));
    }

    private function getExampleNumber(): PhoneNumber
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        $exampleNumber = $phoneUtil->getExampleNumber('NE');
        self::assertNotNull($exampleNumber);

        // Reset PhoneNumberUtil just to make sure that doesn't interfere
        PhoneNumberUtil::resetInstance();

        return $exampleNumber;
    }
}
