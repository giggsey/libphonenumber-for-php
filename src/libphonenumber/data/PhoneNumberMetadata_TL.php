<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [2-489]\\d{6}|
          7\\d{6,7}
        ',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2[1-5]|
            3[1-9]|
            4[1-4]
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '2112345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '7[3-8]\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '77212345',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80\\d{5}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '8012345',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '90\\d{5}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '9012345',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '70\\d{5}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '7012345',
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
    'NationalNumberPattern' => '11[25]',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'TL',
  'countryCode' => 670,
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
        0 => '[2-489]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{4})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '7',
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