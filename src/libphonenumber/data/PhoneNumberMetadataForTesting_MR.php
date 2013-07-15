<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[2-48]\\d{7}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          25[08]\\d{5}|
          35\\d{6}|
          45[1-7]\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '35123456',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2(?:
              2\\d|
              70
            )|
            3(?:
              3\\d|
              6[1-36]|
              7[1-3]
            )|
            4(?:
              4\\d|
              6[0457-9]|
              7[4-9]
            )
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '22123456',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80012345',
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
    'NationalNumberPattern' => '1[78]',
    'PossibleNumberPattern' => '\\d{2}',
    'ExampleNumber' => '17',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'MR',
  'countryCode' => 222,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([2-48]\\d)(\\d{2})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
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