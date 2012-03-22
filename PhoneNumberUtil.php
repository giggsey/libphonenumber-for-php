<?php

namespace com\google\i18n\phonenumbers;

require_once dirname(__FILE__) . '/CountryCodeToRegionCodeMap.php';
require_once dirname(__FILE__) . '/PhoneMetadata.php';

/**
 * INTERNATIONAL and NATIONAL formats are consistent with the definition in ITU-T Recommendation
 * E123. For example, the number of the Google Switzerland office will be written as
 * "+41 44 668 1800" in INTERNATIONAL format, and as "044 668 1800" in NATIONAL format.
 * E164 format is as per INTERNATIONAL format but with no formatting applied, e.g. +41446681800.
 * RFC3966 is as per INTERNATIONAL format, but with all spaces and other separating symbols
 * replaced with a hyphen, and with any phone number extension appended with ";ext=".
 *
 * Note: If you are considering storing the number in a neutral format, you are highly advised to
 * use the PhoneNumber class.
 */
class PhoneNumberFormat {

	const E164 = 0;
	const INTERNATIONAL = 1;
	const NATIONAL = 2;
	const RFC3966 = 3;

}

/**
 * Type of phone numbers.
 */
class PhoneNumberType {

	const FIXED_LINE = 0;
	const MOBILE = 1;
	// In some regions (e.g. the USA), it is impossible to distinguish between fixed-line and
	// mobile numbers by looking at the phone number itself.
	const FIXED_LINE_OR_MOBILE = 2;
	// Freephone lines
	const TOLL_FREE = 3;
	const PREMIUM_RATE = 4;
	// The cost of this call is shared between the caller and the recipient, and is hence typically
	// less than PREMIUM_RATE calls. See // http://en.wikipedia.org/wiki/Shared_Cost_Service for
	// more information.
	const SHARED_COST = 5;
	// Voice over IP numbers. This includes TSoIP (Telephony Service over IP).
	const VOIP = 6;
	// A personal number is associated with a particular person, and may be routed to either a
	// MOBILE or FIXED_LINE number. Some more information can be found here:
	// http://en.wikipedia.org/wiki/Personal_Numbers
	const PERSONAL_NUMBER = 7;
	const PAGER = 8;
	// Used for "Universal Access Numbers" or "Company Numbers". They may be further routed to
	// specific offices, but allow one number to be used for a company.
	const UAN = 9;
	// A phone number is of type UNKNOWN when it does not fit any of the known patterns for a
	// specific region.
	const UNKNOWN = 10;

}

/**
 * Types of phone number matches. See detailed description beside the isNumberMatch() method.
 */
class MatchType {

	const NOT_A_NUMBER = 0;
	const NO_MATCH = 1;
	const SHORT_NSN_MATCH = 2;
	const NSN_MATCH = 3;
	const EXACT_MATCH = 4;

}

/**
 * Possible outcomes when testing if a PhoneNumber is possible.
 */
class ValidationResult {

	const IS_POSSIBLE = 0;
	const INVALID_COUNTRY_CODE = 1;
	const TOO_SHORT = 2;
	const TOO_LONG = 3;

}

/**
 * Utility for international phone numbers. Functionality includes formatting, parsing and
 * validation.
 *
 * <p>If you use this library, and want to be notified about important changes, please sign up to
 * our <a href="http://groups.google.com/group/libphonenumber-discuss/about">mailing list</a>.
 *
 * NOTE: A lot of methods in this class require Region Code strings. These must be provided using
 * ISO 3166-1 two-letter country-code format. These should be in upper-case. The list of the codes
 * can be found here: http://www.iso.org/iso/english_country_names_and_code_elements
 *
 * @author Shaopeng Jia
 * @author Lara Rennie
 */
class PhoneNumberUtil {

	const REGEX_FLAGS = 'ui'; //Unicode and case insensitive
	// The minimum and maximum length of the national significant number.
	const MIN_LENGTH_FOR_NSN = 3;
	const MAX_LENGTH_FOR_NSN = 15;

	// The maximum length of the country calling code.
	const MAX_LENGTH_COUNTRY_CODE = 3;

	// A mapping from a region code to the PhoneMetadata for that region.
	private $regionToMetadataMap = array();
	// A mapping from a country calling code for a non-geographical entity to the PhoneMetadata for
	// that country calling code. Examples of the country calling codes include 800 (International
	// Toll Free Service) and 808 (International Shared Cost Service).
	private $countryCodeToNonGeographicalMetadataMap = array();

	const REGION_CODE_FOR_NON_GEO_ENTITY = "001";
	const META_DATA_FILE_PREFIX = 'PhoneNumberMetadata';
	const TEST_META_DATA_FILE_PREFIX = 'PhoneNumberMetadataForTesting';

	private static $instance = NULL;
	private $supportedRegions = array();
	private $currentFilePrefix = self::META_DATA_FILE_PREFIX;

	const UNKNOWN_REGION = "ZZ";

	// The PLUS_SIGN signifies the international prefix.
	const PLUS_SIGN = '+';


	/**
	 * Gets a {@link PhoneNumberUtil} instance to carry out international phone number formatting,
	 * parsing, or validation. The instance is loaded with phone number metadata for a number of most
	 * commonly used regions.
	 *
	 * <p>The {@link PhoneNumberUtil} is implemented as a singleton. Therefore, calling getInstance
	 * multiple times will only result in one instance being created.
	 *
	 * @return PhoneNumberUtil instance
	 */
	public static function getInstance($baseFileLocation = self::META_DATA_FILE_PREFIX, array $countryCallingCodeToRegionCodeMap = NULL) {
		if ($countryCallingCodeToRegionCodeMap === NULL) {
			$countryCallingCodeToRegionCodeMap = CountryCodeToRegionCodeMap::$countryCodeToRegionCodeMap;
		}
		if (self::$instance == null) {
			self::$instance = new PhoneNumberUtil();
			self::$instance->countryCallingCodeToRegionCodeMap = $countryCallingCodeToRegionCodeMap;
			self::$instance->init($baseFileLocation);
			self::initExtnPatterns();
			self::initCapturingExtnDigits();
			self::initExtnPattern();
			self::$PLUS_CHARS_PATTERN = "[" . self::PLUS_CHARS . "]+";
			self::$SEPARATOR_PATTERN = "[" . self::VALID_PUNCTUATION . "]+";
			self::$CAPTURING_DIGIT_PATTERN = "(" . self::DIGITS . ")";
		}
		return self::$instance;
	}

	/**
	 * Used for testing purposes only to reset the PhoneNumberUtil singleton to null.
	 */
	public static function resetInstance() {
		self::$instance = NULL;
	}

	/**
	 * Convenience method to get a list of what regions the library has metadata for.
	 */
	public function getSupportedRegions() {
		return $this->supportedRegions;
	}

	/**
	 * This class implements a singleton, so the only constructor is private.
	 */
	private function __construct() {
		
	}

	private function init($filePrefix) {
		$this->currentFilePrefix = dirname(__FILE__) . '/data/' . $filePrefix;
		foreach ($this->countryCallingCodeToRegionCodeMap as $regionCodes) {
			$this->supportedRegions = array_merge($this->supportedRegions, $regionCodes);
		}
		unset($this->supportedRegions[array_search(self::REGION_CODE_FOR_NON_GEO_ENTITY, $this->supportedRegions)]);
		//nanpaRegions.addAll(countryCallingCodeToRegionCodeMap.get(NANPA_COUNTRY_CODE));
	}

	/*
	  private void loadMetadataForRegionFromFile(String filePrefix, String regionCode) {
	  InputStream source =
	  PhoneNumberUtil.class.getResourceAsStream(filePrefix + "_" + regionCode);
	  ObjectInputStream in = null;
	  try {
	  in = new ObjectInputStream(source);
	  PhoneMetadataCollection metadataCollection = new PhoneMetadataCollection();
	  metadataCollection.readExternal(in);
	  for (PhoneMetadata metadata : metadataCollection.getMetadataList()) {
	  regionToMetadataMap.put(regionCode, metadata);
	  }
	  } catch (IOException e) {
	  LOGGER.log(Level.WARNING, e.toString());
	  } finally {
	  close(in);
	  }
	  }

	  private static void close(InputStream in) {
	  if (in != null) {
	  try {
	  in.close();
	  } catch (IOException e) {
	  LOGGER.log(Level.WARNING, e.toString());
	  }
	  }
	  }
	 */

	const PLUS_CHARS = '+＋';

	private static $PLUS_CHARS_PATTERN;
	private static $SEPARATOR_PATTERN;
	private static $CAPTURING_DIGIT_PATTERN;

	const STAR_SIGN = '*';
	const RFC3966_EXTN_PREFIX = ";ext=";

	// We use this pattern to check if the phone number has at least three letters in it - if so, then
	// we treat it as a number where some phone-number digits are represented by letters.
	const VALID_ALPHA_PHONE_PATTERN = "(?:.*?[A-Za-z]){3}.*";

	// Regular expression of acceptable punctuation found in phone numbers. This excludes punctuation
	// found as a leading character only.
	// This consists of dash characters, white space characters, full stops, slashes,
	// square brackets, parentheses and tildes. It also includes the letter 'x' as that is found as a
	// placeholder for carrier information in some phone numbers. Full-width variants are also
	// present.
	/* "-x‐-―−ー－-／  <U+200B><U+2060>　()（）［］.\\[\\]/~⁓∼" */
	const VALID_PUNCTUATION = "-x\xE2\x80\x90-\xE2\x80\x95\xE2\x88\x92\xE3\x83\xBC\xEF\xBC\x8D-\xEF\xBC\x8F \xC2\xA0\xE2\x80\x8B\xE2\x81\xA0\xE3\x80\x80()\xEF\xBC\x88\xEF\xBC\x89\xEF\xBC\xBB\xEF\xBC\xBD.\\[\\]/~\xE2\x81\x93\xE2\x88\xBC";
	const DIGITS = "\\p{Nd}";

	private static $CAPTURING_EXTN_DIGITS;

	private static function initCapturingExtnDigits() {
		self::$CAPTURING_EXTN_DIGITS = "(" . self::DIGITS . "{1,7})";
	}

	private static $ALPHA_MAPPINGS = array(
		'A' => '2',
		'B' => '2',
		'C' => '2',
		'D' => '3',
		'E' => '3',
		'F' => '3',
		'G' => '4',
		'H' => '4',
		'I' => '4',
		'J' => '5',
		'K' => '5',
		'L' => '5',
		'M' => '6',
		'N' => '6',
		'O' => '6',
		'P' => '7',
		'Q' => '7',
		'R' => '7',
		'S' => '7',
		'T' => '8',
		'U' => '8',
		'V' => '8',
		'W' => '9',
		'X' => '9',
		'Y' => '9',
		'Z' => '9',
	);

	private static function getValidAlphaPattern() {
		// We accept alpha characters in phone numbers, ASCII only, upper and lower case.
		return preg_replace("[, \\[\\]]", "", implode(array_keys(self::$ALPHA_MAPPINGS))) . preg_replace("[, \\[\\]]", "", strtolower(implode(array_keys(self::$ALPHA_MAPPINGS))));
	}

	private static $EXTN_PATTERNS_FOR_PARSING;
	private static $EXTN_PATTERNS_FOR_MATCHING;

	private static function initExtnPatterns() {
		// One-character symbols that can be used to indicate an extension.
		$singleExtnSymbolsForMatching = "x\xEF\xBD\x98#\xEF\xBC\x83~\xEF\xBD\x9E";
		// For parsing, we are slightly more lenient in our interpretation than for matching. Here we
		// allow a "comma" as a possible extension indicator. When matching, this is hardly ever used to
		// indicate this.
		$singleExtnSymbolsForParsing = "," . $singleExtnSymbolsForMatching;

		self::$EXTN_PATTERNS_FOR_PARSING = self::createExtnPattern($singleExtnSymbolsForParsing);
		self::$EXTN_PATTERNS_FOR_MATCHING = self::createExtnPattern($singleExtnSymbolsForMatching);
	}

	/**
	 * Helper initialiser method to create the regular-expression pattern to match extensions,
	 * allowing the one-char extension symbols provided by {@code singleExtnSymbols}.
	 */
	private static function createExtnPattern($singleExtnSymbols) {
		// There are three regular expressions here. The first covers RFC 3966 format, where the
		// extension is added using ";ext=". The second more generic one starts with optional white
		// space and ends with an optional full stop (.), followed by zero or more spaces/tabs and then
		// the numbers themselves. The other one covers the special case of American numbers where the
		// extension is written with a hash at the end, such as "- 503#".
		// Note that the only capturing groups should be around the digits that you want to capture as
		// part of the extension, or else parsing will fail!
		// Canonical-equivalence doesn't seem to be an option with Android java, so we allow two options
		// for representing the accented o - the character itself, and one in the unicode decomposed
		// form with the combining acute accent.
		return (self::RFC3966_EXTN_PREFIX . self::$CAPTURING_EXTN_DIGITS . "|" . "[ \xC2\xA0\\t,]*" .
				"(?:e?xt(?:ensi(?:o\xCC\x81?|\xC3\xB3))?n?|(?:\xEF\xBD\x85)?\xEF\xBD\x98\xEF\xBD\x94(?:\xEF\xBD\x8E)?|" .
				"[" . $singleExtnSymbols . "]|int|\xEF\xBD\x89\xEF\xBD\x8E\xEF\xBD\x94|anexo)" .
				"[:\\.\xEF\xBC\x8E]?[ \xC2\xA0\\t,-]*" . self::$CAPTURING_EXTN_DIGITS . "#?|" .
				"[- ]+(" . self::DIGITS . "{1,5})#");
	}

	const NON_DIGITS_PATTERN = "(\\D+)";

	// The FIRST_GROUP_PATTERN was originally set to $1 but there are some countries for which the
	// first group is not used in the national pattern (e.g. Argentina) so the $1 group does not match
	// correctly.  Therefore, we use \d, so that the first group actually used in the pattern will be
	// matched.
	const FIRST_GROUP_PATTERN = "(\\$\\d)";
	const NP_PATTERN = '\\$NP';
	const FG_PATTERN = '\\$FG';
	const CC_PATTERN = '\\$CC';

	// Regular expression of viable phone numbers. This is location independent. Checks we have at
	// least three leading digits, and only valid punctuation, alpha characters and
	// digits in the phone number. Does not include extension data.
	// The symbol 'x' is allowed here as valid punctuation since it is often used as a placeholder for
	// carrier codes, for example in Brazilian phone numbers. We also allow multiple "+" characters at
	// the start.
	// Corresponds to the following:
	// plus_sign*([punctuation]*[digits]){3,}([punctuation]|[digits]|[alpha])*
	// Note VALID_PUNCTUATION starts with a -, so must be the first in the range.
	/**
	 * We append optionally the extension pattern to the end here, as a valid phone number may
	 * have an extension prefix appended, followed by 1 or more digits.
	 */
	private static function getValidPhoneNumberPattern() {
		return '%[' . self::PLUS_CHARS . ']*(?:[' . self::VALID_PUNCTUATION . ']*' . self::DIGITS . '){3,}[' .
				self::VALID_PUNCTUATION . self::getValidAlphaPattern() . self::DIGITS . "]*(?:" . self::$EXTN_PATTERNS_FOR_PARSING . ')?%' . self::REGEX_FLAGS;
	}

	/**
	 * Checks to see if the string of characters could possibly be a phone number at all. At the
	 * moment, checks to see that the string begins with at least 3 digits, ignoring any punctuation
	 * commonly found in phone numbers.
	 * This method does not require the number to be normalized in advance - but does assume that
	 * leading non-number symbols have been removed, such as by the method extractPossibleNumber.
	 *
	 * @param number  string to be checked for viability as a phone number
	 * @return boolean       true if the number could be a phone number of some sort, otherwise false
	 */
	public static function isViablePhoneNumber($number) {
		if (strlen($number) < self::MIN_LENGTH_FOR_NSN) {
			return FALSE;
		}
		$m = preg_match(self::getValidPhoneNumberPattern(), $number);
		return $m > 0;
	}

	/**
	 * Normalizes a string of characters representing a phone number. This performs
	 * the following conversions:
	 *   Punctuation is stripped.
	 *   For ALPHA/VANITY numbers:
	 *   Letters are converted to their numeric representation on a telephone
	 *       keypad. The keypad used here is the one defined in ITU Recommendation
	 *       E.161. This is only done if there are 3 or more letters in the number,
	 *       to lessen the risk that such letters are typos.
	 *   For other numbers:
	 *   Wide-ascii digits are converted to normal ASCII (European) digits.
	 *   Arabic-Indic numerals are converted to European numerals.
	 *   Spurious alpha characters are stripped.
	 *
	 * @param {string} number a string of characters representing a phone number.
	 * @return {string} the normalized string version of the phone number.
	 */
	public static function normalize($number) {
		$m = preg_match(self::getValidPhoneNumberPattern(), $number);
		if ($m > 0) {
			return $this->normalizeHelper($number, self::ALPHA_PHONE_MAPPINGS, true);
		} else {
			return $this->normalizeDigitsOnly($number);
		}
	}

	/**
	 * Normalizes a string of characters representing a phone number by replacing all characters found
	 * in the accompanying map with the values therein, and stripping all other characters if
	 * removeNonMatches is true.
	 *
	 * @param number                     a string of characters representing a phone number
	 * @param normalizationReplacements  a mapping of characters to what they should be replaced by in
	 *                                   the normalized version of the phone number
	 * @param removeNonMatches           indicates whether characters that are not able to be replaced
	 *                                   should be stripped from the number. If this is false, they
	 *                                   will be left unchanged in the number.
	 * @return  the normalized string version of the phone number
	 */
	private function normalizeHelper($number, array $normalizationReplacements, $removeNonMatches) {
		$normalizedNumber = "";
		$numberAsArray = str_split($number);
		foreach ($numberAsArray as $character) {
			if (isset($normalizationReplacements[strtoupper($character)])) {
				$normalizedNumber .= $normalizationReplacements[strtoupper($character)];
			} else if (!$removeNonMatches) {
				$normalizedNumber .= $character;
			}
			// If neither of the above are true, we remove this character.
		}
		return $normalizedNumber;
	}

	/**
	 * Normalizes a string of characters representing a phone number. This converts wide-ascii and
	 * arabic-indic numerals to European numerals, and strips punctuation and alpha characters.
	 *
	 * @param number  a string of characters representing a phone number
	 * @return        the normalized string version of the phone number
	 */
	public function normalizeDigitsOnly($number) {
		return $this->normalizeDigits($number, false /* strip non-digits */) . toString();
	}

	private function normalizeDigits($number, $keepNonDigits) {
		$normalizedDigits = "";
		$numberAsArray = str_split($number);
		foreach ($numberAsArray as $character) {
			if (is_int($character)) {
				$normalizedNumber .= $character;
			} else if ($keepNonDigits) {
				$normalizedNumber .= $character;
			}
			// If neither of the above are true, we remove this character.
		}
		return $normalizedDigits;
	}

	/**
	 * Gets the length of the geographical area code in the {@code nationalNumber_} field of the
	 * PhoneNumber object passed in, so that clients could use it to split a national significant
	 * number into geographical area code and subscriber number. It works in such a way that the
	 * resultant subscriber number should be diallable, at least on some devices. An example of how
	 * this could be used:
	 *
	 * <pre>
	 * PhoneNumberUtil phoneUtil = PhoneNumberUtil.getInstance();
	 * PhoneNumber number = phoneUtil.parse("16502530000", "US");
	 * String nationalSignificantNumber = phoneUtil.getNationalSignificantNumber(number);
	 * String areaCode;
	 * String subscriberNumber;
	 *
	 * int areaCodeLength = phoneUtil.getLengthOfGeographicalAreaCode(number);
	 * if (areaCodeLength > 0) {
	 *   areaCode = nationalSignificantNumber.substring(0, areaCodeLength);
	 *   subscriberNumber = nationalSignificantNumber.substring(areaCodeLength);
	 * } else {
	 *   areaCode = "";
	 *   subscriberNumber = nationalSignificantNumber;
	 * }
	 * </pre>
	 *
	 * N.B.: area code is a very ambiguous concept, so the I18N team generally recommends against
	 * using it for most purposes, but recommends using the more general {@code national_number}
	 * instead. Read the following carefully before deciding to use this method:
	 * <ul>
	 *  <li> geographical area codes change over time, and this method honors those changes;
	 *    therefore, it doesn't guarantee the stability of the result it produces.
	 *  <li> subscriber numbers may not be diallable from all devices (notably mobile devices, which
	 *    typically requires the full national_number to be dialled in most regions).
	 *  <li> most non-geographical numbers have no area codes, including numbers from non-geographical
	 *    entities
	 *  <li> some geographical numbers have no area codes.
	 * </ul>
	 * @param number  the PhoneNumber object for which clients want to know the length of the area
	 *     code.
	 * @return  the length of area code of the PhoneNumber object passed in.
	 */
	public function getLengthOfGeographicalAreaCode(PhoneNumber $number) {
		$regionCode = $this->getRegionCodeForNumber($number);

		if (!$this->isValidRegionCode($regionCode)) {
			return 0;
		}
		$metadata = $this->getMetadataForRegion($regionCode);
		if (!$metadata->hasNationalPrefix()) {
			return 0;
		}

		$type = $this->getNumberTypeHelper($this->getNationalSignificantNumber($number), $metadata);
		// Most numbers other than the two types below have to be dialled in full.
		if ($type != PhoneNumberType::FIXED_LINE && $type != PhoneNumberType::FIXED_LINE_OR_MOBILE) {
			return 0;
		}

		return $this->getLengthOfNationalDestinationCode($number);
	}

	/**
	 * Gets the length of the national destination code (NDC) from the PhoneNumber object passed in,
	 * so that clients could use it to split a national significant number into NDC and subscriber
	 * number. The NDC of a phone number is normally the first group of digit(s) right after the
	 * country calling code when the number is formatted in the international format, if there is a
	 * subscriber number part that follows. An example of how this could be used:
	 *
	 * <pre>
	 * PhoneNumberUtil phoneUtil = PhoneNumberUtil.getInstance();
	 * PhoneNumber number = phoneUtil.parse("18002530000", "US");
	 * String nationalSignificantNumber = phoneUtil.getNationalSignificantNumber(number);
	 * String nationalDestinationCode;
	 * String subscriberNumber;
	 *
	 * int nationalDestinationCodeLength = phoneUtil.getLengthOfNationalDestinationCode(number);
	 * if (nationalDestinationCodeLength > 0) {
	 *   nationalDestinationCode = nationalSignificantNumber.substring(0,
	 *       nationalDestinationCodeLength);
	 *   subscriberNumber = nationalSignificantNumber.substring(nationalDestinationCodeLength);
	 * } else {
	 *   nationalDestinationCode = "";
	 *   subscriberNumber = nationalSignificantNumber;
	 * }
	 * </pre>
	 *
	 * Refer to the unittests to see the difference between this function and
	 * {@link #getLengthOfGeographicalAreaCode}.
	 *
	 * @param number  the PhoneNumber object for which clients want to know the length of the NDC.
	 * @return  the length of NDC of the PhoneNumber object passed in.
	 */
	public function getLengthOfNationalDestinationCode(PhoneNumber $number) {
		if ($number->hasExtension()) {
			// We don't want to alter the proto given to us, but we don't want to include the extension
			// when we format it, so we copy it and clear the extension here.
			$copiedProto = new PhoneNumber();
			$copiedProto->mergeFrom($number);
			$copiedProto->clearExtension();
		} else {
			$copiedProto = clone $number;
		}

		$nationalSignificantNumber = $this->format($copiedProto, PhoneNumberFormat::INTERNATIONAL);

		$numberGroups = preg_split('/' . self::NON_DIGITS_PATTERN . '/', $nationalSignificantNumber);

		// The pattern will start with "+COUNTRY_CODE " so the first group will always be the empty
		// string (before the + symbol) and the second group will be the country calling code. The third
		// group will be area code if it is not the last group.
		if (count($numberGroups) <= 3) {
			return 0;
		}

		if ($this->getRegionCodeForCountryCode($number->getCountryCode()) === "AR" &&
				$this->getNumberType($number) == PhoneNumberType::MOBILE) {
			// Argentinian mobile numbers, when formatted in the international format, are in the form of
			// +54 9 NDC XXXX.... As a result, we take the length of the third group (NDC) and add 1 for
			// the digit 9, which also forms part of the national significant number.
			// TODO: Investigate the possibility of better modeling the metadata to make it
			// easier to obtain the NDC.
			return strlen($numberGroups[3]) + 1;
		}
		return strlen($numberGroups[2]);
	}

	/**
	 * Returns the region where a phone number is from. This could be used for geocoding at the region
	 * level.
	 *
	 * @param number  the phone number whose origin we want to know
	 * @return  the region where the phone number is from, or null if no region matches this calling
	 *     code
	 */
	public function getRegionCodeForNumber(PhoneNumber $number) {
		$countryCode = $number->getCountryCode();
		if (!isset($this->countryCallingCodeToRegionCodeMap[$countryCode])) {
			//$numberString = $this->getNationalSignificantNumber($number);
			return NULL;
		}
		$regions = $this->countryCallingCodeToRegionCodeMap[$countryCode];
		if (count($regions) == 1) {
			return $regions[0];
		} else {
			return $this->getRegionCodeForNumberFromRegionList($number, $regions);
		}
	}

	/**
	 * Checks whether the country calling code is from a region whose national significant number
	 * could contain a leading zero. An example of such a region is Italy. Returns false if no
	 * metadata for the country is found.
	 */
	public function isLeadingZeroPossible($countryCallingCode) {
		$mainMetadataForCallingCode = $this->getMetadataForRegion(
				$this->getRegionCodeForCountryCode($countryCallingCode));
		if ($mainMetadataForCallingCode === NULL) {
			return FALSE;
		}
		return (bool) $mainMetadataForCallingCode->isLeadingZeroPossible();
	}

	/**
	 * Checks if the number is a valid vanity (alpha) number such as 800 MICROSOFT. A valid vanity
	 * number will start with at least 3 digits and will have three or more alpha characters. This
	 * does not do region-specific checks - to work out if this number is actually valid for a region,
	 * it should be parsed and methods such as {@link #isPossibleNumberWithReason} and
	 * {@link #isValidNumber} should be used.
	 *
	 * @param number  the number that needs to be checked
	 * @return  true if the number is a valid vanity number
	 */
	public function isAlphaNumber($number) {
		if (!$this->isViablePhoneNumber($number)) {
			// Number is too short, or doesn't match the basic phone number pattern.
			return false;
		}
		$this->maybeStripExtension($number);
		return (bool) preg_match('/' . self::VALID_ALPHA_PHONE_PATTERN . '/' . self::REGEX_FLAGS, $number);
	}

	// Regexp of all known extension prefixes used by different regions followed by 1 or more valid
	// digits, for use when parsing.
	private static $EXTN_PATTERN = NULL;

	private static function initExtnPattern() {
		self::$EXTN_PATTERN = "/(?:" . self::$EXTN_PATTERNS_FOR_PARSING . ")$/" . self::REGEX_FLAGS;
	}

	/**
	 * Strips any extension (as in, the part of the number dialled after the call is connected,
	 * usually indicated with extn, ext, x or similar) from the end of the number, and returns it.
	 *
	 * @param number  the non-normalized telephone number that we wish to strip the extension from
	 * @return        the phone extension
	 */
	private function maybeStripExtension(&$number) {
		$matches = array();
		$find = preg_match(self::$EXTN_PATTERN, $number, $matches, PREG_OFFSET_CAPTURE);
		// If we find a potential extension, and the number preceding this is a viable number, we assume
		// it is an extension.
		if ($find > 0 && $this->isViablePhoneNumber(substr($number, 0, $matches[0][1]))) {
			// The numbers are captured into groups in the regular expression.

			for ($i = 1, $length = count($matches); $i <= $length; $i++) {
				if ($matches[$i][0] != "") {
					// We go through the capturing groups until we find one that captured some digits. If none
					// did, then we will return the empty string.
					$extension = $matches[$i][0];
					$number = substr($number, 0, $matches[0][1]);
					return $extension;
				}
			}
		}
		return "";
	}

	/**
	 * Tests whether a phone number matches a valid pattern. Note this doesn't verify the number
	 * is actually in use, which is impossible to tell by just looking at a number itself.
	 *
	 * @param number       the phone number that we want to validate
	 * @return boolean that indicates whether the number is of a valid pattern
	 */
	public function isValidNumber(PhoneNumber $number) {
		$regionCode = $this->getRegionCodeForNumber($number);
		return $this->isValidNumberForRegion($number, $regionCode);
	}

	/**
	 * Returns the region code that matches the specific country calling code. In the case of no
	 * region code being found, ZZ will be returned. In the case of multiple regions, the one
	 * designated in the metadata as the "main" region for this calling code will be returned.
	 */
	public function getRegionCodeForCountryCode($countryCallingCode) {
		$regionCodes = isset($this->countryCallingCodeToRegionCodeMap[$countryCallingCode]) ? $this->countryCallingCodeToRegionCodeMap[$countryCallingCode] : NULL;
		return $regionCodes === NULL ? self::UNKNOWN_REGION : $regionCodes[0];
	}

	/**
	 * Tests whether a phone number is valid for a certain region. Note this doesn't verify the number
	 * is actually in use, which is impossible to tell by just looking at a number itself. If the
	 * country calling code is not the same as the country calling code for the region, this
	 * immediately exits with false. After this, the specific number pattern rules for the region are
	 * examined. This is useful for determining for example whether a particular number is valid for
	 * Canada, rather than just a valid NANPA number.
	 *
	 * @param PhoneNumber number       the phone number that we want to validate
	 * @param string regionCode   the region that we want to validate the phone number for
	 * @return boolean that indicates whether the number is of a valid pattern
	 */
	public function isValidNumberForRegion(PhoneNumber $number, $regionCode) {
		$countryCode = $number->getCountryCode();
		$metadata = $this->getMetadataForRegionOrCallingCode($countryCode, $regionCode);
		if (($metadata === NULL) ||
				(!self::REGION_CODE_FOR_NON_GEO_ENTITY === $regionCode &&
				$countryCode != $this->getCountryCodeForValidRegion($regionCode))) {
			// Either the region code was invalid, or the country calling code for this number does not
			// match that of the region code.
			return false;
		}
		$generalNumDesc = $metadata->getGeneralDesc();
		$nationalSignificantNumber = $this->getNationalSignificantNumber($number);

		// For regions where we don't have metadata for PhoneNumberDesc, we treat any number passed in
		// as a valid number if its national significant number is between the minimum and maximum
		// lengths defined by ITU for a national significant number.
		if (!$generalNumDesc->hasNationalNumberPattern()) {
			$numberLength = strlen($nationalSignificantNumber);
			return $numberLength > self::MIN_LENGTH_FOR_NSN && $numberLength <= self::MAX_LENGTH_FOR_NSN;
		}
		return $this->getNumberTypeHelper($nationalSignificantNumber, $metadata) != PhoneNumberType::UNKNOWN;
	}

	private function getMetadataForRegionOrCallingCode($countryCallingCode, $regionCode) {
		return self::REGION_CODE_FOR_NON_GEO_ENTITY === $regionCode ? $this->getMetadataForNonGeographicalRegion($countryCallingCode) : $this->getMetadataForRegion($regionCode);
	}

	/**
	 *
	 * @param string $regionCode
	 * @return PhoneMetadata 
	 */
	public function getMetadataForRegion($regionCode) {
		if (!$this->isValidRegionCode($regionCode)) {
			return null;
		}

		if (!isset($this->regionToMetadataMap[$regionCode])) {
			// The regionCode here will be valid and won't be '001', so we don't need to worry about
			// what to pass in for the country calling code.
			$this->loadMetadataFromFile($this->currentFilePrefix, $regionCode, 0);
		}
		return isset($this->regionToMetadataMap[$regionCode]) ? $this->regionToMetadataMap[$regionCode] : NULL;
	}

	/**
	 * Helper function to check region code is not unknown or null.
	 */
	private function isValidRegionCode($regionCode) {
		return $regionCode != null && in_array($regionCode, $this->supportedRegions);
	}

	/**
	 * Helper function to check the country calling code is valid.
	 */
	private function hasValidCountryCallingCode($countryCallingCode) {
		return isset($this->countryCallingCodeToRegionCodeMap[$countryCallingCode]);
	}

	/**
	 * Formats a phone number in the specified format using default rules. Note that this does not
	 * promise to produce a phone number that the user can dial from where they are - although we do
	 * format in either 'national' or 'international' format depending on what the client asks for, we
	 * do not currently support a more abbreviated format, such as for users in the same "area" who
	 * could potentially dial the number without area code. Note that if the phone number has a
	 * country calling code of 0 or an otherwise invalid country calling code, we cannot work out
	 * which formatting rules to apply so we return the national significant number with no formatting
	 * applied.
	 *
	 * @param number         the phone number to be formatted
	 * @param numberFormat   the format the phone number should be formatted into
	 * @return  the formatted phone number
	 */
	public function format(PhoneNumber $number, $numberFormat) {
		if ($number->getNationalNumber() == 0 && $number->hasRawInput()) {
			$rawInput = $number->getRawInput();
			if (strlen($rawInput) > 0) {
				return $rawInput;
			}
		}
		$formattedNumber = "";
		$countryCallingCode = $number->getCountryCode();
		$nationalSignificantNumber = $this->getNationalSignificantNumber($number);
		if ($numberFormat == PhoneNumberFormat::E164) {
			// Early exit for E164 case since no formatting of the national number needs to be applied.
			// Extensions are not formatted.
			$formattedNumber .= $nationalSignificantNumber;
			$this->prefixNumberWithCountryCallingCode($countryCallingCode, PhoneNumberFormat::E164, $formattedNumber);
			return $formattedNumber;
		}
		// Note getRegionCodeForCountryCode() is used because formatting information for regions which
		// share a country calling code is contained by only one region for performance reasons. For
		// example, for NANPA regions it will be contained in the metadata for US.
		$regionCode = $this->getRegionCodeForCountryCode($countryCallingCode);
		if (!$this->hasValidCountryCallingCode($countryCallingCode)) {
			$formattedNumber .= $nationalSignificantNumber;
			return $formattedNumber;
		}

		$metadata = $this->getMetadataForRegionOrCallingCode($countryCallingCode, $regionCode);
		$formattedNumber .= $this->formatNsn($nationalSignificantNumber, $metadata, $numberFormat);
		$this->maybeAppendFormattedExtension($number, $metadata, $numberFormat, $formattedNumber);
		$this->prefixNumberWithCountryCallingCode($countryCallingCode, $numberFormat, $formattedNumber);
		return $formattedNumber;
	}

	private function getRegionCodeForNumberFromRegionList(PhoneNumber $number, array $regionCodes) {
		$nationalNumber = $this->getNationalSignificantNumber($number);
		foreach ($regionCodes as $regionCode) {
			// If leadingDigits is present, use this. Otherwise, do full validation.
			$metadata = $this->getMetadataForRegion($regionCode);
			if ($metadata->hasLeadingDigits()) {
				$nbMatches = preg_match('/' . $metadata->getLeadingDigits() . '/', $nationalNumber, $matches, PREG_OFFSET_CAPTURE);
				if ($nbMatches > 0 && $matches[0][1] === 0) {
					return $regionCode;
				}
			} else if ($this->getNumberTypeHelper($nationalNumber, $metadata) != PhoneNumberType::UNKNOWN) {
				return $regionCode;
			}
		}
		return NULL;
	}

	/**
	 * Gets the national significant number of the a phone number. Note a national significant number
	 * doesn't contain a national prefix or any formatting.
	 *
	 * @param number  the phone number for which the national significant number is needed
	 * @return  the national significant number of the PhoneNumber object passed in
	 */
	public function getNationalSignificantNumber(PhoneNumber $number) {
		// If a leading zero has been set, we prefix this now. Note this is not a national prefix.
		$nationalNumber = $number->isItalianLeadingZero() ? "0" : "";
		$nationalNumber .= $number->getNationalNumber();
		return $nationalNumber;
	}

	/**
	 * A helper function that is used by format and formatByPattern.
	 */
	private function prefixNumberWithCountryCallingCode($countryCallingCode, $numberFormat, &$formattedNumber) {
		switch ($numberFormat) {
			case PhoneNumberFormat::E164:
				$formattedNumber = self::PLUS_SIGN . $countryCallingCode . $formattedNumber;
				return;
			case PhoneNumberFormat::INTERNATIONAL:
				$formattedNumber = self::PLUS_SIGN . $countryCallingCode . " " . $formattedNumber;
				return;
			case PhoneNumberFormat::RFC3966:
				$formattedNumber = self::PLUS_SIGN . $countryCallingCode . "-" . $formattedNumber;
				return;
			case PhoneNumberFormat::NATIONAL:
			default:
				return;
		}
	}

	// Note in some regions, the national number can be written in two completely different ways
	// depending on whether it forms part of the NATIONAL format or INTERNATIONAL format. The
	// numberFormat parameter here is used to specify which format to use for those cases. If a
	// carrierCode is specified, this will be inserted into the formatted string to replace $CC.
	private function formatNsn($number, PhoneMetadata $metadata, $numberFormat, $carrierCode = NULL) {
		$intlNumberFormats = $metadata->intlNumberFormats();
		// When the intlNumberFormats exists, we use that to format national number for the
		// INTERNATIONAL format instead of using the numberDesc.numberFormats.
		$availableFormats =
				(count($intlNumberFormats) == 0 || $numberFormat == PhoneNumberFormat::NATIONAL) ? $metadata->numberFormats() : $metadata->intlNumberFormats();
		$formattingPattern = $this->chooseFormattingPatternForNumber($availableFormats, $number);
		return ($formattingPattern == null) ? $number : $this->formatNsnUsingPattern($number, $formattingPattern, $numberFormat, $carrierCode);
	}
	
	private function chooseFormattingPatternForNumber(array $availableFormats, $nationalNumber) {
		foreach ($availableFormats as $numFormat) {
			$size = $numFormat->leadingDigitsPatternSize();
			// We always use the last leading_digits_pattern, as it is the most detailed.
			if ($size == 0 || preg_match('/^(' . $numFormat->getLeadingDigitsPattern($size - 1) . ')/', $nationalNumber) > 0) {
				$matches = preg_match('/^' . $numFormat->getPattern() . '$/', $nationalNumber);

				if ($matches > 0) {
					return $numFormat;
				}
			}
		}
		return null;
	}
	
	// Note that carrierCode is optional - if NULL or an empty string, no carrier code replacement
	// will take place.
	private function formatNsnUsingPattern($nationalNumber, NumberFormat $formattingPattern, $numberFormat, $carrierCode = NULL) {
		$numberFormatRule = $formattingPattern->getFormat();
		$m = '/' . $formattingPattern->getPattern() . '/';
		$formattedNationalNumber = "";
		if ($numberFormat == PhoneNumberFormat::NATIONAL &&
				$carrierCode != null && strlen($carrierCode) > 0 &&
				strlen($formattingPattern->getDomesticCarrierCodeFormattingRule()) > 0) {
			// Replace the $CC in the formatting rule with the desired carrier code.
			$carrierCodeFormattingRule = $formattingPattern->getDomesticCarrierCodeFormattingRule();
			$carrierCodeFormattingRule = preg_replace('/' . self::CC_PATTERN . '/', $carrierCode, $carrierCodeFormattingRule, 1);
			// Now replace the $FG in the formatting rule with the first group and the carrier code
			// combined in the appropriate way.
			$numberFormatRule = preg_replace('/' . self::FIRST_GROUP_PATTERN . '/', $carrierCodeFormattingRule, $numberFormatRule, 1);
			$formattedNationalNumber = preg_replace($m, $numberFormatRule, $nationalNumber);
		} else {
			// Use the national prefix formatting rule instead.
			$nationalPrefixFormattingRule = $formattingPattern->getNationalPrefixFormattingRule();
			if ($numberFormat == PhoneNumberFormat::NATIONAL &&
					$nationalPrefixFormattingRule != null &&
					strlen($nationalPrefixFormattingRule) > 0) {
				$firstGroupMatcher = preg_replace('/' . self::FIRST_GROUP_PATTERN . '/', $nationalPrefixFormattingRule, $numberFormatRule, 1);
				$formattedNationalNumber = preg_replace($m, $firstGroupMatcher, $nationalNumber);
			} else {
				$formattedNationalNumber = preg_replace($m, $numberFormatRule, $nationalNumber);
			}
		}
		if ($numberFormat == PhoneNumberFormat::RFC3966) {
			// Strip any leading punctuation.
			$matcher = preg_match('%' . self::$SEPARATOR_PATTERN . '%', $formattedNationalNumber);
			if ($matcher == 0) {
				$formattedNationalNumber = preg_replace('%' . self::$SEPARATOR_PATTERN . '%', "", $formattedNationalNumber, 1);
			}
			// Replace the rest with a dash between each number group.
			$formattedNationalNumber = preg_replace('%' . self::$SEPARATOR_PATTERN . '%', "-", $formattedNationalNumber);
		}
		return $formattedNationalNumber;
	}

	/**
	 * Appends the formatted extension of a phone number to formattedNumber, if the phone number had
	 * an extension specified.
	 */
	private function maybeAppendFormattedExtension(PhoneNumber $number, PhoneMetadata $metadata, $numberFormat, &$formattedNumber) {
		if ($number->hasExtension() && strlen($number->getExtension()) > 0) {
			if ($numberFormat == PhoneNumberFormat::RFC3966) {
				$formattedNumber .= self::RFC3966_EXTN_PREFIX . $number->getExtension();
			} else {
				if ($metadata->hasPreferredExtnPrefix()) {
					$formattedNumber .= $metadata->getPreferredExtnPrefix() . $number->getExtension();
				} else {
					$formattedNumber .= self::DEFAULT_EXTN_PREFIX . $number->getExtension();
				}
			}
		}
	}

	/**
	 * Gets the type of a phone number.
	 * >isValidRegionCode($regionCode) && self::REGION_CODE_FOR_NON_GEO_ENTITY != $regionCode) {
	  return PhoneNumberType::UNKNOWN;
	  }
	  $nationalSignificantNumber = $this->getNationalSignificantNumber($number);
	  $metadata = $this->getMetadataForRegionOrCallingCode($number->getCountryCode(), $regionCode);
	  return $this->getNumberTypeHelper($nationalSignificantNumber, $metadata);
	  }

	 * @param number  the phone number that we want to know the type
	 * @return PhoneNumberType the type of the phone number
	 */
	public function getNumberType(PhoneNumber $number) {
		$regionCode = $this->getRegionCodeForNumber($number);
		if (!$this->isValidRegionCode($regionCode) && self::REGION_CODE_FOR_NON_GEO_ENTITY != $regionCode) {
			return PhoneNumberType::UNKNOWN;
		}
		$nationalSignificantNumber = $this->getNationalSignificantNumber($number);
		$metadata = $this->getMetadataForRegionOrCallingCode($number->getCountryCode(), $regionCode);
		return $this->getNumberTypeHelper($nationalSignificantNumber, $metadata);
	}

	private function loadMetadataFromFile($filePrefix, $regionCode, $countryCallingCode) {
		$isNonGeoRegion = self::REGION_CODE_FOR_NON_GEO_ENTITY === $regionCode;
		$source = $isNonGeoRegion ? $filePrefix . "_" . $countryCallingCode : $filePrefix . "_" . $regionCode;
		if (is_readable($source)) {
			$data = include $source;
			$metadata = new PhoneMetadata();
			$metadata->fromArray($data);
			if ($isNonGeoRegion) {
				$this->countryCodeToNonGeographicalMetadataMap[$countryCallingCode] = $metadata;
			} else {
				$this->regionToMetadataMap[$regionCode] = $metadata;
			}
		}
	}

	private function getNumberTypeHelper($nationalNumber, PhoneMetadata $metadata) {
		$generalNumberDesc = $metadata->getGeneralDesc();
		if (!$generalNumberDesc->hasNationalNumberPattern() ||
				!$this->isNumberMatchingDesc($nationalNumber, $generalNumberDesc)) {
			return PhoneNumberType::UNKNOWN;
		}
		if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getPremiumRate())) {
			return PhoneNumberType::PREMIUM_RATE;
		}
		if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getTollFree())) {
			return PhoneNumberType::TOLL_FREE;
		}

		/*
		 * @todo Implement other phone desc
		  if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getSharedCost())) {
		  return PhoneNumberType::SHARED_COST;
		  }
		  if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getVoip())) {
		  return PhoneNumberType::VOIP;
		  }
		  if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getPersonalNumber())) {
		  return PhoneNumberType::PERSONAL_NUMBER;
		  }
		  if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getPager())) {
		  return PhoneNumberType::PAGER;
		  }
		  if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getUan())) {
		  return PhoneNumberType::UAN;
		  }
		  if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getVoicemail())) {
		  return PhoneNumberType::VOICEMAIL;
		  }
		 */
		$isFixedLine = $this->isNumberMatchingDesc($nationalNumber, $metadata->getFixedLine());
		if ($isFixedLine) {
			if ($metadata->isSameMobileAndFixedLinePattern()) {
				return PhoneNumberType::FIXED_LINE_OR_MOBILE;
			} else if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getMobile())) {
				return PhoneNumberType::FIXED_LINE_OR_MOBILE;
			}
			return PhoneNumberType::FIXED_LINE;
		}
		// Otherwise, test to see if the number is mobile. Only do this if certain that the patterns for
		// mobile and fixed line aren't the same.
		if (!$metadata->isSameMobileAndFixedLinePattern() &&
				$this->isNumberMatchingDesc($nationalNumber, $metadata->getMobile())) {
			return PhoneNumberType::MOBILE;
		}
		return PhoneNumberType::UNKNOWN;
	}

	private function isNumberMatchingDesc($nationalNumber, PhoneNumberDesc $numberDesc) {
		$possibleNumberPatternMatcher = preg_match('/^' . str_replace(array(PHP_EOL, ' '), '', $numberDesc->getPossibleNumberPattern()) . '$/', $nationalNumber);
		$nationalNumberPatternMatcher = preg_match('/^' . str_replace(array(PHP_EOL, ' '), '', $numberDesc->getNationalNumberPattern()) . '$/', $nationalNumber);
		return $possibleNumberPatternMatcher && $nationalNumberPatternMatcher;
	}

	public function getMetadataForNonGeographicalRegion($countryCallingCode) {
		if (!isset($this->countryCallingCodeToRegionCodeMap[$countryCallingCode])) {
			return null;
		}
		if (!isset($this->countryCodeToNonGeographicalMetadataMap[$countryCallingCode])) {
			$this->loadMetadataFromFile($this->currentFilePrefix, self::REGION_CODE_FOR_NON_GEO_ENTITY, $countryCallingCode);
		}
		return $this->countryCodeToNonGeographicalMetadataMap[$countryCallingCode];
	}

	/**
	 * Returns true if the number can be dialled from outside the region, or unknown. If the number
	 * can only be dialled from within the region, returns false. Does not check the number is a valid
	 * number.
	 * TODO: Make this method public when we have enough metadata to make it worthwhile.
	 *
	 * @param number  the phone-number for which we want to know whether it is diallable from
	 *     outside the region
	 */
	public function canBeInternationallyDialled(PhoneNumber $number) {
		$regionCode = $this->getRegionCodeForNumber($number);
		if (!$this->isValidRegionCode($regionCode)) {
			// Note numbers belonging to non-geographical entities (e.g. +800 numbers) are always
			// internationally diallable, and will be caught here.
			return true;
		}
		$metadata = $this->getMetadataForRegion($regionCode);
		$nationalSignificantNumber = $this->getNationalSignificantNumber($number);
		return !$this->isNumberMatchingDesc($nationalSignificantNumber, $metadata->getNoInternationalDialling());
	}

}
