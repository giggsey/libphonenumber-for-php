<?php

namespace libphonenumber;

class PhoneNumber implements \Serializable
{

    /**
     * @var int
     */
    private $countryCode = null;

    public function hasCountryCode()
    {
        return isset($this->countryCode);
    }

    public function getCountryCode()
    {
        return $this->countryCode;
    }

    public function setCountryCode($value)
    {
        $this->countryCode = $value;
        return $this;
    }

    public function clearCountryCode()
    {
        $this->countryCode = null;
        return $this;
    }

    /**
     * @var int
     */
    private $nationalNumber = null;

    public function hasNationalNumber()
    {
        return isset($this->nationalNumber);
    }

    public function getNationalNumber()
    {
        return $this->nationalNumber;
    }

    public function setNationalNumber($value)
    {
        $this->nationalNumber = $value;
        return $this;
    }

    public function clearNationalNumber()
    {
        $this->nationalNumber = null;
        return $this;
    }

    private $extension = null;

    public function hasExtension()
    {
        return isset($this->extension);
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setExtension($value)
    {
        $this->extension = $value;
        return $this;
    }

    public function clearExtension()
    {
        $this->extension = null;
        return $this;
    }

    /**
     * @var boolean
     */
    private $italianLeadingZero = null;

    public function hasItalianLeadingZero()
    {
        return isset($this->italianLeadingZero);
    }

    public function isItalianLeadingZero()
    {
        return $this->italianLeadingZero;
    }

    public function setItalianLeadingZero($value)
    {
        $this->italianLeadingZero = $value;
        return $this;
    }

    public function clearItalianLeadingZero()
    {
        $this->italianLeadingZero = null;
        return $this;
    }

    private $rawInput = null;

    public function hasRawInput()
    {
        return isset($this->rawInput);
    }

    public function getRawInput()
    {
        return $this->rawInput;
    }

    public function setRawInput($value)
    {
        $this->rawInput = $value;
        return $this;
    }

    public function clearRawInput()
    {
        $this->rawInput = null;
        return $this;
    }

    private $countryCodeSource = null;

    public function hasCountryCodeSource()
    {
        return isset($this->countryCodeSource);
    }

    public function getCountryCodeSource()
    {
        return $this->countryCodeSource;
    }

    public function setCountryCodeSource($value)
    {
        $this->countryCodeSource = $value;
        return $this;
    }

    public function clearCountryCodeSource()
    {
        $this->countryCodeSource = null;
        return $this;
    }

    private $preferredDomesticCarrierCode = null;

    public function hasPreferredDomesticCarrierCode()
    {
        return isset($this->preferredDomesticCarrierCode);
    }

    public function getPreferredDomesticCarrierCode()
    {
        return $this->preferredDomesticCarrierCode;
    }

    public function setPreferredDomesticCarrierCode($value)
    {
        $this->preferredDomesticCarrierCode = $value;
        return $this;
    }

    public function clearPreferredDomesticCarrierCode()
    {
        $this->preferredDomesticCarrierCode = null;
        return $this;
    }

    private $hasNumberOfLeadingZeros = false;
    private $numberOfLeadingZeros = 1;

    public function hasNumberOfLeadingZeros()
    {
        return $this->hasNumberOfLeadingZeros;
    }

    public function getNumberOfLeadingZeros()
    {
        return $this->numberOfLeadingZeros;
    }

    public function setNumberOfLeadingZeros($value)
    {
        $this->hasNumberOfLeadingZeros = true;
        $this->numberOfLeadingZeros = $value;
        return $this;
    }

    public function clearNumberOfLeadingZeros()
    {
        $this->hasNumberOfLeadingZeros = false;
        $this->numberOfLeadingZeros = 1;
        return $this;
    }

    public function clear()
    {
        $this->clearCountryCode();
        $this->clearNationalNumber();
        $this->clearExtension();
        $this->clearItalianLeadingZero();
        $this->clearNumberOfLeadingZeros();
        $this->clearRawInput();
        $this->clearCountryCodeSource();
        $this->clearPreferredDomesticCarrierCode();
        return $this;
    }

    public function mergeFrom(PhoneNumber $other)
    {
        if ($other->hasCountryCode()) {
            $this->setCountryCode($other->getCountryCode());
        }
        if ($other->hasNationalNumber()) {
            $this->setNationalNumber($other->getNationalNumber());
        }
        if ($other->hasExtension()) {
            $this->setExtension($other->getExtension());
        }
        if ($other->hasItalianLeadingZero()) {
            $this->setItalianLeadingZero($other->isItalianLeadingZero());
        }
        if ($other->hasNumberOfLeadingZeros()) {
            $this->setNumberOfLeadingZeros($other->getNumberOfLeadingZeros());
        }
        if ($other->hasRawInput()) {
            $this->setRawInput($other->getRawInput());
        }
        if ($other->hasCountryCodeSource()) {
            $this->setCountryCodeSource($other->getCountryCodeSource());
        }
        if ($other->hasPreferredDomesticCarrierCode()) {
            $this->setPreferredDomesticCarrierCode($other->getPreferredDomesticCarrierCode());
        }
        return $this;
    }

    public function equals(PhoneNumber $other)
    {
        $sameType = get_class($other) == get_class($this);
        $sameCountry = $this->hasCountryCode() == $other->hasCountryCode() &&
            (!$this->hasCountryCode() || $this->getCountryCode() == $other->getCountryCode());
        $sameNational = $this->hasNationalNumber() == $other->hasNationalNumber() &&
            (!$this->hasNationalNumber() || $this->getNationalNumber() == $other->getNationalNumber());
        $sameExt = $this->hasExtension() == $other->hasExtension() &&
            (!$this->hasExtension() || $this->hasExtension() == $other->hasExtension());
        $sameLead = $this->hasItalianLeadingZero() == $other->hasItalianLeadingZero() &&
            (!$this->hasItalianLeadingZero() || $this->isItalianLeadingZero() == $other->isItalianLeadingZero());
        $sameZeros = $this->getNumberOfLeadingZeros() == $other->getNumberOfLeadingZeros();
        $sameRaw = $this->hasRawInput() == $other->hasRawInput() &&
            (!$this->hasRawInput() || $this->getRawInput() == $other->getRawInput());
        $sameCountrySource = $this->hasCountryCodeSource() == $other->hasCountryCodeSource() &&
            (!$this->hasCountryCodeSource() || $this->getCountryCodeSource() == $other->getCountryCodeSource());
        $samePrefCar = $this->hasPreferredDomesticCarrierCode() == $other->hasPreferredDomesticCarrierCode() &&
            (!$this->hasPreferredDomesticCarrierCode() || $this->getPreferredDomesticCarrierCode(
                ) == $other->getPreferredDomesticCarrierCode());
        return $sameType && $sameCountry && $sameNational && $sameExt && $sameLead && $sameZeros && $sameRaw && $sameCountrySource && $samePrefCar;
    }

    public function __toString()
    {
        return '+' . $this->getCountryCode() . $this->getNationalNumber();
    }

    public function serialize()
    {
        return serialize(
            array(
                $this->getCountryCode(),
                $this->getNationalNumber(),
                $this->getExtension(),
                $this->isItalianLeadingZero(),
                $this->getNumberOfLeadingZeros(),
                $this->getRawInput(),
                $this->getCountryCodeSource(),
                $this->getPreferredDomesticCarrierCode(),
            )
        );
    }

    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        $this->setCountryCode($data[0]);
        $this->setNationalNumber($data[1]);
        $this->setExtension($data[2]);
        $this->setItalianLeadingZero($data[3]);
        $this->setNumberOfLeadingZeros($data[4]);
        $this->setRawInput($data[5]);
        $this->setCountryCodeSource($data[6]);
        $this->setPreferredDomesticCarrierCode($data[7]);
    }
}
