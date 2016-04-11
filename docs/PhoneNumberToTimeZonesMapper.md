# PhoneNumberToTimeZonesMapper

## Getting Started

As with [PhoneNumberUtil](PhoneNumberUtil.md), the Phone Number Timezone Mapper uses a singleton.

```php
$timezoneMapper = \libphonenumber\PhoneNumberToTimeZonesMapper::getInstance();
```

## `getTimeZonesForNumber()`

Returns an array of timezones for which the `PhoneNumber` object supplied belongs in.

```php
$usNumber = \libphonenumber\PhoneNumberUtil::getInstance()->parse("+1 650 253 0000", "US");

var_dump($timezoneMapper->getTimeZonesForNumber($usNumber));
// array(1) { [0]=> string(19) "America/Los_Angeles" }

/*
 * A US Toll Free number is not geographically tied to any location, so could be in any US timezone
 */
$usNumber = \libphonenumber\PhoneNumberUtil::getInstance()->parse("+1 800 253 0000", "US");

var_dump($timezoneMapper->getTimeZonesForNumber($usNumber));
// array(35) { [0]=> string(16) "America/Anguilla" [1]=> string(15) "America/Antigua" [2]=> string(16) "America/Barbados" [3]=> string(14) "America/Cayman" [4]=> string(15) "America/Chicago" [5]=> string(14) "America/Denver" [6]=> string(16) "America/Dominica" [7]=> string(16) "America/Edmonton" [8]=> string(18) "America/Grand_Turk" [9]=> string(15) "America/Grenada" [10]=> string(15) "America/Halifax" [11]=> string(15) "America/Jamaica" [12]=> string(14) "America/Juneau" [13]=> string(19) "America/Los_Angeles" [14]=> string(21) "America/Lower_Princes" [15]=> string(18) "America/Montserrat" [16]=> string(14) "America/Nassau" [17]=> string(16) "America/New_York" [18]=> string(21) "America/Port_of_Spain" [19]=> string(19) "America/Puerto_Rico" [20]=> string(21) "America/Santo_Domingo" [21]=> string(16) "America/St_Johns" [22]=> string(16) "America/St_Kitts" [23]=> string(16) "America/St_Lucia" [24]=> string(17) "America/St_Thomas" [25]=> string(18) "America/St_Vincent" [26]=> string(15) "America/Toronto" [27]=> string(15) "America/Tortola" [28]=> string(17) "America/Vancouver" [29]=> string(16) "America/Winnipeg" [30]=> string(16) "Atlantic/Bermuda" [31]=> string(12) "Pacific/Guam" [32]=> string(16) "Pacific/Honolulu" [33]=> string(17) "Pacific/Pago_Pago" [34]=> string(14) "Pacific/Saipan" }
```


