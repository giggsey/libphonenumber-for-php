<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[347]\\d{6}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            318[023]|
            416[0239]|
            7(?:
              1[578]|
              50
            )\\d
          )\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '7151234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            318[1456]|
            416[15-8]|
            7(?:
              0[01]|
              [89]\\d
            )\\d
          )\\d{3}|
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '3181234',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
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
    'NationalNumberPattern' => '
          112|
          911
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'BQ',
  'countryCode' => 599,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);