<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[2-46-9]\\d{8}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          2(?:
            [12]\\d|
            [35][1-689]|
            4[1-59]|
            6[1-35689]|
            7[1-9]|
            8[1-69]|
            9[1256]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '212345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          9(?:
            [136]\\d{2}|
            2[0-79]\\d|
            480
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '912345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80[02]\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '800123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          76(?:
            0[1-57]|
            1[2-47]|
            2[237]
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '760123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '
          80(?:
            8\\d|
            9[1579]
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '808123456',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '884[128]\\d{5}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '884123456',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '30\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '301234567',
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
          70(?:
            7\\d|
            8[17]
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '707123456',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '112',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'PT',
  'countryCode' => 351,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([2-46-9]\\d{2})(\\d{3})(\\d{3})',
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