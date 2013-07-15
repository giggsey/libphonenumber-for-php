<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[25-9]\\d{6}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          5(?:
            2\\d|
            8[1-9]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '5212345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            5(?:
              6\\d|
              9[2-478]
            )|
            6(?:
              [039]0|
              22|
              4[01]|
              6[0-2]
            )|
            7[34]\\d|
            9(?:
              6[45]|
              9[4-8]
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '5601234',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{4}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '8001234',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '900\\d{4}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '9001234',
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
          28\\d{5}|
          501\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '5011234',
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
          100|
          911
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '911',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'AW',
  'countryCode' => 297,
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