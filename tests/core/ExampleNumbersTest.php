<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberCost;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * Verifies all of the example numbers in the metadata are valid and of the correct type. If no
 * example number exists for a particular type, the test still passes since not all types are
 * relevant for all regions. Tests that check the XML schema will ensure that an exampleNumber
 * node is present for every phone number description.
 */
class ExampleNumbersTest extends TestCase
{
    private PhoneNumberUtil $phoneNumberUtil;
    private ShortNumberInfo $shortNumberInfo;

    public static function setUpBeforeClass(): void
    {
        PhoneNumberUtil::resetInstance();
        PhoneNumberUtil::getInstance();
        ShortNumberInfo::resetInstance();
    }

    public function setUp(): void
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->shortNumberInfo = ShortNumberInfo::getInstance();
    }

    /**
     * @return array<array{string}>
     */
    public static function regionList(): array
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
     * @return array<array{PhoneNumberType}>
     */
    public static function numberTypes(): array
    {
        return [
            [PhoneNumberType::FIXED_LINE],
            [PhoneNumberType::MOBILE],
            [PhoneNumberType::FIXED_LINE_OR_MOBILE],
            [PhoneNumberType::TOLL_FREE],
            [PhoneNumberType::PREMIUM_RATE],
            [PhoneNumberType::SHARED_COST],
            [PhoneNumberType::VOIP],
            [PhoneNumberType::PERSONAL_NUMBER],
            [PhoneNumberType::PAGER],
            [PhoneNumberType::UAN],
            [PhoneNumberType::VOICEMAIL],
        ];
    }

    #[DataProvider('regionList')]
    public function testFixedLine(string $region): void
    {
        $fixedLineTypes = [PhoneNumberType::FIXED_LINE, PhoneNumberType::FIXED_LINE_OR_MOBILE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::FIXED_LINE, $fixedLineTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testFixedLineOrMobile(string $region): void
    {
        $numberTypes = [PhoneNumberType::FIXED_LINE, PhoneNumberType::FIXED_LINE_OR_MOBILE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::FIXED_LINE_OR_MOBILE, $numberTypes, $region);
    }

    /**
     * @param PhoneNumberType[] $possibleExpectedTypes
     */
    private function checkNumbersValidAndCorrectType(PhoneNumberType $exampleNumberRequestedType, array $possibleExpectedTypes, string $regionCode): void
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumberForType($regionCode, $exampleNumberRequestedType);
        if ($exampleNumber !== null) {
            self::assertTrue(
                $this->phoneNumberUtil->isValidNumber($exampleNumber),
                "Failed validation for {$exampleNumber}"
            );

            // We know the number is valid, now we check the type.
            $exampleNumberType = $this->phoneNumberUtil->getNumberType($exampleNumber);
            self::assertContains($exampleNumberType, $possibleExpectedTypes, "Wrong type for {$exampleNumber}");
        }
    }

    #[DataProvider('regionList')]
    public function testMobile(string $region): void
    {
        $mobileTypes = [PhoneNumberType::MOBILE, PhoneNumberType::FIXED_LINE_OR_MOBILE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::MOBILE, $mobileTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testTollFree(string $region): void
    {
        $tollFreeTypes = [PhoneNumberType::TOLL_FREE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::TOLL_FREE, $tollFreeTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testPremiumRate(string $region): void
    {
        $premiumRateTypes = [PhoneNumberType::PREMIUM_RATE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PREMIUM_RATE, $premiumRateTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testVoip(string $region): void
    {
        $voipTypes = [PhoneNumberType::VOIP];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::VOIP, $voipTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testPager(string $region): void
    {
        $pagerTypes = [PhoneNumberType::PAGER];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PAGER, $pagerTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testUan(string $region): void
    {
        $uanTypes = [PhoneNumberType::UAN];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::UAN, $uanTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testVoicemail(string $region): void
    {
        $voicemailTypes = [PhoneNumberType::VOICEMAIL];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::VOICEMAIL, $voicemailTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testPersonalNumber(string $region): void
    {
        $numberTypes = [PhoneNumberType::PERSONAL_NUMBER];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PERSONAL_NUMBER, $numberTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testSharedCost(string $region): void
    {
        $sharedCostTypes = [PhoneNumberType::SHARED_COST];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::SHARED_COST, $sharedCostTypes, $region);
    }

    #[DataProvider('regionList')]
    public function testCanBeInternationallyDialled(string $regionCode): void
    {
        $exampleNumber = null;
        $desc = $this->phoneNumberUtil->getMetadataForRegion($regionCode)?->getNoInternationalDialling();
        self::assertNotNull($desc);
        try {
            if ($desc->hasExampleNumber()) {
                $exampleNumber = $this->phoneNumberUtil->parse($desc->getExampleNumber(), $regionCode);
            }
        } catch (NumberParseException $e) {
        }

        if ($exampleNumber !== null && $this->phoneNumberUtil->canBeInternationallyDialled($exampleNumber)) {
            self::fail("Number {$exampleNumber} should not be internationally diallable");
        }
    }

    /**
     * @return array<array{string}>
     */
    public static function shortNumberRegionList(): array
    {
        $returnList = [];

        PhoneNumberUtil::resetInstance();
        ShortNumberInfo::resetInstance();
        $shortNumberInfo = ShortNumberInfo::getInstance();
        foreach ($shortNumberInfo->getSupportedRegions() as $regionCode) {
            $returnList[] = [$regionCode];
        }

        return $returnList;
    }

    /**
     * @return array<array{int}>
     */
    public static function supportedGlobalNetworkCallingCodes(): array
    {
        $returnList = [];

        PhoneNumberUtil::resetInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        foreach ($phoneUtil->getSupportedGlobalNetworkCallingCodes() as $callingCode) {
            $returnList[] = [$callingCode];
        }

        return $returnList;
    }

    #[DataProvider('supportedGlobalNetworkCallingCodes')]
    public function testGlobalNetworkNumbers(int $callingCode): void
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumberForNonGeoEntity($callingCode);
        self::assertNotNull($exampleNumber, 'No example phone number for calling code ' . $callingCode);
        if (!$this->phoneNumberUtil->isValidNumber($exampleNumber)) {
            self::fail('Failed validation for ' . $exampleNumber);
        }
    }

    #[DataProvider('regionList')]
    public function testEveryRegionHasAnExampleNumber(string $regionCode): void
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumber($regionCode);
        self::assertNotNull($exampleNumber, 'No example number found for region ' . $regionCode);

        /*
         * Check the number is valid
         */

        $e164 = $this->phoneNumberUtil->format($exampleNumber, PhoneNumberFormat::E164);

        $phoneObject = $this->phoneNumberUtil->parse($e164, 'ZZ');

        self::assertEquals($phoneObject, $exampleNumber);

        self::assertTrue($this->phoneNumberUtil->isValidNumber($phoneObject));
        self::assertTrue($this->phoneNumberUtil->isValidNumberForRegion($phoneObject, $regionCode));
    }

    #[DataProvider('regionList')]
    public function testEveryRegionHasAnInvalidExampleNumber(string $regionCode): void
    {
        $exampleNumber = $this->phoneNumberUtil->getInvalidExampleNumber($regionCode);
        self::assertNotNull($exampleNumber, 'No invalid example number found for region ' . $regionCode);
    }

    #[DataProvider('numberTypes')]
    public function testEveryTypeHasAnExampleNumber(PhoneNumberType $numberType): void
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumberForType($numberType);
        self::assertNotNull($exampleNumber, 'No example number found for type ' . $numberType->name);
    }

    #[DataProvider('shortNumberRegionList')]
    public function testShortNumbersValidAndCorrectCost(string $regionCode): void
    {
        $exampleShortNumber = $this->shortNumberInfo->getExampleShortNumber($regionCode);
        if (!$this->shortNumberInfo->isValidShortNumberForRegion(
            $this->phoneNumberUtil->parse($exampleShortNumber, $regionCode),
            $regionCode
        )
        ) {
            self::fail(
                "Failed validation for string region_code: {$regionCode}, national_number: {$exampleShortNumber}"
            );
        }
        $phoneNumber = $this->phoneNumberUtil->parse($exampleShortNumber, $regionCode);
        if (!$this->shortNumberInfo->isValidShortNumber($phoneNumber)) {
            self::fail('Failed validation for ' . $phoneNumber);
        }
    }

    /**
     * @return array<array{string,ShortNumberCost}>
     */
    public static function shortRegionListAndNumberCost(): array
    {
        $costArray = [
            ShortNumberCost::PREMIUM_RATE,
            ShortNumberCost::STANDARD_RATE,
            ShortNumberCost::TOLL_FREE,
            ShortNumberCost::UNKNOWN_COST,
        ];

        $output = [];

        foreach (self::shortNumberRegionList() as $region) {
            foreach ($costArray as $cost) {
                $output[] = [$region[0], $cost];
            }
        }

        return $output;
    }

    #[DataProvider('shortRegionListAndNumberCost')]
    public function testShortNumberHasCorrectCost(string $regionCode, ShortNumberCost $cost): void
    {
        $exampleShortNumber = $this->shortNumberInfo->getExampleShortNumberForCost($regionCode, $cost);
        if ($exampleShortNumber !== '') {
            $phoneNumber = $this->phoneNumberUtil->parse($exampleShortNumber, $regionCode);
            $exampleShortNumberCost = $this->shortNumberInfo->getExpectedCostForRegion($phoneNumber, $regionCode);

            self::assertSame($cost, $exampleShortNumberCost, 'Wrong cost for ' . $phoneNumber);
        }
    }

    #[DataProvider('shortNumberRegionList')]
    public function testEmergency(string $regionCode): void
    {
        $desc = $this->shortNumberInfo->getMetadataForRegion($regionCode)?->getEmergency();
        self::assertNotNull($desc);

        if ($desc->hasExampleNumber()) {
            $exampleNumber = $desc->getExampleNumber();
            $phoneNumber = $this->phoneNumberUtil->parse($exampleNumber, $regionCode);

            if (!$this->shortNumberInfo->isPossibleShortNumberForRegion(
                $phoneNumber,
                $regionCode
            ) || !$this->shortNumberInfo->isEmergencyNumber($exampleNumber, $regionCode)
            ) {
                self::fail('Emergency example number test failed for ' . $regionCode);
            } elseif ($this->shortNumberInfo->getExpectedCostForRegion(
                $phoneNumber,
                $regionCode
            ) !== ShortNumberCost::TOLL_FREE
            ) {
                self::fail('Emergency example number not toll free for ' . $regionCode);
            }
        }
    }

    #[DataProvider('shortNumberRegionList')]
    public function testCarrierSpecificShortNumbers(string $regionCode): void
    {
        // Test the carrier-specific tag.
        $desc = $this->shortNumberInfo->getMetadataForRegion($regionCode)?->getCarrierSpecific();
        self::assertNotNull($desc);

        if ($desc->hasExampleNumber()) {
            $exampleNumber = $desc->getExampleNumber();
            $carrierSpecificNumber = $this->phoneNumberUtil->parse($exampleNumber, $regionCode);

            if (!$this->shortNumberInfo->isPossibleShortNumberForRegion($carrierSpecificNumber, $regionCode)
                || !$this->shortNumberInfo->isCarrierSpecificForRegion($carrierSpecificNumber, $regionCode)
            ) {
                self::fail('Carrier-specific test failed for ' . $regionCode);
            }
        }
    }

    #[DataProvider('shortNumberRegionList')]
    public function testSmsServiceShortNumbers(string $regionCode): void
    {
        $desc = $this->shortNumberInfo->getMetadataForRegion($regionCode)?->getSmsServices();
        self::assertNotNull($desc);

        if ($desc->hasExampleNumber()) {
            $exampleNumber = $desc->getExampleNumber();
            $smsServiceNumber = $this->phoneNumberUtil->parse($exampleNumber, $regionCode);
            if (!$this->shortNumberInfo->isPossibleShortNumberForRegion($smsServiceNumber, $regionCode)
                || !$this->shortNumberInfo->isSmsServiceForRegion($smsServiceNumber, $regionCode)) {
                self::fail('SMS service test failed for ' . $regionCode);
            }
        }
    }
}
