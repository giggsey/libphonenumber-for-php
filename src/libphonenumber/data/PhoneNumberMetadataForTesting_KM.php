<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[379]\\d{6}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          7(?:
            6[0-37-9]|
            7[0-57-9]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '7712345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '3[234]\\d{5}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '3212345',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          (?:
            39[01]|
            9[01]0
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '9001234',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'uan' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '1[78]',
    'PossibleNumberPattern' => '\\d{2}',
    'ExampleNumber' => '17',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'KM',
  'countryCode' => 269,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);