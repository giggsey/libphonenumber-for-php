<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[2589]\\d{9}',
    'PossibleNumberPattern' => '\\d{7}(?:\\d{3})?',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          268(?:
            4(?:
              6[0-38]|
              84
            )|
            56[0-2]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}(?:\\d{3})?',
    'ExampleNumber' => '2684601234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          268(?:
            464|
            7(?:
              2[0-9]|
              64|
              7[0-689]|
              8[02-68]
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '2684641234',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            00|
            55|
            66|
            77|
            88
          )[2-9]\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8002123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '900[2-9]\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '9002123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '
          5(?:
            00|
            33|
            44
          )[2-9]\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '5002345678',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '26848[01]\\d{4}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '2684801234',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => '26840[69]\\d{4}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '2684061234',
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
          9(?:
            11|
            99
          )
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
  'id' => 'AG',
  'countryCode' => 1,
  'internationalPrefix' => '011',
  'nationalPrefix' => '1',
  'nationalPrefixForParsing' => '1',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingDigits' => '268',
  'leadingZeroPossible' => NULL,
);