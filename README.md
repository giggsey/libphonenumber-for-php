# What is it?
PHP library for parsing, formatting, storing and validating international phone numbers.


# Highlights of functionality
* Parsing/formatting/validating phone numbers for all countries/regions of the world.
* getNumberType - gets the type of the number based on the number itself; able to distinguish Fixed-line, Mobile, Toll-free, Premium Rate, Shared Cost, VoIP and Personal Numbers (whenever feasible).
* isNumberMatch - gets a confidence level on whether two numbers could be the same.
* getExampleNumber/getExampleNumberByType - provides valid example numbers for all countries/regions, with the option of specifying which type of example phone number is needed.
* isValidNumber - full validation of a phone number for a region using length and prefix information.

# Quick Examples
Let's say you have a string representing a phone number from Switzerland. This is how you parse/normalize it into a PhoneNumber object:

	$swissNumberStr = "044 668 18 00";
	$phoneUtil = PhoneNumberUtil::getInstance();
	try {
		$swissNumberProto = $phoneUtil->parse($swissNumberStr, "CH");
		var_dump($swissNumberProto);
	} catch (NumberParseException $e) {
		echo $e;
	}

At this point, swissNumberProto contains:

	object(com\google\i18n\phonenumbers\PhoneNumber)#221 (5) {
	  ["countryCode":"com\google\i18n\phonenumbers\PhoneNumber":private]=>
	  int(41)
	  ["nationalNumber":"com\google\i18n\phonenumbers\PhoneNumber":private]=>
	  int(446681800)
	  ["extension":"com\google\i18n\phonenumbers\PhoneNumber":private]=>
	  NULL
	  ["italianLeadingZero":"com\google\i18n\phonenumbers\PhoneNumber":private]=>
	  NULL
	  ["rawInput":"com\google\i18n\phonenumbers\PhoneNumber":private]=>
	  NULL
	}

Now let us validate whether the number is valid:

	$isValid = $phoneUtil->isValidNumber($swissNumberProto);//return true
	var_dump($isValid);

There are a few formats supported by the formatting method, as illustrated below:

	// Produces "+41446681800"
	echo $phoneUtil->format($swissNumberProto, PhoneNumberFormat::E164) . PHP_EOL;