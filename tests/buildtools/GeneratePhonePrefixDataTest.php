<?php

declare(strict_types=1);

namespace libphonenumber\Tests\buildtools;

use libphonenumber\buildtools\GeneratePhonePrefixData;
use PHPUnit\Framework\TestCase;

class GeneratePhonePrefixDataTest extends TestCase
{
    /**
     * @var array<string,array<int|string>>
     */
    private static array $availableDataFiles;

    public static function setUpBeforeClass(): void
    {
        $temporaryMap = [];

        $phonePrefixData = new GeneratePhonePrefixData();


        // Languages for US.
        $phonePrefixData->addConfigurationMapping($temporaryMap, '1', 'en');
        $phonePrefixData->addConfigurationMapping($temporaryMap, '1', 'en_US');
        $phonePrefixData->addConfigurationMapping($temporaryMap, '1', 'es');

        // Languages for France.
        $phonePrefixData->addConfigurationMapping($temporaryMap, '33', 'fr');
        $phonePrefixData->addConfigurationMapping($temporaryMap, '33', 'en');

        // Languages for China.
        $phonePrefixData->addConfigurationMapping($temporaryMap, '86', 'zh_Hans');

        self::$availableDataFiles = $temporaryMap;
    }

    public function testAddConfigurationMapping(): void
    {
        self::assertCount(3, self::$availableDataFiles);

        self::assertArrayHasKey('1', self::$availableDataFiles);
        $languagesForUS = self::$availableDataFiles['1'];

        self::assertContains('en', $languagesForUS);
        self::assertContains('en_US', $languagesForUS);
        self::assertContains('es', $languagesForUS);

        self::assertArrayHasKey('33', self::$availableDataFiles);
        $languagesForFR = self::$availableDataFiles['33'];

        self::assertContains('fr', $languagesForFR);
        self::assertContains('en', $languagesForFR);

        self::assertArrayHasKey('86', self::$availableDataFiles);
        $languagesForCN = self::$availableDataFiles['86'];
        self::assertCount(1, $languagesForCN);

        self::assertContains('zh_Hans', $languagesForCN);
    }
}
