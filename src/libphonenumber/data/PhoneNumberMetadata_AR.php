<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [1-368]\\d{9}|
          9\\d{10}
        ',
    'PossibleNumberPattern' => '\\d{6,11}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          11\\d{8}|
          (?:
            2(?:
              2(?:
                [013]\\d|
                2[13-79]|
                4[1-6]|
                5[2457]|
                6[124-8]|
                7[1-4]|
                8[13-6]|
                9[1267]
              )|
              3(?:
                1[467]|
                2[03-6]|
                3[13-8]|
                [49][2-6]|
                5[2-8]|
                [067]\\d
              )|
              4(?:
                7[3-8]|
                9\\d
              )|
              6(?:
                [01346]\\d|
                2[24-6]|
                5[15-8]
              )|
              80\\d|
              9(?:
                [0124789]\\d|
                3[1-6]|
                5[234]|
                6[2-46]
              )
            )|
            3(?:
              3(?:
                2[79]|
                6\\d|
                8[2578]
              )|
              4(?:
                [78]\\d|
                0[0124-9]|
                [1-35]\\d|
                4[24-7]|
                6[02-9]|
                9[123678]
              )|
              5(?:
                [138]\\d|
                2[1245]|
                4[1-9]|
                6[2-4]|
                7[1-6]
              )|
              6[24]\\d|
              7(?:
                [0469]\\d|
                1[1568]|
                2[013-9]|
                3[145]|
                5[14-8]|
                7[2-57]|
                8[0-24-9]
              )|
              8(?:
                [013578]\\d|
                2[15-7]|
                4[13-6]|
                6[1-357-9]|
                9[124]
              )
            )|
            670\\d
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '1123456789',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          675\\d{7}|
          9(?:
            11[2-9]\\d{7}|
            (?:
              2(?:
                2[013]|
                3[067]|
                49|
                6[01346]|
                80|
                9[147-9]
              )|
              3(?:
                36|
                4[12358]|
                5[138]|
                6[24]|
                7[069]|
                8[013578]
              )
            )[2-9]\\d{6}|
            \\d{4}[2-9]\\d{5}
          )
        ',
    'PossibleNumberPattern' => '\\d{6,11}',
    'ExampleNumber' => '91123456789',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8001234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '60[04579]\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '6001234567',
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
    'NationalNumberPattern' => '810\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8101234567',
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
            0[017]|
            28
          )
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '101',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '810\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8101234567',
  ),
  'id' => 'AR',
  'countryCode' => 54,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '          0?(?:            (11|             2(?:               2(?:                 02?|                 [13]|                 2[13-79]|                 4[1-6]|                 5[2457]|                 6[124-8]|                 7[1-4]|                 8[13-6]|                 9[1267]               )|               3(?:                 02?|                 1[467]|                 2[03-6]|                 3[13-8]|                 [49][2-6]|                 5[2-8]|                 [67]               )|               4(?:                 7[3-578]|                 9               )|               6(?:                 [0136]|                 2[24-6]|                 4[6-8]?|                 5[15-8]               )|               80|               9(?:                 0[1-3]|                 [19]|                 2\\d|                 3[1-6]|                 4[02568]?|                 5[2-4]|                 6[2-46]|                 72?|                 8[23]?               )            )|            3(?:              3(?:                2[79]|                6|                8[2578]              )|              4(?:                0[124-9]|                [12]|                3[5-8]?|                4[24-7]|                5[4-68]?|                6[02-9]|                7[126]|                8[2379]?|                9[1-36-8]              )|              5(?:                1|                2[1245]|                3[237]?|                4[1-46-9]|                6[2-4]|                7[1-6]|                8[2-5]?              )|              6[24]|              7(?:                1[1568]|                2[15]|                3[145]|                4[13]|                5[14-8]|                [069]|                7[2-57]|                8[126]              )|              8(?:                [01]|                2[15-7]|                3[2578]?|                4[13-6]|                5[4-8]?|                6[1-357-9]|                7[36-8]?|                8[5-8]?|                9[124]              )            )          )15        )?',
  'nationalPrefixTransformRule' => '9$1',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([68]\\d{2})(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[68]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(9)(11)(\\d{4})(\\d{4})',
      'format' => '$2 15-$3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '911',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(9)(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$2 15-$3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            9(?:
              2[234689]|
              3[3-8]
            )
          ',
        1 => '
            9(?:
              2(?:
                2[013]|
                3[067]|
                49|
                6[01346]|
                80|
                9[147-9]
              )|
              3(?:
                36|
                4[12358]|
                5[138]|
                6[24]|
                7[069]|
                8[013578]
              )
            )
          ',
        2 => '
            9(?:
              2(?:
                2[013]|
                3[067]|
                49|
                6[01346]|
                80|
                9(?:
                  [17-9]|
                  4[13479]
                )
              )|
              3(?:
                36|
                4[12358]|
                5(?:
                  [18]|
                  3[014-689]
                )|
                6[24]|
                7[069]|
                8(?:
                  [01]|
                  3[013469]|
                  5[0-39]|
                  7[0-2459]|
                  8[0-49]
                )
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(9)(\\d{4})(\\d{3})(\\d{3})',
      'format' => '$2 15-$3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '93[58]',
        1 => '
            9(?:
              3(?:
                53|
                8[78]
              )
            )
          ',
        2 => '
            9(?:
              3(?:
                537|
                8(?:
                  73|
                  88
                )
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(9)(\\d{4})(\\d{2})(\\d{4})',
      'format' => '$2 15-$3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '9[23]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(11)(\\d{4})(\\d{4})',
      'format' => '$1 $2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    6 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2(?:
              2[013]|
              3[067]|
              49|
              6[01346]|
              80|
              9[147-9]
            )|
            3(?:
              36|
              4[12358]|
              5[138]|
              6[24]|
              7[069]|
              8[013578]
            )
          ',
        1 => '
            2(?:
              2[013]|
              3[067]|
              49|
              6[01346]|
              80|
              9(?:
                [17-9]|
                4[13479]
              )
            )|
            3(?:
              36|
              4[12358]|
              5(?:
                [18]|
                3[0-689]
              )|
              6[24]|
              7[069]|
              8(?:
                [01]|
                3[013469]|
                5[0-39]|
                7[0-2459]|
                8[0-49]
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    7 => 
    array (
      'pattern' => '(\\d{4})(\\d{3})(\\d{3})',
      'format' => '$1 $2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3(?:
              53|
              8[78]
            )
          ',
        1 => '
            3(?:
              537|
              8(?:
                73|
                88
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    8 => 
    array (
      'pattern' => '(\\d{4})(\\d{2})(\\d{4})',
      'format' => '$1 $2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[23]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([68]\\d{2})(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[68]',
      ),
    ),
    1 => 
    array (
      'pattern' => '(9)(11)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '911',
      ),
    ),
    2 => 
    array (
      'pattern' => '(9)(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            9(?:
              2[234689]|
              3[3-8]
            )
          ',
        1 => '
            9(?:
              2(?:
                2[013]|
                3[067]|
                49|
                6[01346]|
                80|
                9[147-9]
              )|
              3(?:
                36|
                4[12358]|
                5[138]|
                6[24]|
                7[069]|
                8[013578]
              )
            )
          ',
        2 => '
            9(?:
              2(?:
                2[013]|
                3[067]|
                49|
                6[01346]|
                80|
                9(?:
                  [17-9]|
                  4[13479]
                )
              )|
              3(?:
                36|
                4[12358]|
                5(?:
                  [18]|
                  3[014-689]
                )|
                6[24]|
                7[069]|
                8(?:
                  [01]|
                  3[013469]|
                  5[0-39]|
                  7[0-2459]|
                  8[0-49]
                )
              )
            )
          ',
      ),
    ),
    3 => 
    array (
      'pattern' => '(9)(\\d{4})(\\d{3})(\\d{3})',
      'format' => '$2 15-$3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '93[58]',
        1 => '
            9(?:
              3(?:
                53|
                8[78]
              )
            )
          ',
        2 => '
            9(?:
              3(?:
                537|
                8(?:
                  73|
                  88
                )
              )
            )
          ',
      ),
    ),
    4 => 
    array (
      'pattern' => '(9)(\\d{4})(\\d{2})(\\d{4})',
      'format' => '$1 $2 $3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '9[23]',
      ),
    ),
    5 => 
    array (
      'pattern' => '(11)(\\d{4})(\\d{4})',
      'format' => '$1 $2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '1',
      ),
    ),
    6 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2(?:
              2[013]|
              3[067]|
              49|
              6[01346]|
              80|
              9[147-9]
            )|
            3(?:
              36|
              4[12358]|
              5[138]|
              6[24]|
              7[069]|
              8[013578]
            )
          ',
        1 => '
            2(?:
              2[013]|
              3[067]|
              49|
              6[01346]|
              80|
              9(?:
                [17-9]|
                4[13479]
              )
            )|
            3(?:
              36|
              4[12358]|
              5(?:
                [18]|
                3[0-689]
              )|
              6[24]|
              7[069]|
              8(?:
                [01]|
                3[013469]|
                5[0-39]|
                7[0-2459]|
                8[0-49]
              )
            )
          ',
      ),
    ),
    7 => 
    array (
      'pattern' => '(\\d{4})(\\d{3})(\\d{3})',
      'format' => '$1 $2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3(?:
              53|
              8[78]
            )
          ',
        1 => '
            3(?:
              537|
              8(?:
                73|
                88
              )
            )
          ',
      ),
    ),
    8 => 
    array (
      'pattern' => '(\\d{4})(\\d{2})(\\d{4})',
      'format' => '$1 $2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[23]',
      ),
    ),
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);