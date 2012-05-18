<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          1\\d{4,11}|
          [2-9]\\d{4,10}
        ',
    'PossibleNumberPattern' => '\\d{5,12}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            [3569][1-8]\\d{3,9}|
            [47]\\d{5,10}
          )|
          2[1-8]\\d{3,9}|
          3(?:
            [1-8]\\d{3,9}|
            9\\d{4,8}
          )|
          [5689][1-8]\\d{3,9}
        ',
    'PossibleNumberPattern' => '\\d{5,12}',
    'ExampleNumber' => '1312345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          4\\d{5,10}|
          50\\d{4,8}
        ',
    'PossibleNumberPattern' => '\\d{6,11}',
    'ExampleNumber' => '412345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{4,7}',
    'PossibleNumberPattern' => '\\d{7,10}',
    'ExampleNumber' => '8001234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '[67]00\\d{5,6}',
    'PossibleNumberPattern' => '\\d{8,9}',
    'ExampleNumber' => '600123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '
          [13]00\\d{3,7}|
          2(?:
            0(?:
              0\\d{3,7}|
              2[023]\\d{1,6}|
              9[89]\\d{1,6}
            )
          )|
          60(?:
            [12]\\d{5,6}|
            6\\d{7}
          )|
          7(?:
            1\\d{7}|
            3\\d{8}|
            5[03-9]\\d{2,7}
          )
        ',
    'PossibleNumberPattern' => '\\d{5,10}',
    'ExampleNumber' => '100123',
  ),
  'id' => 'FI',
  'countryCode' => 358,
  'internationalPrefix' => '00|99[049]',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{3,7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            (?:
              [1-3]00|
              [6-8]0
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{4,10})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2[09]|
            [14]|
            50|
            7[135]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d)(\\d{4,11})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [25689][1-8]|
            3
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => true,
  'leadingZeroPossible' => NULL,
);