<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-9]\\d{7,9}',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2[3-6]|
            3[2-6]|
            4[2-4]|
            [567][2-5]
          )(?:
            [2-46-9]|
            5\\d
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{6,9}',
    'ExampleNumber' => '23456789',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            (?:
              1\\d|
              [67][06-9]
            )[1-9]|
            8(?:
              0[89]|
              [134679]\\d|
              5[2-689]|
              8\\d{2}
            )|
            9(?:
              [0-689][1-9]|
              7[1-9]\\d?
            )
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{8,9}',
    'ExampleNumber' => '91234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          1800(?:
            1\\d|
            2[019]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1800123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          1900(?:
            1\\d|
            2[09]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1900123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'KH',
  'countryCode' => 855,
  'internationalPrefix' => '00[14-9]',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1\\d[1-9]|
            [2-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(1[89]00)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1[89]0',
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