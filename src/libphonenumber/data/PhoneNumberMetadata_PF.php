<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [2-79]\\d{5}|
          8\\d{5,7}
        ',
    'PossibleNumberPattern' => '\\d{6}(?:\\d{2})?',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            4(?:
              [02-9]\\d|
              1[02-9]
            )|
            [5689]\\d{2}
          )\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{6}',
    'ExampleNumber' => '401234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            [27]\\d{2}|
            3[0-79]\\d|
            411|
            89\\d{3}
          )\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{6}(?:\\d{2})?',
    'ExampleNumber' => '212345',
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
    'ExampleNumber' => '15',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '44\\d{4}',
    'PossibleNumberPattern' => '\\d{6}',
    'ExampleNumber' => '441234',
  ),
  'id' => 'PF',
  'countryCode' => 689,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '89',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})',
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