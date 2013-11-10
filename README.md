# libphonenumber for PHP [![Build Status](https://travis-ci.org/giggsey/libphonenumber-for-php.png?branch=master)](https://travis-ci.org/giggsey/libphonenumber-for-php) [![Coverage Status](https://coveralls.io/repos/giggsey/libphonenumber-for-php/badge.png)](https://coveralls.io/r/giggsey/libphonenumber-for-php)

[![Total Downloads](https://poser.pugx.org/giggsey/libphonenumber-for-php/downloads.png)](https://packagist.org/packages/giggsey/libphonenumber-for-php)
[![Latest Stable Version](https://poser.pugx.org/giggsey/libphonenumber-for-php/v/stable.png)](https://packagist.org/packages/giggsey/libphonenumber-for-php)

## What is it?
A PHP library for parsing, formatting, storing and validating international phone numbers. This library is based on Google's [libphonenumber](https://code.google.com/p/libphonenumber/) and forked from a version by [Davide Mendolia](https://github.com/davideme/libphonenumber-for-PHP).


# Highlights of functionality
* Parsing/formatting/validating phone numbers for all countries/regions of the world.
* getNumberType - gets the type of the number based on the number itself; able to distinguish Fixed-line, Mobile, Toll-free, Premium Rate, Shared Cost, VoIP and Personal Numbers (whenever feasible).
* isNumberMatch - gets a confidence level on whether two numbers could be the same.
* getExampleNumber/getExampleNumberByType - provides valid example numbers for all countries/regions, with the option of specifying which type of example phone number is needed.
* isValidNumber - full validation of a phone number for a region using length and prefix information.
* PhoneNumberOfflineGeocoder - provides geographical information related to a phone number.
* PhoneNumberToCarrierMapper - provides carrier information related to a phone number.

## Installation

The library can be installed via [composer](http://getcomposer.org/). You can also use any other [PSR-0](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) compliant autoloader.

The PECL [intl](http://php.net/intl) extension is required for this library to be used.

```json
{
    "require": {
        "giggsey/libphonenumber-for-php": "~5.8"
    }
}
```


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
echo $phoneUtil->format($swissNumberProto, PhoneNumberFormat::E164) . PHP_EOL;
```

### Geocoder

```php
$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

$swissNumberProto = $phoneUtil->parse("044 668 18 00", "CH");
$usNumberProto = $phoneUtil->parse("+1 650 253 0000", "US");
$gbNumberProto = $phoneUtil->parse("0161 496 0000", "GB");

$geocoder = \libphonenumber\geocoding\PhoneNumberOfflineGeocoder::getInstance();

// Outputs "Zurich"
echo $geocoder->getDescriptionForNumber($swissNumberProto, "en_US") . PHP_EOL;
// Outputs "Zürich"
echo $geocoder->getDescriptionForNumber($swissNumberProto, "de_DE") . PHP_EOL;
// Outputs "Zurigo"
echo $geocoder->getDescriptionForNumber($swissNumberProto, "it_IT") . PHP_EOL;


// Outputs "Mountain View, CA"
echo $geocoder->getDescriptionForNumber($usNumberProto, "en_US") . PHP_EOL;
// Outputs "Mountain View, CA"
echo $geocoder->getDescriptionForNumber($usNumberProto, "de_DE") . PHP_EOL;
// Outputs "미국" (Korean for United States)
echo $geocoder->getDescriptionForNumber($usNumberProto, "ko-KR") . PHP_EOL;

// Outputs "Manchester"
echo $geocoder->getDescriptionForNumber($gbNumberProto, "en_GB") . PHP_EOL;
// Outputs "영국" (Korean for United Kingdom)
echo $geocoder->getDescriptionForNumber($gbNumberProto, "ko-KR") . PHP_EOL;
```

### Mapping Phone Numbers to carrier

```php

$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
$swissNumberProto = $phoneUtil->parse("798765432", "CH");

$carrierMapper = \libphonenumber\PhoneNumberToCarrierMapper::getInstance();
// Outputs "Swisscom"
echo $carrierMapper->getDescriptionForNumber($swissNumberProto, "en");
```

## Generating data

Data can be generated using phing, running the 'compile' target.