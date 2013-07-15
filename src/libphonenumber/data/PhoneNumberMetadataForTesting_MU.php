<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[2-9]\\d{6}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2(?:
              [034789]\\d|
              1[0-7]|
              6[1-69]
            )|
            4(?:
              [013-8]\\d|
              2[4-7]
            )|
            [56]\\d{2}|
            8(?:
              14|
              3[129]
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '2012345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            25\\d|
            4(?:
              2[12389]|
              9\\d
            )|
            7\\d{2}|
            8(?:
              20|
              7[15-8]
            )|
            9[1-8]\\d
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '2512345',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80[012]\\d{4}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '8001234',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '30\\d{5}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '3012345',
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
    'NationalNumberPattern' => '
          3(?:
            20|
            9\\d
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '3201234',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => '
          2(?:
            1[89]|
            2\\d
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '2181234',
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
          11[45]|
          99\\d
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '999',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'MU',
  'countryCode' => 230,
  'internationalPrefix' => '0(?:[2-7]0|33)',
  'preferredInternationalPrefix' => '020',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([2-9]\\d{2})(\\d{4})',
      'format' => '$1 $2',
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