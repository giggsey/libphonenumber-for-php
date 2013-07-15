<?php

namespace libphonenumber;

/**
 * Phone Number Description
 */
class PhoneNumberDesc
{
    private $hasNationalNumberPattern;
    private $nationalNumberPattern = "";
    private $hasPossibleNumberPattern;
    private $possibleNumberPattern = "";
    private $hasExampleNumber;
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
     * 
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
     * 
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
     * 
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
     * 
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
     * 
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
        return array(
            'NationalNumberPattern' => $this->getNationalNumberPattern(),
            'PossibleNumberPattern' => $this->getPossibleNumberPattern(),
            'ExampleNumber' => $this->getExampleNumber(),
        );
    }

    /**
     * @param array $input
     * 
     * @return PhoneNumberDesc 
     */
    public function fromArray(array $input)
    {
        if (isset($input['NationalNumberPattern'])) {
            $this->setNationalNumberPattern($input['NationalNumberPattern']);
        }
        if (isset($input['PossibleNumberPattern'])) {
            $this->setPossibleNumberPattern($input['PossibleNumberPattern']);
        }
        if (isset($input['ExampleNumber'])) {
            $this->setExampleNumber($input['ExampleNumber']);
        }

        return $this;
    }
}
