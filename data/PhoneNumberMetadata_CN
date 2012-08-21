<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [1-79]\\d{7,11}|
          8[0-357-9]\\d{6,9}
        ',
    'PossibleNumberPattern' => '\\d{4,12}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          21\\d{8,10}|
          (?:
            10|
            2[02-57-9]|
            3(?:
              11|
              7[179]
            )|
            4(?:
              [15]1|
              3[12]
            )|
            5(?:
              1\\d|
              2[37]|
              3[12]|
              7[13-79]|
              9[15]
            )|
            7(?:
              31|
              5[457]|
              6[09]|
              91
            )|
            898
          )\\d{8}|
          (?:
            3(?:
              1[02-9]|
              35|
              49|
              5\\d|
              7[02-68]|
              9[1-68]
            )|
            4(?:
              1[02-9]|
              2[179]|
              3[3-9]|
              5[2-9]|
              6[4789]|
              7\\d|
              8[23]
            )|
            5(?:
              3[03-9]|
              4[36]|
              5\\d|
              6[1-6]|
              7[028]|
              80|
              9[2-46-9]
            )|
            6(?:
              3[1-5]|
              6[0238]|
              9[12]
            )|
            7(?:
              01|
              [17]\\d|
              2[248]|
              3[04-9]|
              4[3-6]|
              5[0-3689]|
              6[2368]|
              9[02-9]
            )|
            8(?:
              1[236-8]|
              2[5-7]|
              [37]\\d|
              5[1-9]|
              8[3678]|
              9[1-7]
            )|
            9(?:
              0[1-3689]|
              1[1-79]|
              [379]\\d|
              4[13]|
              5[1-5]
            )
          )\\d{7}|
          80(?:
            29|
            6[03578]|
            7[018]|
            81
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{4,12}',
    'ExampleNumber' => '1012345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            3\\d|
            4[57]|
            5[0-35-9]|
            8[0235-9]
          )\\d{8}
        ',
    'PossibleNumberPattern' => '\\d{11}',
    'ExampleNumber' => '13123456789',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          (?:
            10
          )?800\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10,12}',
    'ExampleNumber' => '8001234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '16[08]\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '16812345',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '400\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '4001234567',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '
          (?:
            4|
            (?:
              10
            )?8
          )00\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10,12}',
    'ExampleNumber' => '4001234567',
  ),
  'id' => 'CN',
  'countryCode' => 86,
  'internationalPrefix' => '(1[1279]\\d{3})?00',
  'preferredInternationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '(1[1279]\\d{3})|0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(80\\d{2})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '80[2678]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    1 => 
    array (
      'pattern' => '([48]00)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[48]00',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{3,4})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2-9]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(21)(\\d{4})(\\d{4,6})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '21',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    4 => 
    array (
      'pattern' => '([12]\\d)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            10[1-9]|
            2[02-9]
          ',
        1 => '
            10[1-9]|
            2[02-9]
          ',
        2 => '
            10(?:
              [1-79]|
              8(?:
                [1-9]|
                0[1-9]
              )
            )|
            2[02-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    5 => 
    array (
      'pattern' => '(\\d{3})(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3(?:
              11|
              7[179]
            )|
            4(?:
              [15]1|
              3[12]
            )|
            5(?:
              1|
              2[37]|
              3[12]|
              7[13-79]|
              9[15]
            )|
            7(?:
              31|
              5[457]|
              6[09]|
              91
            )|
            898
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    6 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3(?:
              1[02-9]|
              35|
              49|
              5|
              7[02-68]|
              9[1-68]
            )|
            4(?:
              1[02-9]|
              2[179]|
              [35][2-9]|
              6[4789]|
              7\\d|
              8[23]
            )|
            5(?:
              3[03-9]|
              4[36]|
              5|
              6[1-6]|
              7[028]|
              80|
              9[2-46-9]
            )|
            6(?:
              3[1-5]|
              6[0238]|
              9[12]
            )|
            7(?:
              01|
              [1579]|
              2[248]|
              3[04-9]|
              4[3-6]|
              6[2368]
            )|
            8(?:
              1[236-8]|
              2[5-7]|
              [37]|
              5[1-9]|
              8[3678]|
              9[1-7]
            )|
            9(?:
              0[1-3689]|
              1[1-79]|
              [379]|
              4[13]|
              5[1-5]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    7 => 
    array (
      'pattern' => '(1[3-58]\\d)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1[3-58]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    8 => 
    array (
      'pattern' => '(10800)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '108',
        1 => '1080',
        2 => '10800',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(80\\d{2})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '80[2678]',
      ),
    ),
    1 => 
    array (
      'pattern' => '([48]00)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[48]00',
      ),
    ),
    2 => 
    array (
      'pattern' => '(21)(\\d{4})(\\d{4,6})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '21',
      ),
    ),
    3 => 
    array (
      'pattern' => '([12]\\d)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            10[1-9]|
            2[02-9]
          ',
        1 => '
            10[1-9]|
            2[02-9]
          ',
        2 => '
            10(?:
              [1-79]|
              8(?:
                [1-9]|
                0[1-9]
              )
            )|
            2[02-9]
          ',
      ),
    ),
    4 => 
    array (
      'pattern' => '(\\d{3})(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3(?:
              11|
              7[179]
            )|
            4(?:
              [15]1|
              3[12]
            )|
            5(?:
              1|
              2[37]|
              3[12]|
              7[13-79]|
              9[15]
            )|
            7(?:
              31|
              5[457]|
              6[09]|
              91
            )|
            898
          ',
      ),
    ),
    5 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3(?:
              1[02-9]|
              35|
              49|
              5|
              7[02-68]|
              9[1-68]
            )|
            4(?:
              1[02-9]|
              2[179]|
              [35][2-9]|
              6[4789]|
              7\\d|
              8[23]
            )|
            5(?:
              3[03-9]|
              4[36]|
              5|
              6[1-6]|
              7[028]|
              80|
              9[2-46-9]
            )|
            6(?:
              3[1-5]|
              6[0238]|
              9[12]
            )|
            7(?:
              01|
              [1579]|
              2[248]|
              3[04-9]|
              4[3-6]|
              6[2368]
            )|
            8(?:
              1[236-8]|
              2[5-7]|
              [37]|
              5[1-9]|
              8[3678]|
              9[1-7]
            )|
            9(?:
              0[1-3689]|
              1[1-79]|
              [379]|
              4[13]|
              5[1-5]
            )
          ',
      ),
    ),
    6 => 
    array (
      'pattern' => '(1[3-58]\\d)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1[3-58]',
      ),
    ),
    7 => 
    array (
      'pattern' => '(10800)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '108',
        1 => '1080',
        2 => '10800',
      ),
    ),
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);