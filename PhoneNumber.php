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
	
    public function clear() {
      $this->clearCountryCode();
      $this->clearNationalNumber();
      $this->clearExtension();
      $this->clearItalianLeadingZero();
      $this->clearRawInput();
/*      $this->clearCountryCodeSource();
      $this->clearPreferredDomesticCarrierCode();
 */     return $this;
    }
}
