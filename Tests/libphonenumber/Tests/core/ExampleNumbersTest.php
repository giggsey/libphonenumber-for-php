<?php

namespace libphonenumber\Tests\core;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberType;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\ShortNumberCost;
use libphonenumber\ShortNumberInfo;

/**
 * Verifies all of the example numbers in the metadata are valid and of the correct type. If no
 * example number exists for a particular type, the test still passes.
 */
class ExampleNumbersTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var PhoneNumberUtil
     */
    private $phoneNumberUtil;
    /**
     * @var ShortNumberInfo
     */
    private $shortNumberInfo;

    public static function setUpBeforeClass()
    {
        PhoneNumberUtil::resetInstance();
        PhoneNumberUtil::getInstance();
        ShortNumberInfo::resetInstance();
    }

    public function setUp()
    {
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
        $this->shortNumberInfo = ShortNumberInfo::getInstance();
    }

    public function regionList()
    {
        $returnList = array();

        PhoneNumberUtil::resetInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        foreach ($phoneUtil->getSupportedRegions() as $regionCode) {
            $returnList[] = array($regionCode);
        }

        return $returnList;
    }

    public function numberTypes()
    {
        return array(
            array(PhoneNumberType::FIXED_LINE),
            array(PhoneNumberType::MOBILE),
            array(PhoneNumberType::FIXED_LINE_OR_MOBILE),
            array(PhoneNumberType::TOLL_FREE),
            array(PhoneNumberType::PREMIUM_RATE),
            array(PhoneNumberType::SHARED_COST),
            array(PhoneNumberType::VOIP),
            array(PhoneNumberType::PERSONAL_NUMBER),
            array(PhoneNumberType::PAGER),
            array(PhoneNumberType::UAN),
            array(PhoneNumberType::UNKNOWN),
            array(PhoneNumberType::EMERGENCY),
            array(PhoneNumberType::VOICEMAIL),
            array(PhoneNumberType::SHORT_CODE),
            array(PhoneNumberType::STANDARD_RATE),
        );
    }

    /**
     * @dataProvider regionList
     */
    public function testFixedLine($region)
    {
        $fixedLineTypes = array(PhoneNumberType::FIXED_LINE, PhoneNumberType::FIXED_LINE_OR_MOBILE);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::FIXED_LINE, $fixedLineTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testFixedLineOrMobile($region)
    {
        $numberTypes = array(PhoneNumberType::FIXED_LINE, PhoneNumberType::FIXED_LINE_OR_MOBILE);
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
        $mobileTypes = array(PhoneNumberType::MOBILE, PhoneNumberType::FIXED_LINE_OR_MOBILE);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::MOBILE, $mobileTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testTollFree($region)
    {
        $tollFreeTypes = array(PhoneNumberType::TOLL_FREE);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::TOLL_FREE, $tollFreeTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testPremiumRate($region)
    {
        $premiumRateTypes = array(PhoneNumberType::PREMIUM_RATE);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PREMIUM_RATE, $premiumRateTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testVoip($region)
    {
        $voipTypes = array(PhoneNumberType::VOIP);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::VOIP, $voipTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testPager($region)
    {
        $pagerTypes = array(PhoneNumberType::PAGER);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PAGER, $pagerTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testUan($region)
    {
        $uanTypes = array(PhoneNumberType::UAN);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::UAN, $uanTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testVoicemail($region)
    {
        $voicemailTypes = array(PhoneNumberType::VOICEMAIL);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::VOICEMAIL, $voicemailTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testPersonalNumber($region)
    {
        $numberTypes = array(PhoneNumberType::PERSONAL_NUMBER);
        $this->checkNumbersValidAndCorrectType(PhoneNumberType::PERSONAL_NUMBER, $numberTypes, $region);
    }

    /**
     * @dataProvider regionList
     */
    public function testSharedCost($region)
    {
        $sharedCostTypes = array(PhoneNumberType::SHARED_COST);
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
        $returnList = array();

        PhoneNumberUtil::resetInstance();
        ShortNumberInfo::resetInstance();
        $shortNumberInfo = ShortNumberInfo::getInstance();
        foreach ($shortNumberInfo->getSupportedRegions() as $regionCode) {
            $returnList[] = array($regionCode);
        }

        return $returnList;
    }

    public function supportedGlobalNetworkCallingCodes()
    {
        $returnList = array();

        PhoneNumberUtil::resetInstance();
        $phoneUtil = PhoneNumberUtil::getInstance();
        foreach ($phoneUtil->getSupportedGlobalNetworkCallingCodes() as $callingCode) {
            $returnList[] = array($callingCode);
        }

        return $returnList;
    }

    /**
     * @dataProvider supportedGlobalNetworkCallingCodes
     */
    public function testGlobalNetworkNumbers($callingCode)
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumberForNonGeoEntity($callingCode);
        $this->assertNotNull($exampleNumber, "No example phone number for calling code " . $callingCode);
        if (!$this->phoneNumberUtil->isValidNumber($exampleNumber)) {
            $this->fail("Failed validation for " . $exampleNumber);
        }
    }

    /**
     * @dataProvider regionList
     * @param string $regionCode
     */
    public function testEveryRegionHasAnExampleNumber($regionCode)
    {
        $exampleNumber = $this->phoneNumberUtil->getExampleNumber($regionCode);
        $this->assertNotNull($exampleNumber, "No example number found for region " . $regionCode);

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
            $this->fail("Failed validation for " . (string)$phoneNumber);
        }
    }

    public function shortRegionListAndNumberCost()
    {
        $costArray = array(
            ShortNumberCost::PREMIUM_RATE,
            ShortNumberCost::STANDARD_RATE,
            ShortNumberCost::TOLL_FREE,
            ShortNumberCost::UNKNOWN_COST
        );

        $output = array();

        foreach ($this->shortNumberRegionList() as $region) {
            foreach ($costArray as $cost) {
                $output[] = array($region[0], $cost);
            }
        }

        return $output;
    }

    /**
     * @dataProvider shortRegionListAndNumberCost
     * @param $regionCode
     * @param $cost
     */
    public function testShortNumberHasCorrectCost($regionCode, $cost)
    {
        $exampleShortNumber = $this->shortNumberInfo->getExampleShortNumberForCost($regionCode, $cost);
        if ($exampleShortNumber != '') {
            $phoneNumber = $this->phoneNumberUtil->parse($exampleShortNumber, $regionCode);
            $exampleShortNumberCost = $this->shortNumberInfo->getExpectedCostForRegion($phoneNumber, $regionCode);

            $this->assertEquals($cost, $exampleShortNumberCost, 'Wrong cost for ' . (string)$phoneNumber);
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
                $this->fail("Emergency example number test failed for " . $regionCode);
            } elseif ($this->shortNumberInfo->getExpectedCostForRegion(
                    $phoneNumber,
                    $regionCode
                ) !== ShortNumberCost::TOLL_FREE
            ) {
                $this->fail("Emergency example number not toll free for " . $regionCode);
            }
        }
    }

    /**
     * @dataProvider shortNumberRegionList
     */
    public function testCarrierSpecificShortNumbers($regionCode)
    {
        // Test the carrier-specific tag.
        $desc = $this->shortNumberInfo->getMetadataForRegion($regionCode)->getCarrierSpecific();
        if ($desc->hasExampleNumber()) {
            $exampleNumber = $desc->getExampleNumber();
            $carrierSpecificNumber = $this->phoneNumberUtil->parse($exampleNumber, $regionCode);

            if (!$this->shortNumberInfo->isPossibleShortNumberForRegion(
                    $carrierSpecificNumber,
                    $regionCode
                ) || !$this->shortNumberInfo->isCarrierSpecific($carrierSpecificNumber)
            ) {
                $this->fail("Carrier-specific test failed for " . $regionCode);
            }
        }
    }
}
