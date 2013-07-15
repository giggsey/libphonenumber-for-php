<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[257-9]\\d{7}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '2[2-6]\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '22345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '9[5-79]\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '96123456',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80001234',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '90[09]\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '90012345',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '80[1-9]\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80112345',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '700\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '70012345',
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
    'NationalNumberPattern' => '
          (?:
            50|
            77
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '77123456',
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
          1(?:
            12|
            99
          )
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
  'id' => 'CY',
  'countryCode' => 357,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{6})',
      'format' => '$1 $2',
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