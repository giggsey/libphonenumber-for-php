<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[56]\\d{8}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          590(?:
            10|
            2[79]|
            5[128]|
            [78]7
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '590271234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          690(?:
            10|
            2[27]|
            66|
            77|
            8[78]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '690221234',
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
    'NationalNumberPattern' => '1[578]',
    'PossibleNumberPattern' => '\\d{2}',
    'ExampleNumber' => '18',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'MF',
  'countryCode' => 590,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
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