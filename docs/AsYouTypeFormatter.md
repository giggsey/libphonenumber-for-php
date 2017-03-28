# As You Type Formatter

Formats phone numbers as they are being inputted, one character at a time.

## Getting Started
An instance can be created by calling `PhoneNumberUtil::getAsYouTypeFormatter()`

### `getAsYouTypeFormatter()`

Pass a `$regionCode` parameter to set the default region to attempt to format the phone numbers.

```php
$phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();

$asYouTypeFormatter = $phoneNumberUtil->getAsYouTypeFormatter('GB');


$result = $asYouTypeFormatter->inputDigit('0');
var_dump($result);
// string(1) "0"

$result = $asYouTypeFormatter->inputDigit('1');
var_dump($result);
// string(2) "01"

$result = $asYouTypeFormatter->inputDigit('1');
var_dump($result);
// string(3) "011"

$result = $asYouTypeFormatter->inputDigit('7');
var_dump($result);
// string(4) "0117"

$result = $asYouTypeFormatter->inputDigit('4');
var_dump($result);
// string(6) "0117 4"

$result = $asYouTypeFormatter->inputDigit('9');
var_dump($result);
// string(7) "0117 49"

$result = $asYouTypeFormatter->inputDigit('6');
var_dump($result);
// string(8) "0117 496"

$result = $asYouTypeFormatter->inputDigit('0');
var_dump($result);
// string(10) "0117 496 0"

$result = $asYouTypeFormatter->inputDigit('1');
var_dump($result);
// string(11) "0117 496 01"

$result = $asYouTypeFormatter->inputDigit('2');
var_dump($result);
// string(11) "01174 96012"

$result = $asYouTypeFormatter->inputDigit('3');
var_dump($result);
// string(13) "0117 496 0123"
```
