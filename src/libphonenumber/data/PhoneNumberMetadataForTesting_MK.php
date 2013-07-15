<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[2-578]\\d{7}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2(?:
              [23]\\d|
              5[124578]|
              6[01]
            )|
            3(?:
              1[3-6]|
              [23][2-6]|
              4[2356]
            )|
            4(?:
              [23][2-6]|
              4[3-6]|
              5[256]|
              6[25-8]|
              7[24-6]|
              8[4-6]
            )
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{6,8}',
    'ExampleNumber' => '22212345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          7(?:
            [0-25-8]\\d|
            33
          )\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '72345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80012345',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '5[02-9]\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '50012345',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            0[1-9]|
            [1-9]\\d
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80123456',
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
    'NationalNumberPattern' => '
          1(?:
            12|
            9[234]
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
  'id' => 'MK',
  'countryCode' => 389,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(2)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '2',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([347]\\d)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[347]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '([58]\\d{2})(\\d)(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '[58]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);