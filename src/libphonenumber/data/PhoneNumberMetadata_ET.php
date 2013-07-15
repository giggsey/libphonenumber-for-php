<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-59]\\d{8}',
    'PossibleNumberPattern' => '\\d{7,9}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            11(?:
              1(?:
                1[124]|
                2[2-57]|
                3[1-5]|
                5[5-8]|
                8[6-8]
              )|
              2(?:
                13|
                3[6-8]|
                5[89]|
                7[05-9]|
                8[2-6]
              )|
              3(?:
                2[01]|
                3[0-289]|
                4[1289]|
                7[1-4]|
                87
              )|
              4(?:
                1[69]|
                3[2-49]|
                4[0-3]|
                6[5-8]
              )|
              5(?:
                1[57]|
                44|
                5[0-4]
              )|
              6(?:
                18|
                2[69]|
                4[5-7]|
                5[1-5]|
                6[0-59]|
                8[015-8]
              )
            )|
            2(?:
              2(?:
                11[1-9]|
                22[0-7]|
                33\\d|
                44[1467]|
                66[1-68]
              )|
              5(?:
                11[124-6]|
                33[2-8]|
                44[1467]|
                55[14]|
                66[1-3679]|
                77[124-79]|
                880
              )
            )|
            3(?:
              3(?:
                11[0-46-8]|
                22[0-6]|
                33[0134689]|
                44[04]|
                55[0-6]|
                66[01467]
              )|
              4(?:
                44[0-8]|
                55[0-69]|
                66[0-3]|
                77[1-5]
              )
            )|
            4(?:
              6(?:
                22[0-24-7]|
                33[1-5]|
                44[13-69]|
                55[14-689]|
                660|
                88[1-4]
              )|
              7(?:
                11[1-9]|
                22[1-9]|
                33[13-7]|
                44[13-6]|
                55[1-689]
              )
            )|
            5(?:
              7(?:
                227|
                55[05]|
                (?:
                  66|
                  77
                )[14-8]
              )|
              8(?:
                11[149]|
                22[013-79]|
                33[0-68]|
                44[013-8]|
                550|
                66[1-5]|
                77\\d
              )
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7,9}',
    'ExampleNumber' => '111112345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          9(?:
            [1-3]\\d|
            5[89]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '911234567',
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
    'NationalNumberPattern' => '
          9(?:
            11?|
            [23]|
            9[17]
          )
        ',
    'PossibleNumberPattern' => '\\d{2,3}',
    'ExampleNumber' => '991',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'ET',
  'countryCode' => 251,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([1-59]\\d)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
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