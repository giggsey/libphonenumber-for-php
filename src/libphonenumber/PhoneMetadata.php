<?php

namespace libphonenumber;

class PhoneMetadata
{

    /**
     * @var string
     */
    private $id = null;

    /**
     * @return boolean
     */
    public function hasId()
    {
        return isset($this->id);
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $value
     * @return PhoneMetadata
     */
    public function setId($value)
    {
        $this->id = $value;
        return $this;
    }

    /**
     * @var int
     */
    private $countryCode = null;

    /**
     * @return boolean
     */
    public function hasCountryCode()
    {
        return isset($this->countryCode);
    }

    /**
     * @return int
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param int $value
     * @return PhoneMetadata
     */
    public function setCountryCode($value)
    {
        $this->countryCode = $value;
        return $this;
    }

    private $leadingDigits = null;

    /**
     * @return bool
     */
    public function hasLeadingDigits()
    {
        return isset($this->leadingDigits);
    }

    public function getLeadingDigits()
    {
        return $this->leadingDigits;
    }

    public function setLeadingDigits($value)
    {
        $this->leadingDigits = $value;
        return $this;
    }

    private $internationalPrefix = null;

    public function hasInternationalPrefix()
    {
        return isset($this->internationalPrefix);
    }

    public function getInternationalPrefix()
    {
        return $this->internationalPrefix;
    }

    public function setInternationalPrefix($value)
    {
        $this->internationalPrefix = $value;
        return $this;
    }

    private $preferredInternationalPrefix = null;

    public function hasPreferredInternationalPrefix()
    {
        return isset($this->preferredInternationalPrefix);
    }

    public function getPreferredInternationalPrefix()
    {
        return $this->preferredInternationalPrefix;
    }

    public function setPreferredInternationalPrefix($value)
    {
        $this->preferredInternationalPrefix = $value;
        return $this;
    }

    private $nationalPrefixForParsing = null;

    public function hasNationalPrefixForParsing()
    {
        return isset($this->nationalPrefixForParsing);
    }

    public function getNationalPrefixForParsing()
    {
        return $this->nationalPrefixForParsing;
    }

    public function setNationalPrefixForParsing($value)
    {
        $this->nationalPrefixForParsing = $value;
        return $this;
    }

    private $nationalPrefixTransformRule = null;

    public function hasNationalPrefixTransformRule()
    {
        return isset($this->nationalPrefixTransformRule);
    }

    public function getNationalPrefixTransformRule()
    {
        return $this->nationalPrefixTransformRule;
    }

    public function setNationalPrefixTransformRule($value)
    {
        $this->nationalPrefixTransformRule = $value;
        return $this;
    }

    private $nationalPrefix = null;

    public function hasNationalPrefix()
    {
        return isset($this->nationalPrefix);
    }

    public function getNationalPrefix()
    {
        return $this->nationalPrefix;
    }

    public function setNationalPrefix($value)
    {
        $this->nationalPrefix = $value;
        return $this;
    }

    private $preferredExtnPrefix = null;

    public function hasPreferredExtnPrefix()
    {
        return isset($this->preferredExtnPrefix);
    }

    public function getPreferredExtnPrefix()
    {
        return $this->preferredExtnPrefix;
    }

    public function setPreferredExtnPrefix($value)
    {
        $this->preferredExtnPrefix = $value;
        return $this;
    }

    private $mainCountryForCode = false;

    public function hasMainCountryForCode()
    {
        return isset($this->mainCountryForCode);
    }

    public function isMainCountryForCode()
    {
        return $this->mainCountryForCode;
    }

    public function getMainCountryForCode()
    {
        return $this->mainCountryForCode;
    }

    public function setMainCountryForCode($value)
    {
        $this->mainCountryForCode = $value;
        return $this;
    }

    private $leadingZeroPossible = false;

    public function hasLeadingZeroPossible()
    {
        return isset($this->leadingZeroPossible);
    }

    public function isLeadingZeroPossible()
    {
        return $this->leadingZeroPossible;
    }

    public function setLeadingZeroPossible($value)
    {
        $this->leadingZeroPossible = $value;
        return $this;
    }

    private $mobileNumberPortableRegion = false;

    public function hasMobileNumberPortableRegion()
    {
        return isset($this->mobileNumberPortableRegion);
    }

    public function isMobileNumberPortableRegion()
    {
        return $this->mobileNumberPortableRegion;
    }

    public function setMobileNumberPortableRegion($value)
    {
        $this->mobileNumberPortableRegion = $value;
        return $this;
    }

    private $generalDesc = null;

    public function hasGeneralDesc()
    {
        return isset($this->generalDesc);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getGeneralDesc()
    {
        return $this->generalDesc;
    }

    public function setGeneralDesc(PhoneNumberDesc $value)
    {
        $this->generalDesc = $value;
        return $this;
    }

    /**
     * @var PhoneNumberDesc
     */
    private $mobile = null;

    public function hasMobile()
    {
        return isset($this->mobile);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    public function setMobile(PhoneNumberDesc $value)
    {
        $this->mobile = $value;
        return $this;
    }

    private $premiumRate = null;

    public function hasPremiumRate()
    {
        return isset($this->premiumRate);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getPremiumRate()
    {
        return $this->premiumRate;
    }

    public function setPremiumRate(PhoneNumberDesc $value)
    {
        $this->premiumRate = $value;
        return $this;
    }

    private $fixedLine = null;

    public function hasFixedLine()
    {
        return isset($this->fixedLine);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getFixedLine()
    {
        return $this->fixedLine;
    }

    public function setFixedLine(PhoneNumberDesc $value)
    {
        $this->fixedLine = $value;
        return $this;
    }

    private $sameMobileAndFixedLinePattern = false;

    public function hasSameMobileAndFixedLinePattern()
    {
        return isset($this->sameMobileAndFixedLinePattern);
    }

    public function isSameMobileAndFixedLinePattern()
    {
        return $this->sameMobileAndFixedLinePattern;
    }

    public function setSameMobileAndFixedLinePattern($value)
    {
        $this->sameMobileAndFixedLinePattern = $value;
        return $this;
    }

    private $numberFormat = array();

    /**
     * @return NumberFormat[]
     */
    public function numberFormats()
    {
        return $this->numberFormat;
    }

    public function numberFormatSize()
    {
        return count($this->numberFormat);
    }

    /**
     * @param int $index
     * @return NumberFormat
     */
    public function getNumberFormat($index)
    {
        return $this->numberFormat[$index];
    }

    public function addNumberFormat(NumberFormat $value)
    {
        $this->numberFormat[] = $value;
        return $this;
    }

    private $tollFree = null;

    public function hasTollFree()
    {
        return isset($this->tollFree);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getTollFree()
    {
        return $this->tollFree;
    }

    public function setTollFree(PhoneNumberDesc $value)
    {
        $this->tollFree = $value;
        return $this;
    }

    private $sharedCost = null;

    public function hasSharedCost()
    {
        return isset($this->sharedCost);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getSharedCost()
    {
        return $this->sharedCost;
    }

    public function setSharedCost(PhoneNumberDesc $value)
    {
        $this->sharedCost = $value;
        return $this;
    }

    private $personalNumber;

    public function hasPersonalNumber()
    {
        return isset($this->personalNumber);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getPersonalNumber()
    {
        return $this->personalNumber;
    }

    public function setPersonalNumber(PhoneNumberDesc $value)
    {
        $this->personalNumber = $value;
        return $this;
    }

    private $voip;

    public function hasVoip()
    {
        return isset($this->voip);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getVoip()
    {
        return $this->voip;
    }

    public function setVoip(PhoneNumberDesc $value)
    {
        $this->voip = $value;
        return $this;
    }

    private $pager;

    public function hasPager()
    {
        return isset($this->pager);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getPager()
    {
        return $this->pager;
    }

    public function setPager(PhoneNumberDesc $value)
    {
        $this->pager = $value;
        return $this;
    }

    private $uan;

    public function hasUan()
    {
        return isset($this->uan);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getUan()
    {
        return $this->uan;
    }

    public function setUan(PhoneNumberDesc $value)
    {
        $this->uan = $value;
        return $this;
    }

    private $emergency;

    public function hasEmergency()
    {
        return isset($this->emergency);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getEmergency()
    {
        return $this->emergency;
    }

    public function setEmergency(PhoneNumberDesc $value)
    {
        $this->emergency = $value;
        return $this;
    }

    private $voicemail;

    public function hasVoicemail()
    {
        return isset($this->voicemail);
    }

    /**
     * @return PhoneNumberDesc
     */
    public function getVoicemail()
    {
        return $this->voicemail;
    }

    public function setVoicemail(PhoneNumberDesc $value)
    {
        $this->voicemail = $value;
        return $this;
    }

    /**
     * @var PhoneNumberDesc
     */
    private $short_code;

    public function hasShortCode()
    {
        return isset($this->short_code);
    }

    public function getShortCode()
    {
        return $this->short_code;
    }

    public function setShortCode(PhoneNumberDesc $value)
    {
        $this->short_code = $value;
        return $this;
    }

    private $standard_rate;

    public function hasStandardRate()
    {
        return isset($this->standard_rate);
    }

    public function getStandardRate()
    {
        return $this->standard_rate;
    }

    public function setStandardRate(PhoneNumberDesc $value)
    {
        $this->standard_rate = $value;
        return $this;
    }

    /**
     * @var PhoneNumberDesc
     */
    private $carrierSpecific;

    public function hasCarrierSpecific()
    {
        return isset($this->carrierSpecific);
    }

    public function getCarrierSpecific()
    {
        return $this->carrierSpecific;
    }

    public function setCarrierSpecific(PhoneNumberDesc $value)
    {
        $this->carrierSpecific = $value;
        return $this;
    }


    private $noInternationalDialling = null;

    public function hasNoInternationalDialling()
    {
        return isset($this->noInternationalDialling);
    }

    public function getNoInternationalDialling()
    {
        return $this->noInternationalDialling;
    }

    public function setNoInternationalDialling(PhoneNumberDesc $value)
    {
        $this->noInternationalDialling = $value;
        return $this;
    }

    /**
     *
     * @var NumberFormat[]
     */
    private $intlNumberFormat = array();

    public function intlNumberFormats()
    {
        return $this->intlNumberFormat;
    }

    public function intlNumberFormatSize()
    {
        return count($this->intlNumberFormat);
    }

    public function getIntlNumberFormat($index)
    {
        return $this->intlNumberFormat[$index];
    }

    public function addIntlNumberFormat(NumberFormat $value)
    {
        $this->intlNumberFormat[] = $value;
        return $this;
    }

    public function clearIntlNumberFormat()
    {
        $this->intlNumberFormat = array();
        return $this;
    }

    public function toArray()
    {
        $output = array();

        if ($this->hasGeneralDesc()) {
            $output['generalDesc'] = $this->getGeneralDesc()->toArray();
        }

        if ($this->hasFixedLine()) {
            $output['fixedLine'] = $this->getFixedLine()->toArray();
        }

        if ($this->hasMobile()) {
            $output['mobile'] = $this->getMobile()->toArray();
        }

        if ($this->hasTollFree()) {
            $output['tollFree'] = $this->getTollFree()->toArray();
        }

        if ($this->hasPremiumRate()) {
            $output['premiumRate'] = $this->getPremiumRate()->toArray();
        }

        if ($this->hasPremiumRate()) {
            $output['premiumRate'] = $this->getPremiumRate()->toArray();
        }

        if ($this->hasSharedCost()) {
            $output['sharedCost'] = $this->getSharedCost()->toArray();
        }

        if ($this->hasPersonalNumber()) {
            $output['personalNumber'] = $this->getPersonalNumber()->toArray();
        }

        if ($this->hasVoip()) {
            $output['voip'] = $this->getVoip()->toArray();
        }

        if ($this->hasPager()) {
            $output['pager'] = $this->getPager()->toArray();
        }

        if ($this->hasUan()) {
            $output['uan'] = $this->getUan()->toArray();
        }

        if ($this->hasEmergency()) {
            $output['emergency'] = $this->getEmergency()->toArray();
        }

        if ($this->hasVoicemail()) {
            $output['voicemail'] = $this->getVoicemail()->toArray();
        }

        if ($this->hasShortCode()) {
            $output['shortCode'] = $this->getShortCode()->toArray();
        }

        if ($this->hasStandardRate()) {
            $output['standardRate'] = $this->getStandardRate()->toArray();
        }

        if ($this->hasCarrierSpecific()) {
            $output['carrierSpecific'] = $this->getCarrierSpecific()->toArray();
        }

        if ($this->hasNoInternationalDialling()) {
            $output['noInternationalDialling'] = $this->getNoInternationalDialling()->toArray();
        }

        $output['id'] = $this->getId();
        $output['countryCode'] = $this->getCountryCode();
        $output['internationalPrefix'] = $this->getInternationalPrefix();

        if ($this->hasPreferredInternationalPrefix()) {
            $output['preferredInternationalPrefix'] = $this->getPreferredInternationalPrefix();
        }

        if ($this->hasNationalPrefix()) {
            $output['nationalPrefix'] = $this->getNationalPrefix();
        }

        if ($this->hasPreferredExtnPrefix()) {
            $output['preferredExtnPrefix'] = $this->getPreferredExtnPrefix();
        }

        if ($this->hasNationalPrefixForParsing()) {
            $output['nationalPrefixForParsing'] = $this->getNationalPrefixForParsing();
        }

        if ($this->hasNationalPrefixTransformRule()) {
            $output['nationalPrefixTransformRule'] = $this->getNationalPrefixTransformRule();
        }

        $output['sameMobileAndFixedLinePattern'] = $this->isSameMobileAndFixedLinePattern();

        $output['numberFormat'] = array();
        foreach ($this->numberFormats() as $numberFormat) {
            $output['numberFormat'][] = $numberFormat->toArray();
        }

        $output['intlNumberFormat'] = array();
        foreach ($this->intlNumberFormats() as $intlNumberFormat) {
            $output['intlNumberFormat'][] = $intlNumberFormat->toArray();
        }

        $output['mainCountryForCode'] = $this->getMainCountryForCode();

        if ($this->hasLeadingDigits()) {
            $output['leadingDigits'] = $this->getLeadingDigits();
        }

        $output['leadingZeroPossible'] = $this->isLeadingZeroPossible();

        $output['mobileNumberPortableRegion'] = $this->isMobileNumberPortableRegion();

        return $output;
    }

    public function fromArray(array $input)
    {

        if (isset($input['generalDesc'])) {
            $desc = new PhoneNumberDesc();
            $this->setGeneralDesc($desc->fromArray($input['generalDesc']));
        }

        if (isset($input['fixedLine'])) {
            $desc = new PhoneNumberDesc();
            $this->setFixedLine($desc->fromArray($input['fixedLine']));
        }

        if (isset($input['mobile'])) {
            $desc = new PhoneNumberDesc();
            $this->setMobile($desc->fromArray($input['mobile']));
        }

        if (isset($input['tollFree'])) {
            $desc = new PhoneNumberDesc();
            $this->setTollFree($desc->fromArray($input['tollFree']));
        }

        if (isset($input['premiumRate'])) {
            $desc = new PhoneNumberDesc();
            $this->setPremiumRate($desc->fromArray($input['premiumRate']));
        }

        if (isset($input['sharedCost'])) {
            $desc = new PhoneNumberDesc();
            $this->setSharedCost($desc->fromArray($input['sharedCost']));
        }

        if (isset($input['personalNumber'])) {
            $desc = new PhoneNumberDesc();
            $this->setPersonalNumber($desc->fromArray($input['personalNumber']));
        }

        if (isset($input['voip'])) {
            $desc = new PhoneNumberDesc();
            $this->setVoip($desc->fromArray($input['voip']));
        }

        if (isset($input['pager'])) {
            $desc = new PhoneNumberDesc();
            $this->setPager($desc->fromArray($input['pager']));
        }

        if (isset($input['uan'])) {
            $desc = new PhoneNumberDesc();
            $this->setUan($desc->fromArray($input['uan']));
        }

        if (isset($input['emergency'])) {
            $desc = new PhoneNumberDesc();
            $this->setEmergency($desc->fromArray($input['emergency']));
        }

        if (isset($input['voicemail'])) {
            $desc = new PhoneNumberDesc();
            $this->setVoicemail($desc->fromArray($input['voicemail']));
        }

        if (isset($input['shortCode'])) {
            $desc = new PhoneNumberDesc();
            $this->setShortCode(($desc->fromArray($input['shortCode'])));
        }

        if (isset($input['standardRate'])) {
            $desc = new PhoneNumberDesc();
            $this->setStandardRate($desc->fromArray($input['standardRate']));
        }

        if (isset($input['carrierSpecific'])) {
            $desc = new PhoneNumberDesc();
            $this->setCarrierSpecific($desc->fromArray($input['carrierSpecific']));
        }

        if (isset($input['noInternationalDialling'])) {
            $desc = new PhoneNumberDesc();
            $this->setNoInternationalDialling($desc->fromArray($input['noInternationalDialling']));
        }

        $this->setId($input['id']);
        $this->setCountryCode($input['countryCode']);
        $this->setInternationalPrefix($input['internationalPrefix']);

        if (isset($input['preferredInternationalPrefix'])) {
            $this->setPreferredInternationalPrefix($input['preferredInternationalPrefix']);
        }
        if (isset($input['nationalPrefix'])) {
            $this->setNationalPrefix($input['nationalPrefix']);
        }
        if (isset($input['nationalPrefix'])) {
            $this->setNationalPrefix($input['nationalPrefix']);
        }

        if (isset($input['preferredExtnPrefix'])) {
            $this->setPreferredExtnPrefix($input['preferredExtnPrefix']);
        }

        if (isset($input['nationalPrefixForParsing'])) {
            $this->setNationalPrefixForParsing($input['nationalPrefixForParsing']);
        }

        if (isset($input['nationalPrefixTransformRule'])) {
            $this->setNationalPrefixTransformRule($input['nationalPrefixTransformRule']);
        }

        foreach ($input['numberFormat'] as $numberFormatElt) {
            $numberFormat = new NumberFormat();
            $numberFormat->fromArray($numberFormatElt);
            $this->addNumberFormat($numberFormat);
        }

        foreach ($input['intlNumberFormat'] as $intlNumberFormatElt) {
            $numberFormat = new NumberFormat();
            $numberFormat->fromArray($intlNumberFormatElt);
            $this->addIntlNumberFormat($numberFormat);
        }

        $this->setMainCountryForCode($input['mainCountryForCode']);

        if (isset($input['leadingDigits'])) {
            $this->setLeadingDigits($input['leadingDigits']);
        }

        $this->setLeadingZeroPossible($input['leadingZeroPossible']);

        $this->setMobileNumberPortableRegion($input['mobileNumberPortableRegion']);

        return $this;
    }

}
