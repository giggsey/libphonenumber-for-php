<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-9]\\d{6,7}',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1(?:
              0[02-579]|
              19|
              2[37]|
              3[03]|
              4[479]|
              57|
              65|
              7[016-8]|
              8[58]|
              9[134]
            )|
            2(?:
              [0235679]\\d|
              1[0-7]|
              4[04-9]|
              8[028]
            )|
            3(?:
              0[0-7]|
              1[14-7]|
              2[0-3]|
              3[03]|
              4[0457]|
              5[56]|
              6[068]|
              7[078]|
              80|
              9\\d
            )|
            4(?:
              3[013-59]|
              4\\d|
              7[0-689]
            )|
            5(?:
              [01]\\d|
              2[0-7]|
              [56]0|
              79
            )|
            7(?:
              0[09]|
              2[0-267]|
              [349]0|
              5[6-9]|
              7[0-24-7]|
              8[89]
            )|
            8(?:
              [34]\\d|
              5[0-4]|
              8[02]
            )|
            9(?:
              0[78]|
              1[0178]|
              2[0378]|
              3[379]|
              40|
              5[0489]|
              6[06-9]|
              7[046-9]|
              8[36-8]|
              9[1-9]
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '2001234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1[16]1|
            21[89]|
            8(?:
              1[01]|
              7[23]
            )
          )\\d{4}|
          6(?:
            [04-9]\\d|
            1[0-5]|
            2[0-7]|
            3[5-9]
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '60012345',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80[09]\\d{4}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '8001234',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          (?:
            779|
            8(?:
              2[235]|
              55|
              60|
              7[578]|
              86|
              95
            )|
            9(?:
              0[0-2]|
              81
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '8601234',
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
    'NationalNumberPattern' => '911',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '911',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'PA',
  'countryCode' => 507,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{4})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[1-57-9]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{4})(\\d{4})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '6',
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