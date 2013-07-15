<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[589]\\d{9}',
    'PossibleNumberPattern' => '\\d{7}(?:\\d{3})?',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            [04]9[2-9]\\d{6}|
            29(?:
              2(?:
                [0-59]\\d|
                6[04-9]|
                7[0-27]|
                8[0237-9]
              )|
              3(?:
                [0-35-9]\\d|
                4[7-9]
              )|
              [45]\\d{2}|
              6(?:
                [0-27-9]\\d|
                [3-5][1-9]|
                6[0135-8]
              )|
              7(?:
                0[013-9]|
                [1-37]\\d|
                4[1-35689]|
                5[1-4689]|
                6[1-57-9]|
                8[1-79]|
                9[1-8]
              )|
              8(?:
                0[146-9]|
                1[0-48]|
                [248]\\d|
                3[1-79]|
                5[01589]|
                6[013-68]|
                7[124-8]|
                9[0-8]
              )|
              9(?:
                [0-24]\\d|
                3[02-46-9]|
                5[0-79]|
                60|
                7[0169]|
                8[57-9]|
                9[02-9]
              )
            )\\d{4}
          )
        ',
    'PossibleNumberPattern' => '\\d{7}(?:\\d{3})?',
    'ExampleNumber' => '8092345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '8[024]9[2-9]\\d{6}',
    'PossibleNumberPattern' => '\\d{7}(?:\\d{3})?',
    'ExampleNumber' => '8092345678',
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
    'NationalNumberPattern' => '
          112|
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
  'id' => 'DO',
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
  'leadingDigits' => '8[024]9',
  'leadingZeroPossible' => NULL,
);