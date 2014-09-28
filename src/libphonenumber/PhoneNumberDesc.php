<?php

namespace libphonenumber;

/**
 * Phone Number Description
 */
class PhoneNumberDesc
{
    private $hasNationalNumberPattern = false;
    private $nationalNumberPattern = "";
    private $hasPossibleNumberPattern = false;
    private $possibleNumberPattern = "";
    private $hasExampleNumber = false;
    private $exampleNumber = "";

    /**
     * @return boolean
     */
    public function hasNationalNumberPattern()
    {
        return $this->hasNationalNumberPattern;
    }

    /**
     * @return string
     */
    public function getNationalNumberPattern()
    {
        return $this->nationalNumberPattern;
    }

    /**
     * @param string $value
     * @return PhoneNumberDesc
     */
    public function setNationalNumberPattern($value)
    {
        $this->hasNationalNumberPattern = true;
        $this->nationalNumberPattern = $value;

        return $this;
    }

    /**
     * @return boolean
     */
    public function hasPossibleNumberPattern()
    {
        return $this->hasPossibleNumberPattern;
    }

    /**
     * @return string
     */
    public function getPossibleNumberPattern()
    {
        return $this->possibleNumberPattern;
    }

    /**
     * @param string $value
     * @return PhoneNumberDesc
     */
    public function setPossibleNumberPattern($value)
    {
        $this->hasPossibleNumberPattern = true;
        $this->possibleNumberPattern = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function hasExampleNumber()
    {
        return $this->hasExampleNumber;
    }

    /**
     * @return string
     */
    public function getExampleNumber()
    {
        return $this->exampleNumber;
    }

    /**
     * @param string $value
     * @return PhoneNumberDesc
     */
    public function setExampleNumber($value)
    {
        $this->hasExampleNumber = true;
        $this->exampleNumber = $value;

        return $this;
    }

    /**
     * @param PhoneNumberDesc $other
     * @return PhoneNumberDesc
     */
    public function mergeFrom(PhoneNumberDesc $other)
    {
        if ($other->hasNationalNumberPattern()) {
            $this->setNationalNumberPattern($other->getNationalNumberPattern());
        }
        if ($other->hasPossibleNumberPattern()) {
            $this->setPossibleNumberPattern($other->getPossibleNumberPattern());
        }
        if ($other->hasExampleNumber()) {
            $this->setExampleNumber($other->getExampleNumber());
        }

        return $this;
    }

    /**
     * @param PhoneNumberDesc $other
     * @return boolean
     */
    public function exactlySameAs(PhoneNumberDesc $other)
    {
        return $this->nationalNumberPattern === $other->nationalNumberPattern &&
        $this->possibleNumberPattern === $other->possibleNumberPattern &&
        $this->exampleNumber === $other->exampleNumber;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $data = array();
        if ($this->hasNationalNumberPattern()) {
            $data['NationalNumberPattern'] = $this->getNationalNumberPattern();
        }
        if ($this->hasPossibleNumberPattern()) {
            $data['PossibleNumberPattern'] = $this->getPossibleNumberPattern();
        }
        if ($this->hasExampleNumber()) {
            $data['ExampleNumber'] = $this->getExampleNumber();
        }

        return $data;
    }

    /**
     * @param array $input
     * @return PhoneNumberDesc
     */
    public function fromArray(array $input)
    {
        if (isset($input['NationalNumberPattern']) && $input['NationalNumberPattern'] != '') {
            $this->setNationalNumberPattern($input['NationalNumberPattern']);
        }
        if (isset($input['PossibleNumberPattern']) && $input['NationalNumberPattern'] != '') {
            $this->setPossibleNumberPattern($input['PossibleNumberPattern']);
        }
        if (isset($input['ExampleNumber']) && $input['NationalNumberPattern'] != '') {
            $this->setExampleNumber($input['ExampleNumber']);
        }

        return $this;
    }
}
