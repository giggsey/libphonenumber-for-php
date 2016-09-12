<?php

namespace libphonenumber;

/**
 * Number Format
 */
class NumberFormat
{
    protected $pattern = null;
    protected $format = null;
    protected $leadingDigitsPattern = array();
    protected $nationalPrefixFormattingRule = null;
    /**
     * @var bool
     */
    protected $nationalPrefixOptionalWhenFormatting = false;
    protected $domesticCarrierCodeFormattingRule = null;

    public function __construct()
    {
        $this->clear();
    }

    /**
     * @return NumberFormat
     */
    public function clear()
    {
        $this->pattern = "";
        $this->format = "";
        $this->leadingDigitsPattern = array();
        $this->nationalPrefixFormattingRule = "";
        $this->nationalPrefixOptionalWhenFormatting = false;
        $this->domesticCarrierCodeFormattingRule = "";

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasPattern()
    {
        return isset($this->pattern);
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $value
     * @return NumberFormat
     */
    public function setPattern($value)
    {
        $this->pattern = $value;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isNationalPrefixOptionalWhenFormatting()
    {
        return $this->nationalPrefixOptionalWhenFormatting;
    }

    /**
     * @param boolean $nationalPrefixOptionalWhenFormatting
     */
    public function setNationalPrefixOptionalWhenFormatting($nationalPrefixOptionalWhenFormatting)
    {
        $this->nationalPrefixOptionalWhenFormatting = $nationalPrefixOptionalWhenFormatting;
    }

    /**
     * @return boolean
     */
    public function hasFormat()
    {
        return ($this->format);
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @param string $value
     * @return NumberFormat
     */
    public function setFormat($value)
    {
        $this->format = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function leadingDigitPatterns()
    {
        return $this->leadingDigitsPattern;
    }

    /**
     * @return int
     */
    public function leadingDigitsPatternSize()
    {
        return count($this->leadingDigitsPattern);
    }

    /**
     * @param int $index
     * @return string
     */
    public function getLeadingDigitsPattern($index)
    {
        return $this->leadingDigitsPattern[$index];
    }

    /**
     * @param string $value
     * @return NumberFormat
     */
    public function addLeadingDigitsPattern($value)
    {
        $this->leadingDigitsPattern[] = $value;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasNationalPrefixFormattingRule()
    {
        return isset($this->nationalPrefixFormattingRule);
    }

    /**
     * @return string
     */
    public function getNationalPrefixFormattingRule()
    {
        return $this->nationalPrefixFormattingRule;
    }

    /**
     * @param string $value
     * @return NumberFormat
     */
    public function setNationalPrefixFormattingRule($value)
    {
        $this->nationalPrefixFormattingRule = $value;

        return $this;
    }

    /**
     * @return NumberFormat
     */
    public function clearNationalPrefixFormattingRule()
    {
        $this->nationalPrefixFormattingRule = null;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasDomesticCarrierCodeFormattingRule()
    {
        return isset($this->domesticCarrierCodeFormattingRule);
    }

    /**
     * @return string
     */
    public function getDomesticCarrierCodeFormattingRule()
    {
        return $this->domesticCarrierCodeFormattingRule;
    }

    /**
     * @param string $value
     * @return NumberFormat
     */
    public function setDomesticCarrierCodeFormattingRule($value)
    {
        $this->domesticCarrierCodeFormattingRule = $value;

        return $this;
    }

    /**
     * @param NumberFormat $other
     * @return NumberFormat
     */
    public function mergeFrom(NumberFormat $other)
    {
        if ($other->hasPattern()) {
            $this->setPattern($other->getPattern());
        }
        if ($other->hasFormat()) {
            $this->setFormat($other->getFormat());
        }
        $leadingDigitsPatternSize = $other->leadingDigitsPatternSize();
        for ($i = 0; $i < $leadingDigitsPatternSize; $i++) {
            $this->addLeadingDigitsPattern($other->getLeadingDigitsPattern($i));
        }
        if ($other->hasNationalPrefixFormattingRule()) {
            $this->setNationalPrefixFormattingRule($other->getNationalPrefixFormattingRule());
        }
        if ($other->hasDomesticCarrierCodeFormattingRule()) {
            $this->setDomesticCarrierCodeFormattingRule($other->getDomesticCarrierCodeFormattingRule());
        }
        $this->setNationalPrefixOptionalWhenFormatting($other->isNationalPrefixOptionalWhenFormatting());

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $output = array();
        $output['pattern'] = $this->getPattern();
        $output['format'] = $this->getFormat();

        $output['leadingDigitsPatterns'] = $this->leadingDigitPatterns();

        if ($this->hasNationalPrefixFormattingRule()) {
            $output['nationalPrefixFormattingRule'] = $this->getNationalPrefixFormattingRule();
        }

        if ($this->hasDomesticCarrierCodeFormattingRule()) {
            $output['domesticCarrierCodeFormattingRule'] = $this->getDomesticCarrierCodeFormattingRule();
        }

        $output['nationalPrefixOptionalWhenFormatting'] = $this->isNationalPrefixOptionalWhenFormatting();

        return $output;
    }

    /**
     * @param array $input
     */
    public function fromArray(array $input)
    {
        $this->setPattern($input['pattern']);
        $this->setFormat($input['format']);
        foreach ($input['leadingDigitsPatterns'] as $leadingDigitsPattern) {
            $this->addLeadingDigitsPattern($leadingDigitsPattern);
        }

        if (isset($input['nationalPrefixFormattingRule'])) {
            $this->setNationalPrefixFormattingRule($input['nationalPrefixFormattingRule']);
        }
        if (isset($input['domesticCarrierCodeFormattingRule'])) {
            $this->setDomesticCarrierCodeFormattingRule($input['domesticCarrierCodeFormattingRule']);
        }

        $this->setNationalPrefixOptionalWhenFormatting($input['nationalPrefixOptionalWhenFormatting']);
    }
}
