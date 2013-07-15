<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [1-79]\\d{8}|
          8(?:
            [067]\\d{7}|
            [1-4]\\d{3,7}
          )
        ',
    'PossibleNumberPattern' => '\\d{5,9}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1[0-8]|
            2[0-378]|
            3[1-69]|
            4\\d|
            5[1346-8]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '101234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            6[0-5]|
            7[0-46-9]
          )\\d{7}|
          8[1-4]\\d{3,7}
        ',
    'PossibleNumberPattern' => '\\d{5,9}',
    'ExampleNumber' => '711234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '801234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          86[2-9]\\d{6}|
          90\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '862345678',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '860\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '860123456',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '87\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '871234567',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'uan' => 
  array (
    'NationalNumberPattern' => '861\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '861123456',
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
            01(?:
              11|
              77
            )|
            12
          )
        ',
    'PossibleNumberPattern' => '\\d{3,5}',
    'ExampleNumber' => '10111',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'ZA',
  'countryCode' => 27,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(860)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '860',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [1-79]|
            8(?:
              [0-47]|
              6[1-9]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{2})(\\d{3,4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '8[1-4]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})(\\d{2,3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '8[1-4]',
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