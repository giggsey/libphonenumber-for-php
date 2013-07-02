<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[169]\\d{6,7}',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          9(?:
            [48]\\d{2}|
            50\\d|
            7(?:
              2[0-2]|
              [34]\\d|
              6[35-7]|
              77
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '94151234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          9(?:
            5(?:
              [1246]\\d|
              3[01]
            )|
            6(?:
              [1679]\\d|
              3[01]
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '95181234',
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
    'NationalNumberPattern' => '
          (?:
            10|
            69
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '1011234',
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
    'NationalNumberPattern' => '955\\d{5}',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '95581234',
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
  'id' => 'CW',
  'countryCode' => 599,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[13-7]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(9)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '9',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => true,
  'leadingZeroPossible' => NULL,
);