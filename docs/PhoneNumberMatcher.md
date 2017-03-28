# Phone Number Matcher

A class that finds and extracts telephone numbers from text.

## Getting Started
A search instance can be created by using `PhoneNumberUtil::findNumbers()`

### PhoneNumberUtil::findNumbers()

Returns an instance of `PhoneNumberMatcher`, which can be iterated over (returning `PhoneNumberMatch` objects).

It searches the input `$text` for phone numbers, using the `$defaultRegion`. There are also optional parameters to set the phone number `$leniency` (look in [`Leniency`](src/Leniency.php) for possible values), and the `$maxTries` to search for the phone number.

```php
$phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();

$text = "Hi, can you ring me at 1430 on 0117 496 0123. Thanks!";

$phoneNumberMatcher = $phoneNumberUtil->findNumbers($text, 'GB');

foreach ($phoneNumberMatcher as $phoneNumberMatch) {
    var_dump($phoneNumberMatch->number());
}
// (PhoneNumber) Country Code: 44 National Number: 1174960123
```

