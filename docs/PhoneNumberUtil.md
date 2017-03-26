# PhoneNumberUtil

## Basic Usage

### `parse()`

Returns a `PhoneNumber` object version of the `$number`  supplied with the `$region` code.

If the number is passed in an international format (e.g. `+44 117 496 0123`), then the region code is not needed, and can be `null`. Failing that, the library will use the region code to work out the phone number based on rules loaded for that region. 

```php
$phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();

$phoneNumberObject = $phoneNumberUtil->parse('0117 496 0123', 'GB');
$phoneNumberObject = $phoneNumberUtil->parse('+44 117 496 0123', null);
$phoneNumberObject = $phoneNumberUtil->parse('00 44 117 496 0123', 'FR');
$phoneNumberObject = $phoneNumberUtil->parse('117 496 0123', 'GB');
```

All the above examples return the same `$phoneNumberObject`, which contains:

```
object(libphonenumber\PhoneNumber)#31 (9) {
  ["countryCode":"libphonenumber\PhoneNumber":private]=>
  int(44)
  ["nationalNumber":"libphonenumber\PhoneNumber":private]=>
  string(10) "1174960123"
  ["extension":"libphonenumber\PhoneNumber":private]=>
  NULL
  ["italianLeadingZero":"libphonenumber\PhoneNumber":private]=>
  NULL
  ["rawInput":"libphonenumber\PhoneNumber":private]=>
  NULL
  ["countryCodeSource":"libphonenumber\PhoneNumber":private]=>
  NULL
  ["preferredDomesticCarrierCode":"libphonenumber\PhoneNumber":private]=>
  NULL
  ["hasNumberOfLeadingZeros":"libphonenumber\PhoneNumber":private]=>
  bool(false)
  ["numberOfLeadingZeros":"libphonenumber\PhoneNumber":private]=>
  int(1)
}
```

A `NumberParseException` will be thrown if it is unable to obtain a viable number. For example, if the number is too short/long, or the region is invalid. This does not tell you whether the number is valid or not. In order to determine whether the number is valid, it needs to be checked in the validation functions.

The returned `PhoneNumber` object is used with other functions to provide additional information.

## Phone Number Information

### `getRegionCodeForNumber()`

Returns the region code for the `PhoneNumber` object you pass.

```php
var_dump($phoneNumberUtil->getRegionCodeForNumber($phoneNumberObject));
// string(2) "GB"
```

### `getNumberType()`

Returns a `PhoneNumberType` constant for the `PhoneNumber` object you pass.

```php
var_dump($phoneNumberUtil->getNumberType($phoneNumberObject));
// int(0) (PhoneNumberType::FIXED_LINE)
```

### `canBeInternationallyDialled()`

Returns a `boolean` whether the supplied `PhoneNumber` object can be dialled internationally.

```php
var_dump($phoneNumberUtil->canBeInternationallyDialled($phoneNumberObject));
// bool(true)

$australianPhoneNumberObject = $phoneNumberUtil->parse('1300123456', 'AU');

var_dump($phoneNumberUtil->canBeInternationallyDialled($australianPhoneNumberObject));
// bool(false)
```

## Validation

### `isPossibleNumber()`

Returns a `boolean` whether the supplied phone number is possible or not.

This function accepts either a `PhoneNumber` object, or a phone number string and a region code (as with `parse()`).

```php
var_dump($phoneNumberUtil->isPossibleNumber($phoneNumberObject));
// bool(true)

var_dump($phoneNumberUtil->isPossibleNumber('01174960123', 'GB'));
// bool(true)
```

### `isPossibleNumberWithReason()`

Returns a `ValidationResult` constant with the result of whether the supplied `PhoneNumber` object is possible.

```php
var_dump($phoneNumberUtil->isPossibleNumberWithReason($phoneNumberObject));
// int(0) (ValidationResult::IS_POSSIBLE)
```

### `isPossibleNumberForTypeWithReason()`

Returns a `ValidationResult` constant with the result of whether the supplied `PhoneNumber` object is a possible number of a particular `PhoneNumberType` type.

```php
var_dump($phoneNumberUtil->isPossibleNumberForTypeWithReason($phoneNumberObject, PhoneNumberType::FIXED_LINE));
// int(0) (ValidationResult::IS_POSSIBLE)
```

### `isValidNumber()`

Returns a `boolean` whether the supplied `PhoneNumber` object is valid or not.

**Important:** This doesn't actually validate whether the number is in use. libphonenumber-for-php is only able to validate number patterns, and isn't able to check with telecommunication providers.

```php
var_dump($phoneNumberUtil->isValidNumber($phoneNumberObject));
// bool(true)
```

### `isValidNumberForRegion()`

Returns a `boolean` whether the supplied `PhoneNumber` object is valid for the `$region`.

**Important:** As with `isValidNumber()`, this can not validate whether the number is in use.

```php
var_dump($phoneNumberUtil->isValidNumberForRegion($phoneNumberObject, 'FR'));
// bool(false)
```

## Formatting

## `format()`

Formats the supplied `PhoneNumber` object in the `PhoneNumberFormat` constant.

```php
var_dump($phoneNumberUtil->format($phoneNumberObject, PhoneNumberFormat::E164));
// string(13) "+441174960123"

var_dump($phoneNumberUtil->format($phoneNumberObject, PhoneNumberFormat::INTERNATIONAL));
// string(16) "+44 117 496 0123"

var_dump($phoneNumberUtil->format($phoneNumberObject, PhoneNumberFormat::NATIONAL));
// string(13) "0117 496 0123"

var_dump($phoneNumberUtil->format($phoneNumberObject, PhoneNumberFormat::RFC3966));
// string(20) "tel:+44-117-496-0123"
```

### `formatOutOfCountryCallingNumber()`

Formats the supplied `PhoneNumber` object based on the `$regionCallingFrom`.

```php
var_dump($phoneNumberUtil->formatOutOfCountryCallingNumber($phoneNumberObject, 'FR'));
// string(18) "00 44 117 496 0123"

var_dump($phoneNumberUtil->formatOutOfCountryCallingNumber($phoneNumberObject, 'US'));
// string(19) "011 44 117 496 0123"

var_dump($phoneNumberUtil->formatOutOfCountryCallingNumber($phoneNumberObject, 'GB'));
// string(13) "0117 496 0123"
```

### `formatNumberForMobileDialing()`

Formats the supplied `PhoneNumber` object in a way that it can be dialled from the `$regionCallingFrom`. It's third parameter determines whether there is any formatting applied to the number.

```php
$australianPhoneNumberObject = $phoneNumberUtil->parse('1300123456', 'AU');

var_dump($phoneNumberUtil->formatNumberForMobileDialing($australianPhoneNumberObject, 'AU', true));
// string(12) "1300 123 456"

var_dump($phoneNumberUtil->formatNumberForMobileDialing($australianPhoneNumberObject, 'AU', false));
// string(10) "1300123456"

var_dump($phoneNumberUtil->formatNumberForMobileDialing($australianPhoneNumberObject, 'US', true));
// string(0) ""
```

If the number can not be dialled from the region supplied, then an empty string is returned.

## Example Numbers

### `getExampleNumber()`

Returns an example `PhoneNumber` object for the `$regionCode` supplied.

```php
var_dump($phoneNumberUtil->getExampleNumber('GB'));
// (PhoneNumber) Country Code: 44 National Number: 1212345678 ... 
```

### `getExampleNumberForType()`

Returns an example `PhoneNumber` object for the `$regionCode` supplied of the `PhoneNumberType`.

This also accepts the first parameter being a `PhoneNumberType`, where it will return a valid number
for the specified number type from any country. Just leave the second parameter as null.

```php
var_dump($phoneNumberUtil->getExampleNumberForType('GB', PhoneNumberType::MOBILE));
// (PhoneNumber) Country Code: 44 National Number: 7400123456 ...

var_dump($phoneNumberUtil->getExampleNumberForType(PhoneNumberType::MOBILE));
// (PhoneNumber) Country Code: 1 National Number: 2015555555 ...
```

### `getInvalidExampleNumber()`

Returns an example invalid `PhoneNumber` object for the `$regionCode` supplied.

This can be useful for unit testing, where you want to test with an invalid number.
The number returned will be able to be parsed. It may also be a valid short number
for the region.

```php
var_dump($phoneNumberUtil->getInvalidExampleNumber('GB'));
// (PhoneNumber) Country Code: 44 National Number: 121234567 ...
```

