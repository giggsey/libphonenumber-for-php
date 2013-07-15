<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          1\\d{4,9}|
          [2456]\\d{8}|
          3\\d{7}|
          [89]\\d{8,9}
        ',
    'PossibleNumberPattern' => '\\d{5,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1(
              3[23]\\d|
              5[23]
            )|
            2[2-4]\\d{2}|
            3\\d{2}|
            4(?:
              0[2-5]|
              [578][23]|
              64
            )\\d|
            5(?:
              0[2-7]|
              [57][23]
            )\\d|
            6[24-689]3\\d|
            8(?:
              2[2-57]|
              4[26]|
              6[237]|
              8[2-4]
            )\\d|
            9(?:
              2[27]|
              3[24]|
              52|
              6[2356]|
              7[2-4]
            )\\d
          )\\d{5}|
          1[69]\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{5,9}',
    'ExampleNumber' => '234567890',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            0[01269]|
            1[1245]|
            2[0-278]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1001234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8001234567',
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
          1(?:
            2[23]|
            80
          )
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '122',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'EG',
  'countryCode' => 20,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d)(\\d{7,8})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[23]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
             1[012]|
             [89]00
           ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{2})(\\d{6,7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
             1(?:
               3|
               5[23]
             )|
             [4-6]|
             [89][2-9]
           ',
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