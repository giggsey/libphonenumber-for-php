<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          1\\d{8}|
          [2-8]\\d{5,11}|
          9(?:
            [013-9]\\d{4,9}|
            2\\d(?:
              111\\d{6}|
              \\d{3,7}
            )
          )
        ',
    'PossibleNumberPattern' => '\\d{6,12}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            21|
            42
          )[2-9]\\d{7}|
          (?:
            2[25]|
            4[0146-9]|
            5[1-35-7]|
            6[1-8]|
            7[14]|
            8[16]|
            91
          )[2-9]\\d{6}|
          (?:
            2(?:
              3[2358]|
              4[2-4]|
              9[2-8]
            )|
            45[3479]|
            54[2-467]|
            60[468]|
            72[236]|
            8(?:
              2[2-689]|
              3[23578]|
              4[3478]|
              5[2356]
            )|
            9(?:
              1|
              2[2-8]|
              3[27-9]|
              4[2-6]|
              6[3569]|
              9[25-8]
            )
          )[2-9]\\d{5,6}|
          58[126]\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '2123456789',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          3(?:
            0\\d|
            1[1-5]|
            2[0-5]|
            3[1-6]|
            4[1-7]|
            55|
            64
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '3012345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80012345',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '900\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '90012345',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '122\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '122044444',
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
    'NationalNumberPattern' => '
          (?:
            2(?:
              [125]|
              3[2358]|
              4[2-4]|
              9[2-8]
            )|
            4(?:
              [0-246-9]|
              5[3479]
            )|
            5(?:
              [1-35-7]|
              4[2-467]
            )|
            6(?:
              [1-8]|
              0[468]
            )|
            7(?:
              [14]|
              2[236]
            )|
            8(?:
              [16]|
              2[2-689]|
              3[23578]|
              4[3478]|
              5[2356]
            )|
            9(?:
              1|
              22|
              3[27-9]|
              4[2-6]|
              6[3569]|
              9[2-7]
            )
          )111\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{11,12}',
    'ExampleNumber' => '21111825888',
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
            1(?:
              22?|
              5
            )|
            [56]
          )
        ',
    'PossibleNumberPattern' => '\\d{2,4}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'PK',
  'countryCode' => 92,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(111)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            (?:
              2[125]|
              4[0-246-9]|
              5[1-35-7]|
              6[1-8]|
              7[14]|
              8[16]|
              91
            )1
          ',
        1 => '
            (?:
              2[125]|
              4[0-246-9]|
              5[1-35-7]|
              6[1-8]|
              7[14]|
              8[16]|
              91
            )11
          ',
        2 => '
            (?:
              2[125]|
              4[0-246-9]|
              5[1-35-7]|
              6[1-8]|
              7[14]|
              8[16]|
              91
            )111
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(111)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2[349]|
            45|
            54|
            60|
            72|
            8[2-5]|
            9[2-9]
          ',
        1 => '
            (?:
              2[349]|
              45|
              54|
              60|
              72|
              8[2-5]|
              9[2-9]
            )\\d1
          ',
        2 => '
            (?:
              2[349]|
              45|
              54|
              60|
              72|
              8[2-5]|
              9[2-9]
            )\\d11
          ',
        3 => '
            (?:
              2[349]|
              45|
              54|
              60|
              72|
              8[2-5]|
              9[2-9]
            )\\d111
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{2})(\\d{7,8})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            (?:
              2[125]|
              4[0-246-9]|
              5[1-35-7]|
              6[1-8]|
              7[14]|
              8[16]|
              91
            )[2-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(\\d{3})(\\d{6,7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2[349]|
            45|
            54|
            60|
            72|
            8[2-5]|
            9[2-9]
          ',
        1 => '
            (?:
              2[349]|
              45|
              54|
              60|
              72|
              8[2-5]|
              9[2-9]
            )\\d[2-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(3\\d{2})(\\d{7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '3',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '([15]\\d{3})(\\d{5,6})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            58[12]|
            1
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    6 => 
    array (
      'pattern' => '(586\\d{2})(\\d{5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '586',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    7 => 
    array (
      'pattern' => '([89]00)(\\d{3})(\\d{2})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[89]00',
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