<?php
use com\google\i18n\phonenumbers\PhoneNumberUtil;
use com\google\i18n\phonenumbers\PhoneNumber;

require_once 'PhoneNumberUtil.php';

$swissNumberStr = "044 668 18 00";
$phoneUtil = PhoneNumberUtil::getInstance();
try {
	$swissNumberProto = $phoneUtil->parse($swissNumberStr, "CH");
	var_dump($swissNumberProto);
} catch (NumberParseException $e) {
	echo $e;
}
$isValid = $phoneUtil->isValidNumber($swissNumberProto);//return true
var_dump($isValid);
// Produces "+41446681800"
echo $phoneUtil->format($swissNumberProto, PhoneNumberFormat::E164) . PHP_EOL;