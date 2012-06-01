<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [12]\\d{7,9}|
          [57-9]\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          [12](?:
            1\\d|
            2(?:
              [1-3]\\d?|
              7\\d
            )|
            3[2-8]\\d{1,2}|
            4[2-68]\\d{1,2}|
            5[1-4689]\\d{1,2}
          )\\d{5}|
          5[0568]\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '50123456',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            8[89]|
            9[013-9]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '88123456',
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
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'MN',
  'countryCode' => 976,
  'internationalPrefix' => '001',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([12]\\d)(\\d{2})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[12]1',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([12]2\\d)(\\d{5,6})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[12]2[1-3]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '([12]\\d{3})(\\d{5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [12](?:
              27|
              [3-5]
            )
          ',
        1 => '
            [12](?:
              27|
              [3-5]\\d
            )2
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(\\d{4})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[57-9]',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '([12]\\d{4})(\\d{4,5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [12](?:
              27|
              [3-5]
            )
          ',
        1 => '
            [12](?:
              27|
              [3-5]\\d
            )[4-9]
          ',
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