# libphonenumber for PHP [![Build Status](https://travis-ci.org/giggsey/libphonenumber-for-php.png?branch=master)](https://travis-ci.org/giggsey/libphonenumber-for-php)

## What is it?
A PHP library for parsing, formatting, storing and validating international phone numbers. This library is based on Google's [libphonenumber](https://code.google.com/p/libphonenumber/) and forked from a version by [Davide Mendolia](https://github.com/davideme/libphonenumber-for-PHP)


# Highlights of functionality
* Parsing/formatting/validating phone numbers for all countries/regions of the world.
* getNumberType - gets the type of the number based on the number itself; able to distinguish Fixed-line, Mobile, Toll-free, Premium Rate, Shared Cost, VoIP and Personal Numbers (whenever feasible).
* isNumberMatch - gets a confidence level on whether two numbers could be the same.
* getExampleNumber/getExampleNumberByType - provides valid example numbers for all countries/regions, with the option of specifying which type of example phone number is needed.
* isValidNumber - full validation of a phone number for a region using length and prefix information.

## Quick Examples
Let's say you have a string representing a phone number from Switzerland. This is how you parse/normalize it into a PhoneNumber object:

```php
$swissNumberStr = "044 668 18 00";
$phoneUtil = PhoneNumberUtil::getInstance();
try {
    $swissNumberProto = $phoneUtil->parse($swissNumberStr, "CH");
    var_dump($swissNumberProto);
} catch (NumberParseException $e) {
    echo $e;
}
```

At this point, swissNumberProto contains:

	object(libphonenumber\PhoneNumber)#221 (5) {
	  ["countryCode":"libphonenumber\PhoneNumber":private]=>
	  int(41)
	  ["nationalNumber":"libphonenumber\PhoneNumber":private]=>
	  int(446681800)
	  ["extension":"libphonenumber\PhoneNumber":private]=>
	  NULL
	  ["italianLeadingZero":"libphonenumber\PhoneNumber":private]=>
	  NULL
	  ["rawInput":"libphonenumber\PhoneNumber":private]=>
	  NULL
	}

Now let us validate whether the number is valid:

```php
$isValid = $phoneUtil->isValidNumber($swissNumberProto);//return true
var_dump($isValid);
```

There are a few formats supported by the formatting method, as illustrated below:

```php
// Produces "+41446681800"
echo $phoneUtil->format($swissNumberProto, PhoneNumberFormat::E164) . PHP_EOL;
```
