<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[135789]\\d{6,9}',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '1624\\d{6}',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '1624456789',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '7[569]24\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '7924123456',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '808162\\d{4}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8081624567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          (?:
            872299|
            90[0167]624
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '9016247890',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            4(?:
              40[49]06|
              5624\\d
            )|
            70624\\d
          )\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8456247890',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '70\\d{8}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '7012345678',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '56\\d{8}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '5612345678',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'uan' => 
  array (
    'NationalNumberPattern' => '
          3(?:
            08162\\d|
            3\\d{5}|
            4(?:
              40[49]06|
              5624\\d
            )|
            7(?:
              0624\\d|
              2299\\d
            )
          )\\d{3}|
          55\\d{8}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '5512345678',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '999',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '999',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'IM',
  'countryCode' => 44,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'preferredExtnPrefix' => ' x',
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