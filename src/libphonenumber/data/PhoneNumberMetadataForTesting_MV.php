<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [3467]\\d{6}|
          9(?:
            00\\d{7}|
            \\d{6}
          )
        ',
    'PossibleNumberPattern' => '\\d{7,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            3(?:
              0[01]|
              3[0-59]
            )|
            6(?:
              [567][02468]|
              8[024689]|
              90
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '6701234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            46[46]|
            7[3-9]\\d|
            9[6-9]\\d
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '7712345',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '900\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '9001234567',
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
    'NationalNumberPattern' => '781\\d{4}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '7812345',
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
            02|
            19
          )
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '102',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'MV',
  'countryCode' => 960,
  'internationalPrefix' => '0(?:0|19)',
  'preferredInternationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{4})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [3467]|
            9(?:
              [1-9]|
              0[1-9]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '900',
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