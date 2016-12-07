<?php

namespace libphonenumber\Tests\core;

use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberInfo;

class PhoneMetadataTest extends \PHPUnit_Framework_TestCase
{
    public function phoneNumberRegionList()
    {
        $returnList = array();

        PhoneNumberUtil::resetInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        foreach ($phoneUtil->getSupportedRegions() as $regionCode) {
            $returnList[] = array($regionCode);
        }

        return $returnList;
    }

    public function shortNumberRegionList()
    {
        $returnList = array();

        ShortNumberInfo::resetInstance();
        $shortNumber = ShortNumberInfo::getInstance();
        foreach ($shortNumber->getSupportedRegions() as $regionCode) {
            $returnList[] = array($regionCode);
        }

        return $returnList;
    }

    /**
     * @param $region
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
     * @param $region
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
