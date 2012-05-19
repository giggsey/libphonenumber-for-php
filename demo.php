<?php
namespace libphonenumber;

require_once dirname(__FILE__) . '/PhoneNumberUtil.php';
require_once dirname(__FILE__) . '/CountryCodeToRegionCodeMap.php';
require_once dirname(__FILE__) . '/PhoneNumber.php';
require_once dirname(__FILE__) . '/PhoneMetadata.php';
require_once dirname(__FILE__) . '/PhoneNumberDesc.php';
require_once dirname(__FILE__) . '/NumberFormat.php';
require_once dirname(__FILE__) . '/Matcher.php';
require_once dirname(__FILE__) . '/CountryCodeSource.php';
require_once dirname(__FILE__) . '/PhoneNumberType.php';
require_once dirname(__FILE__) . '/PhoneNumberFormat.php';

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