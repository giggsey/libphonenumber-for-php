<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [14578]\\d{5,7}|
          [26]\\d{5,8}|
          9(?:
            [258]|
            4\\d{1,2}|
            [679]\\d?
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{5,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            2\\d{1,2}|
            [3-5]\\d|
            6\\d?|
            [89][0-6]\\d
          )\\d{4}|
          2(?:
            [236-9]\\d{4}|
            4(?:
              0\\d{5}|
              \\d{4}
            )|
            5(?:
              1\\d{3,6}|
              [02-9]\\d{3,5}
            )
          )|
          4(?:
            2[245-8]|
            [346][2-6]|
            5[3-5]
          )\\d{4}|
          5(?:
            2(?:
              20?|
              [3-8]
            )|
            3[2-68]|
            4(?:
              21?|
              [4-8]
            )|
            5[23]|
            6[2-4]|
            7[2-8]|
            8[24-7]|
            9[2-7]
          )\\d{4}|
          6(?:
            0[23]|
            1[2356]|
            [24][2-6]|
            3[24-6]|
            5[2-4]|
            6[2-8]|
            7(?:
              [2367]|
              4\\d|
              5\\d?|
              8[145]\\d
            )|
            8[245]|
            9[24]
          )\\d{4}|
          7(?:
            [04][24-8]|
            [15][2-7]|
            22|
            3[2-4]
          )\\d{4}|
          8(?:
            1(?:
              2\\d?|
              [3-689]
            )|
            2[2-8]|
            3[24]|
            4[24-7]|
            5[245]|
            6[23]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{5,9}',
    'ExampleNumber' => '1234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          17[01]\\d{4}|
          9(?:
            2[0-4]|
            4(?:
              0[0-4]\\d|
              [1379]\\d|
              [24][0-589]\\d|
              5\\d{2}|
              88
            )|
            5[0-6]|
            61?\\d|
            73\\d|
            8\\d|
            9(?:
              1\\d|
              [089]
            )
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{7,10}',
    'ExampleNumber' => '92123456',
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
    'NationalNumberPattern' => '1333\\d{4}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '13331234',
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
    'NationalNumberPattern' => '199',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '199',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'MM',
  'countryCode' => 95,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d)(\\d{3})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1|
            2[45]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(2)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '251',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d)(\\d{2})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            16|
            2
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            67|
            81
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[4-8]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(9)(\\d{3})(\\d{4,5})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            9(?:
              [25-9]|
              4[13789]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    6 => 
    array (
      'pattern' => '(9)(4\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '94[0245]',
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