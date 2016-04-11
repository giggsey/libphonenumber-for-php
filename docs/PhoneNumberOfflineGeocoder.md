# PhoneNumberOfflineGeocoder

The Phone Number Geocoder requires the PHP [intl](http://php.net/intl) extension.

## Getting Started

As with [PhoneNumberUtil](PhoneNumberUtil.md), the Phone Number Geocoder uses a singleton.

```php
$geoCoder = \libphonenumber\geocoding\PhoneNumberOfflineGeocoder::getInstance();
```

## `getDescriptionForNumber()`

Returns a text description for the supplied `PhoneNumber` object, in the `$locale` language supplied.

The description returned might consist of the name of the country, or the name of the geographical area the phone number is from.

If `$userRegion` is supplied, it will also be taken into consideration. If the phone number is from the same region, only a lower-level description will be returned.

```php
$gbNumber = \libphonenumber\PhoneNumberUtil::getInstance()->parse('0161 496 0123', 'GB');

var_dump($geoCoder->getDescriptionForNumber($gbNumber, 'en'));
// string(10) "Manchester"

var_dump($geoCoder->getDescriptionForNumber($gbNumber, 'en_GB', 'GB'));
// string(10) "Manchester"

var_dump($geoCoder->getDescriptionForNumber($gbNumber, 'en_GB', 'US'));
// string(14) "United Kingdom"

var_dump($geoCoder->getDescriptionForNumber($gbNumber, 'ko-KR', 'US'));
// string(6) "영국" (Korean for United Kingdom)


$usNumber = \libphonenumber\PhoneNumberUtil::getInstance()->parse("+1 650 253 0000", "US");

var_dump($geoCoder->getDescriptionForNumber($usNumber, 'en'));
// string(10) "Mountain View, CA"

var_dump($geoCoder->getDescriptionForNumber($usNumber, 'en_GB', 'GB'));
// string(10) "United States"

var_dump($geoCoder->getDescriptionForNumber($usNumber, 'en_GB', 'US'));
// string(14) "Mountain View, CA"

var_dump($geoCoder->getDescriptionForNumber($usNumber, 'ko-KR', 'US'));
// string(6) "영국" (Korean for United States)
```

## `getDescriptionForValidNumber()`

Returns the same as `getDescriptionForNumber()`, but assumes that you have already checked whether the number is suitable for geolocation.
