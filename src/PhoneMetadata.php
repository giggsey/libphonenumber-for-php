<?php

declare(strict_types=1);

namespace libphonenumber;

use function count;

/**
 * Class PhoneMetadata
 * @package libphonenumber
 * @internal Used internally, and can change at any time
 * @phpstan-import-type PhoneNumberDescArray from PhoneNumberDesc
 * @phpstan-import-type NumberFormatArray from NumberFormat
 * @phpstan-type PhoneMetadataArray array{generalDesc?:PhoneNumberDescArray,fixedLine?:PhoneNumberDescArray,mobile?:PhoneNumberDescArray,tollFree?:PhoneNumberDescArray,premiumRate?:PhoneNumberDescArray,sharedCost?:PhoneNumberDescArray,personalNumber?:PhoneNumberDescArray,voip?:PhoneNumberDescArray,pager?:PhoneNumberDescArray,uan?:PhoneNumberDescArray,emergency?:PhoneNumberDescArray,voicemail?:PhoneNumberDescArray,shortCode?:PhoneNumberDescArray,standardRate?:PhoneNumberDescArray,carrierSpecific?:PhoneNumberDescArray,smsServices?:PhoneNumberDescArray,noInternationalDialling?:PhoneNumberDescArray,id:string|null,countryCode?:int,internationalPrefix?:string,preferredInternationalPrefix?:string,nationalPrefix?:string,preferredExtnPrefix?:string,nationalPrefixForParsing?:string,nationalPrefixTransformRule?:string,sameMobileAndFixedLinePattern?:bool,numberFormat:NumberFormatArray[],intlNumberFormat?:NumberFormatArray[],mainCountryForCode?:bool,leadingDigits?:string,mobileNumberPortableRegion?:bool}
 */
class PhoneMetadata
{
    protected ?string $id = null;
    protected ?int $countryCode = null;
    protected ?string $leadingDigits = null;
    protected ?string $internationalPrefix = null;
    protected ?string $preferredInternationalPrefix = null;
    protected ?string $nationalPrefixForParsing = null;
    protected ?string $nationalPrefixTransformRule = null;
    protected ?string $nationalPrefix = null;
    protected ?string $preferredExtnPrefix = null;
    protected bool $mainCountryForCode = false;
    protected bool $mobileNumberPortableRegion = false;
    protected ?PhoneNumberDesc $generalDesc = null;
    protected ?PhoneNumberDesc $mobile = null;
    protected ?PhoneNumberDesc $premiumRate = null;
    protected ?PhoneNumberDesc $fixedLine = null;
    protected bool $sameMobileAndFixedLinePattern = false;
    /**
     * @var NumberFormat[]
     */
    protected array $numberFormat = [];
    protected ?PhoneNumberDesc $tollFree = null;
    protected ?PhoneNumberDesc $sharedCost = null;
    protected ?PhoneNumberDesc $personalNumber = null;
    protected ?PhoneNumberDesc $voip = null;
    protected ?PhoneNumberDesc $pager = null;
    protected ?PhoneNumberDesc $uan = null;
    protected ?PhoneNumberDesc $emergency = null;
    protected ?PhoneNumberDesc $voicemail = null;
    protected ?PhoneNumberDesc $short_code = null;
    protected ?PhoneNumberDesc $standard_rate = null;
    protected ?PhoneNumberDesc $carrierSpecific = null;
    protected ?PhoneNumberDesc $smsServices = null;
    protected ?PhoneNumberDesc $noInternationalDialling = null;
    /**
     * @var NumberFormat[]
     */
    protected array $intlNumberFormat = [];

    public function hasId(): bool
    {
        return $this->id !== null;
    }

    public function hasCountryCode(): bool
    {
        return $this->countryCode !== null;
    }

    public function hasInternationalPrefix(): bool
    {
        return $this->internationalPrefix !== null;
    }

    public function isMainCountryForCode(): bool
    {
        return $this->mainCountryForCode;
    }

    public function getMainCountryForCode(): bool
    {
        return $this->mainCountryForCode;
    }

    public function setMainCountryForCode(bool $value): PhoneMetadata
    {
        $this->mainCountryForCode = $value;
        return $this;
    }

    public function clearMainCountryForCode(): PhoneMetadata
    {
        $this->mainCountryForCode = false;
        return $this;
    }

    public function hasMobileNumberPortableRegion(): bool
    {
        return $this->mobileNumberPortableRegion !== false;
    }

    public function hasSameMobileAndFixedLinePattern(): bool
    {
        return $this->sameMobileAndFixedLinePattern !== false;
    }

    public function numberFormatSize(): int
    {
        return count($this->numberFormat);
    }

    public function getNumberFormat(int $index): NumberFormat
    {
        return $this->numberFormat[$index];
    }

    public function intlNumberFormatSize(): int
    {
        return count($this->intlNumberFormat);
    }

    public function getIntlNumberFormat(int $index): NumberFormat
    {
        return $this->intlNumberFormat[$index];
    }

    public function clearIntlNumberFormat(): PhoneMetadata
    {
        $this->intlNumberFormat = [];
        return $this;
    }

    /**
     * @return PhoneMetadataArray
     */
    public function toArray(): array
    {
        $output = [];

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

        if ($this->hasSmsServices()) {
            $output['smsServices'] = $this->getSmsServices()->toArray();
        }

        if ($this->hasNoInternationalDialling()) {
            $output['noInternationalDialling'] = $this->getNoInternationalDialling()->toArray();
        }

        $output['id'] = $this->getId();
        if ($this->hasCountryCode()) {
            $output['countryCode'] = $this->getCountryCode();
        }

        if ($this->hasInternationalPrefix()) {
            $output['internationalPrefix'] = $this->getInternationalPrefix();
        }

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

        if ($this->hasSameMobileAndFixedLinePattern()) {
            $output['sameMobileAndFixedLinePattern'] = $this->getSameMobileAndFixedLinePattern();
        }

        $output['numberFormat'] = [];
        foreach ($this->numberFormats() as $numberFormat) {
            $output['numberFormat'][] = $numberFormat->toArray();
        }

        $output['intlNumberFormat'] = [];
        foreach ($this->intlNumberFormats() as $intlNumberFormat) {
            $output['intlNumberFormat'][] = $intlNumberFormat->toArray();
        }

        $output['mainCountryForCode'] = $this->getMainCountryForCode();

        if ($this->hasLeadingDigits()) {
            $output['leadingDigits'] = $this->getLeadingDigits();
        }

        if ($this->hasMobileNumberPortableRegion()) {
            $output['mobileNumberPortableRegion'] = $this->isMobileNumberPortableRegion();
        }

        return $output;
    }

    public function hasGeneralDesc(): bool
    {
        return $this->generalDesc !== null;
    }

    public function getGeneralDesc(): ?PhoneNumberDesc
    {
        return $this->generalDesc;
    }

    public function setGeneralDesc(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->generalDesc = $value;
        return $this;
    }

    public function hasFixedLine(): bool
    {
        return $this->fixedLine !== null;
    }

    public function getFixedLine(): ?PhoneNumberDesc
    {
        return $this->fixedLine;
    }

    public function setFixedLine(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->fixedLine = $value;
        return $this;
    }

    public function hasMobile(): bool
    {
        return $this->mobile !== null;
    }

    public function getMobile(): ?PhoneNumberDesc
    {
        return $this->mobile;
    }

    public function setMobile(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->mobile = $value;
        return $this;
    }

    public function hasTollFree(): bool
    {
        return $this->tollFree !== null;
    }

    public function getTollFree(): ?PhoneNumberDesc
    {
        return $this->tollFree;
    }

    public function setTollFree(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->tollFree = $value;
        return $this;
    }

    public function hasPremiumRate(): bool
    {
        return $this->premiumRate !== null;
    }

    public function getPremiumRate(): ?PhoneNumberDesc
    {
        return $this->premiumRate;
    }

    public function setPremiumRate(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->premiumRate = $value;
        return $this;
    }

    public function hasSharedCost(): bool
    {
        return $this->sharedCost !== null;
    }

    public function getSharedCost(): ?PhoneNumberDesc
    {
        return $this->sharedCost;
    }

    public function setSharedCost(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->sharedCost = $value;
        return $this;
    }

    public function hasPersonalNumber(): bool
    {
        return $this->personalNumber !== null;
    }

    public function getPersonalNumber(): ?PhoneNumberDesc
    {
        return $this->personalNumber;
    }

    public function setPersonalNumber(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->personalNumber = $value;
        return $this;
    }

    public function hasVoip(): bool
    {
        return $this->voip !== null;
    }

    public function getVoip(): ?PhoneNumberDesc
    {
        return $this->voip;
    }

    public function setVoip(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->voip = $value;
        return $this;
    }

    public function hasPager(): bool
    {
        return $this->pager !== null;
    }

    public function getPager(): ?PhoneNumberDesc
    {
        return $this->pager;
    }

    public function setPager(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->pager = $value;
        return $this;
    }

    public function hasUan(): bool
    {
        return $this->uan !== null;
    }

    public function getUan(): ?PhoneNumberDesc
    {
        return $this->uan;
    }

    public function setUan(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->uan = $value;
        return $this;
    }

    public function hasEmergency(): bool
    {
        return $this->emergency !== null;
    }

    public function getEmergency(): ?PhoneNumberDesc
    {
        return $this->emergency;
    }

    public function setEmergency(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->emergency = $value;
        return $this;
    }

    public function hasVoicemail(): bool
    {
        return $this->voicemail !== null;
    }

    public function getVoicemail(): ?PhoneNumberDesc
    {
        return $this->voicemail;
    }

    public function setVoicemail(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->voicemail = $value;
        return $this;
    }

    public function hasShortCode(): bool
    {
        return $this->short_code !== null;
    }

    public function getShortCode(): ?PhoneNumberDesc
    {
        return $this->short_code;
    }

    public function setShortCode(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->short_code = $value;
        return $this;
    }

    public function hasStandardRate(): bool
    {
        return $this->standard_rate !== null;
    }

    public function getStandardRate(): ?PhoneNumberDesc
    {
        return $this->standard_rate;
    }

    public function setStandardRate(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->standard_rate = $value;
        return $this;
    }

    public function hasCarrierSpecific(): bool
    {
        return $this->carrierSpecific !== null;
    }

    public function getCarrierSpecific(): ?PhoneNumberDesc
    {
        return $this->carrierSpecific;
    }

    public function setCarrierSpecific(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->carrierSpecific = $value;
        return $this;
    }

    public function hasSmsServices(): bool
    {
        return $this->smsServices !== null;
    }

    public function getSmsServices(): ?PhoneNumberDesc
    {
        return $this->smsServices;
    }

    public function setSmsServices(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->smsServices = $value;
        return $this;
    }

    public function hasNoInternationalDialling(): bool
    {
        return $this->noInternationalDialling !== null;
    }

    public function getNoInternationalDialling(): ?PhoneNumberDesc
    {
        return $this->noInternationalDialling;
    }

    public function setNoInternationalDialling(PhoneNumberDesc $value): PhoneMetadata
    {
        $this->noInternationalDialling = $value;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $value): PhoneMetadata
    {
        $this->id = $value;
        return $this;
    }

    public function getCountryCode(): ?int
    {
        return $this->countryCode;
    }

    public function setCountryCode(int $value): PhoneMetadata
    {
        $this->countryCode = $value;
        return $this;
    }

    public function getInternationalPrefix(): ?string
    {
        return $this->internationalPrefix;
    }

    public function setInternationalPrefix(string $value): PhoneMetadata
    {
        $this->internationalPrefix = $value;
        return $this;
    }

    public function hasPreferredInternationalPrefix(): bool
    {
        return ($this->preferredInternationalPrefix !== null);
    }

    public function getPreferredInternationalPrefix(): ?string
    {
        return $this->preferredInternationalPrefix;
    }

    public function setPreferredInternationalPrefix(string $value): PhoneMetadata
    {
        $this->preferredInternationalPrefix = $value;
        return $this;
    }

    public function clearPreferredInternationalPrefix(): PhoneMetadata
    {
        $this->preferredInternationalPrefix = null;
        return $this;
    }

    public function hasNationalPrefix(): bool
    {
        return $this->nationalPrefix !== null;
    }

    public function getNationalPrefix(): ?string
    {
        return $this->nationalPrefix;
    }

    public function setNationalPrefix(string $value): PhoneMetadata
    {
        $this->nationalPrefix = $value;
        return $this;
    }

    public function clearNationalPrefix(): PhoneMetadata
    {
        $this->nationalPrefix = '';
        return $this;
    }

    public function hasPreferredExtnPrefix(): bool
    {
        return $this->preferredExtnPrefix !== null;
    }

    public function getPreferredExtnPrefix(): ?string
    {
        return $this->preferredExtnPrefix;
    }

    public function setPreferredExtnPrefix(string $value): PhoneMetadata
    {
        $this->preferredExtnPrefix = $value;
        return $this;
    }

    public function clearPreferredExtnPrefix(): PhoneMetadata
    {
        $this->preferredExtnPrefix = '';
        return $this;
    }

    public function hasNationalPrefixForParsing(): bool
    {
        return $this->nationalPrefixForParsing !== null;
    }

    public function getNationalPrefixForParsing(): ?string
    {
        return $this->nationalPrefixForParsing;
    }

    public function setNationalPrefixForParsing(string $value): PhoneMetadata
    {
        $this->nationalPrefixForParsing = $value;
        return $this;
    }

    public function hasNationalPrefixTransformRule(): bool
    {
        return $this->nationalPrefixTransformRule !== null;
    }

    public function getNationalPrefixTransformRule(): ?string
    {
        return $this->nationalPrefixTransformRule;
    }

    public function setNationalPrefixTransformRule(string $value): PhoneMetadata
    {
        $this->nationalPrefixTransformRule = $value;
        return $this;
    }

    public function clearNationalPrefixTransformRule(): PhoneMetadata
    {
        $this->nationalPrefixTransformRule = '';
        return $this;
    }

    public function getSameMobileAndFixedLinePattern(): bool
    {
        return $this->sameMobileAndFixedLinePattern;
    }

    public function setSameMobileAndFixedLinePattern(bool $value): PhoneMetadata
    {
        $this->sameMobileAndFixedLinePattern = $value;
        return $this;
    }

    public function clearSameMobileAndFixedLinePattern(): PhoneMetadata
    {
        $this->sameMobileAndFixedLinePattern = false;
        return $this;
    }

    /**
     * @return NumberFormat[]
     */
    public function numberFormats(): array
    {
        return $this->numberFormat;
    }

    /**
     * @return NumberFormat[]
     */
    public function intlNumberFormats(): array
    {
        return $this->intlNumberFormat;
    }

    public function hasLeadingDigits(): bool
    {
        return $this->leadingDigits !== null;
    }

    public function getLeadingDigits(): ?string
    {
        return $this->leadingDigits;
    }

    public function setLeadingDigits(string $value): PhoneMetadata
    {
        $this->leadingDigits = $value;
        return $this;
    }

    public function isMobileNumberPortableRegion(): bool
    {
        return $this->mobileNumberPortableRegion;
    }

    public function setMobileNumberPortableRegion(bool $value): PhoneMetadata
    {
        $this->mobileNumberPortableRegion = $value;
        return $this;
    }

    public function clearMobileNumberPortableRegion(): PhoneMetadata
    {
        $this->mobileNumberPortableRegion = false;
        return $this;
    }

    /**
     * @param PhoneMetadataArray $input
     */
    public function fromArray(array $input): PhoneMetadata
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
            $this->setShortCode($desc->fromArray($input['shortCode']));
        }

        if (isset($input['standardRate'])) {
            $desc = new PhoneNumberDesc();
            $this->setStandardRate($desc->fromArray($input['standardRate']));
        }

        if (isset($input['carrierSpecific'])) {
            $desc = new PhoneNumberDesc();
            $this->setCarrierSpecific($desc->fromArray($input['carrierSpecific']));
        }

        if (isset($input['smsServices'])) {
            $desc = new PhoneNumberDesc();
            $this->setSmsServices($desc->fromArray($input['smsServices']));
        }

        if (isset($input['noInternationalDialling'])) {
            $desc = new PhoneNumberDesc();
            $this->setNoInternationalDialling($desc->fromArray($input['noInternationalDialling']));
        }

        $this->setId($input['id']);

        if (isset($input['countryCode'])) {
            $this->setCountryCode($input['countryCode']);
        }

        if (isset($input['internationalPrefix'])) {
            $this->setInternationalPrefix($input['internationalPrefix']);
        }

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

        foreach ($input['numberFormat'] ?? [] as $numberFormatElt) {
            $numberFormat = new NumberFormat();
            $numberFormat->fromArray($numberFormatElt);
            $this->addNumberFormat($numberFormat);
        }

        foreach ($input['intlNumberFormat'] ?? [] as $intlNumberFormatElt) {
            $numberFormat = new NumberFormat();
            $numberFormat->fromArray($intlNumberFormatElt);
            $this->addIntlNumberFormat($numberFormat);
        }

        if (isset($input['mainCountryForCode'])) {
            $this->setMainCountryForCode($input['mainCountryForCode']);
        }

        if (isset($input['leadingDigits'])) {
            $this->setLeadingDigits($input['leadingDigits']);
        }

        if (isset($input['mobileNumberPortableRegion'])) {
            $this->setMobileNumberPortableRegion($input['mobileNumberPortableRegion']);
        }

        return $this;
    }

    public function addNumberFormat(NumberFormat $value): PhoneMetadata
    {
        $this->numberFormat[] = $value;
        return $this;
    }

    public function addIntlNumberFormat(NumberFormat $value): PhoneMetadata
    {
        $this->intlNumberFormat[] = $value;
        return $this;
    }
}
