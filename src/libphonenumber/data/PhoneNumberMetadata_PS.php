<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [24589]\\d{7,8}|
          1(?:
            [78]\\d{8}|
            [49]\\d{2,3}
          )
        ',
    'PossibleNumberPattern' => '\\d{4,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            22[234789]|
            42[45]|
            82[01458]|
            92[369]
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '22234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '5[69]\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '599123456',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '1800\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1800123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            4|
            9\\d
           )\\d{2}
        ',
    'PossibleNumberPattern' => '\\d{4,5}',
    'ExampleNumber' => '19123',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '1700\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1700123456',
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
  'id' => 'PS',
  'countryCode' => 970,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([2489])(2\\d{2})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2489]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(5[69]\\d)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '5',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(1[78]00)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1[78]',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);