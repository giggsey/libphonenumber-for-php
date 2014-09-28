<?php

namespace libphonenumber\Tests\buildtools;


use libphonenumber\buildtools\GeneratePhonePrefixData;

class GeneratePhonePrefixDataTest extends \PHPUnit_Framework_TestCase
{
    private static $available_data_files;

    public static function setUpBeforeClass()
    {
        $temporaryMap = array();

        $phonePrefixData = new GeneratePhonePrefixData();


        // Languages for US.
        $phonePrefixData->addConfigurationMapping($temporaryMap, "1", "en");
        $phonePrefixData->addConfigurationMapping($temporaryMap, "1", "en_US");
        $phonePrefixData->addConfigurationMapping($temporaryMap, "1", "es");

        // Languages for France.
        $phonePrefixData->addConfigurationMapping($temporaryMap, "33", "fr");
        $phonePrefixData->addConfigurationMapping($temporaryMap, "33", "en");

        // Languages for China.
        $phonePrefixData->addConfigurationMapping($temporaryMap, "86", "zh_Hans");

        self::$available_data_files = $temporaryMap;
    }

    public function testAddConfigurationMapping()
    {
        $this->assertCount(3, self::$available_data_files);

        $languagesForUS = self::$available_data_files[1];

        $this->assertContains("en", $languagesForUS);
        $this->assertContains("en_US", $languagesForUS);
        $this->assertContains("es", $languagesForUS);

        $languagesForFR = self::$available_data_files[33];

        $this->assertContains("fr", $languagesForFR);
        $this->assertContains("en", $languagesForFR);

        $languagesForCN = self::$available_data_files[86];
        $this->assertCount(1, $languagesForCN);

        $this->assertContains("zh_Hans", $languagesForCN);
    }


}
