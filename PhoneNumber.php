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
		$countryCode = value;
		return $this;
	}

	public function clearCountryCode() {
		$this->countryCode = NULL;
		return $this;
	}

}
