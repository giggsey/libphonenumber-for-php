<?php

namespace libphonenumber\Tests\core;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberCost;
use libphonenumber\ShortNumberInfo;
use PHPUnit\Framework\TestCase;

/**
 * Verifies all of the example numbers in the metadata are valid and of the correct type. If no
 * example number exists for a particular type, the test still passes since not all types are
 * relevant for all regions. Tests that check the XML schema will ensure that an exampleNumber
 * node is present for every phone number description.
 */
class ExampleNumbersTest extends TestCase
{
    /**
     * @var PhoneNumberUtil
     */
    private $phoneNumberUtil;
    /**
     * @var ShortNumberInfo
     */
    private $shortNumberInfo;

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

    public function regionList()
    {
        $returnList = [];

        PhoneNumberUtil::resetInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        foreach ($phoneUtil->getSupportedRegions() as $regionCode) {
            $returnList[] = [$regionCode];
        }

        return $returnList;
    }

    public function numberTypes()
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

    /**
     * @dataProvider regionList
     */
    public function testFixedLine($region)
    {
        $fixedLineTypes = [PhoneNumberType::FIXED_LINE, PhoneNumberType::FIXED_LINE_OR_MOBILE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::FIXED_LINE, $fixedLineTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testFixedLineOrMobile($region)
    {
        $numberTypes = [PhoneNumberType::FIXED_LINE, PhoneNumberType::FIXED_LINE_OR_MOBILE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::FIXED_LINE_OR_MOBILE, $numberTypes, $region);
    }

    private function checkNumbersValidAndCorrectType($exampleNumberRequestedType, $possibleExpectedTypes, $regionCode)
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumberForType($regionCode, $exampleNumberRequestedType);
        if ($exampleNumber !== null) {
            $this->assertTrue(
                $this->phoneNumberUtil->isValidNumber($exampleNumber),
                "Failed validation for {$exampleNumber}"
            );

            // We know the number is valid, now we check the type.
            $exampleNumberType = $this->phoneNumberUtil->getNumberType($exampleNumber);
            $this->assertContains($exampleNumberType, $possibleExpectedTypes, "Wrong type for {$exampleNumber}");
        }
    }

    /**
     * @dataProvider regionList
     */
    public function testMobile($region)
    {
        $mobileTypes = [PhoneNumberType::MOBILE, PhoneNumberType::FIXED_LINE_OR_MOBILE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::MOBILE, $mobileTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testTollFree($region)
    {
        $tollFreeTypes = [PhoneNumberType::TOLL_FREE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::TOLL_FREE, $tollFreeTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testPremiumRate($region)
    {
        $premiumRateTypes = [PhoneNumberType::PREMIUM_RATE];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PREMIUM_RATE, $premiumRateTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testVoip($region)
    {
        $voipTypes = [PhoneNumberType::VOIP];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::VOIP, $voipTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testPager($region)
    {
        $pagerTypes = [PhoneNumberType::PAGER];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PAGER, $pagerTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testUan($region)
    {
        $uanTypes = [PhoneNumberType::UAN];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::UAN, $uanTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testVoicemail($region)
    {
        $voicemailTypes = [PhoneNumberType::VOICEMAIL];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::VOICEMAIL, $voicemailTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testPersonalNumber($region)
    {
        $numberTypes = [PhoneNumberType::PERSONAL_NUMBER];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PERSONAL_NUMBER, $numberTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testSharedCost($region)
    {
        $sharedCostTypes = [PhoneNumberType::SHARED_COST];
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::SHARED_COST, $sharedCostTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testCanBeInternationallyDialled($regionCode)
    {
        $exampleNumber = null;
        /** @var \libphonenumber\PhoneNumberDesc $desc */
        $desc = $this->phoneNumberUtil->getMetadataForRegion($regionCode)->getNoInternationalDialling();
        try {
            if ($desc->hasExampleNumber()) {
                $exampleNumber = $this->phoneNumberUtil->parse($desc->getExampleNumber(), $regionCode);
            }
        } catch (NumberParseException $e) {
        }

        if ($exampleNumber !== null && $this->phoneNumberUtil->canBeInternationallyDialled($exampleNumber)) {
            $this->fail("Number {$exampleNumber} should not be internationally diallable");
        }
    }

    public function shortNumberRegionList()
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

    public function supportedGlobalNetworkCallingCodes()
    {
        $returnList = [];

        PhoneNumberUtil::resetInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        foreach ($phoneUtil->getSupportedGlobalNetworkCallingCodes() as $callingCode) {
            $returnList[] = [$callingCode];
        }

        return $returnList;
    }

    /**
     * @dataProvider supportedGlobalNetworkCallingCodes
     */
    public function testGlobalNetworkNumbers($callingCode)
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumberForNonGeoEntity($callingCode);
        $this->assertNotNull($exampleNumber, 'No example phone number for calling code ' . $callingCode);
        if (!$this->phoneNumberUtil->isValidNumber($exampleNumber)) {
            $this->fail('Failed validation for ' . $exampleNumber);
        }
    }

    /**
     * @dataProvider regionList
     * @param string $regionCode
     */
    public function testEveryRegionHasAnExampleNumber($regionCode)
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumber($regionCode);
        $this->assertNotNull($exampleNumber, 'No example number found for region ' . $regionCode);

        /*
         * Check the number is valid
         */

        $e164 = $this->phoneNumberUtil->format($exampleNumber, PhoneNumberFormat::E164);

        $phoneObject = $this->phoneNumberUtil->parse($e164, 'ZZ');

        $this->assertEquals($phoneObject, $exampleNumber);

        $this->assertTrue($this->phoneNumberUtil->isValidNumber($phoneObject));
        $this->assertTrue($this->phoneNumberUtil->isValidNumberForRegion($phoneObject, $regionCode));
    }

    /**
     * @dataProvider regionList
     * @param string $regionCode
     */
    public function testEveryRegionHasAnInvalidExampleNumber($regionCode)
    {
        $exampleNumber = $this->phoneNumberUtil->getInvalidExampleNumber($regionCode);
        $this->assertNotNull($exampleNumber, 'No invalid example number found for region ' . $regionCode);
    }

    /**
     * @dataProvider numberTypes
     * @param string $numberType
     */
    public function testEveryTypeHasAnExampleNumber($numberType)
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumberForType($numberType);
        $this->assertNotNull($exampleNumber, 'No example number found for type ' . $numberType);
    }

    /**
     * @dataProvider shortNumberRegionList
     */
    public function testShortNumbersValidAndCorrectCost($regionCode)
    {
        $exampleShortNumber = $this->shortNumberInfo->getExampleShortNumber($regionCode);
        if (!$this->shortNumberInfo->isValidShortNumberForRegion(
            $this->phoneNumberUtil->parse($exampleShortNumber, $regionCode),
            $regionCode
        )
        ) {
            $this->fail(
                "Failed validation for string region_code: {$regionCode}, national_number: {$exampleShortNumber}"
            );
        }
        $phoneNumber = $this->phoneNumberUtil->parse($exampleShortNumber, $regionCode);
        if (!$this->shortNumberInfo->isValidShortNumber($phoneNumber)) {
            $this->fail('Failed validation for ' . $phoneNumber);
        }
    }

    public function shortRegionListAndNumberCost()
    {
        $costArray = [
            ShortNumberCost::PREMIUM_RATE,
            ShortNumberCost::STANDARD_RATE,
            ShortNumberCost::TOLL_FREE,
            ShortNumberCost::UNKNOWN_COST,
        ];

        $output = [];

        foreach ($this->shortNumberRegionList() as $region) {
            foreach ($costArray as $cost) {
                $output[] = [$region[0], $cost];
            }
        }

        return $output;
    }

    /**
     * @dataProvider shortRegionListAndNumberCost
     */
    public function testShortNumberHasCorrectCost($regionCode, $cost)
    {
        $exampleShortNumber = $this->shortNumberInfo->getExampleShortNumberForCost($regionCode, $cost);
        if ($exampleShortNumber != '') {
            $phoneNumber = $this->phoneNumberUtil->parse($exampleShortNumber, $regionCode);
            $exampleShortNumberCost = $this->shortNumberInfo->getExpectedCostForRegion($phoneNumber, $regionCode);

            $this->assertEquals($cost, $exampleShortNumberCost, 'Wrong cost for ' . $phoneNumber);
        }
    }

    /**
     * @dataProvider shortNumberRegionList
     */
    public function testEmergency($regionCode)
    {
        $desc = $this->shortNumberInfo->getMetadataForRegion($regionCode)->getEmergency();
        if ($desc->hasExampleNumber()) {
            $exampleNumber = $desc->getExampleNumber();
            $phoneNumber = $this->phoneNumberUtil->parse($exampleNumber, $regionCode);

            if (!$this->shortNumberInfo->isPossibleShortNumberForRegion(
                $phoneNumber,
                $regionCode
            ) || !$this->shortNumberInfo->isEmergencyNumber($exampleNumber, $regionCode)
            ) {
                $this->fail('Emergency example number test failed for ' . $regionCode);
            } elseif ($this->shortNumberInfo->getExpectedCostForRegion(
                $phoneNumber,
                $regionCode
            ) !== ShortNumberCost::TOLL_FREE
            ) {
                $this->fail('Emergency example number not toll free for ' . $regionCode);
            }
        }
    }

    /**
     * @dataProvider shortNumberRegionList
     * @param string $regionCode
     */
    public function testCarrierSpecificShortNumbers($regionCode)
    {
        // Test the carrier-specific tag.
        $desc = $this->shortNumberInfo->getMetadataForRegion($regionCode)->getCarrierSpecific();
        if ($desc->hasExampleNumber()) {
            $exampleNumber = $desc->getExampleNumber();
            $carrierSpecificNumber = $this->phoneNumberUtil->parse($exampleNumber, $regionCode);

            if (!$this->shortNumberInfo->isPossibleShortNumberForRegion($carrierSpecificNumber, $regionCode)
                || !$this->shortNumberInfo->isCarrierSpecificForRegion($carrierSpecificNumber, $regionCode)
            ) {
                $this->fail('Carrier-specific test failed for ' . $regionCode);
            }
        }
    }

    /**
     * @dataProvider shortNumberRegionList
     * @param string $regionCode
     */
    public function testSmsServiceShortNumbers($regionCode)
    {
        $desc = $this->shortNumberInfo->getMetadataForRegion($regionCode)->getSmsServices();

        if ($desc->hasExampleNumber()) {
            $exampleNumber = $desc->getExampleNumber();
            $smsServiceNumber = $this->phoneNumberUtil->parse($exampleNumber, $regionCode);
            if (!$this->shortNumberInfo->isPossibleShortNumberForRegion($smsServiceNumber, $regionCode)
                || !$this->shortNumberInfo->isSmsServiceForRegion($smsServiceNumber, $regionCode)) {
                $this->fail('SMS service test failed for ' . $regionCode);
            }
        }
    }
}
