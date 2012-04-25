<?php

namespace com\google\i18n\phonenumbers;

class PhoneNumber {

	/**
	 * @var int
	 */
	private $countryCode = NULL;

	public function hasCountryCode() {
		return isset($this->countryCode);
	}

	public function getCountryCode() {
		return $this->countryCode;
	}

	public function setCountryCode($value) {
		$this->countryCode = $value;
		return $this;
	}

	public function clearCountryCode() {
		$this->countryCode = NULL;
		return $this;
	}

	/**
	 * @var int
	 */
	private $nationalNumber = NULL;

	public function hasNationalNumber() {
		return isset($this->nationalNumber);
	}

	public function getNationalNumber() {
		return $this->nationalNumber;
	}

	public function setNationalNumber($value) {
		$this->nationalNumber = $value;
		return $this;
	}

	public function clearNationalNumber() {
		$this->nationalNumber = NULL;
		return $this;
	}

	private $extension = NULL;

	public function hasExtension() {
		return isset($this->extension);
	}

	public function getExtension() {
		return $this->extension;
	}

	public function setExtension($value) {
		$this->extension = $value;
		return $this;
	}

	public function clearExtension() {
		$this->extension = NULL;
		return $this;
	}

	/**
	 * @var boolean
	 */
	private $italianLeadingZero = NULL;

	public function hasItalianLeadingZero() {
		return isset($this->italianLeadingZero);
	}

	public function isItalianLeadingZero() {
		return $this->italianLeadingZero;
	}

	public function setItalianLeadingZero($value) {
		$this->italianLeadingZero = $value;
		return $this;
	}

	public function clearItalianLeadingZero() {
		$this->italianLeadingZero = NULL;
		return $this;
	}

	private $rawInput = NULL;

	public function hasRawInput() {
		return isset($this->rawInput);
	}

	public function getRawInput() {
		return $this->rawInput;
	}

	public function setRawInput($value) {
		$this->rawInput = $value;
		return $this;
	}

	public function clearRawInput() {
		$this->rawInput = NULL;
		return $this;
	}

	private $countryCodeSource = NULL;

	public function hasCountryCodeSource() {
		return isset($this->countryCodeSource);
	}

	public function getCountryCodeSource() {
		return $this->countryCodeSource;
	}

	public function setCountryCodeSource($value) {
		$this->countryCodeSource = $value;
		return $this;
	}

	public function clearCountryCodeSource() {
		$this->countryCodeSource = NULL;
		return $this;
	}

	private $preferredDomesticCarrierCode = NULL;

	public function hasPreferredDomesticCarrierCode() {
		return isset($this->preferredDomesticCarrierCode);
	}

	public function getPreferredDomesticCarrierCode() {
		return $this->preferredDomesticCarrierCode;
	}

	public function setPreferredDomesticCarrierCode($value) {
		$this->preferredDomesticCarrierCode = $value;
		return $this;
	}

	public function clearPreferredDomesticCarrierCode() {
		$this->preferredDomesticCarrierCode = NULL;
		return $this;
	}

	public function clear() {
		$this->clearCountryCode();
		$this->clearNationalNumber();
		$this->clearExtension();
		$this->clearItalianLeadingZero();
		$this->clearRawInput();
		$this->clearCountryCodeSource();
	  	$this->clearPreferredDomesticCarrierCode();
		return $this;
	}

	public function  mergeFrom(PhoneNumber $other) {
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
}
class CountryCodeSource {

	const FROM_NUMBER_WITH_PLUS_SIGN = 0;
	const FROM_NUMBER_WITH_IDD = 1;
	const FROM_NUMBER_WITHOUT_PLUS_SIGN = 2;
	const FROM_DEFAULT_COUNTRY = 3;

}