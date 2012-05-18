<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          (?:
            [13]\\d{0,3}|
            [24-8]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{7,11}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '[124-8][2-9]\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '12345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          3(?:
            0[0-24]|
            1[0-8]|
            2[01]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '3211234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '1800\\d{7}',
    'PossibleNumberPattern' => '\\d{11}',
    'ExampleNumber' => '18001234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          19(?:
            0[01]|
            4[78]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{11}',
    'ExampleNumber' => '19001234567',
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
  'id' => 'CO',
  'countryCode' => 57,
  'internationalPrefix' => '00[579]|#555|#999',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0([3579]|4(?:44|56))?',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d)(\\d{7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              8[2-9]|
              9[0-3]|
              [2-7]
            )|
            [24-8]
          ',
        1 => '
            1(?:
              8[2-9]|
              9(?:
                09|
                [1-3]
              )|
              [2-7]
            )|
            [24-8]
          ',
      ),
      'nationalPrefixFormattingRule' => '($1)',
      'domesticCarrierCodeFormattingRule' => '0$CC $1',
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '3',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '0$CC $1',
    ),
    2 => 
    array (
      'pattern' => '(1)(\\d{3})(\\d{7})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              80|
              9[04]
            )
          ',
        1 => '
            1(?:
              800|
              9(?:
                0[01]|
                4[78]
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d)(\\d{7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              8[2-9]|
              9[0-3]|
              [2-7]
            )|
            [24-8]
          ',
        1 => '
            1(?:
              8[2-9]|
              9(?:
                09|
                [1-3]
              )|
              [2-7]
            )|
            [24-8]
          ',
      ),
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '3',
      ),
    ),
    2 => 
    array (
      'pattern' => '(1)(\\d{3})(\\d{7})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              80|
              9[04]
            )
          ',
        1 => '
            1(?:
              800|
              9(?:
                0[01]|
                4[78]
              )
            )
          ',
      ),
    ),
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);