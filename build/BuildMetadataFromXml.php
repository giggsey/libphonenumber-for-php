<?php

namespace com\google\i18n\phonenumbers;

require_once '../PhoneMetadata.php';

/*
 * Copyright (C) 2009 The Libphonenumber Authors
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Library to build phone number metadata from the XML format.
 *
 * @author Davide Mendolia
 */
class BuildMetadataFromXml {

	/**
	 * @var boolean
	 */
	private static $liteBuild;

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
	const PATTERN = "pattern";
	const PERSONAL_NUMBER = "personalNumber";
	const POSSIBLE_NUMBER_PATTERN = "possibleNumberPattern";
	const PREFERRED_EXTN_PREFIX = "preferredExtnPrefix";
	const PREFERRED_INTERNATIONAL_PREFIX = "preferredInternationalPrefix";
	const PREMIUM_RATE = "premiumRate";
	const SHARED_COST = "sharedCost";
	const TOLL_FREE = "tollFree";
	const UAN = "uan";
	const VOICEMAIL = "voicemail";
	const VOIP = "voip";

	/**
	 *
	 * @param string $inputXmlFile
	 * @param boolean $liteBuild
	 * @return array
	 */
	public static function buildPhoneMetadataCollection($inputXmlFile, $liteBuild) {
		self::$liteBuild = $liteBuild;
		$document = new \DOMDocument();
		$document->load($inputXmlFile);
		$territories = $document->getElementsByTagName("territory");
		$metadataCollection = array();
		foreach ($territories as $territory) {
			$id = $territory->getAttribute("id");
			$metadata = self::loadCountryMetadata($id, $territory);
			$metadataCollection[] = $metadata;
		}
		return $metadataCollection;
	}

	/**
	 * @param string regionCode
	 * @param DOMElement $element
	 * @return PhoneMetadata
	 */
	public static function loadCountryMetadata($regionCode, \DOMElement $element) {
		$nationalPrefix = self::getNationalPrefix($element);
		$nationalPrefixFormattingRule = self::getNationalPrefixFormattingRuleFromElement($element, $nationalPrefix);
		$metadata = self::loadTerritoryTagMetadata($regionCode, $element, $nationalPrefix, $nationalPrefixFormattingRule);

		self::loadAvailableFormats($metadata, $regionCode, $element, $nationalPrefix, $nationalPrefixFormattingRule);
		self::loadGeneralDesc($metadata, $element);
		return $metadata;
	}

	/**
	 * Returns the national prefix of the provided country element.
	 * @return string
	 */
	private static function getNationalPrefix(\DOMElement $element) {
		return $element->hasAttribute(self::NATIONAL_PREFIX) ? $element->getAttribute(self::NATIONAL_PREFIX) : "";
	}

	/**
	 *
	 * @param DOMElement $element
	 * @param string $nationalPrefix
	 * @return string
	 */
	private static function getNationalPrefixFormattingRuleFromElement(\DOMElement $element, $nationalPrefix) {
		$nationalPrefixFormattingRule = $element->getAttribute(self::NATIONAL_PREFIX_FORMATTING_RULE);
// Replace $NP with national prefix and $FG with the first group ($1).
		$nationalPrefixFormattingRule = str_replace('$NP', $nationalPrefix, $nationalPrefixFormattingRule);
		$nationalPrefixFormattingRule = str_replace('$FG', '$1', $nationalPrefixFormattingRule);
		return $nationalPrefixFormattingRule;
	}

	private static function getDomesticCarrierCodeFormattingRuleFromElement(\DOMElement $element, $nationalPrefix) {
		$carrierCodeFormattingRule = $element->getAttribute(self::CARRIER_CODE_FORMATTING_RULE);
// Replace $FG with the first group ($1) and $NP with the national prefix.
		$carrierCodeFormattingRule = str_replace('$NP', $nationalPrefix, $carrierCodeFormattingRule);
		$carrierCodeFormattingRule = str_replace('$FG', '$1', $carrierCodeFormattingRule);
		return $carrierCodeFormattingRule;
	}

	/**
	 *
	 * @param string $regionCode
	 * @param DOMElement $element
	 * @param string $nationalPrefix
	 * @param string $nationalPrefixFormattingRule
	 * @return PhoneMetadata 
	 */
	private static function loadTerritoryTagMetadata($regionCode, \DOMElement $element, $nationalPrefix, $nationalPrefixFormattingRule) {
		$metadata = new PhoneMetadata();
		$metadata->setId($regionCode);
		$metadata->setCountryCode((int) $element->getAttribute(self::COUNTRY_CODE));
		if ($element->hasAttribute(self::LEADING_DIGITS)) {
			$metadata->setLeadingDigits($element->getAttribute(self::LEADING_DIGITS));
		}
		$metadata->setInternationalPrefix($element->getAttribute(self::INTERNATIONAL_PREFIX));
		if ($element->hasAttribute(self::PREFERRED_INTERNATIONAL_PREFIX)) {
			$preferredInternationalPrefix = $element->getAttribute(self::PREFERRED_INTERNATIONAL_PREFIX);
			$metadata->setPreferredInternationalPrefix($preferredInternationalPrefix);
		}
		if ($element->hasAttribute(self::NATIONAL_PREFIX_FOR_PARSING)) {
			$metadata->setNationalPrefixForParsing(
					$element->getAttribute(self::NATIONAL_PREFIX_FOR_PARSING));
			if ($element->hasAttribute(self::NATIONAL_PREFIX_TRANSFORM_RULE)) {
				$metadata->setNationalPrefixTransformRule($element->getAttribute(self::NATIONAL_PREFIX_TRANSFORM_RULE));
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
		return $metadata;
	}

	/**
	 * Extracts the pattern for international format. If there is no intlFormat, default to using the
	 * national format. If the intlFormat is set to "NA" the intlFormat should be ignored.
	 *
	 * @throws  RuntimeException if multiple intlFormats have been encountered.
	 * @return  whether an international number format is defined.
	 */
	private static function loadInternationalFormat(PhoneMetadata $metadata, \DOMElement $numberFormatElement, $nationalFormat) {
		$intlFormat = new NumberFormat();
		self::setLeadingDigitsPatterns($numberFormatElement, $intlFormat);
		$intlFormat->setPattern($numberFormatElement->getAttribute(self::PATTERN));
		$intlFormatPattern = $numberFormatElement->getElementsByTagName(self::INTL_FORMAT);
		$hasExplicitIntlFormatDefined = false;

		if ($intlFormatPattern->length > 1) {
			throw new \RuntimeException("Invalid number of intlFormat patterns for country: " .
					$metadata->getId());
		} else if ($intlFormatPattern->length == 0) {
			// Default to use the same as the national pattern if none is defined.
			$intlFormat->setFormat($nationalFormat);
		} else {
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
	 * Extracts the pattern for the national format.
	 *
	 * @throws  RuntimeException if multiple or no formats have been encountered.
	 * @return  the national format string.
	 */
	private static function loadNationalFormat(PhoneMetadata $metadata, \DOMElement $numberFormatElement, NumberFormat $format) {
		self::setLeadingDigitsPatterns($numberFormatElement, $format);
		$format->setPattern($numberFormatElement->getAttribute(self::PATTERN));

		$formatPattern = $numberFormatElement->getElementsByTagName(self::FORMAT);
		if ($formatPattern->length != 1) {
			throw new \RuntimeException("Invalid number of format patterns for country: " .
					$metadata->getId());
		}
		$nationalFormat = $formatPattern->item(0)->firstChild->nodeValue;
		$format->setFormat($nationalFormat);
		return $nationalFormat;
	}

	/**
	 * @todo Implement this method
	 * Extracts the available formats from the provided DOM element. If it does not contain any
	 * nationalPrefixFormattingRule, the one passed-in is retained.
	 * @param PhoneMetadata $metadata
	 * @param type $regionCode
	 * @param DOMElement $element
	 * @param type $nationalPrefix
	 * @param type $nationalPrefixFormattingRule
	 */
	private static function loadAvailableFormats(PhoneMetadata $metadata, $regionCode, \DOMElement $element, $nationalPrefix, $nationalPrefixFormattingRule) {

		$carrierCodeFormattingRule = "";
		if ($element->hasAttribute(self::CARRIER_CODE_FORMATTING_RULE)) {
			$carrierCodeFormattingRule = self::getDomesticCarrierCodeFormattingRuleFromElement($element, $nationalPrefix);
		}
		$numberFormatElements = $element->getElementsByTagName(self::NUMBER_FORMAT);
		$hasExplicitIntlFormatDefined = false;

		$numOfFormatElements = $numberFormatElements->length;
		if ($numOfFormatElements > 0) {
			for ($i = 0; $i < $numOfFormatElements; $i++) {
				$numberFormatElement = $numberFormatElements->item($i);
				$format = new NumberFormat();

				if ($numberFormatElement->hasAttribute(self::NATIONAL_PREFIX_FORMATTING_RULE)) {
					$format->setNationalPrefixFormattingRule(
							self::getNationalPrefixFormattingRuleFromElement($numberFormatElement, $nationalPrefix));
				} else {
					$format->setNationalPrefixFormattingRule($nationalPrefixFormattingRule);
				}
				if ($numberFormatElement->hasAttribute(self::CARRIER_CODE_FORMATTING_RULE)) {
					$format->setDomesticCarrierCodeFormattingRule(
							self::getDomesticCarrierCodeFormattingRuleFromElement($numberFormatElement, $nationalPrefix));
				} else {
					$format->setDomesticCarrierCodeFormattingRule($carrierCodeFormattingRule);
				}
				$nationalFormat = self::loadNationalFormat($metadata, $numberFormatElement, $format);
				$metadata->addNumberFormat($format);

				if (self::loadInternationalFormat($metadata, $numberFormatElement, $nationalFormat)) {
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

	public static function setLeadingDigitsPatterns(\DOMElement $numberFormatElement, NumberFormat $format) {
		$leadingDigitsPatternNodes = $numberFormatElement->getElementsByTagName(self::LEADING_DIGITS);
		$numOfLeadingDigitsPatterns = $leadingDigitsPatternNodes->length;
		if ($numOfLeadingDigitsPatterns > 0) {
			for ($i = 0; $i < $numOfLeadingDigitsPatterns; $i++) {
				$elt = $leadingDigitsPatternNodes->item($i);
				$format->addLeadingDigitsPattern(
						$elt->firstChild->nodeValue, true);
			}
		}
	}

	private static function loadGeneralDesc(PhoneMetadata $metadata, \DOMElement $element) {
		$generalDesc = new PhoneNumberDesc();
		$generalDesc = self::processPhoneNumberDescElement($generalDesc, $element, self::GENERAL_DESC);
		$metadata->setGeneralDesc($generalDesc);
		$metadata->setFixedLine(self::processPhoneNumberDescElement($generalDesc, $element, self::FIXED_LINE));
		$metadata->setMobile(self::processPhoneNumberDescElement($generalDesc, $element, self::MOBILE));
		$metadata->setPremiumRate(self::processPhoneNumberDescElement($generalDesc, $element, self::PREMIUM_RATE));
		$metadata->setTollFree(self::processPhoneNumberDescElement($generalDesc, $element, self::TOLL_FREE));
		$metadata->setSharedCost(self::processPhoneNumberDescElement($generalDesc, $element, self::SHARED_COST));

		/*
		 * @todo
		  $metadata->setVoip(self::processPhoneNumberDescElement($generalDesc, $element, self::VOIP));
		  $metadata->setPersonalNumber(self::processPhoneNumberDescElement($generalDesc, $element, self::PERSONAL_NUMBER));
		  $metadata->setPager(self::processPhoneNumberDescElement($generalDesc, $element, self::PAGER));
		  $metadata->setUan(self::processPhoneNumberDescElement($generalDesc, $element, self::UAN));
		  $metadata->setEmergency(self::processPhoneNumberDescElement($generalDesc, $element, self::EMERGENCY));
		 * 
		 */
		$metadata->setNoInternationalDialling(self::processPhoneNumberDescElement($generalDesc, $element, self::NO_INTERNATIONAL_DIALLING));
		$metadata->setSameMobileAndFixedLinePattern(
				$metadata->getMobile()->getNationalNumberPattern() === $metadata->getFixedLine()->getNationalNumberPattern()
		);
	}

	/**
	 * Processes a phone number description element from the XML file and returns it as a
	 * PhoneNumberDesc. If the description element is a fixed line or mobile number, the general
	 * description will be used to fill in the whole element if necessary, or any components that are
	 * missing. For all other types, the general description will only be used to fill in missing
	 * components if the type has a partial definition. For example, if no "tollFree" element exists,
	 * we assume there are no toll free numbers for that locale, and return a phone number description
	 * with "NA" for both the national and possible number patterns.
	 *
	 * @param generalDesc  a generic phone number description that will be used to fill in missing
	 *                     parts of the description
	 * @param countryElement  the XML element representing all the country information
	 * @param numberType  the name of the number type, corresponding to the appropriate tag in the XML
	 *                    file with information about that type
	 * @return  complete description of that phone number type
	 */
	private static function processPhoneNumberDescElement(PhoneNumberDesc $generalDesc, \DOMElement $countryElement, $numberType) {
		$phoneNumberDescList = $countryElement->getElementsByTagName($numberType);
		$numberDesc = new PhoneNumberDesc();
		if ($phoneNumberDescList->length == 0 && !self::isValidNumberType($numberType)) {
			$numberDesc->setNationalNumberPattern("NA");
			$numberDesc->setPossibleNumberPattern("NA");
			return $numberDesc;
		}
		$numberDesc->mergeFrom($generalDesc);
		if ($phoneNumberDescList->length > 0) {
			$element = $phoneNumberDescList->item(0);
			$possiblePattern = $element->getElementsByTagName(self::POSSIBLE_NUMBER_PATTERN);
			if ($possiblePattern->length > 0) {
				$numberDesc->setPossibleNumberPattern($possiblePattern->item(0)->firstChild->nodeValue);
			}

			$validPattern = $element->getElementsByTagName(self::NATIONAL_NUMBER_PATTERN);
			if ($validPattern->length > 0) {
				$numberDesc->setNationalNumberPattern($validPattern->item(0)->firstChild->nodeValue);
			}

			if (!self::$liteBuild) {
				$exampleNumber = $element->getElementsByTagName(self::EXAMPLE_NUMBER);
				if ($exampleNumber->length > 0) {
					$numberDesc->setExampleNumber($exampleNumber->item(0)->firstChild->nodeValue);
				}
			}
		}
		return $numberDesc;
	}

	/**
	 * @param string $numberType
	 */
	private static function isValidNumberType($numberType) {
		return $numberType == self::FIXED_LINE || $numberType == self::MOBILE || $numberType == self::GENERAL_DESC;
	}

}