<?php

namespace libphonenumber\buildtools;

use Guzzle\Common\Exception\RuntimeException;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;

/**
 * Class to encapsulate the metadata filtering logic and restrict visibility into raw data
 * structures
 *
 *
 * @package libphonenumber\buildtools
 * @internal
 */
class MetadataFilter
{
    public static $EXCLUDABLE_PARENT_FIELDS = array(
        "fixedLine",
        "mobile",
        "tollFree",
        "premiumRate",
        "sharedCost",
        "personalNumber",
        "voip",
        "pager",
        "uan",
        "emergency",
        "voicemail",
        "shortCode",
        "standardRate",
        "carrierSpecific",
        "noInternationalDialling"
    );

    public static $EXCLUDABLE_CHILD_FIELDS = array(
        "nationalNumberPattern",
        "possibleLength",
        "possibleLengthLocalOnly",
        "exampleNumber"
    );

    public static $EXCLUDABLE_CHILDLESS_FIELDS = array(
        "preferredInternationalPrefix",
        "nationalPrefix",
        "preferredExtnPrefix",
        "nationalPrefixTransformRule",
        "sameMobileAndFixedLinePattern",
        "mainCountryForCode",
        "leadingZeroPossible",
        "mobileNumberPortableRegion"
    );

    protected $blackList;

    public function __construct($blackList = array())
    {
        $this->blackList = $blackList;
    }

    public static function forLiteBuild()
    {
        // "exampleNumber" is a blacklist.
        return new static(self::parseFieldMapFromString("exampleNumber"));
    }

    /**
     * The input blacklist or whitelist string is expected to be of the form "a(b,c):d(e):f", where
     * b and c are children of a, e is a child of d, and f is either a parent field, a child field, or
     * a childless field. Order and whitespace don't matter. We throw RuntimeException for any
     * duplicates, malformed strings, or strings where field tokens do not correspond to strings in
     * the sets of excludable fields. We also throw RuntimeException for empty strings since such
     * strings should be treated as a special case by the flag checking code and not passed here.
     * @param string $string
     * @return array
     */
    public static function parseFieldMapFromString($string)
    {
        if ($string === null) {
            throw new \RuntimeException("Null string should not be passed to parseFieldMapFromString");
        }

        // Remove whitespace
        $string = str_replace(' ', '', $string);
        if (strlen($string) === 0) {
            throw new \RuntimeException("Empty string should not be passed to parseFieldMapFromString");
        }

        $fieldMap = array();
        $wildCardChildren = array();

        $groups = explode(':', $string);
        foreach ($groups as $group) {
            $leftParenIndex = strpos($group, '(');
            $rightParenIndex = strpos($group, ')');

            if ($leftParenIndex === false && $rightParenIndex === false) {
                if (in_array($group, self::$EXCLUDABLE_PARENT_FIELDS)) {
                    if (array_key_exists($group, $fieldMap)) {
                        throw new \RuntimeException($group . ' given more than once in ' . $string);
                    }
                    $fieldMap[$group] = self::$EXCLUDABLE_CHILD_FIELDS;
                } elseif (in_array($group, self::$EXCLUDABLE_CHILDLESS_FIELDS)) {
                    if (array_key_exists($group, $fieldMap)) {
                        throw new \RuntimeException($group . ' given more than once in ' . $string);
                    }
                    $fieldMap[$group] = array();
                } elseif (in_array($group, self::$EXCLUDABLE_CHILD_FIELDS)) {
                    if (in_array($group, $wildCardChildren)) {
                        throw new \RuntimeException($group . ' given more than once in ' . $string);
                    }
                    $wildCardChildren[] = $group;
                } else {
                    throw new \RuntimeException($group . ' is not a valid token');
                }
            } elseif ($leftParenIndex > 0 && $rightParenIndex == strlen($group) - 1) {
                // We don't check for duplicate parentheses or illegal characters since these will be caught
                // as not being part of valid field tokens.
                $parent = substr($group, 0, $leftParenIndex);
                if (!in_array($parent, self::$EXCLUDABLE_PARENT_FIELDS)) {
                    throw new \RuntimeException($parent . ' is not a valid parent token');
                }

                if (array_key_exists($parent, $fieldMap)) {
                    throw new \RuntimeException($parent . ' given more than once in ' . $string);
                }
                $children = array();
                $childSearch = explode(',', substr($group, $leftParenIndex + 1, $rightParenIndex - $leftParenIndex - 1));
                foreach ($childSearch as $child) {
                    if (!in_array($child, self::$EXCLUDABLE_CHILD_FIELDS)) {
                        throw new \RuntimeException($child . ' is not a valid child token');
                    }
                    if (in_array($child, $children)) {
                        throw new \RuntimeException($child . ' given more than once in ' . $group);
                    }
                    $children[] = $child;
                }
                $fieldMap[$parent] = $children;
            } else {
                throw new \RuntimeException("Incorrect location of parentheses in " . $group);
            }
        }

        foreach ($wildCardChildren as $wildCardChild) {
            foreach (self::$EXCLUDABLE_PARENT_FIELDS as $parent) {
                if (!array_key_exists($parent, $fieldMap)) {
                    $fieldMap[$parent] = array();
                }

                $children = $fieldMap[$parent];

                if (in_array($wildCardChild, $children)
                    && count($fieldMap[$parent]) != count(self::$EXCLUDABLE_CHILD_FIELDS)
                ) {
                    // The map already contains parent -> wildcardChild but not all possible children.
                    // So wildcardChild was given explicitly as a child of parent, which is a duplication
                    // since it's also given as a wildcard child.
                    throw new \RuntimeException($wildCardChild . ' is present by itself so remove it from ' . $parent . '\'s group');
                }

                if (!in_array($wildCardChild, $children)) {
                    // We don't have an add() that fails if it's a duplicate
                    $children[] = $wildCardChild;
                }
                $fieldMap[$parent] = $children;
            }
        }

        return $fieldMap;
    }

    public static function forSpecialBuild()
    {
        // "mobile" is a whitelist.
        return new static(self::computeComplement(self::parseFieldMapFromString("mobile")));
    }

    /**
     * Does not check that legal tokens are used, assuming that $fieldMap is constructed using
     * parseFieldMapFromString which does check. If $fieldMap contains illegal tokens or parent
     * fields with no children or other unexpected state, the behavior of this function is undefined.
     * @param $fieldMap
     * @return array
     */
    public static function computeComplement($fieldMap)
    {
        $complement = array();
        foreach (self::$EXCLUDABLE_PARENT_FIELDS as $parent) {
            if (!array_key_exists($parent, $fieldMap)) {
                $complement[$parent] = self::$EXCLUDABLE_CHILD_FIELDS;
            } else {
                $otherChildren = $fieldMap[$parent];
                // If the other map has all the children for this parent then we don't want to include the
                // parent as a key.
                if (count($otherChildren) != count(self::$EXCLUDABLE_CHILD_FIELDS)) {
                    $children = array();
                    foreach (self::$EXCLUDABLE_CHILD_FIELDS as $child) {
                        if (!in_array($child, $otherChildren)) {
                            $children[] = $child;
                        }
                    }
                    $complement[$parent] = $children;
                }
            }
        }
        foreach (self::$EXCLUDABLE_CHILDLESS_FIELDS as $childlessField) {
            if (!array_key_exists($childlessField, $fieldMap)) {
                $complement[$childlessField] = array();
            }
        }

        return $complement;
    }

    public static function emptyFilter()
    {
        // Empty blacklist, meaning we filter nothing.
        return new MetadataFilter();
    }

    /**
     * Clears certain fields in $metadata as defined by the MetadataFilter instance.
     * Note that this changes the mutable $metadata object. If this method does not
     * return successfully, do not assume $metadata has not changed.
     *
     * @param PhoneMetadata $metadata The object to be filtered
     */
    public function filterMetadata(PhoneMetadata $metadata)
    {
        if ($metadata->hasFixedLine()) {
            $metadata->setFixedLine($this->getFiltered('fixedLine', $metadata->getFixedLine()));
        }

        if ($metadata->hasMobile()) {
            $metadata->setMobile($this->getFiltered('mobile', $metadata->getMobile()));
        }

        if ($metadata->hasTollFree()) {
            $metadata->setTollFree($this->getFiltered('tollFree', $metadata->getTollFree()));
        }

        if ($metadata->hasPremiumRate()) {
            $metadata->setPremiumRate($this->getFiltered('premiumRate', $metadata->getPremiumRate()));
        }

        if ($metadata->hasSharedCost()) {
            $metadata->setSharedCost($this->getFiltered('sharedCost', $metadata->getSharedCost()));
        }

        if ($metadata->hasPersonalNumber()) {
            $metadata->setPersonalNumber($this->getFiltered('personalNumber', $metadata->getPersonalNumber()));
        }

        if ($metadata->hasVoip()) {
            $metadata->setVoip($this->getFiltered('voip', $metadata->getVoip()));
        }

        if ($metadata->hasPager()) {
            $metadata->setPager($this->getFiltered('pager', $metadata->getPager()));
        }

        if ($metadata->hasUan()) {
            $metadata->setUan($this->getFiltered('uan', $metadata->getUan()));
        }

        if ($metadata->hasEmergency()) {
            $metadata->setEmergency($this->getFiltered('emergency', $metadata->getEmergency()));
        }

        if ($metadata->hasVoicemail()) {
            $metadata->setVoicemail($this->getFiltered('voicemail', $metadata->getVoicemail()));
        }

        if ($metadata->hasShortCode()) {
            $metadata->setShortCode($this->getFiltered('shortCode', $metadata->getShortCode()));
        }

        if ($metadata->hasStandardRate()) {
            $metadata->setStandardRate($this->getFiltered('standardRate', $metadata->getStandardRate()));
        }

        if ($metadata->hasCarrierSpecific()) {
            $metadata->setCarrierSpecific($this->getFiltered('carrierSpecific', $metadata->getCarrierSpecific()));
        }

        if ($metadata->hasNoInternationalDialling()) {
            $metadata->setNoInternationalDialling($this->getFiltered('noInternationalDialling',
                $metadata->getNoInternationalDialling()));
        }

        if ($this->drop('preferredInternationalPrefix')) {
            $metadata->clearPreferredInternationalPrefix();
        }

        if ($this->drop('preferredExtnPrefix')) {
            $metadata->clearPreferredExtnPrefix();
        }

        if ($this->drop('nationalPrefixTransformRule')) {
            $metadata->clearNationalPrefixTransformRule();
        }

        if ($this->drop('sameMobileAndFixedLinePattern')) {
            $metadata->clearSameMobileAndFixedLinePattern();
        }

        if ($this->drop('mainCountryForCode')) {
            $metadata->clearMainCountryForCode();
        }

        if ($this->drop('leadingZeroPossible')) {
            $metadata->clearLeadingZeroPossible();
        }

        if ($this->drop('mobileNumberPortableRegion')) {
            $metadata->clearMobileNumberPortableRegion();
        }
    }

    /**
     * @param string $type
     * @param PhoneNumberDesc $desc
     * @return PhoneNumberDesc
     */
    private function getFiltered($type, PhoneNumberDesc $desc)
    {
        $builder = new PhoneNumberDesc();
        $builder->mergeFrom($desc);

        if ($this->drop($type, 'nationalNumberPattern')) {
            $builder->clearNationalNumberPattern();
        }

        if ($this->drop($type, 'possibleLength')) {
            $builder->clearPossibleLength();
        }

        if ($this->drop($type, 'possibleLengthLocalOnly')) {
            $builder->clearPossibleLengthLocalOnly();
        }

        if ($this->drop($type, 'exampleNumber')) {
            $builder->clearExampleNumber();
        }

        return $builder;
    }

    /**
     * @param $parent
     * @param $child
     * @return bool
     */
    public function drop($parent, $child = null)
    {
        if ($child !== null) {
            if (!in_array($parent, self::$EXCLUDABLE_PARENT_FIELDS)) {
                throw new RuntimeException($parent . ' is not an excludable parent field');
            }

            if (!in_array($child, self::$EXCLUDABLE_CHILD_FIELDS)) {
                throw new RuntimeException($parent . ' is not an excludable child field');
            }

            return array_key_exists($parent, $this->blackList) && in_array($child, $this->blackList[$parent]);
        } else {
            $childlessField = $parent;
            if (!in_array($childlessField, self::$EXCLUDABLE_CHILDLESS_FIELDS)) {
                throw new \RuntimeException($childlessField . ' is not an excludable childless field');
            }

            return array_key_exists($childlessField, $this->blackList);
        }
    }
}
