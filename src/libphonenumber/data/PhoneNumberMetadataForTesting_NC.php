<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[2-47-9]\\d{5}',
    'PossibleNumberPattern' => '\\d{6}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2[03-9]|
            3[0-5]|
            4[1-7]|
            88
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{6}',
    'ExampleNumber' => '201234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            [79]\\d|
            8[0-79]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{6}',
    'ExampleNumber' => '751234',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '36\\d{4}',
    'PossibleNumberPattern' => '\\d{6}',
    'ExampleNumber' => '366711',
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
    'NationalNumberPattern' => '1[5-8]',
    'PossibleNumberPattern' => '\\d{2}',
    'ExampleNumber' => '15',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'NC',
  'countryCode' => 687,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})',
      'format' => '$1.$2.$3',
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