<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [1-9]\\d{8,9}|
          0(?:
            [36]\\d{7,14}|
            7\\d{5,7}|
            8\\d{7}
          )
        ',
    'PossibleNumberPattern' => '\\d{7,16}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1(?:
              1[235-8]|
              2[3-6]|
              3[3-9]|
              4[2-6]|
              [58][2-8]|
              6[2-7]|
              7[2-9]|
              9[1-9]
            )|
            2[2-9]\\d|
            [36][1-9]\\d|
            4(?:
              6[02-8]|
              [2-578]\\d|
              9[2-59]
            )|
            5(?:
              6[1-9]|
              7[2-8]|
              [2-589]\\d
            )|
            7(?:
              3[4-9]|
              4[02-9]|
              [25-9]\\d
            )|
            8(?:
              3[2-9]|
              4[5-9]|
              5[1-9]|
              8[03-9]|
              [2679]\\d
            )|
            9(?:
              [679][1-9]|
              [2-58]\\d
            )
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '312345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            [79]0\\d|
            80[1-9]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '7012345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          120\\d{6}|
          800\\d{7}|
          0(?:
            37\\d{6,13}|
            66\\d{6,13}|
            777(?:
              [01]\\d{2}|
              5\\d{3}|
              8\\d{4}
            )|
            882[1245]\\d{4}
          )
        ',
    'PossibleNumberPattern' => '\\d{7,16}',
    'ExampleNumber' => '120123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '990\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '990123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '60\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '601234567',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '50[1-9]\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '5012345678',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => '20\\d{8}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '2012345678',
  ),
  'uan' => 
  array (
    'NationalNumberPattern' => '570\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '570123456',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '11[09]',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '110',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '
          0(?:
            37\\d{6,13}|
            66\\d{6,13}|
            777(?:
              [01]\\d{2}|
              5\\d{3}|
              8\\d{4}
            )|
            882[1245]\\d{4}
          )
        ',
    'PossibleNumberPattern' => '\\d{7,16}',
    'ExampleNumber' => '0777012',
  ),
  'id' => 'JP',
  'countryCode' => 81,
  'internationalPrefix' => '010',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{3})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            (?:
              12|
              57|
              99
            )0
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '800',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{3})(\\d{4})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '077',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{3,4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '077',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '088',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{3,4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            0(?:
              37|
              66
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    6 => 
    array (
      'pattern' => '(\\d{3})(\\d{4})(\\d{4,5})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            0(?:
              37|
              66
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    7 => 
    array (
      'pattern' => '(\\d{3})(\\d{5})(\\d{5,6})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            0(?:
              37|
              66
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    8 => 
    array (
      'pattern' => '(\\d{3})(\\d{6})(\\d{6,7})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            0(?:
              37|
              66
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    9 => 
    array (
      'pattern' => '(\\d{2})(\\d{4})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [2579]0|
            80[1-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    10 => 
    array (
      'pattern' => '(\\d{4})(\\d)(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              26|
              3[79]|
              4[56]|
              5[4-68]|
              6[3-5]
            )|
            5(?:
              76|
              97
            )|
            499|
            746|
            8(?:
              3[89]|
              63|
              47|
              51
            )|
            9(?:
              49|
              80|
              9[16]
            )
          ',
        1 => '
            1(?:
              267|
              3(?:
                7[247]|
                9[278]
              )|
              4(?:
                5[67]|
                66
              )|
              5(?:
                47|
                58|
                64|
                8[67]
              )|
              6(?:
                3[245]|
                48|
                5[4-68]
              )
            )|
            5(?:
              76|
              97
            )9|
            499[2468]|
            7468|
            8(?:
              3(?:
                8[78]|
                96
              )|
              636|
              477|
              51[24]
            )|
            9(?:
              496|
              802|
              9(?:
                1[23]|
                69
              )
            )
          ',
        2 => '
            1(?:
              267|
              3(?:
                7[247]|
                9[278]
              )|
              4(?:
                5[67]|
                66
              )|
              5(?:
                47|
                58|
                64|
                8[67]
              )|
              6(?:
                3[245]|
                48|
                5[4-68]
              )
            )|
            5(?:
              769|
              979[2-69]
            )|
            499[2468]|
            7468|
            8(?:
              3(?:
                8[78]|
                96[2457-9]
              )|
              636[2-57-9]|
              477|
              51[24]
            )|
            9(?:
              496|
              802|
              9(?:
                1[23]|
                69
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    11 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              2[3-6]|
              3[3-9]|
              4[2-6]|
              5[2-8]|
              [68][2-7]|
              7[2-689]|
              9[1-578]
            )|
            2(?:
              2[03-689]|
              3[3-58]|
              4[0-468]|
              5[04-8]|
              6[013-8]|
              7[06-9]|
              8[02-57-9]|
              9[13]
            )|
            4(?:
              2[28]|
              3[689]|
              6[035-7]|
              7[05689]|
              80|
              9[3-5]
            )|
            5(?:
              3[1-36-9]|
              4[4578]|
              5[013-8]|
              6[1-9]|
              7[2-8]|
              8[14-7]|
              9[4-9]
            )|
            7(?:
              2[15]|
              3[5-9]|
              4[02-9]|
              6[135-8]|
              7[0-4689]|
              9[014-9]
            )|
            8(?:
              2[49]|
              3[3-8]|
              4[5-8]|
              5[2-9]|
              6[35-9]|
              7[579]|
              8[03-579]|
              9[2-8]
            )|
            9(?:
              [23]0|
              4[02-46-9]|
              5[024-79]|
              6[4-9]|
              7[2-47-9]|
              8[02-7]|
              9[3-7]
            )
          ',
        1 => '
            1(?:
              2[3-6]|
              3[3-9]|
              4[2-6]|
              5(?:
                [236-8]|
                [45][2-69]
              )|
              [68][2-7]|
              7[2-689]|
              9[1-578]
            )|
            2(?:
              2(?:
                [04-689]|
                3[23]
              )|
              3[3-58]|
              4[0-468]|
              5(?:
                5[78]|
                7[2-4]|
                [0468][2-9]
              )|
              6(?:
                [0135-8]|
                4[2-5]
              )|
              7(?:
                [0679]|
                8[2-7]
              )|
              8(?:
                [024578]|
                3[25-9]|
                9[6-9]
              )|
              9(?:
                11|
                3[2-4]
              )
            )|
            4(?:
              2(?:
                2[2-9]|
                8[237-9]
              )|
              3[689]|
              6[035-7]|
              7(?:
                [059][2-8]|
                [68]
              )|
              80|
              9[3-5]
            )|
            5(?:
              3[1-36-9]|
              4[4578]|
              5[013-8]|
              6[1-9]|
              7[2-8]|
              8[14-7]|
              9(?:
                [89][2-8]|
                [4-7]
              )
            )|
            7(?:
              2[15]|
              3[5-9]|
              4[02-9]|
              6[135-8]|
              7[0-4689]|
              9(?:
                [017-9]|
                4[6-8]|
                5[2-478]|
                6[2-589]
              )
            )|
            8(?:
              2(?:
                4[4-8]|
                9[2-8]
              )|
              3(?:
                7[2-6]|
                [3-6][2-9]|
                8[2-5]
              )|
              4[5-8]|
              5[2-9]|
              6(?:
                [37]|
                5[4-7]|
                6[2-9]|
                8[2-8]|
                9[236-9]
              )|
              7[579]|
              8[03-579]|
              9[2-8]
            )|
            9(?:
              [23]0|
              4[02-46-9]|
              5[024-79]|
              6[4-9]|
              7[2-47-9]|
              8[02-7]|
              9(?:
                3[34]|
                [4-7]
              )
            )
          ',
        2 => '
            1(?:
              2[3-6]|
              3[3-9]|
              4[2-6]|
              5(?:
                [236-8]|
                [45][2-69]
              )|
              [68][2-7]|
              7[2-689]|
              9[1-578]
            )|
            2(?:
              2(?:
                [04-689]|
                3[23]
              )|
              3[3-58]|
              4[0-468]|
              5(?:
                5[78]|
                7[2-4]|
                [0468][2-9]
              )|
              6(?:
                [0135-8]|
                4[2-5]
              )|
              7(?:
                [0679]|
                8[2-7]
              )|
              8(?:
                [024578]|
                3[25-9]|
                9[6-9]
              )|
              9(?:
                11|
                3[2-4]
              )
            )|
            4(?:
              2(?:
                2[2-9]|
                8[237-9]
              )|
              3[689]|
              6[035-7]|
              7(?:
                [059][2-8]|
                [68]
              )|
              80|
              9[3-5]
            )|
            5(?:
              3[1-36-9]|
              4[4578]|
              5[013-8]|
              6[1-9]|
              7[2-8]|
              8[14-7]|
              9(?:
                [89][2-8]|
                [4-7]
              )
            )|
            7(?:
              2[15]|
              3[5-9]|
              4[02-9]|
              6[135-8]|
              7[0-4689]|
              9(?:
                [017-9]|
                4[6-8]|
                5[2-478]|
                6[2-589]
              )
            )|
            8(?:
              2(?:
                4[4-8]|
                9(?:
                  [3578]|
                  20|
                  4[04-9]|
                  6[56]
                )
              )|
              3(?:
                7(?:
                  [2-5]|
                  6[0-59]
                )|
                [3-6][2-9]|
                8[2-5]
              )|
              4[5-8]|
              5[2-9]|
              6(?:
                [37]|
                5(?:
                  [467]|
                  5[014-9]
                )|
                6(?:
                  [2-8]|
                  9[02-69]
                )|
                8[2-8]|
                9(?:
                  [236-8]|
                  9[23]
                )
              )|
              7[579]|
              8[03-579]|
              9[2-8]
            )|
            9(?:
              [23]0|
              4[02-46-9]|
              5[024-79]|
              6[4-9]|
              7[2-47-9]|
              8[02-7]|
              9(?:
                3(?:
                  3[02-9]|
                  4[0-24689]
                )|
                4[2-69]|
                [5-7]
              )
            )
          ',
        3 => '
            1(?:
              2[3-6]|
              3[3-9]|
              4[2-6]|
              5(?:
                [236-8]|
                [45][2-69]
              )|
              [68][2-7]|
              7[2-689]|
              9[1-578]
            )|
            2(?:
              2(?:
                [04-689]|
                3[23]
              )|
              3[3-58]|
              4[0-468]|
              5(?:
                5[78]|
                7[2-4]|
                [0468][2-9]
              )|
              6(?:
                [0135-8]|
                4[2-5]
              )|
              7(?:
                [0679]|
                8[2-7]
              )|
              8(?:
                [024578]|
                3[25-9]|
                9[6-9]
              )|
              9(?:
                11|
                3[2-4]
              )
            )|
            4(?:
              2(?:
                2[2-9]|
                8[237-9]
              )|
              3[689]|
              6[035-7]|
              7(?:
                [059][2-8]|
                [68]
              )|
              80|
              9[3-5]
            )|
            5(?:
              3[1-36-9]|
              4[4578]|
              5[013-8]|
              6[1-9]|
              7[2-8]|
              8[14-7]|
              9(?:
                [89][2-8]|
                [4-7]
              )
            )|
            7(?:
              2[15]|
              3[5-9]|
              4[02-9]|
              6[135-8]|
              7[0-4689]|
              9(?:
                [017-9]|
                4[6-8]|
                5[2-478]|
                6[2-589]
              )
            )|
            8(?:
              2(?:
                4[4-8]|
                9(?:
                  [3578]|
                  20|
                  4[04-9]|
                  6(?:
                    5[25]|
                    60
                  )
                )
              )|
              3(?:
                7(?:
                  [2-5]|
                  6[0-59]
                )|
                [3-6][2-9]|
                8[2-5]
              )|
              4[5-8]|
              5[2-9]|
              6(?:
                [37]|
                5(?:
                  [467]|
                  5[014-9]
                )|
                6(?:
                  [2-8]|
                  9[02-69]
                )|
                8[2-8]|
                9(?:
                  [236-8]|
                  9[23]
                )
              )|
              7[579]|
              8[03-579]|
              9[2-8]
            )|
            9(?:
              [23]0|
              4[02-46-9]|
              5[024-79]|
              6[4-9]|
              7[2-47-9]|
              8[02-7]|
              9(?:
                3(?:
                  3[02-9]|
                  4[0-24689]
                )|
                4[2-69]|
                [5-7]
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    12 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1|
            2(?:
              2[37]|
              5[5-9]|
              64|
              78|
              8[39]|
              91
            )|
            4(?:
              2[2689]|
              64|
              7[347]
            )|
            5(?:
              [2-589]|
              39
            )|
            60|
            8(?:
              [46-9]|
              3[279]|
              2[124589]
            )|
            9(?:
              [235-8]|
              93
            )
          ',
        1 => '
            1|
            2(?:
              2[37]|
              5(?:
                [57]|
                [68]0|
                9[19]
              )|
              64|
              78|
              8[39]|
              917
            )|
            4(?:
              2(?:
                [68]|
                20|
                9[178]
              )|
              64|
              7[347]
            )|
            5(?:
              [2-589]|
              39[67]
            )|
            60|
            8(?:
              [46-9]|
              3[279]|
              2[124589]
            )|
            9(?:
              [235-8]|
              93[34]
            )
          ',
        2 => '
            1|
            2(?:
              2[37]|
              5(?:
                [57]|
                [68]0|
                9(?:
                  17|
                  99
                )
              )|
              64|
              78|
              8[39]|
              917
            )|
            4(?:
              2(?:
                [68]|
                20|
                9[178]
              )|
              64|
              7[347]
            )|
            5(?:
              [2-589]|
              39[67]
            )|
            60|
            8(?:
              [46-9]|
              3[279]|
              2[124589]
            )|
            9(?:
              [235-8]|
              93(?:
                31|
                4
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    13 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2(?:
              9[14-79]|
              74|
              [34]7|
              [56]9
            )|
            82|
            993
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    14 => 
    array (
      'pattern' => '(\\d)(\\d{4})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3|
            4(?:
              2[09]|
              7[01]
            )|
            6[1-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    15 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2479][1-9]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => true,
);