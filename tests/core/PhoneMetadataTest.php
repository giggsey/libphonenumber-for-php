<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\TestCase;

class PhoneMetadataTest extends TestCase
{
    /**
     * @return array<array{string}>
     */
    public static function phoneNumberRegionList(): array
    {
        $returnList = [];

        PhoneNumberUtil::resetInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        foreach ($phoneUtil->getSupportedRegions() as $regionCode) {
            $returnList[] = [$regionCode];
        }

        return $returnList;
    }

    /**
     * @return array<array{string}>
     */
    public static function shortNumberRegionList(): array
    {
        $returnList = [];

        ShortNumberInfo::resetInstance();
        $shortNumber = ShortNumberInfo::getInstance();
        foreach ($shortNumber->getSupportedRegions() as $regionCode) {
            $returnList[] = [$regionCode];
        }

        return $returnList;
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('phoneNumberRegionList')]
    public function testPhoneNumberMetadataToAndFromArray(string $region): void
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phoneMetadata = $phoneNumberUtil->getMetadataForRegion($region);

        self::assertNotNull($phoneMetadata);

        $array = $phoneMetadata->toArray();

        /*
         * Load a new Metadata object from Array, and compare
         */

        $newPhoneMetadata = new PhoneMetadata();
        $newPhoneMetadata->fromArray($array);

        self::assertEquals($phoneMetadata, $newPhoneMetadata);
    }

    #[\PHPUnit\Framework\Attributes\DataProvider('shortNumberRegionList')]
    public function testShortCodeMetadataToAndFromArray(string $region): void
    {
        $shortNumberInfo = ShortNumberInfo::getInstance();
        $phoneMetadata = $shortNumberInfo->getMetadataForRegion($region);

        self::assertNotNull($phoneMetadata);

        $array = $phoneMetadata->toArray();

        /*
         * Load a new Metadata object from Array, and compare
         */

        $newPhoneMetadata = new PhoneMetadata();
        $newPhoneMetadata->fromArray($array);

        self::assertEquals($phoneMetadata, $newPhoneMetadata);
    }
}
