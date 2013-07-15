<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          2(?:
            [012457-9]\\d{3,8}|
            6\\d{3,6}
          )|
          [13-79]\\d{4,8}|
          8[06]\\d{8}
        ',
    'PossibleNumberPattern' => '\\d{3,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1[3-9]|
            2(?:
              0[45]|
              [16]|
              2[28]|
              [49]8?|
              58[23]|
              7[246]|
              8[1346-9]
            )|
            3(?:
              08?|
              17?|
              3[78]|
              [2456]|
              7[1569]|
              8[379]
            )|
            5(?:
              [07-9]|
              1[78]|
              483|
              5(?:
                7?|
                8
              )
            )|
            6(?:
              0|
              28|
              37?|
              [45][68][78]|
              98?
            )|
            848
          )\\d{3,6}|
          (?:
            2(?:
              27|
              5|
              7[135789]|
              8[25]
            )|
            3[39]|
            5[1-46]|
            6[126-8]
          )\\d{4,6}|
          2(?:
            (?:
              0|
              70
            )\\d{5,6}|
            2[05]\\d{7}
          )|
          (?:
            4\\d|
            9[2-8]
          )\\d{4,7}
        ',
    'PossibleNumberPattern' => '\\d{3,10}',
    'ExampleNumber' => '1312345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          7[1378]\\d{7}|
          86(?:
            22|
            44
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{9,10}',
    'ExampleNumber' => '711234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{7}',
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
          86(?:
            1[12]|
            30|
            55|
            77|
            8[367]|
            99
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8686123456',
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
          (?:
            112|
            99[3459]
          )
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
  'id' => 'ZW',
  'countryCode' => 263,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([49])(\\d{3})(\\d{2,5})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            4|
            9[2-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([179]\\d)(\\d{3})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [19]1|
            7
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(86\\d{2})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '86[24]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '([2356]\\d{2})(\\d{3,5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2(?:
              [278]|
              0[45]|
              [49]8
            )|
            3(?:
              08|
              17|
              3[78]|
              [78]
            )|
            5[15][78]|
            6(?:
              [29]8|
              37|
              [68][78]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2(?:
              [278]|
              0[45]|
              48
            )|
            3(?:
              08|
              17|
              3[78]|
              [78]
            )|
            5[15][78]|
            6(?:
              [29]8|
              37|
              [68][78]
            )|
            80
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '([1-356]\\d)(\\d{3,5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[3-9]|
            2(?:
              [1-469]|
              0[0-35-9]|
              [45][0-79]
            )|
            3(?:
              0[0-79]|
              1[0-689]|
              [24-69]|
              3[0-69]
            )|
            5(?:
              [02-46-9]|
              [15][0-69]
            )|
            6(?:
              [0145]|
              [29][0-79]|
              3[0-689]|
              [68][0-69]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    6 => 
    array (
      'pattern' => '([1-356]\\d)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[3-9]|
            2(?:
              [1-469]|
              0[0-35-9]|
              [45][0-79]
            )|
            3(?:
              0[0-79]|
              1[0-689]|
              [24-69]|
              3[0-69]
            )|
            5(?:
              [02-46-9]|
              [15][0-69]
            )|
            6(?:
              [0145]|
              [29][0-79]|
              3[0-689]|
              [68][0-69]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    7 => 
    array (
      'pattern' => '([25]\\d{3})(\\d{3,5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            (?:
              25|
              54
            )8
          ',
        1 => '
            258[23]|
            5483
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    8 => 
    array (
      'pattern' => '([25]\\d{3})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            (?:
              25|
              54
            )8
          ',
        1 => '
            258[23]|
            5483
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    9 => 
    array (
      'pattern' => '(8\\d{3})(\\d{6})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '86',
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