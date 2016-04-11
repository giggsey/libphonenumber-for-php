# PhoneNumberToCarrierMapper

The Phone Number Carrier Mapper requires the PHP [intl](http://php.net/intl) extension.

## Getting Started

As with [PhoneNumberUtil](PhoneNumberUtil.md), the Phone Number Carrier Mapper uses a singleton.

```php
$carrierMapper = \libphonenumber\PhoneNumberToCarrierMapper::getInstance();
```

## `getNameForNumber()`

Returns the name of the carrier for the supplied `PhoneNumber` object within the `$language` supplied.

```php
$chNumber = \libphonenumber\PhoneNumberUtil::getInstance()->parse("798765432", "CH");

var_dump($carrierMapper->getNameForNumber($chNumber, 'en'));
// string(8) "Swisscom"
```

## `getNameForValidNumber()`

Returns the same as `getNameForNumber()` without checking whether it is a valid number for carrier mapping.

## `getSafeDisplayName()`

Returns the same as `getNameForNumber()`, but only if the number is safe for carrier mapping. A number is only validate for carrier mapping if it's a Mobile or Fixed line, and the country does not support Mobile Number Portability.
