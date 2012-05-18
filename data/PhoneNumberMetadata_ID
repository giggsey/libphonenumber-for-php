<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-9]\\d{6,10}',
    'PossibleNumberPattern' => '\\d{5,11}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          2(?:
            1(?:
              [0-8]\\d{6,7}|
              9\\d{6}
            )|
            [24]\\d{7,8}
          )|
          (?:
            2(?:
              [35][1-4]|
              6[0-8]|
              7[1-6]|
              8\\d|
              9[1-8]
            )|
            3(?:
              1|
              2[1-578]|
              3[1-68]|
              4[1-3]|
              5[1-8]|
              6[1-3568]|
              7[0-46]|
              8\\d
            )|
            4(?:
              0[1-589]|
              1[01347-9]|
              2[0-36-8]|
              3[0-24-68]|
              5[1-378]|
              6[1-5]|
              7[134]|
              8[1245]
            )|
            5(?:
              1[1-35-9]|
              2[25-8]|
              3[1246-9]|
              4[1-3589]|
              5[1-46]|
              6[1-8]
            )|
            6(?:
              19?|
              [25]\\d|
              3[1-469]|
              4[1-6]
            )|
            7(?:
              1[1-46-9]|
              2[14-9]|
              [36]\\d|
              4[1-8]|
              5[1-9]|
              7[0-36-9]
            )|
            9(?:
              0[12]|
              1[013-8]|
              2[0-479]|
              5[125-8]|
              6[23679]|
              7[159]|
              8[01346]
            )
          )\\d{5,8}
        ',
    'PossibleNumberPattern' => '\\d{5,10}',
    'ExampleNumber' => '612345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2(?:
              1(?:
                3[145]|
                4[01]|
                5[1-469]|
                60|
                8[0359]|
                9\\d
              )|
              2(?:
                88|
                9[1256]
              )|
              3[1-4]9|
              4(?:
                36|
                91
              )|
              5(?:
                1[349]|
                [2-4]9
              )|
              6[0-7]9|
              7(?:
                [1-36]9|
                4[39]
              )|
              8[1-5]9|
              9[1-48]9
            )|
            3(?:
              19[1-3]|
              2[12]9|
              3[13]9|
              4(?:
                1[69]|
                39
              )|
              5[14]9|
              6(?:
                1[69]|
                2[89]
              )|
              709
            )|
            4[13]19|
            5(?:
              1(?:
                19|
                8[39]
              )|
              4[129]9|
              6[12]9
            )|
            6(?:
              19[12]|
              2(?:
                [23]9|
                77
              )
            )|
            7(?:
              1[13]9|
              2[15]9|
              419|
              5(?:
                1[89]|
                29
              )|
              6[15]9|
              7[178]9
            )
          )\\d{5,6}|
          8[1-35-9]\\d{7,9}
        ',
    'PossibleNumberPattern' => '\\d{9,11}',
    'ExampleNumber' => '812345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          177\\d{6,8}|
          800\\d{5,7}
        ',
    'PossibleNumberPattern' => '\\d{8,11}',
    'ExampleNumber' => '8001234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '809\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8091234567',
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
  'id' => 'ID',
  'countryCode' => 62,
  'internationalPrefix' => '0(?:0[1789]|10(?:00|1[67]))',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{7,8})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2[124]|
            [36]1
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{5,7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [4579]|
            2[035-9]|
            [36][02-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(8\\d{2})(\\d{3,4})(\\d{3,4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '8[1-35-9]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(177)(\\d{6,8})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '1',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(800)(\\d{5,7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '800',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(809)(\\d)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '809',
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