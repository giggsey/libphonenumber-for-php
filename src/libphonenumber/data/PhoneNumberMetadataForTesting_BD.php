<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [2-79]\\d{5,9}|
          1\\d{9}|
          8[0-7]\\d{4,8}
        ',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          2(?:
            7(?:
              1[0-267]|
              2[0-289]|
              3[0-29]|
              [46][01]|
              5[1-3]|
              7[017]|
              91
            )|
            8(?:
              0[125]|
              [139][1-6]|
              2[0157-9]|
              6[1-35]|
              7[1-5]|
              8[1-8]
            )|
            9(?:
              0[0-2]|
              1[1-4]|
              2[568]|
              3[3-6]|
              5[5-7]|
              6[0167]|
              7[15]|
              8[016-8]
            )
          )\\d{4}|
          3(?:
            12?[5-7]\\d{2}|
            0(?:
              2(?:
                [025-79]\\d|
                [348]\\d{1,2}
              )|
              3(?:
                [2-4]\\d|
                [56]\\d?
              )
            )|
            2(?:
              1\\d{2}|
              2(?:
                [12]\\d|
                [35]\\d{1,2}|
                4\\d?
              )
            )|
            3(?:
              1\\d{2}|
              2(?:
                [2356]\\d|
                4\\d{1,2}
              )
            )|
            4(?:
              1\\d{2}|
              2(?:
                2\\d{1,2}|
                [47]|
                5\\d{2}
              )
            )|
            5(?:
              1\\d{2}|
              29
            )|
            [67]1\\d{2}|
            8(?:
              1\\d{2}|
              2(?:
                2\\d{2}|
                3|
                4\\d
              )
            )|
          )\\d{3}|
          4(?:
            0(?:
              2(?:
                [09]\\d|
                7
              )|
              33\\d{2}
            )|
            1\\d{3}|
            2(?:
              1\\d{2}|
              2(?:
                [25]\\d?|
                [348]\\d|
                [67]\\d{1,2}
              )
            )|
            3(?:
              1\\d{2}(?:\\d{2})?|
              2(?:
                [045]\\d|
                [236-9]\\d{1,2}
              )|
              32\\d{2}
            )|
            4(?:
              [18]\\d{2}|
              2(?:
                [2-46]\\d{2}|
                3
              )|
              5[25]\\d{2}
            )|
            5(?:
              1\\d{2}|
              2(?:
                3\\d|
                5
              )
            )|
            6(?:
              [18]\\d{2}|
              2(?:
                3(?:\\d{2})?|
                [46]\\d{1,2}|
                5\\d{2}|
                7\\d
              )|
              5(?:
                3\\d?|
                4\\d|
                [57]\\d{1,2}|
                6\\d{2}|
                8
              )
            )|
            71\\d{2}|
            8(?:
              [18]\\d{2}|
              23\\d{2}|
              54\\d{2}
            )|
            9(?:
              [18]\\d{2}|
              2[2-5]\\d{2}|
              53\\d{1,2}
            )
          )\\d{3}|
          5(?:
            02[03489]\\d{2}|
            1\\d{2}|
            2(?:
              1\\d{2}|
              2(?:
                2(?:\\d{2})?|
                [457]\\d{2}
              )
            )|
            3(?:
              1\\d{2}|
              2(?:
                [37](?:\\d{2})?|
                [569]\\d{2}
              )
            )|
            4(?:
              1\\d{2}|
              2[46]\\d{2}
            )|
            5(?:
              1\\d{2}|
              26\\d{1,2}
            )|
            6(?:
              [18]\\d{2}|
              2|
              53\\d{2}
            )|
            7(?:
              1|
              24
            )\\d{2}|
            8(?:
              1|
              26
            )\\d{2}|
            91\\d{2}
          )\\d{3}|
          6(?:
            0(?:
              1\\d{2}|
              2(?:
                3\\d{2}|
                4\\d{1,2}
              )
            )|
            2(?:
              2[2-5]\\d{2}|
              5(?:
                [3-5]\\d{2}|
                7
              )|
              8\\d{2}
            )|
            3(?:
              1|
              2[3478]
            )\\d{2}|
            4(?:
              1|
              2[34]
            )\\d{2}|
            5(?:
              1|
              2[47]
            )\\d{2}|
            6(?:
              [18]\\d{2}|
              6(?:
                2(?:
                  2\\d|
                  [34]\\d{2}
                )|
                5(?:
                  [24]\\d{2}|
                  3\\d|
                  5\\d{1,2}
                )
              )
            )|
            72[2-5]\\d{2}|
            8(?:
              1\\d{2}|
              2[2-5]\\d{2}
            )|
            9(?:
              1\\d{2}|
              2[2-6]\\d{2}
            )
          )\\d{3}|
          7(?:
            (?:
              02|
              [3-589]1|
              6[12]|
              72[24]
            )\\d{2}|
            21\\d{3}|
            32
          )\\d{3}|
          8(?:
            (?:
              4[12]|
              [5-7]2|
              1\\d?
            )|
            (?:
              0|
              3[12]|
              [5-7]1|
              217
            )\\d
          )\\d{4}|
          9(?:
            [35]1|
            (?:
              [024]2|
              81
            )\\d|
            (?:
              1|
              [24]1
            )\\d{2}
          )\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{6,9}',
    'ExampleNumber' => '27111234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1[13-9]\\d|
            (?:
              3[78]|
              44
            )[02-9]|
            6(?:
              44|
              6[02-9]
            )
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1812345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80[03]\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8001234567',
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
    'NationalNumberPattern' => '
          96(?:
            0[49]|
            1[0-4]|
            6[69]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '9604123456',
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
          10[0-2]|
          999
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '999',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'BD',
  'countryCode' => 880,
  'internationalPrefix' => '00[12]?',
  'preferredInternationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(2)(\\d{7})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '2',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{4,6})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[3-79]1',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{4})(\\d{3,6})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1|
            3(?:
              0|
              [2-58]2
            )|
            4(?:
              0|
              [25]2|
              3[23]|
              [4689][25]
            )|
            5(?:
              [02-578]2|
              6[25]
            )|
            6(?:
              [0347-9]2|
              [26][25]
            )|
            7[02-9]2|
            8(?:
              [023][23]|
              [4-7]2
            )|
            9(?:
              [02][23]|
              [458]2|
              6[016]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(\\d{3})(\\d{3,7})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [3-79][2-9]|
            8
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