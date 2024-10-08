<?php

namespace libphonenumber\Tests\core;

use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\TestCase;

class PhoneMetadataTest extends TestCase
{
    public function phoneNumberRegionList()
    {
        $returnList = [];

        PhoneNumberUtil::resetInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        foreach ($phoneUtil->getSupportedRegions() as $regionCode) {
            $returnList[] = [$regionCode];
        }

        return $returnList;
    }

    public function shortNumberRegionList()
    {
        $returnList = [];

        ShortNumberInfo::resetInstance();
        $shortNumber = ShortNumberInfo::getInstance();
        foreach ($shortNumber->getSupportedRegions() as $regionCode) {
            $returnList[] = [$regionCode];
        }

        return $returnList;
    }

    /**
     * @dataProvider phoneNumberRegionList
     */
    public function testPhoneNumberMetadataToAndFromArray($region)
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();
        $phoneMetadata = $phoneNumberUtil->getMetadataForRegion($region);

        $array = $phoneMetadata->toArray();

        /*
         * Load a new Metadata object from Array, and compare
         */

        $newPhoneMetadata = new PhoneMetadata();
        $newPhoneMetadata->fromArray($array);

        $this->assertEquals($phoneMetadata, $newPhoneMetadata);
    }

    /**
     * @dataProvider shortNumberRegionList
     */
    public function testShortCodeMetadataToAndFromArray($region)
    {
        $shortNumberInfo = ShortNumberInfo::getInstance();
        $phoneMetadata = $shortNumberInfo->getMetadataForRegion($region);

        $array = $phoneMetadata->toArray();

        /*
         * Load a new Metadata object from Array, and compare
         */

        $newPhoneMetadata = new PhoneMetadata();
        $newPhoneMetadata->fromArray($array);

        $this->assertEquals($phoneMetadata, $newPhoneMetadata);
    }
}
