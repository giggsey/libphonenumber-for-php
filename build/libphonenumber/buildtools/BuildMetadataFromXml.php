<?php

namespace libphonenumber\buildtools;

use libphonenumber\NumberFormat;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;

/**
 * Library to build phone number metadata from the XML format.
 *
 * @author Davide Mendolia
 */
class BuildMetadataFromXml
{
    // String constants used to fetch the XML nodes and attributes.
    const CARRIER_CODE_FORMATTING_RULE = "carrierCodeFormattingRule";
    const COUNTRY_CODE = "countryCode";
    const EMERGENCY = "emergency";
    const EXAMPLE_NUMBER = "exampleNumber";
    const FIXED_LINE = "fixedLine";
    const FORMAT = "format";
    const GENERAL_DESC = "generalDesc";
    const INTERNATIONAL_PREFIX = "internationalPrefix";
    const INTL_FORMAT = "intlFormat";
    const LEADING_DIGITS = "leadingDigits";
    const LEADING_ZERO_POSSIBLE = "leadingZeroPossible";
    const MOBILE_NUMBER_PORTABLE_REGION = "mobileNumberPortableRegion";
    const MAIN_COUNTRY_FOR_CODE = "mainCountryForCode";
    const MOBILE = "mobile";
    const NATIONAL_NUMBER_PATTERN = "nationalNumberPattern";
    const NATIONAL_PREFIX = "nationalPrefix";
    const NATIONAL_PREFIX_FORMATTING_RULE = "nationalPrefixFormattingRule";
    const NATIONAL_PREFIX_OPTIONAL_WHEN_FORMATTING = "nationalPrefixOptionalWhenFormatting";
    const NATIONAL_PREFIX_FOR_PARSING = "nationalPrefixForParsing";
    const NATIONAL_PREFIX_TRANSFORM_RULE = "nationalPrefixTransformRule";
    const NO_INTERNATIONAL_DIALLING = "noInternationalDialling";
    const NUMBER_FORMAT = "numberFormat";
    const PAGER = "pager";
    const CARRIER_SPECIFIC = 'carrierSpecific';
    const PATTERN = "pattern";
    const PERSONAL_NUMBER = "personalNumber";
    const POSSIBLE_NUMBER_PATTERN = "possibleNumberPattern";
    const POSSIBLE_LENGTHS = "possibleLengths";
    const NATIONAL = "national";
    const LOCAL_ONLY = "localOnly";
    const PREFERRED_EXTN_PREFIX = "preferredExtnPrefix";
    const PREFERRED_INTERNATIONAL_PREFIX = "preferredInternationalPrefix";
    const PREMIUM_RATE = "premiumRate";
    const SHARED_COST = "sharedCost";
    const SHORT_CODE = "shortCode";
    const STANDARD_RATE = "standardRate";
    const TOLL_FREE = "tollFree";
    const UAN = "uan";
    const VOICEMAIL = "voicemail";
    const VOIP = "voip";

    private static $phoneNumberDescsWithoutMatchingTypes = array(
        self::NO_INTERNATIONAL_DIALLING
    );

    /**
     * @internal
     * @param $regex
     * @param bool $removeWhitespace
     * @return string
     */
    public static function validateRE($regex, $removeWhitespace = false)
    {
        $compressedRegex = $removeWhitespace ? preg_replace('/\\s/', '', $regex) : $regex;
        // Match regex against an empty string to check the regex is valid
        if (preg_match('/' . $compressedRegex . '/', '') === false) {
            throw new \RuntimeException("Regex error: " . preg_last_error());
        }
        // We don't ever expect to see | followed by a ) in our metadata - this would be an indication
        // of a bug. If one wants to make something optional, we prefer ? to using an empty group.
        $errorIndex = strpos($compressedRegex, '|)');
        if ($errorIndex !== false) {
            throw new \RuntimeException("| followed by )");
        }
        // return the regex if it is of correct syntax, i.e. compile did not fail with a
        return $compressedRegex;
    }

    /**
     *
     * @param string $inputXmlFile
     * @param boolean $liteBuild
     * @return PhoneMetadata[]
     */
    public static function buildPhoneMetadataCollection($inputXmlFile, $liteBuild)
    {
        $document = new \DOMDocument();
        $document->load($inputXmlFile);
        $document->normalizeDocument();
        $territories = $document->getElementsByTagName("territory");
        $metadataCollection = array();

        $isShortNumberMetadata = strpos($inputXmlFile, 'ShortNumberMetadata');
        $isAlternateFormatsMetadata = strpos($inputXmlFile, 'PhoneNumberAlternateFormats');

        foreach ($territories as $territoryElement) {
            /** @var $territoryElement \DOMElement */
            // For the main metadata file this should always be set, but for other supplementary data
            // files the country calling code may be all that is needed.
            if ($territoryElement->hasAttribute("id")) {
                $regionCode = $territoryElement->getAttribute("id");
            } else {
                $regionCode = "";
            }
            $metadata = self::loadCountryMetadata($regionCode, $territoryElement, $liteBuild, $isShortNumberMetadata, $isAlternateFormatsMetadata);
            $metadataCollection[] = $metadata;
        }
        return $metadataCollection;
    }

    /**
     * @param string $regionCode
     * @param \DOMElement $element
     * @param string $liteBuild
     * @param string $isShortNumberMetadata
     * @param string $isAlternateFormatsMetadata
     * @return PhoneMetadata
     */
    public static function loadCountryMetadata($regionCode, \DOMElement $element, $liteBuild, $isShortNumberMetadata, $isAlternateFormatsMetadata)
    {
        $nationalPrefix = self::getNationalPrefix($element);
        $metadata = self::loadTerritoryTagMetadata($regionCode, $element, $nationalPrefix);
        $nationalPrefixFormattingRule = self::getNationalPrefixFormattingRuleFromElement($element, $nationalPrefix);

        self::loadAvailableFormats($metadata, $element, $nationalPrefix, $nationalPrefixFormattingRule, $element->hasAttribute(self::NATIONAL_PREFIX_OPTIONAL_WHEN_FORMATTING));
        if (!$isAlternateFormatsMetadata) {
            // The alternate formats metadata does not need most of the patterns to be set.
            self::setRelevantDescPatterns($metadata, $element, $liteBuild, $isShortNumberMetadata);
        }
        return $metadata;
    }

    /**
     * Returns the national prefix of the provided country element.
     * @internal
     * @param \DOMElement $element
     * @return string
     */
    public static function getNationalPrefix(\DOMElement $element)
    {
        return $element->hasAttribute(self::NATIONAL_PREFIX) ? $element->getAttribute(self::NATIONAL_PREFIX) : "";
    }

    /**
     *
     * @internal
     * @param \DOMElement $element
     * @param string $nationalPrefix
     * @return string
     */
    public static function getNationalPrefixFormattingRuleFromElement(\DOMElement $element, $nationalPrefix)
    {
        $nationalPrefixFormattingRule = $element->getAttribute(self::NATIONAL_PREFIX_FORMATTING_RULE);
// Replace $NP with national prefix and $FG with the first group ($1).
        $nationalPrefixFormattingRule = str_replace('$NP', $nationalPrefix, $nationalPrefixFormattingRule);
        $nationalPrefixFormattingRule = str_replace('$FG', '$1', $nationalPrefixFormattingRule);
        return $nationalPrefixFormattingRule;
    }

    /**
     *
     * @internal
     * @param string $regionCode
     * @param \DOMElement $element
     * @param string $nationalPrefix
     * @return PhoneMetadata
     */
    public static function loadTerritoryTagMetadata(
        $regionCode,
        \DOMElement $element,
        $nationalPrefix
    ) {
        $metadata = new PhoneMetadata();
        $metadata->setId($regionCode);
        $metadata->setCountryCode((int)$element->getAttribute(self::COUNTRY_CODE));
        if ($element->hasAttribute(self::LEADING_DIGITS)) {
            $metadata->setLeadingDigits(self::validateRE($element->getAttribute(self::LEADING_DIGITS)));
        }
        $metadata->setInternationalPrefix(self::validateRE($element->getAttribute(self::INTERNATIONAL_PREFIX)));
        if ($element->hasAttribute(self::PREFERRED_INTERNATIONAL_PREFIX)) {
            $preferredInternationalPrefix = $element->getAttribute(self::PREFERRED_INTERNATIONAL_PREFIX);
            $metadata->setPreferredInternationalPrefix($preferredInternationalPrefix);
        }
        if ($element->hasAttribute(self::NATIONAL_PREFIX_FOR_PARSING)) {
            $metadata->setNationalPrefixForParsing(
                self::validateRE($element->getAttribute(self::NATIONAL_PREFIX_FOR_PARSING), true)
            );
            if ($element->hasAttribute(self::NATIONAL_PREFIX_TRANSFORM_RULE)) {
                $metadata->setNationalPrefixTransformRule(self::validateRE($element->getAttribute(self::NATIONAL_PREFIX_TRANSFORM_RULE)));
            }
        }
        if ($nationalPrefix != '') {
            $metadata->setNationalPrefix($nationalPrefix);
            if (!$metadata->hasNationalPrefixForParsing()) {
                $metadata->setNationalPrefixForParsing($nationalPrefix);
            }
        }
        if ($element->hasAttribute(self::PREFERRED_EXTN_PREFIX)) {
            $metadata->setPreferredExtnPrefix($element->getAttribute(self::PREFERRED_EXTN_PREFIX));
        }
        if ($element->hasAttribute(self::MAIN_COUNTRY_FOR_CODE)) {
            $metadata->setMainCountryForCode(true);
        }
        if ($element->hasAttribute(self::LEADING_ZERO_POSSIBLE)) {
            $metadata->setLeadingZeroPossible(true);
        }
        if ($element->hasAttribute(self::MOBILE_NUMBER_PORTABLE_REGION)) {
            $metadata->setMobileNumberPortableRegion(true);
        }
        return $metadata;
    }

    /**
     * Extracts the available formats from the provided DOM element. If it does not contain any
     * nationalPrefixFormattingRule, the one passed-in is retained; similarly for
     * nationalPrefixOptionalWhenFormatting. The nationalPrefix, nationalPrefixFormattingRule and
     * nationalPrefixOptionalWhenFormatting values are provided from the parent (territory) element.
     * @internal
     * @param PhoneMetadata $metadata
     * @param \DOMElement $element
     * @param string $nationalPrefix
     * @param string $nationalPrefixFormattingRule
     * @param bool $nationalPrefixOptionalWhenFormatting
     */
    public static function loadAvailableFormats(
        PhoneMetadata $metadata,
        \DOMElement $element,
        $nationalPrefix,
        $nationalPrefixFormattingRule,
        $nationalPrefixOptionalWhenFormatting
    ) {
        $carrierCodeFormattingRule = "";
        if ($element->hasAttribute(self::CARRIER_CODE_FORMATTING_RULE)) {
            $carrierCodeFormattingRule = self::validateRE(self::getDomesticCarrierCodeFormattingRuleFromElement($element, $nationalPrefix));
        }
        $numberFormatElements = $element->getElementsByTagName(self::NUMBER_FORMAT);
        $hasExplicitIntlFormatDefined = false;

        $numOfFormatElements = $numberFormatElements->length;
        if ($numOfFormatElements > 0) {
            for ($i = 0; $i < $numOfFormatElements; $i++) {
                /** @var \DOMElement $numberFormatElement */
                $numberFormatElement = $numberFormatElements->item($i);
                $format = new NumberFormat();

                if ($numberFormatElement->hasAttribute(self::NATIONAL_PREFIX_FORMATTING_RULE)) {
                    $format->setNationalPrefixFormattingRule(
                        self::getNationalPrefixFormattingRuleFromElement($numberFormatElement, $nationalPrefix)
                    );
                } else {
                    $format->setNationalPrefixFormattingRule($nationalPrefixFormattingRule);
                }
                if ($numberFormatElement->hasAttribute(self::NATIONAL_PREFIX_OPTIONAL_WHEN_FORMATTING)) {
                    $format->setNationalPrefixOptionalWhenFormatting($numberFormatElement->getAttribute(self::NATIONAL_PREFIX_OPTIONAL_WHEN_FORMATTING) == 'true' ? true : false);
                } else {
                    $format->setNationalPrefixOptionalWhenFormatting($nationalPrefixOptionalWhenFormatting);
                }
                if ($numberFormatElement->hasAttribute(self::CARRIER_CODE_FORMATTING_RULE)) {
                    $format->setDomesticCarrierCodeFormattingRule(
                        self::validateRE(self::getDomesticCarrierCodeFormattingRuleFromElement($numberFormatElement, $nationalPrefix))
                    );
                } else {
                    $format->setDomesticCarrierCodeFormattingRule($carrierCodeFormattingRule);
                }
                self::loadNationalFormat($metadata, $numberFormatElement, $format);
                $metadata->addNumberFormat($format);

                if (self::loadInternationalFormat($metadata, $numberFormatElement, $format)) {
                    $hasExplicitIntlFormatDefined = true;
                }
            }
            // Only a small number of regions need to specify the intlFormats in the xml. For the majority
            // of countries the intlNumberFormat metadata is an exact copy of the national NumberFormat
            // metadata. To minimize the size of the metadata file, we only keep intlNumberFormats that
            // actually differ in some way to the national formats.
            if (!$hasExplicitIntlFormatDefined) {
                $metadata->clearIntlNumberFormat();
            }
        }
    }

    /**
     * @internal
     * @param \DOMElement $element
     * @param string $nationalPrefix
     * @return mixed|string
     */
    public static function getDomesticCarrierCodeFormattingRuleFromElement(\DOMElement $element, $nationalPrefix)
    {
        $carrierCodeFormattingRule = $element->getAttribute(self::CARRIER_CODE_FORMATTING_RULE);
        // Replace $FG with the first group ($1) and $NP with the national prefix.
        $carrierCodeFormattingRule = str_replace('$NP', $nationalPrefix, $carrierCodeFormattingRule);
        $carrierCodeFormattingRule = str_replace('$FG', '$1', $carrierCodeFormattingRule);
        return $carrierCodeFormattingRule;
    }

    /**
     * Extracts the pattern for the national format.
     *
     * @internal
     * @param PhoneMetadata $metadata
     * @param \DOMElement $numberFormatElement
     * @param NumberFormat $format
     * @throws \RuntimeException if multiple or no formats have been encountered.
     */
    public static function loadNationalFormat(
        PhoneMetadata $metadata,
        \DOMElement $numberFormatElement,
        NumberFormat $format
    ) {
        self::setLeadingDigitsPatterns($numberFormatElement, $format);
        $format->setPattern(self::validateRE($numberFormatElement->getAttribute(self::PATTERN)));

        $formatPattern = $numberFormatElement->getElementsByTagName(self::FORMAT);
        if ($formatPattern->length != 1) {
            $countryId = strlen($metadata->getId()) > 0 ? $metadata->getId() : $metadata->getCountryCode();
            throw new \RuntimeException("Invalid number of format patterns for country: " . $countryId);
        }
        $nationalFormat = $formatPattern->item(0)->firstChild->nodeValue;
        $format->setFormat($nationalFormat);
    }

    /**
     * @internal
     * @param \DOMElement $numberFormatElement
     * @param NumberFormat $format
     */
    public static function setLeadingDigitsPatterns(\DOMElement $numberFormatElement, NumberFormat $format)
    {
        $leadingDigitsPatternNodes = $numberFormatElement->getElementsByTagName(self::LEADING_DIGITS);
        $numOfLeadingDigitsPatterns = $leadingDigitsPatternNodes->length;
        if ($numOfLeadingDigitsPatterns > 0) {
            for ($i = 0; $i < $numOfLeadingDigitsPatterns; $i++) {
                $format->addLeadingDigitsPattern(self::validateRE($leadingDigitsPatternNodes->item($i)->firstChild->nodeValue, true));
            }
        }
    }

    /**
     * Extracts the pattern for international format. If there is no intlFormat, default to using the
     * national format. If the intlFormat is set to "NA" the intlFormat should be ignored.
     *
     * @internal
     * @param PhoneMetadata $metadata
     * @param \DOMElement $numberFormatElement
     * @param NumberFormat $nationalFormat
     * @throws \RuntimeException if multiple intlFormats have been encountered.
     * @return bool whether an international number format is defined.
     */
    public static function loadInternationalFormat(
        PhoneMetadata $metadata,
        \DOMElement $numberFormatElement,
        NumberFormat $nationalFormat
    ) {
        $intlFormat = new NumberFormat();
        $intlFormatPattern = $numberFormatElement->getElementsByTagName(self::INTL_FORMAT);
        $hasExplicitIntlFormatDefined = false;

        if ($intlFormatPattern->length > 1) {
            $countryId = strlen($metadata->getId()) > 0 ? $metadata->getId() : $metadata->getCountryCode();
            throw new \RuntimeException("Invalid number of intlFormat patterns for country: " . $countryId);
        } elseif ($intlFormatPattern->length == 0) {
            // Default to use the same as the national pattern if none is defined.
            $intlFormat->mergeFrom($nationalFormat);
        } else {
            $intlFormat->setPattern($numberFormatElement->getAttribute(self::PATTERN));
            self::setLeadingDigitsPatterns($numberFormatElement, $intlFormat);
            $intlFormatPatternValue = $intlFormatPattern->item(0)->firstChild->nodeValue;
            if ($intlFormatPatternValue !== "NA") {
                $intlFormat->setFormat($intlFormatPatternValue);
            }
            $hasExplicitIntlFormatDefined = true;
        }

        if ($intlFormat->hasFormat()) {
            $metadata->addIntlNumberFormat($intlFormat);
        }
        return $hasExplicitIntlFormatDefined;
    }

    /**
     * @internal
     * @param PhoneMetadata $metadata
     * @param \DOMElement $element
     * @param bool $liteBuild
     * @param bool $isShortNumberMetadata
     */
    public static function setRelevantDescPatterns(PhoneMetadata $metadata, \DOMElement $element, $liteBuild, $isShortNumberMetadata)
    {
        $generalDesc = self::processPhoneNumberDescElement(null, $element, self::GENERAL_DESC, $liteBuild);
        $metadata->setGeneralDesc($generalDesc);

        $metadataId = $metadata->getId();
        // Calculate the possible lengths for the general description. This will be based on the
        // possible lengths of the child elements.
        self::setPossibleLengthsGeneralDesc($generalDesc, $metadataId, $element, $isShortNumberMetadata);

        if (!$isShortNumberMetadata) {
            // Set fields used by regular length phone numbers.
            $metadata->setFixedLine(self::processPhoneNumberDescElement($generalDesc, $element, self::FIXED_LINE, $liteBuild));
            $metadata->setMobile(self::processPhoneNumberDescElement($generalDesc, $element, self::MOBILE, $liteBuild));
            $metadata->setSharedCost(self::processPhoneNumberDescElement($generalDesc, $element, self::SHARED_COST, $liteBuild));
            $metadata->setVoip(self::processPhoneNumberDescElement($generalDesc, $element, self::VOIP, $liteBuild));
            $metadata->setPersonalNumber(self::processPhoneNumberDescElement($generalDesc, $element, self::PERSONAL_NUMBER, $liteBuild));
            $metadata->setPager(self::processPhoneNumberDescElement($generalDesc, $element, self::PAGER, $liteBuild));
            $metadata->setUan(self::processPhoneNumberDescElement($generalDesc, $element, self::UAN, $liteBuild));
            $metadata->setVoicemail(self::processPhoneNumberDescElement($generalDesc, $element, self::VOICEMAIL, $liteBuild));
            $metadata->setNoInternationalDialling(self::processPhoneNumberDescElement($generalDesc, $element, self::NO_INTERNATIONAL_DIALLING, $liteBuild));
            $metadata->setSameMobileAndFixedLinePattern($metadata->getMobile()->getNationalNumberPattern() === $metadata->getFixedLine()->getNationalNumberPattern());
            $metadata->setTollFree(self::processPhoneNumberDescElement($generalDesc, $element, self::TOLL_FREE, $liteBuild));
            $metadata->setPremiumRate(self::processPhoneNumberDescElement($generalDesc, $element, self::PREMIUM_RATE, $liteBuild));
        } else {
            // Set fields used by short numbers.
            $metadata->setStandardRate(self::processPhoneNumberDescElement($generalDesc, $element, self::STANDARD_RATE, $liteBuild));
            $metadata->setShortCode(self::processPhoneNumberDescElement($generalDesc, $element, self::SHORT_CODE, $liteBuild));
            $metadata->setCarrierSpecific(self::processPhoneNumberDescElement($generalDesc, $element, self::CARRIER_SPECIFIC, $liteBuild));
            $metadata->setEmergency(self::processPhoneNumberDescElement($generalDesc, $element, self::EMERGENCY, $liteBuild));
            $metadata->setTollFree(self::processPhoneNumberDescElement($generalDesc, $element, self::TOLL_FREE, $liteBuild));
            $metadata->setPremiumRate(self::processPhoneNumberDescElement($generalDesc, $element, self::PREMIUM_RATE, $liteBuild));
        }
    }

    /**
     * Parses a possible length string into a set of the integers that are covered.
     *
     * @param string $possibleLengthString a string specifying the possible lengths of phone numbers. Follows
     * this syntax: ranges or elements are separated by commas, and ranges are specified in
     * [min-max] notation, inclusive. For example, [3-5],7,9,[11-14] should be parsed to
     * 3,4,5,7,9,11,12,13,14
     * @return array
     */
    private static function parsePossibleLengthStringToSet($possibleLengthString)
    {
        if (strlen($possibleLengthString) === 0) {
            throw new \RuntimeException("Empty possibleLength string found.");
        }

        $lengths = explode(",", $possibleLengthString);
        $lengthSet = array();


        $lengthLength = count($lengths);
        for ($i = 0; $i < $lengthLength; $i++) {
            $lengthSubstring = $lengths[$i];
            if (strlen($lengthSubstring) === 0) {
                throw new \RuntimeException("Leading, trailing or adjacent commas in possible "
                    . "length string {$possibleLengthString}, these should only separate numbers or ranges.");
            } elseif (substr($lengthSubstring, 0, 1) === '[') {
                if (substr($lengthSubstring, -1) !== ']') {
                    throw new \RuntimeException("Missing end of range character in possible length string {$possibleLengthString}.");
                }

                // Strip the leading and trailing [], and split on the -.
                $minMax = explode('-', substr($lengthSubstring, 1, -1));
                if (count($minMax) !== 2) {
                    throw new \RuntimeException("Ranges must have exactly one - character: missing for {$possibleLengthString}.");
                }
                $min = (int)$minMax[0];
                $max = (int)$minMax[1];
                // We don't even accept [6-7] since we prefer the shorter 6,7 variant; for a range to be in
                // use the hyphen needs to replace at least one digit.
                if ($max - $min < 2) {
                    throw new \RuntimeException("The first number in a range should be two or more digits lower than the second. Culprit possibleLength string: {$possibleLengthString}.");
                }
                for ($j = $min; $j <= $max; $j++) {
                    if (in_array($j, $lengthSet)) {
                        throw new \RuntimeException("Duplicate length element found ({$j}) in possibleLength string {$possibleLengthString}.");
                    }
                    array_push($lengthSet, $j);
                }
            } else {
                $length = $lengthSubstring;
                if (in_array($length, $lengthSet)) {
                    throw new \RuntimeException("Duplicate length element found ({$length}) in possibleLength string {$possibleLengthString}.");
                }
                if (!is_numeric($length)) {
                    throw new \RuntimeException("For input string \"{$length}\"");
                }
                array_push($lengthSet, $length);
            }
        }
        return $lengthSet;
    }

    /**
     * Reads the possible length present in the metadata and splits them into two sets: one for
     * full-length numbers, one for local numbers.
     *
     *
     * @param \DOMElement $data One or more phone number descriptions
     * @param array $lengths An array in which to add possible lengths of full phone numbers
     * @param array $localOnlyLengths An array in which to add possible lengths of phone numbers only diallable
     *  locally (e.g. within a province)
     */
    private static function populatePossibleLengthSets(\DOMElement $data, &$lengths, &$localOnlyLengths)
    {
        $possibleLengths = $data->getElementsByTagName(self::POSSIBLE_LENGTHS);

        for ($i = 0; $i < $possibleLengths->length; $i++) {
            /** @var \DOMElement $element */
            $element = $possibleLengths->item($i);
            $nationalLengths = $element->getAttribute(self::NATIONAL);
            // We don't add to the phone metadata yet, since we want to sort length elements found under
            // different nodes first, make sure there are no duplicates between them and that the
            // localOnly lengths don't overlap with the others.
            $thisElementLengths = self::parsePossibleLengthStringToSet($nationalLengths);
            if ($element->hasAttribute(self::LOCAL_ONLY)) {
                $localLengths = $element->getAttribute(self::LOCAL_ONLY);
                $thisElementLocalOnlyLengths = self::parsePossibleLengthStringToSet($localLengths);
                $intersection = array_intersect($thisElementLengths, $thisElementLocalOnlyLengths);
                if (count($intersection) > 0) {
                    throw new \RuntimeException("Possible length(s) found specified as a normal and local-only length: [" . implode(',', $intersection) . '].');
                }
                // We check again when we set these lengths on the metadata itself in setPossibleLengths
                // that the elements in localOnly are not also in lengths. For e.g. the generalDesc, it
                // might have a local-only length for one type that is a normal length for another type. We
                // don't consider this an error, but we do want to remove the local-only lengths.
                $localOnlyLengths = array_merge($localOnlyLengths, $thisElementLocalOnlyLengths);
                sort($localOnlyLengths);
            }
            // It is okay if at this time we have duplicates, because the same length might be possible
            // for e.g. fixed-line and for mobile numbers, and this method operates potentially on
            // multiple phoneNumberDesc XML elements.
            $lengths = array_merge($lengths, $thisElementLengths);
            sort($lengths);
        }
    }

    /**
     * Sets possible lengths in the general description, derived from certain child elements
     *
     * @internal
     * @param PhoneNumberDesc $generalDesc
     * @param string $metadataId
     * @param \DOMElement $data
     * @param bool $isShortNumberMetadata
     */
    public static function setPossibleLengthsGeneralDesc(PhoneNumberDesc $generalDesc, $metadataId, \DOMElement $data, $isShortNumberMetadata)
    {
        $lengths = array();
        $localOnlyLengths = array();
        // The general description node should *always* be present if metadata for other types is
        // present, aside from in some unit tests.
        // (However, for e.g. formatting metadata in PhoneNumberAlternateFormats, no PhoneNumberDesc
        // elements are present).
        $generalDescNodes = $data->getElementsByTagName(self::GENERAL_DESC);
        if ($generalDescNodes->length > 0) {
            $generalDescNode = $generalDescNodes->item(0);
            self::populatePossibleLengthSets($generalDescNode, $lengths, $localOnlyLengths);
            if (count($lengths) > 0 || count($localOnlyLengths) > 0) {
                // We shouldn't have anything specified at the "general desc" level: we are going to
                // calculate this ourselves from child elements.
                throw new \RuntimeException("Found possible lengths specified at general desc: this should be derived from child elements. Affected country: {$metadataId}");
            }
        }
        if (!$isShortNumberMetadata) {
            // Make a copy here since we want to remove some nodes, but we don't want to do that on our
            // actual data.
            /** @var \DOMElement $allDescData */
            $allDescData = $data->cloneNode(true);
            foreach (self::$phoneNumberDescsWithoutMatchingTypes as $tag) {
                $nodesToRemove = $allDescData->getElementsByTagName($tag);
                if ($nodesToRemove->length > 0) {
                    // We check when we process phone number descriptions that there are only one of each
                    // type, so this is safe to do.
                    $allDescData->removeChild($nodesToRemove->item(0));
                }
            }
            self::populatePossibleLengthSets($allDescData, $lengths, $localOnlyLengths);
        } else {
            // For short number metadata, we want to copy the lengths from the "short code" section only.
            // This is because it's the more detailed validation pattern, it's not a sub-type of short
            // codes. The other lengths will be checked later to see that they are a sub-set of these
            // possible lengths.
            $shortCodeDescList = $data->getElementsByTagName(self::SHORT_CODE);
            if (count($shortCodeDescList) > 0) {
                $shortCodeDesc = $shortCodeDescList->item(0);
                self::populatePossibleLengthSets($shortCodeDesc, $lengths, $localOnlyLengths);
            }
            if (count($localOnlyLengths) > 0) {
                throw new \RuntimeException("Found local-only lengths in short-number metadata");
            }
        }
        self::setPossibleLengths($lengths, $localOnlyLengths, null, $generalDesc);
    }

    /**
     * Sets the possible length fields in the metadata from the sets of data passed in. Checks that
     * the length is covered by the "parent" phone number description element if one is present, and
     * if the lengths are exactly the same as this, they are not filled in for efficiency reasons.
     *
     * @param array $lengths
     * @param array $localOnlyLengths
     * @param PhoneNumberDesc $parentDesc
     * @param PhoneNumberDesc $desc
     */
    private static function setPossibleLengths($lengths, $localOnlyLengths, PhoneNumberDesc $parentDesc = null, PhoneNumberDesc $desc)
    {
        $parentDescPossibleLengths = ($parentDesc === null) ? null : $parentDesc->getPossibleLength();
        $parentDescPossibleLengthLocalOnlys = ($parentDesc === null) ? null : $parentDesc->getPossibleLengthLocalOnly();
        $descPossibleLengths = array();
        $descPossibleLengthLocalOnlys = array();

        // Only add the lengths to this sub-type if they aren't exactly the same as the possible
        // lengths in the general desc (for metadata size reasons).
        if ($parentDesc === null || !self::arePossibleLengthsEqual($lengths, $parentDesc)) {
            foreach ($lengths as $length) {
                if ($parentDesc === null || in_array($length, $parentDescPossibleLengths)) {
                    if (!in_array($length, $descPossibleLengths)) {
                        $descPossibleLengths[] = $length;
                    }
                } else {
                    // We shouldn't have possible lengths defined in a child element that are not covered by
                    // the general description. We check this here even though the general description is
                    // derived from child elements because it is only derived from a subset, and we need to
                    // ensure *all* child elements have a valid possible length.
                    throw new \RuntimeException("Out-of-range possible length found ({$length}), parent lengths " . implode(',', $parentDesc->getPossibleLength()));
                }
            }
        }
        // We check that the local-only length isn't also a normal possible length (only relevant for
        // the general-desc, since within elements such as fixed-line we would throw an exception if we
        // saw this) before adding it to the collection of possible local-only lengths.
        foreach ($localOnlyLengths as $length) {
            if (!in_array($length, $lengths)) {
                // We check it is covered by either of the possible length sets of the parent
                // PhoneNumberDesc, because for example 7 might be a valid localOnly length for mobile, but
                // a valid national length for fixedLine, so the generalDesc would have the 7 removed from
                // localOnly.
                if ($parentDesc === null || in_array($length, $parentDescPossibleLengthLocalOnlys) || in_array($length, $parentDescPossibleLengths)) {
                    if (!in_array($length, $descPossibleLengthLocalOnlys)) {
                        $descPossibleLengthLocalOnlys[] = $length;
                    }
                } else {
                    throw new \RuntimeException("Out-of-range local-only possible length found ({$length}), parent length {$parentDesc->getPossibleLengthLocalOnly()}");
                }
            }
        }
        $desc->setPossibleLength($descPossibleLengths);
        $desc->setPossibleLengthLocalOnly($descPossibleLengthLocalOnlys);
    }

    /**
     * Processes a phone number description element from the XML file and returns it as a
     * PhoneNumberDesc. If the description element is a fixed line or mobile number, the parent
     * description will be used to fill in the whole element if necessary, or any components that are
     * missing. For all other types, the parent description will only be used to fill in missing
     * components if the type has a partial definition. For example, if no "tollFree" element exists,
     * we assume there are no toll free numbers for that locale, and return a phone number description
     * with "NA" for both the national and possible number patterns. Note that the parent description
     * must therefore already be processed before this method is called on any child elements.
     *
     * @internal
     * @param PhoneNumberDesc $parentDesc a generic phone number description that will be used to fill in missing
     *     parts of the description, or null if this is the root node. This must be processed before
     *     this is run on any child elements.
     * @param \DOMElement $countryElement XML element representing all the country information
     * @param string $numberType name of the number type, corresponding to the appropriate tag in the XML
     * file with information about that type
     * @param bool $liteBuild
     * @return PhoneNumberDesc complete description of that phone number type
     */
    public static function processPhoneNumberDescElement(
        PhoneNumberDesc $parentDesc = null,
        \DOMElement $countryElement,
        $numberType,
        $liteBuild
    ) {
        $phoneNumberDescList = $countryElement->getElementsByTagName($numberType);
        $numberDesc = new PhoneNumberDesc();
        if ($phoneNumberDescList->length == 0 && !self::numberTypeShouldAlwaysBeFilledIn($numberType)) {
            $numberDesc->setNationalNumberPattern("NA");
            $numberDesc->setPossibleNumberPattern("NA");
            // -1 will never match a possible phone number length, so is safe to use to ensure this never
            // matches. We don't leave it empty, since for compression reasons, we use the empty list to
            // mean that the generalDesc possible lengths apply.
            $numberDesc->setPossibleLength(array(-1));
            return $numberDesc;
        }

        if ($parentDesc != null) {
            if ($parentDesc->getNationalNumberPattern() !== "") {
                $numberDesc->setNationalNumberPattern($parentDesc->getNationalNumberPattern());
            }
            if ($parentDesc->getPossibleNumberPattern() !== "") {
                $numberDesc->setPossibleNumberPattern($parentDesc->getPossibleNumberPattern());
            }
            if ($parentDesc->getExampleNumber() !== "") {
                $numberDesc->setExampleNumber($parentDesc->getExampleNumber());
            }
        }

        if ($phoneNumberDescList->length > 0) {
            if ($phoneNumberDescList->length > 1) {
                throw new \RuntimeException("Multiple elements with type {$numberType} found.");
            }

            /** @var \DOMElement $element */
            $element = $phoneNumberDescList->item(0);
            // Old way of handling possible number lengths. This will be deleted when no data is
            // represented in this way anymore.
            $possiblePattern = $element->getElementsByTagName(self::POSSIBLE_NUMBER_PATTERN);
            if ($possiblePattern->length > 0) {
                $numberDesc->setPossibleNumberPattern(self::validateRE($possiblePattern->item(0)->firstChild->nodeValue, true));
            }

            if ($parentDesc != null) {
                // New way of handling possible number lengths. We don't do this for the general
                // description, since these tags won't be present; instead we will calculate its values
                // based on the values for all the other number type descriptions (see
                // setPossibleLengthsGeneralDesc).
                $lengths = array();
                $localOnlyLengths = array();
                self::populatePossibleLengthSets($element, $lengths, $localOnlyLengths);
                // NOTE: We don't use the localOnlyLengths for specific number types yet, since they aren't
                // used in the API and won't be until a method that assesses whether a number is possible
                // for a certain type or not is available. To ensure size is small, we don't set them
                // outside the general desc at this time. If we want this data later, the empty set here
                // should be replaced with the localOnlyLengths set above.
                self::setPossibleLengths($lengths, array(), $parentDesc, $numberDesc);
            }

            $validPattern = $element->getElementsByTagName(self::NATIONAL_NUMBER_PATTERN);
            if ($validPattern->length > 0) {
                $numberDesc->setNationalNumberPattern(self::validateRE($validPattern->item(0)->firstChild->nodeValue, true));
            }

            if (!$liteBuild) {
                $exampleNumber = $element->getElementsByTagName(self::EXAMPLE_NUMBER);
                if ($exampleNumber->length > 0) {
                    $numberDesc->setExampleNumber($exampleNumber->item(0)->firstChild->nodeValue);
                }
            }
        }
        return $numberDesc;
    }

    /**
     * @internal
     * @param string $numberType
     * @return bool
     */
    public static function numberTypeShouldAlwaysBeFilledIn($numberType)
    {
        return $numberType == self::FIXED_LINE || $numberType == self::MOBILE || $numberType == self::GENERAL_DESC;
    }

    private static function arePossibleLengthsEqual($possibleLengths, PhoneNumberDesc $desc)
    {
        $descPossibleLength = $desc->getPossibleLength();
        if (count($possibleLengths) != count($descPossibleLength)) {
            return false;
        }

        // Note that both should be sorted already, and we know they are the same length.
        $i = 0;
        foreach ($possibleLengths as $length) {
            if ($length != $descPossibleLength[$i]) {
                return false;
            }
            $i++;
        }
        return true;
    }

    /**
     * @param $metadataCollection PhoneMetadata[]
     * @return array
     */
    public static function buildCountryCodeToRegionCodeMap($metadataCollection)
    {
        $countryCodeToRegionCodeMap = array();

        foreach ($metadataCollection as $metadata) {
            $regionCode = $metadata->getId();
            $countryCode = $metadata->getCountryCode();
            if (array_key_exists($countryCode, $countryCodeToRegionCodeMap)) {
                if ($metadata->getMainCountryForCode()) {
                    array_unshift($countryCodeToRegionCodeMap[$countryCode], $regionCode);
                } else {
                    $countryCodeToRegionCodeMap[$countryCode][] = $regionCode;
                }
            } else {
                // For most countries, there will be only one region code for the country calling code.
                $listWithRegionCode = array();
                if ($regionCode != '') { // For alternate formats, there are no region codes at all.
                    $listWithRegionCode[] = $regionCode;
                }
                $countryCodeToRegionCodeMap[$countryCode] = $listWithRegionCode;
            }
        }

        return $countryCodeToRegionCodeMap;
    }
}
