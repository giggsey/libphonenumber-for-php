<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-9]\\d{6,9}',
    'PossibleNumberPattern' => '\\d{5,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            0[1-8]\\d{6}|
            [136]\\d{5,7}|
            (?:
              2[0-35]|
              4[0-4]|
              5[0-25-9]|
              7[13-6]|
              [89]\\d
            )\\d{5,6}
          )|
          2(?:
            [136]\\d{5,7}|
            (?:
              2[0-7]|
              4[0136-8]|
              5[0-38]|
              7[018]|
              8[01]|
              9[0-57]
            )\\d{5,6}
          )|
          3(?:
            [356]\\d{5,7}|
            (?:
              0[0-4]|
              1\\d|
              2[0-25]|
              4[056]|
              7[0-2]|
              8[0-3]|
              9[023]
            )\\d{5,6}
          )|
          4(?:
            [0246]\\d{5,7}|
            (?:
              1[0-8]|
              3[0135]|
              5[14-79]|
              7[0-246-9]|
              8[0156]|
              9[0-689]
            )\\d{5,6}
          )|
          5(?:
            0[0-6]|
            1[0-5]|
            2[0-68]|
            3[0-4]|
            4\\d|
            5[0-5]|
            6[03-5]|
            7[013]|
            8[0-79]|
            9[01]
          )\\d{5,6}|
          6(?:
            [03]\\d{5,7}|
            (?:
              1[1-3]|
              2[0-4]|
              4[02-57]|
              5[0-37]|
              6[0-3]|
              7[0-2]|
              8[0247]|
              9[0-356]
            )\\d{5,6}
          )|
          8\\d{6,8}|
          9(?:
            0\\d{5,7}|
            (?:
              1[0-68]|
              2\\d|
              3[02-59]|
              4[0-4]|
              5[0-4]|
              6[01]|
              7[0135-8]|
              8[01]
            )\\d{5,6}
          )
        ',
    'PossibleNumberPattern' => '\\d{5,9}',
    'ExampleNumber' => '8123456',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '7[02-46]\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '701234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '20\\d{4,7}',
    'PossibleNumberPattern' => '\\d{6,9}',
    'ExampleNumber' => '201234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          9(?:
            00|
            39|
            44
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '9001234567',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '77\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '771234567',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'SE',
  'countryCode' => 46,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(8)(\\d{2,3})(\\d{2,3})(\\d{2})',
      'format' => '$1-$2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '8',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([1-69]\\d)(\\d{2,3})(\\d{2})(\\d{2})',
      'format' => '$1-$2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[013689]|
            2[0136]|
            3[1356]|
            4[0246]|
            54|
            6[03]|
            90
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '([1-69]\\d)(\\d{3})(\\d{2})',
      'format' => '$1-$2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[13689]|
            2[136]|
            3[1356]|
            4[0246]|
            54|
            6[03]|
            90
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
      'format' => '$1-$2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[2457]|
            2[2457-9]|
            3[0247-9]|
            4[1357-9]|
            5[0-35-9]|
            6[124-9]|
            9(?:
              [125-8]|
              3[0-5]|
              4[0-3]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(\\d{3})(\\d{2,3})(\\d{2})',
      'format' => '$1-$2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[2457]|
            2[2457-9]|
            3[0247-9]|
            4[1357-9]|
            5[0-35-9]|
            6[124-9]|
            9(?:
              [125-8]|
              3[0-5]|
              4[0-3]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(7\\d)(\\d{3})(\\d{2})(\\d{2})',
      'format' => '$1-$2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '7',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    6 => 
    array (
      'pattern' => '(20)(\\d{2,3})(\\d{2})',
      'format' => '$1-$2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '20',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    7 => 
    array (
      'pattern' => '(9[034]\\d)(\\d{2})(\\d{2})(\\d{3})',
      'format' => '$1-$2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '9[034]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(8)(\\d{2,3})(\\d{2,3})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '8',
      ),
    ),
    1 => 
    array (
      'pattern' => '([1-69]\\d)(\\d{2,3})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[013689]|
            2[0136]|
            3[1356]|
            4[0246]|
            54|
            6[03]|
            90
          ',
      ),
    ),
    2 => 
    array (
      'pattern' => '([1-69]\\d)(\\d{3})(\\d{2})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[13689]|
            2[136]|
            3[1356]|
            4[0246]|
            54|
            6[03]|
            90
          ',
      ),
    ),
    3 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[2457]|
            2[2457-9]|
            3[0247-9]|
            4[1357-9]|
            5[0-35-9]|
            6[124-9]|
            9(?:
              [125-8]|
              3[0-5]|
              4[0-3]
            )
          ',
      ),
    ),
    4 => 
    array (
      'pattern' => '(\\d{3})(\\d{2,3})(\\d{2})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[2457]|
            2[2457-9]|
            3[0247-9]|
            4[1357-9]|
            5[0-35-9]|
            6[124-9]|
            9(?:
              [125-8]|
              3[0-5]|
              4[0-3]
            )
          ',
      ),
    ),
    5 => 
    array (
      'pattern' => '(7\\d)(\\d{3})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '7',
      ),
    ),
    6 => 
    array (
      'pattern' => '(20)(\\d{2,3})(\\d{2})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '20',
      ),
    ),
    7 => 
    array (
      'pattern' => '(9[034]\\d)(\\d{2})(\\d{2})(\\d{3})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '9[034]',
      ),
    ),
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);