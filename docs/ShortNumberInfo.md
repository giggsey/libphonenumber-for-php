# ShortNumberInfo

## Getting Started

As with [PhoneNumberUtil](PhoneNumberUtil.md), ShortNumberInfo uses a singleton.

```php
$shortNumberUtil = \libphonenumber\ShortNumberInfo::getInstance();
```

## Example Numbers

### `getExampleShortNumber()`

Returns an example short phone number for the `$regionCode` supplied

```php
var_dump($shortNumberUtil->getExampleShortNumber('GB'));
// string(3) "150"
```

### `getExampleShortNumberForCost()`

Returns a valid short number for the specified `$regionCode` and `$cost` category.

```php
var_dump($shortNumberUtil->getExampleShortNumberForCost('GB', \libphonenumber\ShortNumberCost::TOLL_FREE));
// string(6) "116000"

var_dump($shortNumberUtil->getExampleShortNumberForCost('GB', \libphonenumber\ShortNumberCost::PREMIUM_RATE));
// string(0) ""

var_dump($shortNumberUtil->getExampleShortNumberForCost('US', \libphonenumber\ShortNumberCost::PREMIUM_RATE));
// string(5) "24280"
```

## Emergency Numbers

### `isEmergencyNumber()`

Returns whether the supplied `$number` exactly matches an emergency service number for the `$region`.

```php
var_dump($shortNumberUtil->isEmergencyNumber('999', 'GB'));
// bool(true)

var_dump($shortNumberUtil->isEmergencyNumber('9999', 'GB'));
// bool(false)
```

### `connectsToEmergencyNumber()`

Checks whether the `$number` (when dialled) might connect to an emergency service within the given `$region`.

```php
var_dump($shortNumberUtil->connectsToEmergencyNumber('999', 'GB'));
// bool(true)

// Note, 999 is a GB emergency service, but additional digits after the 999
// might be possible to dial.
var_dump($shortNumberUtil->connectsToEmergencyNumber('999123', 'GB'));
// bool(true)
```

## Short Number Validation

### `isPossibleShortNumber()`

Checks whether the specified `PhoneNumber` object is a possible short number.

```php
$phoneNumber = new \libphonenumber\PhoneNumber();
$phoneNumber->setCountryCode(44);
$phoneNumber->setNationalNumber(118118);

var_dump($shortNumberUtil->isPossibleShortNumber($phoneNumber));
// bool(true)
```

### `isPossibleShortNumberForRegion()`

Checks whether the supplied `$shortNumber` (which can either be a string or a `PhoneNumber` object) is possible for the `$region`.

```php

$phoneNumber = new \libphonenumber\PhoneNumber();
$phoneNumber->setCountryCode(44);
$phoneNumber->setNationalNumber(118118);

var_dump($shortNumberUtil->isPossibleShortNumberForRegion($phoneNumber, 'GB'));
// bool(true)

var_dump($shortNumberUtil->isPossibleShortNumberForRegion('1234', 'GB'));
// bool(true)
```

### `isValidShortNumber()`

Checks whether the specified `PhoneNumber` object is a valid short number.

**Important:** This doesn't actually validate whether the number is in use. libphonenumber-for-php is only able to validate number patterns, and isn't able to check with telecommunication providers.

```php
$phoneNumber = new \libphonenumber\PhoneNumber();
$phoneNumber->setCountryCode(44);
$phoneNumber->setNationalNumber(118118);

var_dump($shortNumberUtil->isValidShortNumber($phoneNumber));
// bool(true)
```

### `isValidShortNumberForRegion()`

Checks whether the supplied `$shortNumber` (which can either be a string or a `PhoneNumber` object) is valid for the `$region`.

**Important:** As with `isValidShortNumber()`, this can not validate whether the number is actually in use.

```php
$phoneNumber = new \libphonenumber\PhoneNumber();
$phoneNumber->setCountryCode(44);
$phoneNumber->setNationalNumber(118118);

var_dump($shortNumberUtil->isValidShortNumberForRegion($phoneNumber, 'GB'));
// bool(true)

var_dump($shortNumberUtil->isValidShortNumberForRegion('1234', 'GB'));
// bool(false)
```

### `isCarrierSpecific()`

Returns whether the supplied `PhoneNumber` is a carrier specific short number.

```php
$phoneNumber = new \libphonenumber\PhoneNumber();
$phoneNumber->setCountryCode(1);
$phoneNumber->setNationalNumber(611);

var_dump($shortNumberUtil->isCarrierSpecific($phoneNumber));
// (bool) true
```

### `isCarrierSpecificForRegion()`

Returns whether the supplied `PhoneNumber` is a carrier specific short number in the `$region` provided.

```php
$phoneNumber = new \libphonenumber\PhoneNumber();
$phoneNumber->setCountryCode(1);
$phoneNumber->setNationalNumber(611);

var_dump($shortNumberUtil->isCarrierSpecificForRegion($phoneNumber, 'US'));
// (bool) true
```

## Expected Costs

### `getExpectedCost()`

Returns the expected cost (as a `ShortNumberCost` constant) of the supplied `PhoneNumber` short number.

```php
$phoneNumber = new \libphonenumber\PhoneNumber();
$phoneNumber->setCountryCode(44);
$phoneNumber->setNationalNumber(118118);

var_dump($shortNumberUtil->getExpectedCost($phoneNumber, 'GB'));
// int(10) (ShortNumberCost::UNKNOWN_COST)
```

### `getExpectedCostForRegion()`

Returns the expected cost (as a `ShortNumberCost` constant) of the supplied `$number` (which can be a string or a `PhoneNumber` object).

```php
$phoneNumber = new \libphonenumber\PhoneNumber();
$phoneNumber->setCountryCode(44);
$phoneNumber->setNationalNumber(118118);

var_dump($shortNumberUtil->getExpectedCostForRegion($phoneNumber, 'GB'));
// int(10) (ShortNumberCost::UNKNOWN_COST)

var_dump($shortNumberUtil->getExpectedCostForRegion('24280', 'US'));
// int(4) (ShortNumberCost::PREMIUM_RATE)
```
