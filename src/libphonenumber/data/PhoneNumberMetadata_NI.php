<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[128]\\d{7}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '2\\d{7}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '21234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '8\\d{7}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '81234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '1800\\d{4}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '18001234',
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
    'NationalNumberPattern' => '118',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '118',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'NI',
  'countryCode' => 505,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{4})(\\d{4})',
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