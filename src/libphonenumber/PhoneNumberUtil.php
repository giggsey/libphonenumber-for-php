<?php

namespace libphonenumber;

/**
 * Utility for international phone numbers. Functionality includes formatting, parsing and
 * validation.
 *
 * <p>If you use this library, and want to be notified about important changes, please sign up to
 * our <a href="http://groups.google.com/group/libphonenumber-discuss/about">mailing list</a>.
 *
 * NOTE: A lot of methods in this class require Region Code strings. These must be provided using
 * ISO 3166-1 two-letter country-code format. These should be in upper-case. The list of the codes
 * can be found here:
 * http://www.iso.org/iso/country_codes/iso_3166_code_lists/country_names_and_code_elements.htm
 *
 * @author Shaopeng Jia
 * @author Lara Rennie
 * @see https://code.google.com/p/libphonenumber/
 */
class PhoneNumberUtil
{
    /** Flags to use when compiling regular expressions for phone numbers */
    const REGEX_FLAGS = 'ui'; //Unicode and case insensitive
    // The minimum and maximum length of the national significant number.
    const MIN_LENGTH_FOR_NSN = 2;
    // The ITU says the maximum length should be 15, but we have found longer numbers in Germany.
    const MAX_LENGTH_FOR_NSN = 17;

    // We don't allow input strings for parsing to be longer than 250 chars. This prevents malicious
    // input from overflowing the regular-expression engine.
    const MAX_INPUT_STRING_LENGTH = 250;

    // The maximum length of the country calling code.
    const MAX_LENGTH_COUNTRY_CODE = 3;

    const REGION_CODE_FOR_NON_GEO_ENTITY = "001";
    const META_DATA_FILE_PREFIX = 'PhoneNumberMetadata';
    const TEST_META_DATA_FILE_PREFIX = 'PhoneNumberMetadataForTesting';

    // Region-code for the unknown region.
    const UNKNOWN_REGION = "ZZ";

    const NANPA_COUNTRY_CODE = 1;
    /*
     * The prefix that needs to be inserted in front of a Colombian landline number when dialed from
     * a mobile number in Colombia.
     */
    const COLOMBIA_MOBILE_TO_FIXED_LINE_PREFIX = "3";
    // The PLUS_SIGN signifies the international prefix.
    const PLUS_SIGN = '+';
    const PLUS_CHARS = '+＋';
    const STAR_SIGN = '*';

    const RFC3966_EXTN_PREFIX = ";ext=";
    const RFC3966_PREFIX = "tel:";
    const RFC3966_PHONE_CONTEXT = ";phone-context=";
    const RFC3966_ISDN_SUBADDRESS = ";isub=";

    // We use this pattern to check if the phone number has at least three letters in it - if so, then
    // we treat it as a number where some phone-number digits are represented by letters.
    const VALID_ALPHA_PHONE_PATTERN = "(?:.*?[A-Za-z]){3}.*";
    // We accept alpha characters in phone numbers, ASCII only, upper and lower case.
    const VALID_ALPHA = "A-Za-z";


    // Default extension prefix to use when formatting. This will be put in front of any extension
    // component of the number, after the main national number is formatted. For example, if you wish
    // the default extension formatting to be " extn: 3456", then you should specify " extn: " here
    // as the default extension prefix. This can be overridden by region-specific preferences.
    const DEFAULT_EXTN_PREFIX = " ext. ";

    // Regular expression of acceptable punctuation found in phone numbers. This excludes punctuation
    // found as a leading character only.
    // This consists of dash characters, white space characters, full stops, slashes,
    // square brackets, parentheses and tildes. It also includes the letter 'x' as that is found as a
    // placeholder for carrier information in some phone numbers. Full-width variants are also
    // present.
    const VALID_PUNCTUATION = "-x\xE2\x80\x90-\xE2\x80\x95\xE2\x88\x92\xE3\x83\xBC\xEF\xBC\x8D-\xEF\xBC\x8F \xC2\xA0\xC2\xAD\xE2\x80\x8B\xE2\x81\xA0\xE3\x80\x80()\xEF\xBC\x88\xEF\xBC\x89\xEF\xBC\xBB\xEF\xBC\xBD.\\[\\]/~\xE2\x81\x93\xE2\x88\xBC";
    const DIGITS = "\\p{Nd}";

    // Pattern that makes it easy to distinguish whether a region has a unique international dialing
    // prefix or not. If a region has a unique international prefix (e.g. 011 in USA), it will be
    // represented as a string that contains a sequence of ASCII digits. If there are multiple
    // available international prefixes in a region, they will be represented as a regex string that
    // always contains character(s) other than ASCII digits.
    // Note this regex also includes tilde, which signals waiting for the tone.
    const UNIQUE_INTERNATIONAL_PREFIX = "[\\d]+(?:[~\xE2\x81\x93\xE2\x88\xBC\xEF\xBD\x9E][\\d]+)?";
    const NON_DIGITS_PATTERN = "(\\D+)";

    // The FIRST_GROUP_PATTERN was originally set to $1 but there are some countries for which the
    // first group is not used in the national pattern (e.g. Argentina) so the $1 group does not match
    // correctly.  Therefore, we use \d, so that the first group actually used in the pattern will be
    // matched.
    const FIRST_GROUP_PATTERN = "(\\$\\d)";
    const NP_PATTERN = '\\$NP';
    const FG_PATTERN = '\\$FG';
    const CC_PATTERN = '\\$CC';

    // A pattern that is used to determine if the national prefix formatting rule has the first group
    // only, i.e., does not start with the national prefix. Note that the pattern explicitly allows
    // for unbalanced parentheses.
    const FIRST_GROUP_ONLY_PREFIX_PATTERN = '\\(?\\$1\\)?';
    public static $PLUS_CHARS_PATTERN;
    private static $SEPARATOR_PATTERN;
    private static $CAPTURING_DIGIT_PATTERN;
    private static $VALID_START_CHAR_PATTERN = null;
    private static $SECOND_NUMBER_START_PATTERN = "[\\\\/] *x";
    private static $UNWANTED_END_CHAR_PATTERN = "[[\\P{N}&&\\P{L}]&&[^#]]+$";
    private static $DIALLABLE_CHAR_MAPPINGS = array();
    private static $CAPTURING_EXTN_DIGITS;

    /**
     * @var PhoneNumberUtil
     */
    private static $instance = null;

    /**
     * Only upper-case variants of alpha characters are stored.
     * @var array
     */
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

    /**
     * Map of country calling codes that use a mobile token before the area code. One example of when
     * this is relevant is when determining the length of the national destination code, which should
     * be the length of the area code plus the length of the mobile token.
     * @var array
     */
    private static $MOBILE_TOKEN_MAPPINGS;

    /**
     * For performance reasons, amalgamate both into one map.
     * @var array
     */
    private static $ALPHA_PHONE_MAPPINGS;

    /**
     * Separate map of all symbols that we wish to retain when formatting alpha numbers. This
     * includes digits, ASCII letters and number grouping symbols such as "-" and " ".
     * @var array
     */
    private static $ALL_PLUS_NUMBER_GROUPING_SYMBOLS;

    /**
     * Simple ASCII digits map used to populate ALPHA_PHONE_MAPPINGS and
     * ALL_PLUS_NUMBER_GROUPING_SYMBOLS.
     * @var array
     */
    private static $asciiDigitMappings;
    /**
     * Regexp of all possible ways to write extensions, for use when parsing. This will be run as a
     * case-insensitive regexp match. Wide character versions are also provided after each ASCII
     * version.
     * @var String
     */
    private static $EXTN_PATTERNS_FOR_PARSING;
    private static $EXTN_PATTERNS_FOR_MATCHING;
    private static $EXTN_PATTERN = null;
    private static $VALID_PHONE_NUMBER_PATTERN;
    private static $MIN_LENGTH_PHONE_NUMBER_PATTERN;
    /**
     *  Regular expression of viable phone numbers. This is location independent. Checks we have at
     * least three leading digits, and only valid punctuation, alpha characters and
     * digits in the phone number. Does not include extension data.
     * The symbol 'x' is allowed here as valid punctuation since it is often used as a placeholder for
     * carrier codes, for example in Brazilian phone numbers. We also allow multiple "+" characters at
     * the start.
     * Corresponds to the following:
     * [digits]{minLengthNsn}|
     * plus_sign*(([punctuation]|[star])*[digits]){3,}([punctuation]|[star]|[digits]|[alpha])*
     *
     * The first reg-ex is to allow short numbers (two digits long) to be parsed if they are entered
     * as "15" etc, but only if there is no punctuation in them. The second expression restricts the
     * number of digits to three or more, but then allows them to be in international form, and to
     * have alpha-characters and punctuation.
     *
     * Note VALID_PUNCTUATION starts with a -, so must be the first in the range.
     * @var string
     */
    private static $VALID_PHONE_NUMBER;
    private static $numericCharacters = array();

    /**
     * The metadata loader used to inject alternative metadata sources.
     * @var MetadataLoaderInterface
     */
    private $metadataLoader;

    /**
     * A mapping from a region code to the PhoneMetadata for that region.
     * @var array
     */
    private $regionToMetadataMap = array();
    /**
     * A mapping from a country calling code for a non-geographical entity to the PhoneMetadata for
     * that country calling code. Examples of the country calling codes include 800 (International
     * Toll Free Service) and 808 (International Shared Cost Service).
     * @var array
     */
    private $countryCodeToNonGeographicalMetadataMap = array();
    /**
     * The set of county calling codes that map to the non-geo entity region ("001").
     * @var array
     */
    private $countryCodesForNonGeographicalRegion = array();
    /**
     * The set of regions the library supports.
     * @var array
     */
    private $supportedRegions = array();
    /**
     * The prefix of the metadata files from which region data is loaded.
     * @var String
     */
    private $currentFilePrefix = self::META_DATA_FILE_PREFIX;

    /**
     * A mapping from a country calling code to the region codes which denote the region represented
     * by that country calling code. In the case of multiple regions sharing a calling code, such as
     * the NANPA regions, the one indicated with "isMainCountryForCode" in the metadata should be
     * first.
     * @var array
     */
    private $countryCallingCodeToRegionCodeMap = array();
    /**
     * The set of regions that share country calling code 1.
     * @var array
     */
    private $nanpaRegions = array();

    /**
     * This class implements a singleton, so the only constructor is private.
     */
    private function __construct($filePrefix, MetadataLoaderInterface $metadataLoader, $countryCallingCodeToRegionCodeMap)
    {
        $this->metadataLoader = $metadataLoader;
        $this->countryCallingCodeToRegionCodeMap = $countryCallingCodeToRegionCodeMap;
        $this->init($filePrefix);
        self::initCapturingExtnDigits();
        self::initExtnPatterns();
        self::initAsciiDigitMappings();
        self::initExtnPattern();
        self::$PLUS_CHARS_PATTERN = "[" . self::PLUS_CHARS . "]+";
        self::$SEPARATOR_PATTERN = "[" . self::VALID_PUNCTUATION . "]+";
        self::$CAPTURING_DIGIT_PATTERN = "(" . self::DIGITS . ")";
        self::$VALID_START_CHAR_PATTERN = "[" . self::PLUS_CHARS . self::DIGITS . "]";

        self::$ALPHA_PHONE_MAPPINGS = self::$ALPHA_MAPPINGS + self::$asciiDigitMappings;

        self::$DIALLABLE_CHAR_MAPPINGS = self::$asciiDigitMappings;
        self::$DIALLABLE_CHAR_MAPPINGS[self::PLUS_SIGN] = self::PLUS_SIGN;
        self::$DIALLABLE_CHAR_MAPPINGS['*'] = '*';

        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS = array();
        // Put (lower letter -> upper letter) and (upper letter -> upper letter) mappings.
        foreach (self::$ALPHA_MAPPINGS as $c => $value) {
            self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS[strtolower($c)] = $c;
            self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS[$c] = $c;
        }
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS += self::$asciiDigitMappings;
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["-"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xEF\xBC\x8D"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE2\x80\x90"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE2\x80\x91"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE2\x80\x92"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE2\x80\x93"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE2\x80\x94"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE2\x80\x95"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE2\x88\x92"] = '-';
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["/"] = "/";
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xEF\xBC\x8F"] = "/";
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS[" "] = " ";
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE3\x80\x80"] = " ";
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xE2\x81\xA0"] = " ";
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["."] = ".";
        self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS["\xEF\xBC\x8E"] = ".";


        self::$MIN_LENGTH_PHONE_NUMBER_PATTERN = "[" . self::DIGITS . "]{" . self::MIN_LENGTH_FOR_NSN . "}";
        self::$VALID_PHONE_NUMBER = "[" . self::PLUS_CHARS . "]*(?:[" . self::VALID_PUNCTUATION . self::STAR_SIGN . "]*[" . self::DIGITS . "]){3,}[" . self::VALID_PUNCTUATION . self::STAR_SIGN . self::VALID_ALPHA . self::DIGITS . "]*";
        self::$VALID_PHONE_NUMBER_PATTERN = "%^" . self::$MIN_LENGTH_PHONE_NUMBER_PATTERN . "$|^" . self::$VALID_PHONE_NUMBER . "(?:" . self::$EXTN_PATTERNS_FOR_PARSING . ")?%" . self::REGEX_FLAGS;

        self::$UNWANTED_END_CHAR_PATTERN = "[^" . self::DIGITS . self::VALID_ALPHA . "#]+$";

        self::$MOBILE_TOKEN_MAPPINGS = array();
        self::$MOBILE_TOKEN_MAPPINGS['52'] = "1";
        self::$MOBILE_TOKEN_MAPPINGS['54'] = "9";

        self::loadNumericCharacters();
    }

    /**
     * Gets a {@link PhoneNumberUtil} instance to carry out international phone number formatting,
     * parsing, or validation. The instance is loaded with phone number metadata for a number of most
     * commonly used regions.
     *
     * <p>The {@link PhoneNumberUtil} is implemented as a singleton. Therefore, calling getInstance
     * multiple times will only result in one instance being created.
     *
     * @param string $baseFileLocation
     * @param array|null $countryCallingCodeToRegionCodeMap
     * @param MetadataLoaderInterface $metadataLoader
     * @return PhoneNumberUtil instance
     */
    public static function getInstance($baseFileLocation = self::META_DATA_FILE_PREFIX, array $countryCallingCodeToRegionCodeMap = null, MetadataLoaderInterface $metadataLoader = null)
    {
        if (self::$instance === null) {
            if ($countryCallingCodeToRegionCodeMap === null) {
                $countryCallingCodeToRegionCodeMap = CountryCodeToRegionCodeMap::$countryCodeToRegionCodeMap;
            }

            if ($metadataLoader === null) {
                $metadataLoader = new DefaultMetadataLoader();
            }

            self::$instance = new PhoneNumberUtil($baseFileLocation, $metadataLoader, $countryCallingCodeToRegionCodeMap);
        }
        return self::$instance;
    }

    private static function loadNumericCharacters()
    {
        self::$numericCharacters[pack("H*", 'efbc90')] = 0;
        self::$numericCharacters[pack("H*", 'efbc91')] = 1;
        self::$numericCharacters[pack("H*", 'efbc92')] = 2;
        self::$numericCharacters[pack("H*", 'efbc93')] = 3;
        self::$numericCharacters[pack("H*", 'efbc94')] = 4;
        self::$numericCharacters[pack("H*", 'efbc95')] = 5;
        self::$numericCharacters[pack("H*", 'efbc96')] = 6;
        self::$numericCharacters[pack("H*", 'efbc97')] = 7;
        self::$numericCharacters[pack("H*", 'efbc98')] = 8;
        self::$numericCharacters[pack("H*", 'efbc99')] = 9;

        self::$numericCharacters[pack("H*", 'd9a0')] = 0;
        self::$numericCharacters[pack("H*", 'd9a1')] = 1;
        self::$numericCharacters[pack("H*", 'd9a2')] = 2;
        self::$numericCharacters[pack("H*", 'd9a3')] = 3;
        self::$numericCharacters[pack("H*", 'd9a4')] = 4;
        self::$numericCharacters[pack("H*", 'd9a5')] = 5;
        self::$numericCharacters[pack("H*", 'd9a6')] = 6;
        self::$numericCharacters[pack("H*", 'd9a7')] = 7;
        self::$numericCharacters[pack("H*", 'd9a8')] = 8;
        self::$numericCharacters[pack("H*", 'd9a9')] = 9;

        self::$numericCharacters[pack("H*", 'dbb0')] = 0;
        self::$numericCharacters[pack("H*", 'dbb1')] = 1;
        self::$numericCharacters[pack("H*", 'dbb2')] = 2;
        self::$numericCharacters[pack("H*", 'dbb3')] = 3;
        self::$numericCharacters[pack("H*", 'dbb4')] = 4;
        self::$numericCharacters[pack("H*", 'dbb5')] = 5;
        self::$numericCharacters[pack("H*", 'dbb6')] = 6;
        self::$numericCharacters[pack("H*", 'dbb7')] = 7;
        self::$numericCharacters[pack("H*", 'dbb8')] = 8;
        self::$numericCharacters[pack("H*", 'dbb9')] = 9;

        self::$numericCharacters[pack("H*", 'e1a090')] = 0;
        self::$numericCharacters[pack("H*", 'e1a091')] = 1;
        self::$numericCharacters[pack("H*", 'e1a092')] = 2;
        self::$numericCharacters[pack("H*", 'e1a093')] = 3;
        self::$numericCharacters[pack("H*", 'e1a094')] = 4;
        self::$numericCharacters[pack("H*", 'e1a095')] = 5;
        self::$numericCharacters[pack("H*", 'e1a096')] = 6;
        self::$numericCharacters[pack("H*", 'e1a097')] = 7;
        self::$numericCharacters[pack("H*", 'e1a098')] = 8;
        self::$numericCharacters[pack("H*", 'e1a099')] = 9;
    }

    private function init($filePrefix)
    {
        $this->currentFilePrefix = dirname(__FILE__) . '/data/' . $filePrefix;
        foreach ($this->countryCallingCodeToRegionCodeMap as $countryCode => $regionCodes) {
            // We can assume that if the country calling code maps to the non-geo entity region code then
            // that's the only region code it maps to.
            if (count($regionCodes) == 1 && self::REGION_CODE_FOR_NON_GEO_ENTITY === $regionCodes[0]) {
                // This is the subset of all country codes that map to the non-geo entity region code.
                $this->countryCodesForNonGeographicalRegion[] = $countryCode;
            } else {
                // The supported regions set does not include the "001" non-geo entity region code.
                $this->supportedRegions = array_merge($this->supportedRegions, $regionCodes);
            }
        }
        // If the non-geo entity still got added to the set of supported regions it must be because
        // there are entries that list the non-geo entity alongside normal regions (which is wrong).
        // If we discover this, remove the non-geo entity from the set of supported regions and log.
        $idx_region_code_non_geo_entity = array_search(self::REGION_CODE_FOR_NON_GEO_ENTITY, $this->supportedRegions);
        if ($idx_region_code_non_geo_entity !== false) {
            unset($this->supportedRegions[$idx_region_code_non_geo_entity]);
        }
        $this->nanpaRegions = $this->countryCallingCodeToRegionCodeMap[self::NANPA_COUNTRY_CODE];
    }

    private static function initCapturingExtnDigits()
    {
        self::$CAPTURING_EXTN_DIGITS = "(" . self::DIGITS . "{1,7})";
    }

    private static function initExtnPatterns()
    {
        // One-character symbols that can be used to indicate an extension.
        $singleExtnSymbolsForMatching = "x\xEF\xBD\x98#\xEF\xBC\x83~\xEF\xBD\x9E";
        // For parsing, we are slightly more lenient in our interpretation than for matching. Here we
        // allow a "comma" as a possible extension indicator. When matching, this is hardly ever used to
        // indicate this.
        $singleExtnSymbolsForParsing = "," . $singleExtnSymbolsForMatching;

        self::$EXTN_PATTERNS_FOR_PARSING = self::createExtnPattern($singleExtnSymbolsForParsing);
        self::$EXTN_PATTERNS_FOR_MATCHING = self::createExtnPattern($singleExtnSymbolsForMatching);
    }

    // The FIRST_GROUP_PATTERN was originally set to $1 but there are some countries for which the
    // first group is not used in the national pattern (e.g. Argentina) so the $1 group does not match
    // correctly.  Therefore, we use \d, so that the first group actually used in the pattern will be
    // matched.

    /**
     * Helper initialiser method to create the regular-expression pattern to match extensions,
     * allowing the one-char extension symbols provided by {@code singleExtnSymbols}.
     * @param string $singleExtnSymbols
     * @return string
     */
    private static function createExtnPattern($singleExtnSymbols)
    {
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

    private static function initAsciiDigitMappings()
    {
        // Simple ASCII digits map used to populate ALPHA_PHONE_MAPPINGS and
        // ALL_PLUS_NUMBER_GROUPING_SYMBOLS.
        self::$asciiDigitMappings = array(
            '0' => '0',
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
        );
    }

    private static function initExtnPattern()
    {
        self::$EXTN_PATTERN = "/(?:" . self::$EXTN_PATTERNS_FOR_PARSING . ")$/" . self::REGEX_FLAGS;
    }

    /**
     * Used for testing purposes only to reset the PhoneNumberUtil singleton to null.
     */
    public static function resetInstance()
    {
        self::$instance = null;
    }

    /**
     * Converts all alpha characters in a number to their respective digits on a keypad, but retains
     * existing formatting.
     * @param string $number
     * @return string
     */
    public static function convertAlphaCharactersInNumber($number)
    {
        return self::normalizeHelper($number, self::$ALPHA_PHONE_MAPPINGS, false);
    }

    /**
     * Normalizes a string of characters representing a phone number by replacing all characters found
     * in the accompanying map with the values therein, and stripping all other characters if
     * removeNonMatches is true.
     *
     * @param string $number a string of characters representing a phone number
     * @param array $normalizationReplacements a mapping of characters to what they should be replaced by in
     * the normalized version of the phone number
     * @param bool $removeNonMatches indicates whether characters that are not able to be replaced
     * should be stripped from the number. If this is false, they will be left unchanged in the number.
     * @return string the normalized string version of the phone number
     */
    private static function normalizeHelper($number, array $normalizationReplacements, $removeNonMatches)
    {
        $normalizedNumber = "";
        $strLength = mb_strlen($number, 'UTF-8');
        for ($i = 0; $i < $strLength; $i++) {
            $character = mb_substr($number, $i, 1, 'UTF-8');
            if (isset($normalizationReplacements[mb_strtoupper($character, 'UTF-8')])) {
                $normalizedNumber .= $normalizationReplacements[mb_strtoupper($character, 'UTF-8')];
            } else {
                if (!$removeNonMatches) {
                    $normalizedNumber .= $character;
                }
            }
            // If neither of the above are true, we remove this character.
        }
        return $normalizedNumber;
    }

    /**
     * Helper function to check if the national prefix formatting rule has the first group only, i.e.,
     * does not start with the national prefix.
     * @param string $nationalPrefixFormattingRule
     * @return bool
     */
    public static function formattingRuleHasFirstGroupOnly($nationalPrefixFormattingRule)
    {
        $m = preg_match(self::FIRST_GROUP_ONLY_PREFIX_PATTERN, $nationalPrefixFormattingRule);
        return $m > 0;
    }

    /**
     * Convenience method to get a list of what regions the library has metadata for.
     * @return array
     */
    public function getSupportedRegions()
    {
        return $this->supportedRegions;
    }

    /**
     * Convenience method to get a list of what global network calling codes the library has metadata
     * for.
     * @return array
     */
    public function getSupportedGlobalNetworkCallingCodes()
    {
        return $this->countryCodesForNonGeographicalRegion;
    }

    /**
     * Gets the length of the geographical area code from the {@code nationalNumber} field of the
     * PhoneNumber object passed in, so that clients could use it to split a national significant
     * number into geographical area code and subscriber number. It works in such a way that the
     * resultant subscriber number should be diallable, at least on some devices. An example of how
     * this could be used:
     *
     * <code>
     * $phoneUtil = PhoneNumberUtil::getInstance();
     * $number = $phoneUtil->parse("16502530000", "US");
     * $nationalSignificantNumber = $phoneUtil->getNationalSignificantNumber($number);
     *
     * $areaCodeLength = $phoneUtil->getLengthOfGeographicalAreaCode($number);
     * if ($areaCodeLength > 0)
     * {
     *     $areaCode = substr($nationalSignificantNumber, 0,$areaCodeLength);
     *     $subscriberNumber = substr($nationalSignificantNumber, $areaCodeLength);
     * } else {
     *     $areaCode = "";
     *     $subscriberNumber = $nationalSignificantNumber;
     * }
     * </code>
     *
     * N.B.: area code is a very ambiguous concept, so the I18N team generally recommends against
     * using it for most purposes, but recommends using the more general {@code nationalNumber}
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
     * @param PhoneNumber $number PhoneNumber object for which clients want to know the length of the area code.
     * @return int the length of area code of the PhoneNumber object passed in.
     */
    public function getLengthOfGeographicalAreaCode(PhoneNumber $number)
    {
        $metadata = $this->getMetadataForRegion($this->getRegionCodeForNumber($number));
        if ($metadata === null) {
            return 0;
        }
        // If a country doesn't use a national prefix, and this number doesn't have an Italian leading
        // zero, we assume it is a closed dialling plan with no area codes.
        if (!$metadata->hasNationalPrefix() && !$number->isItalianLeadingZero()) {
            return 0;
        }

        if (!$this->isNumberGeographical($number)) {
            return 0;
        }

        return $this->getLengthOfNationalDestinationCode($number);
    }

    /**
     * Returns the metadata for the given region code or {@code null} if the region code is invalid
     * or unknown.
     * @param string $regionCode
     * @return PhoneMetadata
     */
    public function getMetadataForRegion($regionCode)
    {
        if (!$this->isValidRegionCode($regionCode)) {
            return null;
        }

        if (!isset($this->regionToMetadataMap[$regionCode])) {
            // The regionCode here will be valid and won't be '001', so we don't need to worry about
            // what to pass in for the country calling code.
            $this->loadMetadataFromFile($this->currentFilePrefix, $regionCode, 0, $this->metadataLoader);
        }
        return isset($this->regionToMetadataMap[$regionCode]) ? $this->regionToMetadataMap[$regionCode] : null;
    }

    /**
     * Helper function to check region code is not unknown or null.
     * @param string $regionCode
     * @return bool
     */
    private function isValidRegionCode($regionCode)
    {
        return $regionCode !== null && in_array($regionCode, $this->supportedRegions);
    }

    /**
     * @param string $filePrefix
     * @param string $regionCode
     * @param int $countryCallingCode
     * @param MetadataLoaderInterface $metadataLoader
     * @throws \RuntimeException
     */
    public function loadMetadataFromFile($filePrefix, $regionCode, $countryCallingCode, MetadataLoaderInterface $metadataLoader)
    {
        $isNonGeoRegion = self::REGION_CODE_FOR_NON_GEO_ENTITY === $regionCode;
        $fileName = $filePrefix . '_' . ($isNonGeoRegion ? $countryCallingCode : $regionCode) . '.php';
        if (!is_readable($fileName)) {
            throw new \RuntimeException('missing metadata: ' . $fileName);
        } else {
            $data = $metadataLoader->loadMetadata($fileName);
            $metadata = new PhoneMetadata();
            $metadata->fromArray($data);
            if ($isNonGeoRegion) {
                $this->countryCodeToNonGeographicalMetadataMap[$countryCallingCode] = $metadata;
            } else {
                $this->regionToMetadataMap[$regionCode] = $metadata;
            }
        }
    }

    /**
     * Returns the region where a phone number is from. This could be used for geocoding at the region
     * level.
     *
     * @param PhoneNumber $number the phone number whose origin we want to know
     * @return null|string  the region where the phone number is from, or null if no region matches this calling
     * code
     */
    public function getRegionCodeForNumber(PhoneNumber $number)
    {
        $countryCode = $number->getCountryCode();
        if (!isset($this->countryCallingCodeToRegionCodeMap[$countryCode])) {
            return null;
        }
        $regions = $this->countryCallingCodeToRegionCodeMap[$countryCode];
        if (count($regions) == 1) {
            return $regions[0];
        } else {
            return $this->getRegionCodeForNumberFromRegionList($number, $regions);
        }
    }

    /**
     * @param PhoneNumber $number
     * @param array $regionCodes
     * @return null|string
     */
    private function getRegionCodeForNumberFromRegionList(PhoneNumber $number, array $regionCodes)
    {
        $nationalNumber = $this->getNationalSignificantNumber($number);
        foreach ($regionCodes as $regionCode) {
            // If leadingDigits is present, use this. Otherwise, do full validation.
            // Metadata cannot be null because the region codes come from the country calling code map.
            $metadata = $this->getMetadataForRegion($regionCode);
            if ($metadata->hasLeadingDigits()) {
                $nbMatches = preg_match(
                    '/' . $metadata->getLeadingDigits() . '/',
                    $nationalNumber,
                    $matches,
                    PREG_OFFSET_CAPTURE
                );
                if ($nbMatches > 0 && $matches[0][1] === 0) {
                    return $regionCode;
                }
            } else if ($this->getNumberTypeHelper($nationalNumber, $metadata) != PhoneNumberType::UNKNOWN) {
                return $regionCode;
            }
        }
        return null;
    }

    /**
     * Gets the national significant number of the a phone number. Note a national significant number
     * doesn't contain a national prefix or any formatting.
     *
     * @param PhoneNumber $number the phone number for which the national significant number is needed
     * @return string the national significant number of the PhoneNumber object passed in
     */
    public function getNationalSignificantNumber(PhoneNumber $number)
    {
        // If leading zero(s) have been set, we prefix this now. Note this is not a national prefix.
        $nationalNumber = '';
        if ($number->isItalianLeadingZero()) {
            $zeros = str_repeat('0', $number->getNumberOfLeadingZeros());
            $nationalNumber .= $zeros;
        }
        $nationalNumber .= $number->getNationalNumber();
        return $nationalNumber;
    }

    /**
     * @param string $nationalNumber
     * @param PhoneMetadata $metadata
     * @return int PhoneNumberType constant
     */
    private function getNumberTypeHelper($nationalNumber, PhoneMetadata $metadata)
    {
        if (!$this->isNumberMatchingDesc($nationalNumber, $metadata->getGeneralDesc())) {
            return PhoneNumberType::UNKNOWN;
        }
        if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getPremiumRate())) {
            return PhoneNumberType::PREMIUM_RATE;
        }
        if ($this->isNumberMatchingDesc($nationalNumber, $metadata->getTollFree())) {
            return PhoneNumberType::TOLL_FREE;
        }


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
            $this->isNumberMatchingDesc($nationalNumber, $metadata->getMobile())
        ) {
            return PhoneNumberType::MOBILE;
        }
        return PhoneNumberType::UNKNOWN;
    }

    /**
     * @param string $nationalNumber
     * @param PhoneNumberDesc $numberDesc
     * @return bool
     */
    public function isNumberMatchingDesc($nationalNumber, PhoneNumberDesc $numberDesc)
    {
        $nationalNumberPatternMatcher = new Matcher($numberDesc->getNationalNumberPattern(), $nationalNumber);

        return $this->isNumberPossibleForDesc($nationalNumber, $numberDesc) && $nationalNumberPatternMatcher->matches();
    }

    /**
     *
     * Helper method to check whether a number is too short to be a regular length phone number in a
     * region.
     *
     * @param PhoneMetadata $regionMetadata
     * @param string $number
     * @return bool
     */
    private function isShorterThanPossibleNormalNumber(PhoneMetadata $regionMetadata, $number)
    {
        $possibleNumberPattern = $regionMetadata->getGeneralDesc()->getPossibleNumberPattern();
        return ($this->testNumberLengthAgainstPattern($possibleNumberPattern, $number) === ValidationResult::TOO_SHORT);
    }

    /**
     * @param string $nationalNumber
     * @param PhoneNumberDesc $numberDesc
     * @return bool
     */
    public function isNumberPossibleForDesc($nationalNumber, PhoneNumberDesc $numberDesc)
    {
        $possibleNumberPatternMatcher = new Matcher($numberDesc->getPossibleNumberPattern(), $nationalNumber);

        return $possibleNumberPatternMatcher->matches();
    }

    /**
     * Tests whether a phone number has a geographical association. It checks if the number is
     * associated to a certain region in the country where it belongs to. Note that this doesn't
     * verify if the number is actually in use.
     * @param PhoneNumber $phoneNumber
     * @return bool
     */
    public function isNumberGeographical(PhoneNumber $phoneNumber)
    {
        $numberType = $this->getNumberType($phoneNumber);
        // TODO: Include mobile phone numbers from countries like Indonesia, which has some
        // mobile numbers that are geographical.
        return $numberType == PhoneNumberType::FIXED_LINE || $numberType == PhoneNumberType::FIXED_LINE_OR_MOBILE;
    }

    /**
     * Gets the type of a phone number.
     * @param PhoneNumber $number the number the phone number that we want to know the type
     * @return int PhoneNumberType the type of the phone number
     */
    public function getNumberType(PhoneNumber $number)
    {
        $regionCode = $this->getRegionCodeForNumber($number);
        $metadata = $this->getMetadataForRegionOrCallingCode($number->getCountryCode(), $regionCode);
        if ($metadata === null) {
            return PhoneNumberType::UNKNOWN;
        }
        $nationalSignificantNumber = $this->getNationalSignificantNumber($number);
        return $this->getNumberTypeHelper($nationalSignificantNumber, $metadata);
    }

    /**
     * @param int $countryCallingCode
     * @param string $regionCode
     * @return PhoneMetadata
     */
    private function getMetadataForRegionOrCallingCode($countryCallingCode, $regionCode)
    {
        return self::REGION_CODE_FOR_NON_GEO_ENTITY === $regionCode ?
            $this->getMetadataForNonGeographicalRegion($countryCallingCode) : $this->getMetadataForRegion($regionCode);
    }

    /**
     * @param int $countryCallingCode
     * @return PhoneMetadata
     */
    public function getMetadataForNonGeographicalRegion($countryCallingCode)
    {
        if (!isset($this->countryCallingCodeToRegionCodeMap[$countryCallingCode])) {
            return null;
        }
        if (!isset($this->countryCodeToNonGeographicalMetadataMap[$countryCallingCode])) {
            $this->loadMetadataFromFile(
                $this->currentFilePrefix,
                self::REGION_CODE_FOR_NON_GEO_ENTITY,
                $countryCallingCode,
                $this->metadataLoader
            );
        }
        return $this->countryCodeToNonGeographicalMetadataMap[$countryCallingCode];
    }

    /**
     * Gets the length of the national destination code (NDC) from the PhoneNumber object passed in,
     * so that clients could use it to split a national significant number into NDC and subscriber
     * number. The NDC of a phone number is normally the first group of digit(s) right after the
     * country calling code when the number is formatted in the international format, if there is a
     * subscriber number part that follows. An example of how this could be used:
     *
     * <code>
     * $phoneUtil = PhoneNumberUtil::getInstance();
     * $number = $phoneUtil->parse("18002530000", "US");
     * $nationalSignificantNumber = $phoneUtil->getNationalSignificantNumber($number);
     *
     * $nationalDestinationCodeLength = $phoneUtil->getLengthOfNationalDestinationCode($number);
     * if ($nationalDestinationCodeLength > 0) {
     *     $nationalDestinationCode = substr($nationalSignificantNumber, 0, $nationalDestinationCodeLength);
     *     $subscriberNumber = substr($nationalSignificantNumber, $nationalDestinationCodeLength);
     * } else {
     *     $nationalDestinationCode = "";
     *     $subscriberNumber = $nationalSignificantNumber;
     * }
     * </code>
     *
     * Refer to the unit tests to see the difference between this function and
     * {@link #getLengthOfGeographicalAreaCode}.
     *
     * @param PhoneNumber $number the PhoneNumber object for which clients want to know the length of the NDC.
     * @return int the length of NDC of the PhoneNumber object passed in.
     */
    public function getLengthOfNationalDestinationCode(PhoneNumber $number)
    {
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

        if ($this->getNumberType($number) == PhoneNumberType::MOBILE) {
            // For example Argentinian mobile numbers, when formatted in the international format, are in
            // the form of +54 9 NDC XXXX.... As a result, we take the length of the third group (NDC) and
            // add the length of the second group (which is the mobile token), which also forms part of
            // the national significant number. This assumes that the mobile token is always formatted
            // separately from the rest of the phone number.

            $mobileToken = self::getCountryMobileToken($number->getCountryCode());
            if ($mobileToken !== "") {
                return mb_strlen($numberGroups[2]) + mb_strlen($numberGroups[3]);
            }
        }
        return mb_strlen($numberGroups[2]);
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
     * @param PhoneNumber $number the phone number to be formatted
     * @param int $numberFormat the PhoneNumberFormat the phone number should be formatted into
     * @return string the formatted phone number
     */
    public function format(PhoneNumber $number, $numberFormat)
    {
        if ($number->getNationalNumber() == 0 && $number->hasRawInput()) {
            // Unparseable numbers that kept their raw input just use that.
            // This is the only case where a number can be formatted as E164 without a
            // leading '+' symbol (but the original number wasn't parseable anyway).
            // TODO: Consider removing the 'if' above so that unparseable
            // strings without raw input format to the empty string instead of "+00"
            $rawInput = $number->getRawInput();
            if (mb_strlen($rawInput) > 0) {
                return $rawInput;
            }
        }
        $metadata = null;
        $formattedNumber = "";
        $countryCallingCode = $number->getCountryCode();
        $nationalSignificantNumber = $this->getNationalSignificantNumber($number);
        if ($numberFormat == PhoneNumberFormat::E164) {
            // Early exit for E164 case (even if the country calling code is invalid) since no formatting
            // of the national number needs to be applied. Extensions are not formatted.
            $formattedNumber .= $nationalSignificantNumber;
            $this->prefixNumberWithCountryCallingCode($countryCallingCode, PhoneNumberFormat::E164, $formattedNumber);
        } elseif (!$this->hasValidCountryCallingCode($countryCallingCode)) {
            $formattedNumber .= $nationalSignificantNumber;
        } else {
            // Note getRegionCodeForCountryCode() is used because formatting information for regions which
            // share a country calling code is contained by only one region for performance reasons. For
            // example, for NANPA regions it will be contained in the metadata for US.
            $regionCode = $this->getRegionCodeForCountryCode($countryCallingCode);
            // Metadata cannot be null because the country calling code is valid (which means that the
            // region code cannot be ZZ and must be one of our supported region codes).
            $metadata = $this->getMetadataForRegionOrCallingCode($countryCallingCode, $regionCode);
            $formattedNumber .= $this->formatNsn($nationalSignificantNumber, $metadata, $numberFormat);
            $this->prefixNumberWithCountryCallingCode($countryCallingCode, $numberFormat, $formattedNumber);
        }
        $this->maybeAppendFormattedExtension($number, $metadata, $numberFormat, $formattedNumber);
        return $formattedNumber;
    }

    /**
     * A helper function that is used by format and formatByPattern.
     * @param int $countryCallingCode
     * @param int $numberFormat PhoneNumberFormat
     * @param string $formattedNumber
     */
    private function prefixNumberWithCountryCallingCode($countryCallingCode, $numberFormat, &$formattedNumber)
    {
        switch ($numberFormat) {
            case PhoneNumberFormat::E164:
                $formattedNumber = self::PLUS_SIGN . $countryCallingCode . $formattedNumber;
                return;
            case PhoneNumberFormat::INTERNATIONAL:
                $formattedNumber = self::PLUS_SIGN . $countryCallingCode . " " . $formattedNumber;
                return;
            case PhoneNumberFormat::RFC3966:
                $formattedNumber = self::RFC3966_PREFIX . self::PLUS_SIGN . $countryCallingCode . "-" . $formattedNumber;
                return;
            case PhoneNumberFormat::NATIONAL:
            default:
                return;
        }
    }

    /**
     * Helper function to check the country calling code is valid.
     * @param int $countryCallingCode
     * @return bool
     */
    private function hasValidCountryCallingCode($countryCallingCode)
    {
        return isset($this->countryCallingCodeToRegionCodeMap[$countryCallingCode]);
    }

    /**
     * Returns the region code that matches the specific country calling code. In the case of no
     * region code being found, ZZ will be returned. In the case of multiple regions, the one
     * designated in the metadata as the "main" region for this calling code will be returned. If the
     * countryCallingCode entered is valid but doesn't match a specific region (such as in the case of
     * non-geographical calling codes like 800) the value "001" will be returned (corresponding to
     * the value for World in the UN M.49 schema).
     *
     * @param int $countryCallingCode
     * @return string
     */
    public function getRegionCodeForCountryCode($countryCallingCode)
    {
        $regionCodes = isset($this->countryCallingCodeToRegionCodeMap[$countryCallingCode]) ? $this->countryCallingCodeToRegionCodeMap[$countryCallingCode] : null;
        return $regionCodes === null ? self::UNKNOWN_REGION : $regionCodes[0];
    }

    /**
     * Note in some regions, the national number can be written in two completely different ways
     * depending on whether it forms part of the NATIONAL format or INTERNATIONAL format. The
     * numberFormat parameter here is used to specify which format to use for those cases. If a
     * carrierCode is specified, this will be inserted into the formatted string to replace $CC.
     * @param string $number
     * @param PhoneMetadata $metadata
     * @param int $numberFormat PhoneNumberFormat
     * @param null|string $carrierCode
     * @return string
     */
    private function formatNsn($number, PhoneMetadata $metadata, $numberFormat, $carrierCode = null)
    {
        $intlNumberFormats = $metadata->intlNumberFormats();
        // When the intlNumberFormats exists, we use that to format national number for the
        // INTERNATIONAL format instead of using the numberDesc.numberFormats.
        $availableFormats = (count($intlNumberFormats) == 0 || $numberFormat == PhoneNumberFormat::NATIONAL)
            ? $metadata->numberFormats()
            : $metadata->intlNumberFormats();
        $formattingPattern = $this->chooseFormattingPatternForNumber($availableFormats, $number);
        return ($formattingPattern === null)
            ? $number
            : $this->formatNsnUsingPattern($number, $formattingPattern, $numberFormat, $carrierCode);
    }

    /**
     * @param NumberFormat[] $availableFormats
     * @param string $nationalNumber
     * @return NumberFormat|null
     */
    public function chooseFormattingPatternForNumber(array $availableFormats, $nationalNumber)
    {
        foreach ($availableFormats as $numFormat) {
            $leadingDigitsPatternMatcher = null;
            $size = $numFormat->leadingDigitsPatternSize();
            // We always use the last leading_digits_pattern, as it is the most detailed.
            if ($size > 0) {
                $leadingDigitsPatternMatcher = new Matcher(
                    $numFormat->getLeadingDigitsPattern($size - 1),
                    $nationalNumber
                );
            }
            if ($size == 0 || $leadingDigitsPatternMatcher->lookingAt()) {
                $m = new Matcher($numFormat->getPattern(), $nationalNumber);
                if ($m->matches() > 0) {
                    return $numFormat;
                }
            }
        }
        return null;
    }

    /**
     * Note that carrierCode is optional - if null or an empty string, no carrier code replacement
     * will take place.
     * @param string $nationalNumber
     * @param NumberFormat $formattingPattern
     * @param int $numberFormat PhoneNumberFormat
     * @param null|string $carrierCode
     * @return string
     */
    private function formatNsnUsingPattern(
        $nationalNumber,
        NumberFormat $formattingPattern,
        $numberFormat,
        $carrierCode = null
    ) {
        $numberFormatRule = $formattingPattern->getFormat();
        $m = new Matcher($formattingPattern->getPattern(), $nationalNumber);
        if ($numberFormat === PhoneNumberFormat::NATIONAL &&
            $carrierCode !== null && mb_strlen($carrierCode) > 0 &&
            mb_strlen($formattingPattern->getDomesticCarrierCodeFormattingRule()) > 0
        ) {
            // Replace the $CC in the formatting rule with the desired carrier code.
            $carrierCodeFormattingRule = $formattingPattern->getDomesticCarrierCodeFormattingRule();
            $ccPatternMatcher = new Matcher(self::CC_PATTERN, $carrierCodeFormattingRule);
            $carrierCodeFormattingRule = $ccPatternMatcher->replaceFirst($carrierCode);
            // Now replace the $FG in the formatting rule with the first group and the carrier code
            // combined in the appropriate way.
            $firstGroupMatcher = new Matcher(self::FIRST_GROUP_PATTERN, $numberFormatRule);
            $numberFormatRule = $firstGroupMatcher->replaceFirst($carrierCodeFormattingRule);
            $formattedNationalNumber = $m->replaceAll($numberFormatRule);
        } else {
            // Use the national prefix formatting rule instead.
            $nationalPrefixFormattingRule = $formattingPattern->getNationalPrefixFormattingRule();
            if ($numberFormat == PhoneNumberFormat::NATIONAL &&
                $nationalPrefixFormattingRule !== null &&
                mb_strlen($nationalPrefixFormattingRule) > 0
            ) {
                $firstGroupMatcher = new Matcher(self::FIRST_GROUP_PATTERN, $numberFormatRule);
                $formattedNationalNumber = $m->replaceAll(
                    $firstGroupMatcher->replaceFirst($nationalPrefixFormattingRule)
                );
            } else {
                $formattedNationalNumber = $m->replaceAll($numberFormatRule);
            }

        }
        if ($numberFormat == PhoneNumberFormat::RFC3966) {
            // Strip any leading punctuation.
            $matcher = new Matcher(self::$SEPARATOR_PATTERN, $formattedNationalNumber);
            if ($matcher->lookingAt()) {
                $formattedNationalNumber = $matcher->replaceFirst("");
            }
            // Replace the rest with a dash between each number group.
            $formattedNationalNumber = $matcher->reset($formattedNationalNumber)->replaceAll("-");
        }
        return $formattedNationalNumber;
    }

    /**
     * Appends the formatted extension of a phone number to formattedNumber, if the phone number had
     * an extension specified.
     *
     * @param PhoneNumber $number
     * @param PhoneMetadata|null $metadata
     * @param int $numberFormat PhoneNumberFormat
     * @param string $formattedNumber
     */
    private function maybeAppendFormattedExtension(PhoneNumber $number, $metadata, $numberFormat, &$formattedNumber)
    {
        if ($number->hasExtension() && mb_strlen($number->getExtension()) > 0) {
            if ($numberFormat === PhoneNumberFormat::RFC3966) {
                $formattedNumber .= self::RFC3966_EXTN_PREFIX . $number->getExtension();
            } else {
                if (!empty($metadata) && $metadata->hasPreferredExtnPrefix()) {
                    $formattedNumber .= $metadata->getPreferredExtnPrefix() . $number->getExtension();
                } else {
                    $formattedNumber .= self::DEFAULT_EXTN_PREFIX . $number->getExtension();
                }
            }
        }
    }

    /**
     * Returns the mobile token for the provided country calling code if it has one, otherwise
     * returns an empty string. A mobile token is a number inserted before the area code when dialing
     * a mobile number from that country from abroad.
     *
     * @param int $countryCallingCode the country calling code for which we want the mobile token
     * @return string the mobile token, as a string, for the given country calling code
     */
    public static function getCountryMobileToken($countryCallingCode)
    {
        if (array_key_exists($countryCallingCode, self::$MOBILE_TOKEN_MAPPINGS)) {
            return self::$MOBILE_TOKEN_MAPPINGS[$countryCallingCode];
        }
        return "";
    }

    /**
     * Checks if the number is a valid vanity (alpha) number such as 800 MICROSOFT. A valid vanity
     * number will start with at least 3 digits and will have three or more alpha characters. This
     * does not do region-specific checks - to work out if this number is actually valid for a region,
     * it should be parsed and methods such as {@link #isPossibleNumberWithReason} and
     * {@link #isValidNumber} should be used.
     *
     * @param string $number the number that needs to be checked
     * @return bool true if the number is a valid vanity number
     */
    public function isAlphaNumber($number)
    {
        if (!$this->isViablePhoneNumber($number)) {
            // Number is too short, or doesn't match the basic phone number pattern.
            return false;
        }
        $this->maybeStripExtension($number);
        return (bool)preg_match('/' . self::VALID_ALPHA_PHONE_PATTERN . '/' . self::REGEX_FLAGS, $number);
    }

    /**
     * Checks to see if the string of characters could possibly be a phone number at all. At the
     * moment, checks to see that the string begins with at least 2 digits, ignoring any punctuation
     * commonly found in phone numbers.
     * This method does not require the number to be normalized in advance - but does assume that
     * leading non-number symbols have been removed, such as by the method extractPossibleNumber.
     *
     * @param string $number to be checked for viability as a phone number
     * @return boolean true if the number could be a phone number of some sort, otherwise false
     */
    public static function isViablePhoneNumber($number)
    {
        if (mb_strlen($number) < self::MIN_LENGTH_FOR_NSN) {
            return false;
        }

        $validPhoneNumberPattern = self::getValidPhoneNumberPattern();

        $m = preg_match($validPhoneNumberPattern, $number);
        return $m > 0;
    }

    /**
     * We append optionally the extension pattern to the end here, as a valid phone number may
     * have an extension prefix appended, followed by 1 or more digits.
     * @return string
     */
    private static function getValidPhoneNumberPattern()
    {
        return self::$VALID_PHONE_NUMBER_PATTERN;
    }

    /**
     * Strips any extension (as in, the part of the number dialled after the call is connected,
     * usually indicated with extn, ext, x or similar) from the end of the number, and returns it.
     *
     * @param string $number the non-normalized telephone number that we wish to strip the extension from
     * @return string the phone extension
     */
    private function maybeStripExtension(&$number)
    {
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
     * Parses a string and returns it in proto buffer format. This method differs from {@link #parse}
     * in that it always populates the raw_input field of the protocol buffer with numberToParse as
     * well as the country_code_source field.
     *
     * @param string $numberToParse number that we are attempting to parse. This can contain formatting
     *                                  such as +, ( and -, as well as a phone number extension. It can also
     *                                  be provided in RFC3966 format.
     * @param string $defaultRegion region that we are expecting the number to be from. This is only used
     *                                  if the number being parsed is not written in international format.
     *                                  The country calling code for the number in this case would be stored
     *                                  as that of the default region supplied.
     * @param PhoneNumber $phoneNumber
     * @return PhoneNumber              a phone number proto buffer filled with the parsed number
     */
    public function parseAndKeepRawInput($numberToParse, $defaultRegion, PhoneNumber $phoneNumber = null)
    {
        if ($phoneNumber === null) {
            $phoneNumber = new PhoneNumber();
        }
        $this->parseHelper($numberToParse, $defaultRegion, true, true, $phoneNumber);
        return $phoneNumber;
    }

    /**
     * A helper function to set the values related to leading zeros in a PhoneNumber.
     * @param string $nationalNumber
     * @param PhoneNumber $phoneNumber
     */
    public static function setItalianLeadingZerosForPhoneNumber($nationalNumber, PhoneNumber $phoneNumber)
    {
        if (strlen($nationalNumber) > 1 && substr($nationalNumber, 0, 1) == '0') {
            $phoneNumber->setItalianLeadingZero(true);
            $numberOfLeadingZeros = 1;
            // Note that if the national number is all "0"s, the last "0" is not counted as a leading
            // zero.
            while ($numberOfLeadingZeros < (strlen($nationalNumber) - 1) &&
                substr($nationalNumber, $numberOfLeadingZeros, 1) == '0') {
                $numberOfLeadingZeros++;
            }

            if ($numberOfLeadingZeros != 1) {
                $phoneNumber->setNumberOfLeadingZeros($numberOfLeadingZeros);
            }
        }
    }

    /**
     * Parses a string and fills up the phoneNumber. This method is the same as the public
     * parse() method, with the exception that it allows the default region to be null, for use by
     * isNumberMatch(). checkRegion should be set to false if it is permitted for the default region
     * to be null or unknown ("ZZ").
     * @param string $numberToParse
     * @param string $defaultRegion
     * @param bool $keepRawInput
     * @param bool $checkRegion
     * @param PhoneNumber $phoneNumber
     * @throws NumberParseException
     */
    private function parseHelper($numberToParse, $defaultRegion, $keepRawInput, $checkRegion, PhoneNumber $phoneNumber)
    {
        if ($numberToParse === null) {
            throw new NumberParseException(NumberParseException::NOT_A_NUMBER, "The phone number supplied was null.");
        }

        $numberToParse = trim($numberToParse);

        if (mb_strlen($numberToParse) > self::MAX_INPUT_STRING_LENGTH) {
            throw new NumberParseException(
                NumberParseException::TOO_LONG,
                "The string supplied was too long to parse."
            );
        }

        $nationalNumber = '';
        $this->buildNationalNumberForParsing($numberToParse, $nationalNumber);

        if (!$this->isViablePhoneNumber($nationalNumber)) {
            throw new NumberParseException(
                NumberParseException::NOT_A_NUMBER,
                "The string supplied did not seem to be a phone number."
            );
        }

        // Check the region supplied is valid, or that the extracted number starts with some sort of +
        // sign so the number's region can be determined.
        if ($checkRegion && !$this->checkRegionForParsing($nationalNumber, $defaultRegion)) {
            throw new NumberParseException(
                NumberParseException::INVALID_COUNTRY_CODE,
                "Missing or invalid default region."
            );
        }

        if ($keepRawInput) {
            $phoneNumber->setRawInput($numberToParse);
        }
        // Attempt to parse extension first, since it doesn't require region-specific data and we want
        // to have the non-normalised number here.
        $extension = $this->maybeStripExtension($nationalNumber);
        if (mb_strlen($extension) > 0) {
            $phoneNumber->setExtension($extension);
        }

        $regionMetadata = $this->getMetadataForRegion($defaultRegion);
        // Check to see if the number is given in international format so we know whether this number is
        // from the default region or not.
        $normalizedNationalNumber = "";
        try {
            // TODO: This method should really just take in the string buffer that has already
            // been created, and just remove the prefix, rather than taking in a string and then
            // outputting a string buffer.
            $countryCode = $this->maybeExtractCountryCode(
                $nationalNumber,
                $regionMetadata,
                $normalizedNationalNumber,
                $keepRawInput,
                $phoneNumber
            );
        } catch (NumberParseException $e) {
            $matcher = new Matcher(self::$PLUS_CHARS_PATTERN, $nationalNumber);
            if ($e->getErrorType() == NumberParseException::INVALID_COUNTRY_CODE && $matcher->lookingAt()) {
                // Strip the plus-char, and try again.
                $countryCode = $this->maybeExtractCountryCode(
                    substr($nationalNumber, $matcher->end()),
                    $regionMetadata,
                    $normalizedNationalNumber,
                    $keepRawInput,
                    $phoneNumber
                );
                if ($countryCode == 0) {
                    throw new NumberParseException(
                        NumberParseException::INVALID_COUNTRY_CODE,
                        "Could not interpret numbers after plus-sign."
                    );
                }
            } else {
                throw new NumberParseException($e->getErrorType(), $e->getMessage(), $e);
            }
        }
        if ($countryCode !== 0) {
            $phoneNumberRegion = $this->getRegionCodeForCountryCode($countryCode);
            if ($phoneNumberRegion != $defaultRegion) {
                // Metadata cannot be null because the country calling code is valid.
                $regionMetadata = $this->getMetadataForRegionOrCallingCode($countryCode, $phoneNumberRegion);
            }
        } else {
            // If no extracted country calling code, use the region supplied instead. The national number
            // is just the normalized version of the number we were given to parse.

            $normalizedNationalNumber .= $this->normalize($nationalNumber);
            if ($defaultRegion !== null) {
                $countryCode = $regionMetadata->getCountryCode();
                $phoneNumber->setCountryCode($countryCode);
            } else if ($keepRawInput) {
                $phoneNumber->clearCountryCodeSource();
            }
        }
        if (mb_strlen($normalizedNationalNumber) < self::MIN_LENGTH_FOR_NSN) {
            throw new NumberParseException(
                NumberParseException::TOO_SHORT_NSN,
                "The string supplied is too short to be a phone number."
            );
        }
        if ($regionMetadata !== null) {
            $carrierCode = "";
            $potentialNationalNumber = $normalizedNationalNumber;
            $this->maybeStripNationalPrefixAndCarrierCode($potentialNationalNumber, $regionMetadata, $carrierCode);
            // We require that the NSN remaining after stripping the national prefix and carrier code be
            // of a possible length for the region. Otherwise, we don't do the stripping, since the
            // original number could be a valid short number.
            if (!$this->isShorterThanPossibleNormalNumber($regionMetadata, $potentialNationalNumber)) {
                $normalizedNationalNumber = $potentialNationalNumber;
                if ($keepRawInput) {
                    $phoneNumber->setPreferredDomesticCarrierCode($carrierCode);
                }
            }
        }
        $lengthOfNationalNumber = mb_strlen($normalizedNationalNumber);
        if ($lengthOfNationalNumber < self::MIN_LENGTH_FOR_NSN) {
            throw new NumberParseException(
                NumberParseException::TOO_SHORT_NSN,
                "The string supplied is too short to be a phone number."
            );
        }
        if ($lengthOfNationalNumber > self::MAX_LENGTH_FOR_NSN) {
            throw new NumberParseException(
                NumberParseException::TOO_LONG,
                "The string supplied is too long to be a phone number."
            );
        }
        $this->setItalianLeadingZerosForPhoneNumber($normalizedNationalNumber, $phoneNumber);


        /*
         * We have to store the National Number as a string instead of a "long" as Google do
         *
         * Since PHP doesn't always support 64 bit INTs, this was a float, but that had issues
         * with long numbers.
         *
         * We have to remove the leading zeroes ourself though
         */
        if ((int)$normalizedNationalNumber == 0) {
            $normalizedNationalNumber = "0";
        } else {
            $normalizedNationalNumber = ltrim($normalizedNationalNumber, '0');
        }

        $phoneNumber->setNationalNumber($normalizedNationalNumber);
    }

    /**
     * Converts numberToParse to a form that we can parse and write it to nationalNumber if it is
     * written in RFC3966; otherwise extract a possible number out of it and write to nationalNumber.
     * @param string $numberToParse
     * @param string $nationalNumber
     */
    private function buildNationalNumberForParsing($numberToParse, &$nationalNumber)
    {
        $indexOfPhoneContext = strpos($numberToParse, self::RFC3966_PHONE_CONTEXT);
        if ($indexOfPhoneContext > 0) {
            $phoneContextStart = $indexOfPhoneContext + mb_strlen(self::RFC3966_PHONE_CONTEXT);
            // If the phone context contains a phone number prefix, we need to capture it, whereas domains
            // will be ignored.
            if (substr($numberToParse, $phoneContextStart, 1) == self::PLUS_SIGN) {
                // Additional parameters might follow the phone context. If so, we will remove them here
                // because the parameters after phone context are not important for parsing the
                // phone number.
                $phoneContextEnd = strpos($numberToParse, ';', $phoneContextStart);
                if ($phoneContextEnd > 0) {
                    $nationalNumber .= substr($numberToParse, $phoneContextStart, $phoneContextEnd - $phoneContextStart);
                } else {
                    $nationalNumber .= substr($numberToParse, $phoneContextStart);
                }
            }

            // Now append everything between the "tel:" prefix and the phone-context. This should include
            // the national number, an optional extension or isdn-subaddress component. Note we also
            // handle the case when "tel:" is missing, as we have seen in some of the phone number inputs.
            // In that case, we append everything from the beginning.

            $indexOfRfc3966Prefix = strpos($numberToParse, self::RFC3966_PREFIX);
            $indexOfNationalNumber = ($indexOfRfc3966Prefix !== false) ? $indexOfRfc3966Prefix + strlen(self::RFC3966_PREFIX) : 0;
            $nationalNumber .= substr($numberToParse, $indexOfNationalNumber, ($indexOfPhoneContext - $indexOfNationalNumber));
        } else {
            // Extract a possible number from the string passed in (this strips leading characters that
            // could not be the start of a phone number.)
            $nationalNumber .= $this->extractPossibleNumber($numberToParse);
        }

        // Delete the isdn-subaddress and everything after it if it is present. Note extension won't
        // appear at the same time with isdn-subaddress according to paragraph 5.3 of the RFC3966 spec,
        $indexOfIsdn = strpos($nationalNumber, self::RFC3966_ISDN_SUBADDRESS);
        if ($indexOfIsdn > 0) {
            $nationalNumber = substr($nationalNumber, 0, $indexOfIsdn);
        }
        // If both phone context and isdn-subaddress are absent but other parameters are present, the
        // parameters are left in nationalNumber. This is because we are concerned about deleting
        // content from a potential number string when there is no strong evidence that the number is
        // actually written in RFC3966.
    }

    /**
     * Attempts to extract a possible number from the string passed in. This currently strips all
     * leading characters that cannot be used to start a phone number. Characters that can be used to
     * start a phone number are defined in the VALID_START_CHAR_PATTERN. If none of these characters
     * are found in the number passed in, an empty string is returned. This function also attempts to
     * strip off any alternative extensions or endings if two or more are present, such as in the case
     * of: (530) 583-6985 x302/x2303. The second extension here makes this actually two phone numbers,
     * (530) 583-6985 x302 and (530) 583-6985 x2303. We remove the second extension so that the first
     * number is parsed correctly.
     *
     * @param int $number the string that might contain a phone number
     * @return string the number, stripped of any non-phone-number prefix (such as "Tel:") or an empty
     *                string if no character used to start phone numbers (such as + or any digit) is
     *                found in the number
     */
    public static function extractPossibleNumber($number)
    {
        $matches = array();
        $match = preg_match('/' . self::$VALID_START_CHAR_PATTERN . '/ui', $number, $matches, PREG_OFFSET_CAPTURE);
        if ($match > 0) {
            $number = substr($number, $matches[0][1]);
            // Remove trailing non-alpha non-numerical characters.
            $trailingCharsMatcher = new Matcher(self::$UNWANTED_END_CHAR_PATTERN, $number);
            if ($trailingCharsMatcher->find() && $trailingCharsMatcher->start() > 0) {
                $number = substr($number, 0, $trailingCharsMatcher->start());
            }

            // Check for extra numbers at the end.
            $match = preg_match('%' . self::$SECOND_NUMBER_START_PATTERN . '%', $number, $matches, PREG_OFFSET_CAPTURE);
            if ($match > 0) {
                $number = substr($number, 0, $matches[0][1]);
            }

            return $number;
        } else {
            return "";
        }
    }

    /**
     * Checks to see that the region code used is valid, or if it is not valid, that the number to
     * parse starts with a + symbol so that we can attempt to infer the region from the number.
     * Returns false if it cannot use the region provided and the region cannot be inferred.
     * @param string $numberToParse
     * @param string $defaultRegion
     * @return bool
     */
    private function checkRegionForParsing($numberToParse, $defaultRegion)
    {
        if (!$this->isValidRegionCode($defaultRegion)) {
            // If the number is null or empty, we can't infer the region.
            $plusCharsPatternMatcher = new Matcher(self::$PLUS_CHARS_PATTERN, $numberToParse);
            if ($numberToParse === null || mb_strlen($numberToParse) == 0 || !$plusCharsPatternMatcher->lookingAt()) {
                return false;
            }
        }
        return true;
    }

    /**
     * Tries to extract a country calling code from a number. This method will return zero if no
     * country calling code is considered to be present. Country calling codes are extracted in the
     * following ways:
     * <ul>
     *  <li> by stripping the international dialing prefix of the region the person is dialing from,
     *       if this is present in the number, and looking at the next digits
     *  <li> by stripping the '+' sign if present and then looking at the next digits
     *  <li> by comparing the start of the number and the country calling code of the default region.
     *       If the number is not considered possible for the numbering plan of the default region
     *       initially, but starts with the country calling code of this region, validation will be
     *       reattempted after stripping this country calling code. If this number is considered a
     *       possible number, then the first digits will be considered the country calling code and
     *       removed as such.
     * </ul>
     * It will throw a NumberParseException if the number starts with a '+' but the country calling
     * code supplied after this does not match that of any known region.
     *
     * @param string $number non-normalized telephone number that we wish to extract a country calling
     *     code from - may begin with '+'
     * @param PhoneMetadata $defaultRegionMetadata metadata about the region this number may be from
     * @param string $nationalNumber a string buffer to store the national significant number in, in the case
     *     that a country calling code was extracted. The number is appended to any existing contents.
     *     If no country calling code was extracted, this will be left unchanged.
     * @param bool $keepRawInput true if the country_code_source and preferred_carrier_code fields of
     *     phoneNumber should be populated.
     * @param PhoneNumber $phoneNumber the PhoneNumber object where the country_code and country_code_source need
     *     to be populated. Note the country_code is always populated, whereas country_code_source is
     *     only populated when keepCountryCodeSource is true.
     * @return int the country calling code extracted or 0 if none could be extracted
     * @throws NumberParseException
     */
    public function maybeExtractCountryCode(
        $number,
        PhoneMetadata $defaultRegionMetadata = null,
        &$nationalNumber,
        $keepRawInput,
        PhoneNumber $phoneNumber
    ) {
        if (mb_strlen($number) == 0) {
            return 0;
        }
        $fullNumber = $number;
        // Set the default prefix to be something that will never match.
        $possibleCountryIddPrefix = "NonMatch";
        if ($defaultRegionMetadata !== null) {
            $possibleCountryIddPrefix = $defaultRegionMetadata->getInternationalPrefix();
        }
        $countryCodeSource = $this->maybeStripInternationalPrefixAndNormalize($fullNumber, $possibleCountryIddPrefix);

        if ($keepRawInput) {
            $phoneNumber->setCountryCodeSource($countryCodeSource);
        }
        if ($countryCodeSource != CountryCodeSource::FROM_DEFAULT_COUNTRY) {
            if (mb_strlen($fullNumber) <= self::MIN_LENGTH_FOR_NSN) {
                throw new NumberParseException(
                    NumberParseException::TOO_SHORT_AFTER_IDD,
                    "Phone number had an IDD, but after this was not long enough to be a viable phone number."
                );
            }
            $potentialCountryCode = $this->extractCountryCode($fullNumber, $nationalNumber);

            if ($potentialCountryCode != 0) {
                $phoneNumber->setCountryCode($potentialCountryCode);
                return $potentialCountryCode;
            }

            // If this fails, they must be using a strange country calling code that we don't recognize,
            // or that doesn't exist.
            throw new NumberParseException(
                NumberParseException::INVALID_COUNTRY_CODE,
                "Country calling code supplied was not recognised."
            );
        } else if ($defaultRegionMetadata !== null) {
            // Check to see if the number starts with the country calling code for the default region. If
            // so, we remove the country calling code, and do some checks on the validity of the number
            // before and after.
            $defaultCountryCode = $defaultRegionMetadata->getCountryCode();
            $defaultCountryCodeString = (string)$defaultCountryCode;
            $normalizedNumber = (string)$fullNumber;
            if (strpos($normalizedNumber, $defaultCountryCodeString) === 0) {
                $potentialNationalNumber = substr($normalizedNumber, mb_strlen($defaultCountryCodeString));
                $generalDesc = $defaultRegionMetadata->getGeneralDesc();
                $validNumberPattern = $generalDesc->getNationalNumberPattern();
                // Don't need the carrier code.
                $carriercode = null;
                $this->maybeStripNationalPrefixAndCarrierCode(
                    $potentialNationalNumber,
                    $defaultRegionMetadata,
                    $carriercode
                );
                $possibleNumberPattern = $generalDesc->getPossibleNumberPattern();
                // If the number was not valid before but is valid now, or if it was too long before, we
                // consider the number with the country calling code stripped to be a better result and
                // keep that instead.
                if ((preg_match('/^(' . $validNumberPattern . ')$/x', $fullNumber) == 0 &&
                        preg_match('/^(' . $validNumberPattern . ')$/x', $potentialNationalNumber) > 0) ||
                    $this->testNumberLengthAgainstPattern($possibleNumberPattern, (string)$fullNumber)
                    == ValidationResult::TOO_LONG
                ) {
                    $nationalNumber .= $potentialNationalNumber;
                    if ($keepRawInput) {
                        $phoneNumber->setCountryCodeSource(CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN);
                    }
                    $phoneNumber->setCountryCode($defaultCountryCode);
                    return $defaultCountryCode;
                }
            }
        }
        // No country calling code present.
        $phoneNumber->setCountryCode(0);
        return 0;
    }

    /**
     * Strips any international prefix (such as +, 00, 011) present in the number provided, normalizes
     * the resulting number, and indicates if an international prefix was present.
     *
     * @param string $number the non-normalized telephone number that we wish to strip any international
     *     dialing prefix from.
     * @param string $possibleIddPrefix string the international direct dialing prefix from the region we
     *     think this number may be dialed in
     * @return int the corresponding CountryCodeSource if an international dialing prefix could be
     *     removed from the number, otherwise CountryCodeSource.FROM_DEFAULT_COUNTRY if the number did
     *     not seem to be in international format.
     */
    public function maybeStripInternationalPrefixAndNormalize(&$number, $possibleIddPrefix)
    {
        if (mb_strlen($number) == 0) {
            return CountryCodeSource::FROM_DEFAULT_COUNTRY;
        }
        $matches = array();
        // Check to see if the number begins with one or more plus signs.
        $match = preg_match('/^' . self::$PLUS_CHARS_PATTERN . '/' . self::REGEX_FLAGS, $number, $matches, PREG_OFFSET_CAPTURE);
        if ($match > 0) {
            $number = mb_substr($number, $matches[0][1] + mb_strlen($matches[0][0]));
            // Can now normalize the rest of the number since we've consumed the "+" sign at the start.
            $number = $this->normalize($number);
            return CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN;
        }
        // Attempt to parse the first digits as an international prefix.
        $iddPattern = $possibleIddPrefix;
        $number = $this->normalize($number);
        return $this->parsePrefixAsIdd($iddPattern, $number)
            ? CountryCodeSource::FROM_NUMBER_WITH_IDD
            : CountryCodeSource::FROM_DEFAULT_COUNTRY;
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
     * @param string $number a string of characters representing a phone number.
     * @return string the normalized string version of the phone number.
     */
    public static function normalize(&$number)
    {
        $m = new Matcher(self::VALID_ALPHA_PHONE_PATTERN, $number);
        if ($m->matches()) {
            return self::normalizeHelper($number, self::$ALPHA_PHONE_MAPPINGS, true);
        } else {
            return self::normalizeDigitsOnly($number);
        }
    }

    /**
     * Normalizes a string of characters representing a phone number. This converts wide-ascii and
     * arabic-indic numerals to European numerals, and strips punctuation and alpha characters.
     *
     * @param $number string  a string of characters representing a phone number
     * @return string the normalized string version of the phone number
     */
    public static function normalizeDigitsOnly($number)
    {
        return self::normalizeDigits($number, false /* strip non-digits */);
    }

    /**
     * @param string $number
     * @param bool $keepNonDigits
     * @return string
     */
    public static function normalizeDigits($number, $keepNonDigits)
    {
        $normalizedDigits = "";
        $numberAsArray = preg_split('/(?<!^)(?!$)/u', $number);
        foreach ($numberAsArray as $character) {
            if (is_numeric($character)) {
                $normalizedDigits .= $character;
            } elseif ($keepNonDigits) {
                $normalizedDigits .= $character;
            }
            // If neither of the above are true, we remove this character.

            // Check if we are in the unicode number range
            if (array_key_exists($character, self::$numericCharacters)) {
                $normalizedDigits .= self::$numericCharacters[$character];
            }
        }
        return $normalizedDigits;
    }

    /**
     * Strips the IDD from the start of the number if present. Helper function used by
     * maybeStripInternationalPrefixAndNormalize.
     * @param string $iddPattern
     * @param string $number
     * @return bool
     */
    private function parsePrefixAsIdd($iddPattern, &$number)
    {
        $m = new Matcher($iddPattern, $number);
        if ($m->lookingAt()) {
            $matchEnd = $m->end();
            // Only strip this if the first digit after the match is not a 0, since country calling codes
            // cannot begin with 0.
            $digitMatcher = new Matcher(self::$CAPTURING_DIGIT_PATTERN, substr($number, $matchEnd));
            if ($digitMatcher->find()) {
                $normalizedGroup = $this->normalizeDigitsOnly($digitMatcher->group(1));
                if ($normalizedGroup == "0") {
                    return false;
                }
            }
            $number = substr($number, $matchEnd);
            return true;
        }
        return false;
    }

    /**
     * Extracts country calling code from fullNumber, returns it and places the remaining number in  nationalNumber.
     * It assumes that the leading plus sign or IDD has already been removed.
     * Returns 0 if fullNumber doesn't start with a valid country calling code, and leaves nationalNumber unmodified.
     * @param string $fullNumber
     * @param string $nationalNumber
     * @return int
     */
    private function extractCountryCode(&$fullNumber, &$nationalNumber)
    {
        if ((mb_strlen($fullNumber) == 0) || ($fullNumber[0] == '0')) {
            // Country codes do not begin with a '0'.
            return 0;
        }
        $numberLength = mb_strlen($fullNumber);
        for ($i = 1; $i <= self::MAX_LENGTH_COUNTRY_CODE && $i <= $numberLength; $i++) {
            $potentialCountryCode = (int)substr($fullNumber, 0, $i);
            if (isset($this->countryCallingCodeToRegionCodeMap[$potentialCountryCode])) {
                $nationalNumber .= substr($fullNumber, $i);
                return $potentialCountryCode;
            }
        }
        return 0;
    }

    /**
     * Strips any national prefix (such as 0, 1) present in the number provided.
     *
     * @param string $number the normalized telephone number that we wish to strip any national
     *     dialing prefix from
     * @param PhoneMetadata $metadata the metadata for the region that we think this number is from
     * @param string $carrierCode a place to insert the carrier code if one is extracted
     * @return bool true if a national prefix or carrier code (or both) could be extracted.
     */
    public function maybeStripNationalPrefixAndCarrierCode(&$number, PhoneMetadata $metadata, &$carrierCode)
    {
        $numberLength = mb_strlen($number);
        $possibleNationalPrefix = $metadata->getNationalPrefixForParsing();
        if ($numberLength == 0 || $possibleNationalPrefix === null || mb_strlen($possibleNationalPrefix) == 0) {
            // Early return for numbers of zero length.
            return false;
        }

        // Attempt to parse the first digits as a national prefix.
        $prefixMatcher = new Matcher($possibleNationalPrefix, $number);
        if ($prefixMatcher->lookingAt()) {
            $nationalNumberRule = $metadata->getGeneralDesc()->getNationalNumberPattern();
            // Check if the original number is viable.
            $nationalNumberRuleMatcher = new Matcher($nationalNumberRule, $number);
            $isViableOriginalNumber = $nationalNumberRuleMatcher->matches();
            // $prefixMatcher->group($numOfGroups) === null implies nothing was captured by the capturing
            // groups in $possibleNationalPrefix; therefore, no transformation is necessary, and we just
            // remove the national prefix
            $numOfGroups = $prefixMatcher->groupCount();
            $transformRule = $metadata->getNationalPrefixTransformRule();
            if ($transformRule === null
                || mb_strlen($transformRule) == 0
                || $prefixMatcher->group($numOfGroups - 1) === null
            ) {
                // If the original number was viable, and the resultant number is not, we return.
                $matcher = new Matcher($nationalNumberRule, substr($number, $prefixMatcher->end()));
                if ($isViableOriginalNumber && !$matcher->matches()) {
                    return false;
                }
                if ($carrierCode !== null && $numOfGroups > 0 && $prefixMatcher->group($numOfGroups) !== null) {
                    $carrierCode .= $prefixMatcher->group(1);
                }

                $number = substr($number, $prefixMatcher->end());
                return true;
            } else {
                // Check that the resultant number is still viable. If not, return. Check this by copying
                // the string and making the transformation on the copy first.
                $transformedNumber = $number;
                $transformedNumber = substr_replace(
                    $transformedNumber,
                    $prefixMatcher->replaceFirst($transformRule),
                    0,
                    $numberLength
                );
                $matcher = new Matcher($nationalNumberRule, $transformedNumber);
                if ($isViableOriginalNumber && !$matcher->matches()) {
                    return false;
                }
                if ($carrierCode !== null && $numOfGroups > 1) {
                    $carrierCode .= $prefixMatcher->group(1);
                }
                $number = substr_replace($number, $transformedNumber, 0, mb_strlen($number));
                return true;
            }
        }
        return false;
    }

    /**
     * Helper method to check a number against a particular pattern and determine whether it matches,
     * or is too short or too long. Currently, if a number pattern suggests that numbers of length 7
     * and 10 are possible, and a number in between these possible lengths is entered, such as of
     * length 8, this will return TOO_LONG.
     * @param string $numberPattern
     * @param string $number
     * @return int ValidationResult
     */
    private function testNumberLengthAgainstPattern($numberPattern, $number)
    {
        $numberMatcher = new Matcher($numberPattern, $number);
        if ($numberMatcher->matches()) {
            return ValidationResult::IS_POSSIBLE;
        }
        if ($numberMatcher->lookingAt()) {
            return ValidationResult::TOO_LONG;
        } else {
            return ValidationResult::TOO_SHORT;
        }
    }

    /**
     * Returns a list with the region codes that match the specific country calling code. For
     * non-geographical country calling codes, the region code 001 is returned. Also, in the case
     * of no region code being found, an empty list is returned.
     * @param int $countryCallingCode
     * @return array|null
     */
    public function getRegionCodesForCountryCode($countryCallingCode)
    {
        $regionCodes = isset($this->countryCallingCodeToRegionCodeMap[$countryCallingCode]) ? $this->countryCallingCodeToRegionCodeMap[$countryCallingCode] : null;
        return $regionCodes === null ? array() : $regionCodes;
    }

    /**
     * Returns the country calling code for a specific region. For example, this would be 1 for the
     * United States, and 64 for New Zealand. Assumes the region is already valid.
     *
     * @param string $regionCode the region that we want to get the country calling code for
     * @return int the country calling code for the region denoted by regionCode
     */
    public function getCountryCodeForRegion($regionCode)
    {
        if (!$this->isValidRegionCode($regionCode)) {
            return 0;
        }
        return $this->getCountryCodeForValidRegion($regionCode);
    }

    /**
     * Returns the country calling code for a specific region. For example, this would be 1 for the
     * United States, and 64 for New Zealand. Assumes the region is already valid.
     *
     * @param string $regionCode the region that we want to get the country calling code for
     * @return int the country calling code for the region denoted by regionCode
     * @throws \InvalidArgumentException if the region is invalid
     */
    private function getCountryCodeForValidRegion($regionCode)
    {
        $metadata = $this->getMetadataForRegion($regionCode);
        if ($metadata === null) {
            throw new \InvalidArgumentException("Invalid region code: " . $regionCode);
        }
        return $metadata->getCountryCode();
    }

    /**
     * Returns a number formatted in such a way that it can be dialed from a mobile phone in a
     * specific region. If the number cannot be reached from the region (e.g. some countries block
     * toll-free numbers from being called outside of the country), the method returns an empty
     * string.
     *
     * @param PhoneNumber $number the phone number to be formatted
     * @param string $regionCallingFrom the region where the call is being placed
     * @param boolean $withFormatting whether the number should be returned with formatting symbols, such as
     *     spaces and dashes.
     * @return string the formatted phone number
     */
    public function formatNumberForMobileDialing(PhoneNumber $number, $regionCallingFrom, $withFormatting)
    {
        $countryCallingCode = $number->getCountryCode();
        if (!$this->hasValidCountryCallingCode($countryCallingCode)) {
            return $number->hasRawInput() ? $number->getRawInput() : "";
        }

        $formattedNumber = "";
        // Clear the extension, as that part cannot normally be dialed together with the main number.
        $numberNoExt = new PhoneNumber();
        $numberNoExt->mergeFrom($number)->clearExtension();
        $regionCode = $this->getRegionCodeForCountryCode($countryCallingCode);
        $numberType = $this->getNumberType($numberNoExt);
        $isValidNumber = ($numberType !== PhoneNumberType::UNKNOWN);
        if ($regionCallingFrom == $regionCode) {
            $isFixedLineOrMobile = ($numberType == PhoneNumberType::FIXED_LINE) || ($numberType == PhoneNumberType::MOBILE) || ($numberType == PhoneNumberType::FIXED_LINE_OR_MOBILE);
            // Carrier codes may be needed in some countries. We handle this here.
            if ($regionCode == "CO" && $numberType == PhoneNumberType::FIXED_LINE) {
                $formattedNumber = $this->formatNationalNumberWithCarrierCode(
                    $numberNoExt,
                    self::COLOMBIA_MOBILE_TO_FIXED_LINE_PREFIX
                );
            } elseif ($regionCode == "BR" && $isFixedLineOrMobile) {
                // Brazilian fixed line and mobile numbers need to be dialed with a carrier code when
                // called within Brazil. Without that, most of the carriers won't connect the call.
                // Because of that, we return an empty string here.
                $formattedNumber = $numberNoExt->hasPreferredDomesticCarrierCode(
                ) ? $this->formatNationalNumberWithCarrierCode($numberNoExt, "") : "";
            } elseif ($isValidNumber && $regionCode == "HU") {
                // The national format for HU numbers doesn't contain the national prefix, because that is
                // how numbers are normally written down. However, the national prefix is obligatory when
                // dialing from a mobile phone, except for short numbers. As a result, we add it back here
                // if it is a valid regular length phone number.
                $formattedNumber = $this->getNddPrefixForRegion(
                        $regionCode,
                        true /* strip non-digits */
                    ) . " " . $this->format($numberNoExt, PhoneNumberFormat::NATIONAL);
            } elseif ($countryCallingCode === self::NANPA_COUNTRY_CODE) {
                // For NANPA countries, we output international format for numbers that can be dialed
                // internationally, since that always works, except for numbers which might potentially be
                // short numbers, which are always dialled in national format.
                $regionMetadata = $this->getMetadataForRegion($regionCallingFrom);
                if ($this->canBeInternationallyDialled($numberNoExt) &&
                    !$this->isShorterThanPossibleNormalNumber(
                        $regionMetadata,
                        $this->getNationalSignificantNumber($numberNoExt)
                    )
                ) {
                    $formattedNumber = $this->format($numberNoExt, PhoneNumberFormat::INTERNATIONAL);
                } else {
                    $formattedNumber = $this->format($numberNoExt, PhoneNumberFormat::NATIONAL);
                }
            } else {
                // For non-geographical countries, Mexican and Chilean fixed line and mobile numbers, we
                // output international format for numbers that can be dialed internationally as that always
                // works.
                if (($regionCode == self::REGION_CODE_FOR_NON_GEO_ENTITY ||
                        // MX fixed line and mobile numbers should always be formatted in international format,
                        // even when dialed within MX. For national format to work, a carrier code needs to be
                        // used, and the correct carrier code depends on if the caller and callee are from the
                        // same local area. It is trickier to get that to work correctly than using
                        // international format, which is tested to work fine on all carriers.
                        // CL fixed line numbers need the national prefix when dialing in the national format,
                        // but don't have it when used for display. The reverse is true for mobile numbers.
                        // As a result, we output them in the international format to make it work.
                        (($regionCode == "MX" || $regionCode == "CL") && $isFixedLineOrMobile)) && $this->canBeInternationallyDialled(
                        $numberNoExt
                    )
                ) {
                    $formattedNumber = $this->format($numberNoExt, PhoneNumberFormat::INTERNATIONAL);
                } else {
                    $formattedNumber = $this->format($numberNoExt, PhoneNumberFormat::NATIONAL);
                }
            }
        } elseif ($isValidNumber && $this->canBeInternationallyDialled($numberNoExt)) {
            // We assume that short numbers are not diallable from outside their region, so if a number
            // is not a valid regular length phone number, we treat it as if it cannot be internationally
            // dialled.
            return $withFormatting ?
                $this->format($numberNoExt, PhoneNumberFormat::INTERNATIONAL) :
                $this->format($numberNoExt, PhoneNumberFormat::E164);
        }
        return $withFormatting ? $formattedNumber : $this->normalizeDiallableCharsOnly($formattedNumber);
    }

    /**
     * Formats a phone number in national format for dialing using the carrier as specified in the
     * {@code carrierCode}. The {@code carrierCode} will always be used regardless of whether the
     * phone number already has a preferred domestic carrier code stored. If {@code carrierCode}
     * contains an empty string, returns the number in national format without any carrier code.
     *
     * @param PhoneNumber $number the phone number to be formatted
     * @param string $carrierCode the carrier selection code to be used
     * @return string the formatted phone number in national format for dialing using the carrier as
     * specified in the {@code carrierCode}
     */
    public function formatNationalNumberWithCarrierCode(PhoneNumber $number, $carrierCode)
    {
        $countryCallingCode = $number->getCountryCode();
        $nationalSignificantNumber = $this->getNationalSignificantNumber($number);
        if (!$this->hasValidCountryCallingCode($countryCallingCode)) {
            return $nationalSignificantNumber;
        }

        // Note getRegionCodeForCountryCode() is used because formatting information for regions which
        // share a country calling code is contained by only one region for performance reasons. For
        // example, for NANPA regions it will be contained in the metadata for US.
        $regionCode = $this->getRegionCodeForCountryCode($countryCallingCode);
        // Metadata cannot be null because the country calling code is valid.
        $metadata = $this->getMetadataForRegionOrCallingCode($countryCallingCode, $regionCode);

        $formattedNumber = $this->formatNsn(
            $nationalSignificantNumber,
            $metadata,
            PhoneNumberFormat::NATIONAL,
            $carrierCode
        );
        $this->maybeAppendFormattedExtension($number, $metadata, PhoneNumberFormat::NATIONAL, $formattedNumber);
        $this->prefixNumberWithCountryCallingCode(
            $countryCallingCode,
            PhoneNumberFormat::NATIONAL,
            $formattedNumber
        );
        return $formattedNumber;
    }

    /**
     * Formats a phone number in national format for dialing using the carrier as specified in the
     * preferredDomesticCarrierCode field of the PhoneNumber object passed in. If that is missing,
     * use the {@code fallbackCarrierCode} passed in instead. If there is no
     * {@code preferredDomesticCarrierCode}, and the {@code fallbackCarrierCode} contains an empty
     * string, return the number in national format without any carrier code.
     *
     * <p>Use {@link #formatNationalNumberWithCarrierCode} instead if the carrier code passed in
     * should take precedence over the number's {@code preferredDomesticCarrierCode} when formatting.
     *
     * @param PhoneNumber $number the phone number to be formatted
     * @param string $fallbackCarrierCode the carrier selection code to be used, if none is found in the
     *     phone number itself
     * @return string the formatted phone number in national format for dialing using the number's
     *     {@code preferredDomesticCarrierCode}, or the {@code fallbackCarrierCode} passed in if
     *     none is found
     */
    public function formatNationalNumberWithPreferredCarrierCode(PhoneNumber $number, $fallbackCarrierCode)
    {
        return $this->formatNationalNumberWithCarrierCode(
            $number,
            $number->hasPreferredDomesticCarrierCode()
                ? $number->getPreferredDomesticCarrierCode()
                : $fallbackCarrierCode
        );
    }

    /**
     * Returns true if the number can be dialled from outside the region, or unknown. If the number
     * can only be dialled from within the region, returns false. Does not check the number is a valid
     * number.
     * TODO: Make this method public when we have enough metadata to make it worthwhile.
     *
     * @param PhoneNumber $number the phone-number for which we want to know whether it is diallable from outside the region
     * @return bool
     */
    public function canBeInternationallyDialled(PhoneNumber $number)
    {
        $metadata = $this->getMetadataForRegion($this->getRegionCodeForNumber($number));
        if ($metadata === null) {
            // Note numbers belonging to non-geographical entities (e.g. +800 numbers) are always
            // internationally diallable, and will be caught here.
            return true;
        }
        $nationalSignificantNumber = $this->getNationalSignificantNumber($number);
        return !$this->isNumberMatchingDesc($nationalSignificantNumber, $metadata->getNoInternationalDialling());
    }

    /**
     * Normalizes a string of characters representing a phone number. This strips all characters which
     * are not diallable on a mobile phone keypad (including all non-ASCII digits).
     *
     * @param string $number a string of characters representing a phone number
     * @return string the normalized string version of the phone number
     */
    public static function normalizeDiallableCharsOnly($number)
    {
        return self::normalizeHelper($number, self::$DIALLABLE_CHAR_MAPPINGS, true /* remove non matches */);
    }

    /**
     * Formats a phone number for out-of-country dialing purposes.
     *
     * Note that in this version, if the number was entered originally using alpha characters and
     * this version of the number is stored in raw_input, this representation of the number will be
     * used rather than the digit representation. Grouping information, as specified by characters
     * such as "-" and " ", will be retained.
     *
     * <p><b>Caveats:</b></p>
     * <ul>
     *  <li> This will not produce good results if the country calling code is both present in the raw
     *       input _and_ is the start of the national number. This is not a problem in the regions
     *       which typically use alpha numbers.
     *  <li> This will also not produce good results if the raw input has any grouping information
     *       within the first three digits of the national number, and if the function needs to strip
     *       preceding digits/words in the raw input before these digits. Normally people group the
     *       first three digits together so this is not a huge problem - and will be fixed if it
     *       proves to be so.
     * </ul>
     *
     * @param PhoneNumber $number the phone number that needs to be formatted
     * @param String $regionCallingFrom the region where the call is being placed
     * @return String the formatted phone number
     */
    public function formatOutOfCountryKeepingAlphaChars(PhoneNumber $number, $regionCallingFrom)
    {
        $rawInput = $number->getRawInput();
        // If there is no raw input, then we can't keep alpha characters because there aren't any.
        // In this case, we return formatOutOfCountryCallingNumber.
        if (mb_strlen($rawInput) == 0) {
            return $this->formatOutOfCountryCallingNumber($number, $regionCallingFrom);
        }
        $countryCode = $number->getCountryCode();
        if (!$this->hasValidCountryCallingCode($countryCode)) {
            return $rawInput;
        }
        // Strip any prefix such as country calling code, IDD, that was present. We do this by comparing
        // the number in raw_input with the parsed number.
        // To do this, first we normalize punctuation. We retain number grouping symbols such as " "
        // only.
        $rawInput = $this->normalizeHelper($rawInput, self::$ALL_PLUS_NUMBER_GROUPING_SYMBOLS, true);
        // Now we trim everything before the first three digits in the parsed number. We choose three
        // because all valid alpha numbers have 3 digits at the start - if it does not, then we don't
        // trim anything at all. Similarly, if the national number was less than three digits, we don't
        // trim anything at all.
        $nationalNumber = $this->getNationalSignificantNumber($number);
        if (mb_strlen($nationalNumber) > 3) {
            $firstNationalNumberDigit = strpos($rawInput, substr($nationalNumber, 0, 3));
            if ($firstNationalNumberDigit !== false) {
                $rawInput = substr($rawInput, $firstNationalNumberDigit);
            }
        }
        $metadataForRegionCallingFrom = $this->getMetadataForRegion($regionCallingFrom);
        if ($countryCode == self::NANPA_COUNTRY_CODE) {
            if ($this->isNANPACountry($regionCallingFrom)) {
                return $countryCode . " " . $rawInput;
            }
        } else if ($metadataForRegionCallingFrom !== null &&
            $countryCode == $this->getCountryCodeForValidRegion($regionCallingFrom)
        ) {
            $formattingPattern =
                $this->chooseFormattingPatternForNumber(
                    $metadataForRegionCallingFrom->numberFormats(),
                    $nationalNumber
                );
            if ($formattingPattern === null) {
                // If no pattern above is matched, we format the original input.
                return $rawInput;
            }
            $newFormat = new NumberFormat();
            $newFormat->mergeFrom($formattingPattern);
            // The first group is the first group of digits that the user wrote together.
            $newFormat->setPattern("(\\d+)(.*)");
            // Here we just concatenate them back together after the national prefix has been fixed.
            $newFormat->setFormat("$1$2");
            // Now we format using this pattern instead of the default pattern, but with the national
            // prefix prefixed if necessary.
            // This will not work in the cases where the pattern (and not the leading digits) decide
            // whether a national prefix needs to be used, since we have overridden the pattern to match
            // anything, but that is not the case in the metadata to date.
            return $this->formatNsnUsingPattern($rawInput, $newFormat, PhoneNumberFormat::NATIONAL);
        }
        $internationalPrefixForFormatting = "";
        // If an unsupported region-calling-from is entered, or a country with multiple international
        // prefixes, the international format of the number is returned, unless there is a preferred
        // international prefix.
        if ($metadataForRegionCallingFrom !== null) {
            $internationalPrefix = $metadataForRegionCallingFrom->getInternationalPrefix();
            $uniqueInternationalPrefixMatcher = new Matcher(self::UNIQUE_INTERNATIONAL_PREFIX, $internationalPrefix);
            $internationalPrefixForFormatting =
                $uniqueInternationalPrefixMatcher->matches()
                    ? $internationalPrefix
                    : $metadataForRegionCallingFrom->getPreferredInternationalPrefix();
        }
        $formattedNumber = $rawInput;
        $regionCode = $this->getRegionCodeForCountryCode($countryCode);
        // Metadata cannot be null because the country calling code is valid.
        $metadataForRegion = $this->getMetadataForRegionOrCallingCode($countryCode, $regionCode);
        $this->maybeAppendFormattedExtension(
            $number,
            $metadataForRegion,
            PhoneNumberFormat::INTERNATIONAL,
            $formattedNumber
        );
        if (mb_strlen($internationalPrefixForFormatting) > 0) {
            $formattedNumber = $internationalPrefixForFormatting . " " . $countryCode . " " . $formattedNumber;
        } else {
            // Invalid region entered as country-calling-from (so no metadata was found for it) or the
            // region chosen has multiple international dialling prefixes.
            $this->prefixNumberWithCountryCallingCode(
                $countryCode,
                PhoneNumberFormat::INTERNATIONAL,
                $formattedNumber
            );
        }
        return $formattedNumber;
    }

    /**
     * Formats a phone number for out-of-country dialing purposes. If no regionCallingFrom is
     * supplied, we format the number in its INTERNATIONAL format. If the country calling code is the
     * same as that of the region where the number is from, then NATIONAL formatting will be applied.
     *
     * <p>If the number itself has a country calling code of zero or an otherwise invalid country
     * calling code, then we return the number with no formatting applied.
     *
     * <p>Note this function takes care of the case for calling inside of NANPA and between Russia and
     * Kazakhstan (who share the same country calling code). In those cases, no international prefix
     * is used. For regions which have multiple international prefixes, the number in its
     * INTERNATIONAL format will be returned instead.
     *
     * @param PhoneNumber $number the phone number to be formatted
     * @param string $regionCallingFrom the region where the call is being placed
     * @return string  the formatted phone number
     */
    public function formatOutOfCountryCallingNumber(PhoneNumber $number, $regionCallingFrom)
    {
        if (!$this->isValidRegionCode($regionCallingFrom)) {
            return $this->format($number, PhoneNumberFormat::INTERNATIONAL);
        }
        $countryCallingCode = $number->getCountryCode();
        $nationalSignificantNumber = $this->getNationalSignificantNumber($number);
        if (!$this->hasValidCountryCallingCode($countryCallingCode)) {
            return $nationalSignificantNumber;
        }
        if ($countryCallingCode == self::NANPA_COUNTRY_CODE) {
            if ($this->isNANPACountry($regionCallingFrom)) {
                // For NANPA regions, return the national format for these regions but prefix it with the
                // country calling code.
                return $countryCallingCode . " " . $this->format($number, PhoneNumberFormat::NATIONAL);
            }
        } else if ($countryCallingCode == $this->getCountryCodeForValidRegion($regionCallingFrom)) {
            // If regions share a country calling code, the country calling code need not be dialled.
            // This also applies when dialling within a region, so this if clause covers both these cases.
            // Technically this is the case for dialling from La Reunion to other overseas departments of
            // France (French Guiana, Martinique, Guadeloupe), but not vice versa - so we don't cover this
            // edge case for now and for those cases return the version including country calling code.
            // Details here: http://www.petitfute.com/voyage/225-info-pratiques-reunion
            return $this->format($number, PhoneNumberFormat::NATIONAL);
        }
        // Metadata cannot be null because we checked 'isValidRegionCode()' above.
        $metadataForRegionCallingFrom = $this->getMetadataForRegion($regionCallingFrom);

        $internationalPrefix = $metadataForRegionCallingFrom->getInternationalPrefix();

        // For regions that have multiple international prefixes, the international format of the
        // number is returned, unless there is a preferred international prefix.
        $internationalPrefixForFormatting = "";
        $uniqueInternationalPrefixMatcher = new Matcher(self::UNIQUE_INTERNATIONAL_PREFIX, $internationalPrefix);

        if ($uniqueInternationalPrefixMatcher->matches()) {
            $internationalPrefixForFormatting = $internationalPrefix;
        } else if ($metadataForRegionCallingFrom->hasPreferredInternationalPrefix()) {
            $internationalPrefixForFormatting = $metadataForRegionCallingFrom->getPreferredInternationalPrefix();
        }

        $regionCode = $this->getRegionCodeForCountryCode($countryCallingCode);
        // Metadata cannot be null because the country calling code is valid.
        $metadataForRegion = $this->getMetadataForRegionOrCallingCode($countryCallingCode, $regionCode);
        $formattedNationalNumber = $this->formatNsn(
            $nationalSignificantNumber,
            $metadataForRegion,
            PhoneNumberFormat::INTERNATIONAL
        );
        $formattedNumber = $formattedNationalNumber;
        $this->maybeAppendFormattedExtension(
            $number,
            $metadataForRegion,
            PhoneNumberFormat::INTERNATIONAL,
            $formattedNumber
        );
        if (mb_strlen($internationalPrefixForFormatting) > 0) {
            $formattedNumber = $internationalPrefixForFormatting . " " . $countryCallingCode . " " . $formattedNumber;
        } else {
            $this->prefixNumberWithCountryCallingCode(
                $countryCallingCode,
                PhoneNumberFormat::INTERNATIONAL,
                $formattedNumber
            );
        }
        return $formattedNumber;
    }

    /**
     * Checks if this is a region under the North American Numbering Plan Administration (NANPA).
     * @param string $regionCode
     * @return boolean true if regionCode is one of the regions under NANPA
     */
    public function isNANPACountry($regionCode)
    {
        return in_array($regionCode, $this->nanpaRegions);
    }

    /**
     * Formats a phone number using the original phone number format that the number is parsed from.
     * The original format is embedded in the country_code_source field of the PhoneNumber object
     * passed in. If such information is missing, the number will be formatted into the NATIONAL
     * format by default. When the number contains a leading zero and this is unexpected for this
     * country, or we don't have a formatting pattern for the number, the method returns the raw input
     * when it is available.
     *
     * Note this method guarantees no digit will be inserted, removed or modified as a result of
     * formatting.
     *
     * @param PhoneNumber $number the phone number that needs to be formatted in its original number format
     * @param string $regionCallingFrom the region whose IDD needs to be prefixed if the original number
     *     has one
     * @return string the formatted phone number in its original number format
     */
    public function formatInOriginalFormat(PhoneNumber $number, $regionCallingFrom)
    {
        if ($number->hasRawInput() &&
            ($this->hasUnexpectedItalianLeadingZero($number) || !$this->hasFormattingPatternForNumber($number))
        ) {
            // We check if we have the formatting pattern because without that, we might format the number
            // as a group without national prefix.
            return $number->getRawInput();
        }
        if (!$number->hasCountryCodeSource()) {
            return $this->format($number, PhoneNumberFormat::NATIONAL);
        }
        switch ($number->getCountryCodeSource()) {
            case CountryCodeSource::FROM_NUMBER_WITH_PLUS_SIGN:
                $formattedNumber = $this->format($number, PhoneNumberFormat::INTERNATIONAL);
                break;
            case CountryCodeSource::FROM_NUMBER_WITH_IDD:
                $formattedNumber = $this->formatOutOfCountryCallingNumber($number, $regionCallingFrom);
                break;
            case CountryCodeSource::FROM_NUMBER_WITHOUT_PLUS_SIGN:
                $formattedNumber = substr($this->format($number, PhoneNumberFormat::INTERNATIONAL), 1);
                break;
            case CountryCodeSource::FROM_DEFAULT_COUNTRY:
                // Fall-through to default case.
            default:

                $regionCode = $this->getRegionCodeForCountryCode($number->getCountryCode());
                // We strip non-digits from the NDD here, and from the raw input later, so that we can
                // compare them easily.
                $nationalPrefix = $this->getNddPrefixForRegion($regionCode, true /* strip non-digits */);
                $nationalFormat = $this->format($number, PhoneNumberFormat::NATIONAL);
                if ($nationalPrefix === null || mb_strlen($nationalPrefix) == 0) {
                    // If the region doesn't have a national prefix at all, we can safely return the national
                    // format without worrying about a national prefix being added.
                    $formattedNumber = $nationalFormat;
                    break;
                }
                // Otherwise, we check if the original number was entered with a national prefix.
                if ($this->rawInputContainsNationalPrefix(
                    $number->getRawInput(),
                    $nationalPrefix,
                    $regionCode
                )
                ) {
                    // If so, we can safely return the national format.
                    $formattedNumber = $nationalFormat;
                    break;
                }
                // Metadata cannot be null here because getNddPrefixForRegion() (above) returns null if
                // there is no metadata for the region.
                $metadata = $this->getMetadataForRegion($regionCode);
                $nationalNumber = $this->getNationalSignificantNumber($number);
                $formatRule = $this->chooseFormattingPatternForNumber($metadata->numberFormats(), $nationalNumber);
                // The format rule could still be null here if the national number was 0 and there was no
                // raw input (this should not be possible for numbers generated by the phonenumber library
                // as they would also not have a country calling code and we would have exited earlier).
                if ($formatRule === null) {
                    $formattedNumber = $nationalFormat;
                    break;
                }
                // When the format we apply to this number doesn't contain national prefix, we can just
                // return the national format.
                // TODO: Refactor the code below with the code in isNationalPrefixPresentIfRequired.
                $candidateNationalPrefixRule = $formatRule->getNationalPrefixFormattingRule();
                // We assume that the first-group symbol will never be _before_ the national prefix.
                $indexOfFirstGroup = strpos($candidateNationalPrefixRule, '$1');
                if ($indexOfFirstGroup <= 0) {
                    $formattedNumber = $nationalFormat;
                    break;
                }
                $candidateNationalPrefixRule = substr($candidateNationalPrefixRule, 0, $indexOfFirstGroup);
                $candidateNationalPrefixRule = $this->normalizeDigitsOnly($candidateNationalPrefixRule);
                if (mb_strlen($candidateNationalPrefixRule) == 0) {
                    // National prefix not used when formatting this number.
                    $formattedNumber = $nationalFormat;
                    break;
                }
                // Otherwise, we need to remove the national prefix from our output.
                $numFormatCopy = new NumberFormat();
                $numFormatCopy->mergeFrom($formatRule);
                $numFormatCopy->clearNationalPrefixFormattingRule();
                $numberFormats = array();
                $numberFormats[] = $numFormatCopy;
                $formattedNumber = $this->formatByPattern($number, PhoneNumberFormat::NATIONAL, $numberFormats);
                break;
        }
        $rawInput = $number->getRawInput();
        // If no digit is inserted/removed/modified as a result of our formatting, we return the
        // formatted phone number; otherwise we return the raw input the user entered.
        if ($formattedNumber !== null && mb_strlen($rawInput) > 0) {
            $normalizedFormattedNumber = $this->normalizeDiallableCharsOnly($formattedNumber);
            $normalizedRawInput = $this->normalizeDiallableCharsOnly($rawInput);
            if ($normalizedFormattedNumber != $normalizedRawInput) {
                $formattedNumber = $rawInput;
            }
        }
        return $formattedNumber;
    }

    /**
     * Returns true if a number is from a region whose national significant number couldn't contain a
     * leading zero, but has the italian_leading_zero field set to true.
     * @param PhoneNumber $number
     * @return bool
     */
    private function hasUnexpectedItalianLeadingZero(PhoneNumber $number)
    {
        return $number->isItalianLeadingZero() && !$this->isLeadingZeroPossible($number->getCountryCode());
    }

    /**
     * Checks whether the country calling code is from a region whose national significant number
     * could contain a leading zero. An example of such a region is Italy. Returns false if no
     * metadata for the country is found.
     * @param int $countryCallingCode
     * @return bool
     */
    public function isLeadingZeroPossible($countryCallingCode)
    {
        $mainMetadataForCallingCode = $this->getMetadataForRegionOrCallingCode(
            $countryCallingCode,
            $this->getRegionCodeForCountryCode($countryCallingCode)
        );
        if ($mainMetadataForCallingCode === null) {
            return false;
        }
        return (bool)$mainMetadataForCallingCode->isLeadingZeroPossible();
    }

    /**
     * @param PhoneNumber $number
     * @return bool
     */
    private function hasFormattingPatternForNumber(PhoneNumber $number)
    {
        $countryCallingCode = $number->getCountryCode();
        $phoneNumberRegion = $this->getRegionCodeForCountryCode($countryCallingCode);
        $metadata = $this->getMetadataForRegionOrCallingCode($countryCallingCode, $phoneNumberRegion);
        if ($metadata === null) {
            return false;
        }
        $nationalNumber = $this->getNationalSignificantNumber($number);
        $formatRule = $this->chooseFormattingPatternForNumber($metadata->numberFormats(), $nationalNumber);
        return $formatRule !== null;
    }

    /**
     * Returns the national dialling prefix for a specific region. For example, this would be 1 for
     * the United States, and 0 for New Zealand. Set stripNonDigits to true to strip symbols like "~"
     * (which indicates a wait for a dialling tone) from the prefix returned. If no national prefix is
     * present, we return null.
     *
     * <p>Warning: Do not use this method for do-your-own formatting - for some regions, the
     * national dialling prefix is used only for certain types of numbers. Use the library's
     * formatting functions to prefix the national prefix when required.
     *
     * @param string $regionCode the region that we want to get the dialling prefix for
     * @param boolean $stripNonDigits true to strip non-digits from the national dialling prefix
     * @return string the dialling prefix for the region denoted by regionCode
     */
    public function getNddPrefixForRegion($regionCode, $stripNonDigits)
    {
        $metadata = $this->getMetadataForRegion($regionCode);
        if ($metadata === null) {
            return null;
        }
        $nationalPrefix = $metadata->getNationalPrefix();
        // If no national prefix was found, we return null.
        if (mb_strlen($nationalPrefix) == 0) {
            return null;
        }
        if ($stripNonDigits) {
            // Note: if any other non-numeric symbols are ever used in national prefixes, these would have
            // to be removed here as well.
            $nationalPrefix = str_replace("~", "", $nationalPrefix);
        }
        return $nationalPrefix;
    }

    /**
     * Check if rawInput, which is assumed to be in the national format, has a national prefix. The
     * national prefix is assumed to be in digits-only form.
     * @param string $rawInput
     * @param string $nationalPrefix
     * @param string $regionCode
     * @return bool
     */
    private function rawInputContainsNationalPrefix($rawInput, $nationalPrefix, $regionCode)
    {
        $normalizedNationalNumber = $this->normalizeDigitsOnly($rawInput);
        if (strpos($normalizedNationalNumber, $nationalPrefix) === 0) {
            try {
                // Some Japanese numbers (e.g. 00777123) might be mistaken to contain the national prefix
                // when written without it (e.g. 0777123) if we just do prefix matching. To tackle that, we
                // check the validity of the number if the assumed national prefix is removed (777123 won't
                // be valid in Japan).
                return $this->isValidNumber(
                    $this->parse(substr($normalizedNationalNumber, mb_strlen($nationalPrefix)), $regionCode)
                );
            } catch (NumberParseException $e) {
                return false;
            }
        }
        return false;
    }

    /**
     * Tests whether a phone number matches a valid pattern. Note this doesn't verify the number
     * is actually in use, which is impossible to tell by just looking at a number itself.
     *
     * @param PhoneNumber $number the phone number that we want to validate
     * @return boolean that indicates whether the number is of a valid pattern
     */
    public function isValidNumber(PhoneNumber $number)
    {
        $regionCode = $this->getRegionCodeForNumber($number);
        return $this->isValidNumberForRegion($number, $regionCode);
    }

    /**
     * Tests whether a phone number is valid for a certain region. Note this doesn't verify the number
     * is actually in use, which is impossible to tell by just looking at a number itself. If the
     * country calling code is not the same as the country calling code for the region, this
     * immediately exits with false. After this, the specific number pattern rules for the region are
     * examined. This is useful for determining for example whether a particular number is valid for
     * Canada, rather than just a valid NANPA number.
     * Warning: In most cases, you want to use {@link #isValidNumber} instead. For example, this
     * method will mark numbers from British Crown dependencies such as the Isle of Man as invalid for
     * the region "GB" (United Kingdom), since it has its own region code, "IM", which may be
     * undesirable.
     *
     * @param PhoneNumber $number the phone number that we want to validate
     * @param string $regionCode the region that we want to validate the phone number for
     * @return boolean that indicates whether the number is of a valid pattern
     */
    public function isValidNumberForRegion(PhoneNumber $number, $regionCode)
    {
        $countryCode = $number->getCountryCode();
        $metadata = $this->getMetadataForRegionOrCallingCode($countryCode, $regionCode);
        if (($metadata === null) ||
            (self::REGION_CODE_FOR_NON_GEO_ENTITY !== $regionCode &&
                $countryCode !== $this->getCountryCodeForValidRegion($regionCode))
        ) {
            // Either the region code was invalid, or the country calling code for this number does not
            // match that of the region code.
            return false;
        }
        $nationalSignificantNumber = $this->getNationalSignificantNumber($number);

        return $this->getNumberTypeHelper($nationalSignificantNumber, $metadata) != PhoneNumberType::UNKNOWN;
    }

    /**
     * Parses a string and returns it in proto buffer format. This method will throw a
     * {@link NumberParseException} if the number is not considered to be
     * a possible number. Note that validation of whether the number is actually a valid number for a
     * particular region is not performed. This can be done separately with {@link #isValidNumber}.
     *
     * @param string $numberToParse number that we are attempting to parse. This can contain formatting
     *                          such as +, ( and -, as well as a phone number extension.
     * @param string $defaultRegion region that we are expecting the number to be from. This is only used
     *                          if the number being parsed is not written in international format.
     *                          The country_code for the number in this case would be stored as that
     *                          of the default region supplied. If the number is guaranteed to
     *                          start with a '+' followed by the country calling code, then
     *                          "ZZ" or null can be supplied.
     * @param PhoneNumber|null $phoneNumber
     * @param bool $keepRawInput
     * @return PhoneNumber a phone number proto buffer filled with the parsed number
     * @throws NumberParseException  if the string is not considered to be a viable phone number or if
     *                               no default region was supplied and the number is not in
     *                               international format (does not start with +)
     */
    public function parse($numberToParse, $defaultRegion, PhoneNumber $phoneNumber = null, $keepRawInput = false)
    {
        if ($phoneNumber === null) {
            $phoneNumber = new PhoneNumber();
        }
        $this->parseHelper($numberToParse, $defaultRegion, $keepRawInput, true, $phoneNumber);
        return $phoneNumber;
    }

    /**
     * Formats a phone number in the specified format using client-defined formatting rules. Note that
     * if the phone number has a country calling code of zero or an otherwise invalid country calling
     * code, we cannot work out things like whether there should be a national prefix applied, or how
     * to format extensions, so we return the national significant number with no formatting applied.
     *
     * @param PhoneNumber $number the phone number to be formatted
     * @param int $numberFormat the format the phone number should be formatted into
     * @param array $userDefinedFormats formatting rules specified by clients
     * @return String the formatted phone number
     */
    public function formatByPattern(PhoneNumber $number, $numberFormat, array $userDefinedFormats)
    {
        $countryCallingCode = $number->getCountryCode();
        $nationalSignificantNumber = $this->getNationalSignificantNumber($number);
        if (!$this->hasValidCountryCallingCode($countryCallingCode)) {
            return $nationalSignificantNumber;
        }
        // Note getRegionCodeForCountryCode() is used because formatting information for regions which
        // share a country calling code is contained by only one region for performance reasons. For
        // example, for NANPA regions it will be contained in the metadata for US.
        $regionCode = $this->getRegionCodeForCountryCode($countryCallingCode);
        // Metadata cannot be null because the country calling code is valid
        $metadata = $this->getMetadataForRegionOrCallingCode($countryCallingCode, $regionCode);

        $formattedNumber = "";

        $formattingPattern = $this->chooseFormattingPatternForNumber($userDefinedFormats, $nationalSignificantNumber);
        if ($formattingPattern === null) {
            // If no pattern above is matched, we format the number as a whole.
            $formattedNumber .= $nationalSignificantNumber;
        } else {
            $numFormatCopy = new NumberFormat();
            // Before we do a replacement of the national prefix pattern $NP with the national prefix, we
            // need to copy the rule so that subsequent replacements for different numbers have the
            // appropriate national prefix.
            $numFormatCopy->mergeFrom($formattingPattern);
            $nationalPrefixFormattingRule = $formattingPattern->getNationalPrefixFormattingRule();
            if (mb_strlen($nationalPrefixFormattingRule) > 0) {
                $nationalPrefix = $metadata->getNationalPrefix();
                if (mb_strlen($nationalPrefix) > 0) {
                    // Replace $NP with national prefix and $FG with the first group ($1).
                    $npPatternMatcher = new Matcher(self::NP_PATTERN, $nationalPrefixFormattingRule);
                    $nationalPrefixFormattingRule = $npPatternMatcher->replaceFirst($nationalPrefix);
                    $fgPatternMatcher = new Matcher(self::FG_PATTERN, $nationalPrefixFormattingRule);
                    $nationalPrefixFormattingRule = $fgPatternMatcher->replaceFirst("\\$1");
                    $numFormatCopy->setNationalPrefixFormattingRule($nationalPrefixFormattingRule);
                } else {
                    // We don't want to have a rule for how to format the national prefix if there isn't one.
                    $numFormatCopy->clearNationalPrefixFormattingRule();
                }
            }
            $formattedNumber .= $this->formatNsnUsingPattern($nationalSignificantNumber, $numFormatCopy, $numberFormat);
        }
        $this->maybeAppendFormattedExtension($number, $metadata, $numberFormat, $formattedNumber);
        $this->prefixNumberWithCountryCallingCode($countryCallingCode, $numberFormat, $formattedNumber);
        return $formattedNumber;
    }

    /**
     * Gets a valid number for the specified region.
     *
     * @param string regionCode  the region for which an example number is needed
     * @return PhoneNumber a valid fixed-line number for the specified region. Returns null when the metadata
     *    does not contain such information, or the region 001 is passed in. For 001 (representing
     *    non-geographical numbers), call {@link #getExampleNumberForNonGeoEntity} instead.
     */
    public function getExampleNumber($regionCode)
    {
        return $this->getExampleNumberForType($regionCode, PhoneNumberType::FIXED_LINE);
    }

    /**
     * Gets a valid number for the specified region and number type.
     *
     * @param string $regionCode the region for which an example number is needed
     * @param int $type the PhoneNumberType of number that is needed
     * @return PhoneNumber a valid number for the specified region and type. Returns null when the metadata
     *     does not contain such information or if an invalid region or region 001 was entered.
     *     For 001 (representing non-geographical numbers), call
     *     {@link #getExampleNumberForNonGeoEntity} instead.
     */
    public function getExampleNumberForType($regionCode, $type)
    {
        // Check the region code is valid.
        if (!$this->isValidRegionCode($regionCode)) {
            return null;
        }
        $desc = $this->getNumberDescByType($this->getMetadataForRegion($regionCode), $type);
        try {
            if ($desc->hasExampleNumber()) {
                return $this->parse($desc->getExampleNumber(), $regionCode);
            }
        } catch (NumberParseException $e) {
        }
        return null;
    }

    /**
     * @param PhoneMetadata $metadata
     * @param int $type PhoneNumberType
     * @return PhoneNumberDesc
     */
    private function getNumberDescByType(PhoneMetadata $metadata, $type)
    {
        switch ($type) {
            case PhoneNumberType::PREMIUM_RATE:
                return $metadata->getPremiumRate();
            case PhoneNumberType::TOLL_FREE:
                return $metadata->getTollFree();
            case PhoneNumberType::MOBILE:
                return $metadata->getMobile();
            case PhoneNumberType::FIXED_LINE:
            case PhoneNumberType::FIXED_LINE_OR_MOBILE:
                return $metadata->getFixedLine();
            case PhoneNumberType::SHARED_COST:
                return $metadata->getSharedCost();
            case PhoneNumberType::VOIP:
                return $metadata->getVoip();
            case PhoneNumberType::PERSONAL_NUMBER:
                return $metadata->getPersonalNumber();
            case PhoneNumberType::PAGER:
                return $metadata->getPager();
            case PhoneNumberType::UAN:
                return $metadata->getUan();
            case PhoneNumberType::VOICEMAIL:
                return $metadata->getVoicemail();
            default:
                return $metadata->getGeneralDesc();
        }
    }

    /**
     * Gets a valid number for the specified country calling code for a non-geographical entity.
     *
     * @param int $countryCallingCode the country calling code for a non-geographical entity
     * @return PhoneNumber a valid number for the non-geographical entity. Returns null when the metadata
     *    does not contain such information, or the country calling code passed in does not belong
     *    to a non-geographical entity.
     */
    public function getExampleNumberForNonGeoEntity($countryCallingCode)
    {
        $metadata = $this->getMetadataForNonGeographicalRegion($countryCallingCode);
        if ($metadata !== null) {
            $desc = $metadata->getGeneralDesc();
            try {
                if ($desc->hasExampleNumber()) {
                    return $this->parse("+" . $countryCallingCode . $desc->getExampleNumber(), "ZZ");
                }
            } catch (NumberParseException $e) {
            }
        }
        return null;
    }


    /**
     * Takes two phone numbers and compares them for equality.
     *
     * <p>Returns EXACT_MATCH if the country_code, NSN, presence of a leading zero
     * for Italian numbers and any extension present are the same. Returns NSN_MATCH
     * if either or both has no region specified, and the NSNs and extensions are
     * the same. Returns SHORT_NSN_MATCH if either or both has no region specified,
     * or the region specified is the same, and one NSN could be a shorter version
     * of the other number. This includes the case where one has an extension
     * specified, and the other does not. Returns NO_MATCH otherwise. For example,
     * the numbers +1 345 657 1234 and 657 1234 are a SHORT_NSN_MATCH. The numbers
     * +1 345 657 1234 and 345 657 are a NO_MATCH.
     *
     * @param $firstNumberIn PhoneNumber|string First number to compare. If it is a
     * string it can contain formatting, and can have country calling code specified
     * with + at the start.
     * @param $secondNumberIn PhoneNumber|string Second number to compare. If it is a
     * string it can contain formatting, and can have country calling code specified
     * with + at the start.
     * @throws \InvalidArgumentException
     * @return int {MatchType} NOT_A_NUMBER, NO_MATCH,
     */
    public function isNumberMatch($firstNumberIn, $secondNumberIn)
    {
        if (is_string($firstNumberIn) && is_string($secondNumberIn)) {
            try {
                $firstNumberAsProto = $this->parse($firstNumberIn, self::UNKNOWN_REGION);
                return $this->isNumberMatch($firstNumberAsProto, $secondNumberIn);
            } catch (NumberParseException $e) {
                if ($e->getErrorType() === NumberParseException::INVALID_COUNTRY_CODE) {
                    try {
                        $secondNumberAsProto = $this->parse($secondNumberIn, self::UNKNOWN_REGION);
                        return $this->isNumberMatch($secondNumberAsProto, $firstNumberIn);
                    } catch (NumberParseException $e2) {
                        if ($e2->getErrorType() === NumberParseException::INVALID_COUNTRY_CODE) {
                            try {
                                $firstNumberProto = new PhoneNumber();
                                $secondNumberProto = new PhoneNumber();
                                $this->parseHelper($firstNumberIn, null, false, false, $firstNumberProto);
                                $this->parseHelper($secondNumberIn, null, false, false, $secondNumberProto);
                                return $this->isNumberMatch($firstNumberProto, $secondNumberProto);
                            } catch (NumberParseException $e3) {
                                // Fall through and return MatchType::NOT_A_NUMBER
                            }
                        }
                    }
                }
            }
            return MatchType::NOT_A_NUMBER;
        }
        if ($firstNumberIn instanceof PhoneNumber && is_string($secondNumberIn)) {
            // First see if the second number has an implicit country calling code, by attempting to parse
            // it.
            try {
                $secondNumberAsProto = $this->parse($secondNumberIn, self::UNKNOWN_REGION);
                return $this->isNumberMatch($firstNumberIn, $secondNumberAsProto);
            } catch (NumberParseException $e) {
                if ($e->getErrorType() === NumberParseException::INVALID_COUNTRY_CODE) {
                    // The second number has no country calling code. EXACT_MATCH is no longer possible.
                    // We parse it as if the region was the same as that for the first number, and if
                    // EXACT_MATCH is returned, we replace this with NSN_MATCH.
                    $firstNumberRegion = $this->getRegionCodeForCountryCode($firstNumberIn->getCountryCode());
                    try {
                        if ($firstNumberRegion != self::UNKNOWN_REGION) {
                            $secondNumberWithFirstNumberRegion = $this->parse($secondNumberIn, $firstNumberRegion);
                            $match = $this->isNumberMatch($firstNumberIn, $secondNumberWithFirstNumberRegion);
                            if ($match === MatchType::EXACT_MATCH) {
                                return MatchType::NSN_MATCH;
                            }
                            return $match;
                        } else {
                            // If the first number didn't have a valid country calling code, then we parse the
                            // second number without one as well.
                            $secondNumberProto = new PhoneNumber();
                            $this->parseHelper($secondNumberIn, null, false, false, $secondNumberProto);
                            return $this->isNumberMatch($firstNumberIn, $secondNumberProto);
                        }
                    } catch (NumberParseException $e2) {
                        // Fall-through to return NOT_A_NUMBER.
                    }
                }
            }
        }
        if ($firstNumberIn instanceof PhoneNumber && $secondNumberIn instanceof PhoneNumber) {
            // Make copies of the phone number so that the numbers passed in are not edited.
            $firstNumber = new PhoneNumber();
            $firstNumber->mergeFrom($firstNumberIn);
            $secondNumber = new PhoneNumber();
            $secondNumber->mergeFrom($secondNumberIn);

            // First clear raw_input, country_code_source and preferred_domestic_carrier_code fields and any
            // empty-string extensions so that we can use the proto-buffer equality method.
            $firstNumber->clearRawInput();
            $firstNumber->clearCountryCodeSource();
            $firstNumber->clearPreferredDomesticCarrierCode();
            $secondNumber->clearRawInput();
            $secondNumber->clearCountryCodeSource();
            $secondNumber->clearPreferredDomesticCarrierCode();
            if ($firstNumber->hasExtension() && mb_strlen($firstNumber->getExtension()) === 0) {
                $firstNumber->clearExtension();
            }

            if ($secondNumber->hasExtension() && mb_strlen($secondNumber->getExtension()) === 0) {
                $secondNumber->clearExtension();
            }

            // Early exit if both had extensions and these are different.
            if ($firstNumber->hasExtension() && $secondNumber->hasExtension() &&
                $firstNumber->getExtension() != $secondNumber->getExtension()
            ) {
                return MatchType::NO_MATCH;
            }

            $firstNumberCountryCode = $firstNumber->getCountryCode();
            $secondNumberCountryCode = $secondNumber->getCountryCode();
            // Both had country_code specified.
            if ($firstNumberCountryCode != 0 && $secondNumberCountryCode != 0) {
                if ($firstNumber->equals($secondNumber)) {
                    return MatchType::EXACT_MATCH;
                } elseif ($firstNumberCountryCode == $secondNumberCountryCode &&
                    $this->isNationalNumberSuffixOfTheOther($firstNumber, $secondNumber)
                ) {
                    // A SHORT_NSN_MATCH occurs if there is a difference because of the presence or absence of
                    // an 'Italian leading zero', the presence or absence of an extension, or one NSN being a
                    // shorter variant of the other.
                    return MatchType::SHORT_NSN_MATCH;
                }
                // This is not a match.
                return MatchType::NO_MATCH;
            }
            // Checks cases where one or both country_code fields were not specified. To make equality
            // checks easier, we first set the country_code fields to be equal.
            $firstNumber->setCountryCode($secondNumberCountryCode);
            // If all else was the same, then this is an NSN_MATCH.
            if ($firstNumber->equals($secondNumber)) {
                return MatchType::NSN_MATCH;
            }
            if ($this->isNationalNumberSuffixOfTheOther($firstNumber, $secondNumber)) {
                return MatchType::SHORT_NSN_MATCH;
            }
            return MatchType::NO_MATCH;
        }
        return MatchType::NOT_A_NUMBER;
    }

    /**
     * Returns true when one national number is the suffix of the other or both are the same.
     * @param PhoneNumber $firstNumber
     * @param PhoneNumber $secondNumber
     * @return bool
     */
    private function isNationalNumberSuffixOfTheOther(PhoneNumber $firstNumber, PhoneNumber $secondNumber)
    {
        $firstNumberNationalNumber = trim((string)$firstNumber->getNationalNumber());
        $secondNumberNationalNumber = trim((string)$secondNumber->getNationalNumber());
        return $this->stringEndsWithString($firstNumberNationalNumber, $secondNumberNationalNumber) ||
        $this->stringEndsWithString($secondNumberNationalNumber, $firstNumberNationalNumber);
    }

    private function stringEndsWithString($hayStack, $needle)
    {
        $revNeedle = strrev($needle);
        $revHayStack = strrev($hayStack);
        return strpos($revHayStack, $revNeedle) === 0;
    }

    /**
     * Returns true if the supplied region supports mobile number portability. Returns false for
     * invalid, unknown or regions that don't support mobile number portability.
     *
     * @param string $regionCode the region for which we want to know whether it supports mobile number
     *                    portability or not.
     * @return bool
     */
    public function isMobileNumberPortableRegion($regionCode)
    {
        $metadata = $this->getMetadataForRegion($regionCode);
        if ($metadata === null) {
            return false;
        }

        return $metadata->isMobileNumberPortableRegion();
    }

    /**
     * Check whether a phone number is a possible number given a number in the form of a string, and
     * the region where the number could be dialed from. It provides a more lenient check than
     * {@link #isValidNumber}. See {@link #isPossibleNumber(PhoneNumber)} for details.
     *
     * <p>This method first parses the number, then invokes {@link #isPossibleNumber(PhoneNumber)}
     * with the resultant PhoneNumber object.
     *
     * @param PhoneNumber|string $number the number that needs to be checked, in the form of a string
     * @param string $regionDialingFrom the region that we are expecting the number to be dialed from.
     *     Note this is different from the region where the number belongs.  For example, the number
     *     +1 650 253 0000 is a number that belongs to US. When written in this form, it can be
     *     dialed from any region. When it is written as 00 1 650 253 0000, it can be dialed from any
     *     region which uses an international dialling prefix of 00. When it is written as
     *     650 253 0000, it can only be dialed from within the US, and when written as 253 0000, it
     *     can only be dialed from within a smaller area in the US (Mountain View, CA, to be more
     *     specific).
     * @return boolean true if the number is possible
     */
    public function isPossibleNumber($number, $regionDialingFrom = null)
    {
        if ($regionDialingFrom !== null && is_string($number)) {
            try {
                return $this->isPossibleNumberWithReason(
                    $this->parse($number, $regionDialingFrom)
                ) === ValidationResult::IS_POSSIBLE;
            } catch (NumberParseException $e) {
                return false;
            }
        } else {
            return $this->isPossibleNumberWithReason($number) === ValidationResult::IS_POSSIBLE;
        }
    }


    /**
     * Check whether a phone number is a possible number. It provides a more lenient check than
     * {@link #isValidNumber} in the following sense:
     * <ol>
     * <li> It only checks the length of phone numbers. In particular, it doesn't check starting
     *      digits of the number.
     * <li> It doesn't attempt to figure out the type of the number, but uses general rules which
     *      applies to all types of phone numbers in a region. Therefore, it is much faster than
     *      isValidNumber.
     * <li> For fixed line numbers, many regions have the concept of area code, which together with
     *      subscriber number constitute the national significant number. It is sometimes okay to dial
     *      the subscriber number only when dialing in the same area. This function will return
     *      true if the subscriber-number-only version is passed in. On the other hand, because
     *      isValidNumber validates using information on both starting digits (for fixed line
     *      numbers, that would most likely be area codes) and length (obviously includes the
     *      length of area codes for fixed line numbers), it will return false for the
     *      subscriber-number-only version.
     * </ol>
     * @param PhoneNumber $number the number that needs to be checked
     * @return int a ValidationResult object which indicates whether the number is possible
     */
    public function isPossibleNumberWithReason(PhoneNumber $number)
    {
        $nationalNumber = $this->getNationalSignificantNumber($number);
        $countryCode = $number->getCountryCode();
        // Note: For Russian Fed and NANPA numbers, we just use the rules from the default region (US or
        // Russia) since the getRegionCodeForNumber will not work if the number is possible but not
        // valid. This would need to be revisited if the possible number pattern ever differed between
        // various regions within those plans.
        if (!$this->hasValidCountryCallingCode($countryCode)) {
            return ValidationResult::INVALID_COUNTRY_CODE;
        }

        $regionCode = $this->getRegionCodeForCountryCode($countryCode);
        // Metadata cannot be null because the country calling code is valid.
        $metadata = $this->getMetadataForRegionOrCallingCode($countryCode, $regionCode);

        $possibleNumberPattern = $metadata->getGeneralDesc()->getPossibleNumberPattern();
        return $this->testNumberLengthAgainstPattern($possibleNumberPattern, $nationalNumber);
    }

    /**
     * Attempts to extract a valid number from a phone number that is too long to be valid, and resets
     * the PhoneNumber object passed in to that valid version. If no valid number could be extracted,
     * the PhoneNumber object passed in will not be modified.
     * @param PhoneNumber $number a PhoneNumber object which contains a number that is too long to be valid.
     * @return boolean true if a valid phone number can be successfully extracted.
     */
    public function truncateTooLongNumber(PhoneNumber $number)
    {
        if ($this->isValidNumber($number)) {
            return true;
        }
        $numberCopy = new PhoneNumber();
        $numberCopy->mergeFrom($number);
        $nationalNumber = $number->getNationalNumber();
        do {
            $nationalNumber = floor($nationalNumber / 10);
            $numberCopy->setNationalNumber($nationalNumber);
            if ($this->isPossibleNumberWithReason($numberCopy) == ValidationResult::TOO_SHORT || $nationalNumber == 0) {
                return false;
            }
        } while (!$this->isValidNumber($numberCopy));
        $number->setNationalNumber($nationalNumber);
        return true;
    }
}
