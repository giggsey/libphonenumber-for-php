<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[124-9]\\d{6,9}',
    'PossibleNumberPattern' => '\\d{5,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          1\\d{7,8}|
          2(?:
            1\\d{6,7}|
            3\\d{7}|
            [24-9]\\d{5}
          )|
          4(?:
            0[24]\\d{5}|
            [1-469]\\d{7}|
            5\\d{6}|
            7\\d{5}|
            8[0-46-9]\\d{7}
          )|
          5(?:
            0[45]\\d{5}|
            1\\d{6}|
            [23679]\\d{7}|
            8\\d{5}
          )|
          6(?:
            1\\d{6}|
            [237-9]\\d{5}|
            [4-6]\\d{7}
          )|
          7[14]\\d{7}|
          9(?:
            1\\d{6}|
            [04]\\d{7}|
            [35-9]\\d{5}
          )
        ',
    'PossibleNumberPattern' => '\\d{5,10}',
    'ExampleNumber' => '2212345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            22\\d{6}|
            [35-9]\\d{7}
          )
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '850123456',
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
          15(?:
            1[2-8]|
            [2-8]0|
            9[089]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1520123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '18[59]0\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1850123456',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '700\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '700123456',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '76\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '761234567',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'uan' => 
  array (
    'NationalNumberPattern' => '818\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '818123456',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => '8[35-9]\\d{8}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8501234567',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '
          112|
          999
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '18[59]0\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1850123456',
  ),
  'id' => 'IE',
  'countryCode' => 353,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(1)(\\d{3,4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2[24-9]|
            47|
            58|
            6[237-9]|
            9[35-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{3})(\\d{5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            40[24]|
            50[45]
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(48)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '48',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(818)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '81',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [24-69]|
            7[14]
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    6 => 
    array (
      'pattern' => '([78]\\d)(\\d{3,4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            76|
            8[35-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    7 => 
    array (
      'pattern' => '(700)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '70',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    8 => 
    array (
      'pattern' => '(\\d{4})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              8[059]|
              5
            )
          ',
        1 => '
            1(?:
              8[059]0|
              5
            )
          ',
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