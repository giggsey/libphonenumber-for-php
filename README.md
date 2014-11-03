# libphonenumber for PHP [![Build Status](https://travis-ci.org/giggsey/libphonenumber-for-php.svg?branch=master)](https://travis-ci.org/giggsey/libphonenumber-for-php) [![Coverage Status](https://img.shields.io/coveralls/giggsey/libphonenumber-for-php.svg)](https://coveralls.io/r/giggsey/libphonenumber-for-php?branch=master)

[![Total Downloads](https://poser.pugx.org/giggsey/libphonenumber-for-php/downloads.svg)](https://packagist.org/packages/giggsey/libphonenumber-for-php)
[![Latest Stable Version](https://poser.pugx.org/giggsey/libphonenumber-for-php/v/stable.svg)](https://packagist.org/packages/giggsey/libphonenumber-for-php)
[![License](https://poser.pugx.org/giggsey/libphonenumber-for-php/license.svg)](https://packagist.org/packages/giggsey/libphonenumber-for-php)

## What is it?
A PHP library for parsing, formatting, storing and validating international phone numbers. This library is based on Google's [libphonenumber](https://code.google.com/p/libphonenumber/) and was forked from a version by [Davide Mendolia](https://github.com/davideme/libphonenumber-for-PHP).


# Highlights of functionality
* Parsing/formatting/validating phone numbers for all countries/regions of the world.
* `getNumberType` - gets the type of the number based on the number itself; able to distinguish Fixed-line, Mobile, Toll-free, Premium Rate, Shared Cost, VoIP and Personal Numbers (whenever feasible).
* `isNumberMatch` - gets a confidence level on whether two numbers could be the same.
* `getExampleNumber`/`getExampleNumberByType` - provides valid example numbers for all countries/regions, with the option of specifying which type of example phone number is needed.
* `isValidNumber` - full validation of a phone number for a region using length and prefix information.
* PhoneNumberOfflineGeocoder - provides geographical information related to a phone number.
* PhoneNumberToTimeZonesMapper - provides timezone information related to a phone number.
* PhoneNumberToCarrierMapper - provides carrier information related to a phone number.

## Installation

The library can be installed via [composer](http://getcomposer.org/). You can also use any other [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) compliant autoloader.

The PECL [mbstring](http://php.net/mbstring) extension is required for this library to be used.

```json
{
    "require": {
        "giggsey/libphonenumber-for-php": "~7.0"
    }
}
```

## Versioning

This library will try to follow the same version numbers as Google. There could be additional releases where needed to fix critical issues that can not wait until the next release from Google.

This does mean that this project will not follow [Semantic Versioning](http://semver.org/), but instead Google's version policy. As a result, jumps in major versions may not actually contain any backwards
incompatible changes. Please read the release notes for such releases.


## Online Demo
An [online demo](http://giggsey.com/libphonenumber/) is available, and the source can be found at [giggsey/libphonenumber-example](https://github.com/giggsey/libphonenumber-example).

## Quick Examples
Let's say you have a string representing a phone number from Switzerland. This is how you parse/normalize it into a PhoneNumber object:

```php
$swissNumberStr = "044 668 18 00";
$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
try {
    $swissNumberProto = $phoneUtil->parse($swissNumberStr, "CH");
    var_dump($swissNumberProto);
} catch (\libphonenumber\NumberParseException $e) {
    var_dump($e);
}
```

At this point, swissNumberProto contains:

    class libphonenumber\PhoneNumber#9 (7) {
     private $countryCode =>
      int(41)
     private $nationalNumber =>
      double(446681800)
     private $extension =>
      NULL
     private $italianLeadingZero =>
      NULL
     private $rawInput =>
      NULL
     private $countryCodeSource =>
      NULL
     private $preferredDomesticCarrierCode =>
      NULL
    }

Now let us validate whether the number is valid:

```php
$isValid = $phoneUtil->isValidNumber($swissNumberProto);
var_dump($isValid); // true
```

There are a few formats supported by the formatting method, as illustrated below:

```php
// Produces "+41446681800"
echo $phoneUtil->format($swissNumberProto, PhoneNumberFormat::E164);

// Produces "044 668 18 00"
echo $phoneUtil->format($swissNumberProto, PhoneNumberFormat::NATIONAL);

// Produces "+41 44 668 18 00"
echo $phoneUtil->format($swissNumberProto, PhoneNumberFormat::INTERNATIONAL);
```

You could also choose to format the number in the way it is dialled from another country:

```php
// Produces "011 41 44 668 1800", the number when it is dialled in the United States.
echo $phoneUtil->formatOutOfCountryCallingNumber($swissNumberProto, "US");

// Produces "00 41 44 668 18 00", the number when it is dialled in Great Britain.
echo $phoneUtil->formatOutOfCountryCallingNumber($swissNumberProto, "GB");
```

### Geocoder

The PECL [intl](http://php.net/intl) extension is required for the geocoder to be used.

```php
$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

$swissNumberProto = $phoneUtil->parse("044 668 18 00", "CH");
$usNumberProto = $phoneUtil->parse("+1 650 253 0000", "US");
$gbNumberProto = $phoneUtil->parse("0161 496 0000", "GB");

$geocoder = \libphonenumber\geocoding\PhoneNumberOfflineGeocoder::getInstance();

// Outputs "Zurich"
echo $geocoder->getDescriptionForNumber($swissNumberProto, "en_US");

// Outputs "Zürich"
echo $geocoder->getDescriptionForNumber($swissNumberProto, "de_DE");

// Outputs "Zurigo"
echo $geocoder->getDescriptionForNumber($swissNumberProto, "it_IT");


// Outputs "Mountain View, CA"
echo $geocoder->getDescriptionForNumber($usNumberProto, "en_US");

// Outputs "Mountain View, CA"
echo $geocoder->getDescriptionForNumber($usNumberProto, "de_DE");

// Outputs "미국" (Korean for United States)
echo $geocoder->getDescriptionForNumber($usNumberProto, "ko-KR");

// Outputs "Manchester"
echo $geocoder->getDescriptionForNumber($gbNumberProto, "en_GB");

// Outputs "영국" (Korean for United Kingdom)
echo $geocoder->getDescriptionForNumber($gbNumberProto, "ko-KR");
```

### ShortNumberInfo

```php
$shortNumberInfo = \libphonenumber\ShortNumberInfo::getInstance();

// true
var_dump($shortNumberInfo->isEmergencyNumber("999", "GB"));

// true
var_dump($shortNumberInfo->connectsToEmergencyNumber("999", "GB"));

// false
var_dump($shortNumberInfo->connectsToEmergencyNumber("911", "GB"));

// true
var_dump($shortNumberInfo->isEmergencyNumber("911", "US"));

// true
var_dump($shortNumberInfo->connectsToEmergencyNumber("911", "US"));

// false
var_dump($shortNumberInfo->isEmergencyNumber("911123", "US"));

// true
var_dump($shortNumberInfo->connectsToEmergencyNumber("911123", "US"));
```

### Mapping Phone Numbers to carrier

The PECL [intl](http://php.net/intl) extension is required for the carrier mapper to be used.

```php

$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
$swissNumberProto = $phoneUtil->parse("798765432", "CH");

$carrierMapper = \libphonenumber\PhoneNumberToCarrierMapper::getInstance();
// Outputs "Swisscom"
echo $carrierMapper->getNameForNumber($swissNumberProto, "en");
```

### Mapping Phone Numbers to TimeZones

```php

$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
$swissNumberProto = $phoneUtil->parse("798765432", "CH");

$timeZoneMapper = \libphonenumber\PhoneNumberToTimeZonesMapper::getInstance();
// returns array("Europe/Zurich")
$timeZones = $timeZoneMapper->getTimeZonesForNumber($swissNumberProto);

```

## Generating data

Phing is used to 'compile' the metadata.

Ensure you have all the dev composer dependencies installed, then run

```bash
vendor/bin/phing compile
```

## Integration with frameworks

Other packages exist that integrate libphonenumber-for-php into frameworks.

These packages are supplied by third parties, and their quality can not be guaranteed.

 - Symfony: [PhoneNumberBundle](https://github.com/misd-service-development/phone-number-bundle)

