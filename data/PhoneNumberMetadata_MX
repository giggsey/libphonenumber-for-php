<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-9]\\d{9,10}',
    'PossibleNumberPattern' => '\\d{7,11}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            33|
            55|
            81
          )\\d{8}|
          (?:
            2(?:
              2[2-9]|
              3[1-35-8]|
              4[13-9]|
              7[1-689]|
              8[1-578]|
              9[467]
            )|
            3(?:
              1[1-79]|
              [2458][1-9]|
              7[1-8]|
              9[1-5]
            )|
            4(?:
              1[1-57-9]|
              [24-6][1-9]|
              [37][1-8]|
              8[1-35-9]|
              9[2-689]
            )|
            5(?:
              88|
              9[1-79]
            )|
            6(?:
              1[2-68]|
              [234][1-9]|
              5[1-3689]|
              6[12457-9]|
              7[1-7]|
              8[67]|
              9[4-8]
            )|
            7(?:
              [13467][1-9]|
              2[1-8]|
              5[13-9]|
              8[1-69]|
              9[17]
            )|
            8(?:
              2[13-689]|
              3[1-6]|
              4[124-6]|
              6[1246-9]|
              7[1-378]|
              9[12479]
            )|
            9(?:
              1[346-9]|
              2[1-4]|
              3[2-46-8]|
              5[1348]|
              [69][1-9]|
              7[12]|
              8[1-8]
            )
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{7,10}',
    'ExampleNumber' => '2221234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            (?:
              33|
              55|
              81
            )\\d{8}|
            (?:
              2(?:
                2[2-9]|
                3[1-35-8]|
                4[13-9]|
                7[1-689]|
                8[1-578]|
                9[467]
              )|
              3(?:
                1[1-79]|
                [2458][1-9]|
                7[1-8]|
                9[1-5]
              )|
              4(?:
                1[1-57-9]|
                [24-6][1-9]|
                [37][1-8]|
                8[1-35-9]|
                9[2-689]
              )|
              5(?:
                88|
                9[1-79]
              )|
              6(?:
                1[2-68]|
                [2-4][1-9]|
                5[1-3689]|
                6[12457-9]|
                7[1-7]|
                8[67]|
                9[4-8]
              )|
              7(?:
                [13467][1-9]|
                2[1-8]|
                5[13-9]|
                8[1-69]|
                9[17]
              )|
              8(?:
                2[13-689]|
                3[1-6]|
                4[124-6]|
                6[1246-9]|
                7[1-378]|
                9[12479]
              )|
              9(?:
                1[346-9]|
                2[1-4]|
                3[2-46-8]|
                5[1348]|
                [69][1-9]|
                7[12]|
                8[1-8]
              )
            )\\d{7}
          )
        ',
    'PossibleNumberPattern' => '\\d{11}',
    'ExampleNumber' => '12221234567',
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
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'MX',
  'countryCode' => 52,
  'internationalPrefix' => '0[09]',
  'nationalPrefix' => '01',
  'nationalPrefixForParsing' => '0[12]|04[45](\\d{10})',
  'nationalPrefixTransformRule' => '1$1',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([358]\\d)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            33|
            55|
            81
          ',
      ),
      'nationalPrefixFormattingRule' => '01 $1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [2467]|
            3[12457-9]|
            5[89]|
            8[02-9]|
            9[0-35-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '01 $1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(1)([358]\\d)(\\d{4})(\\d{4})',
      'format' => '044 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              33|
              55|
              81
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(1)(\\d{3})(\\d{3})(\\d{4})',
      'format' => '044 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              [2467]|
              3[12457-9]|
              5[89]|
              8[2-9]|
              9[1-35-9]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([358]\\d)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            33|
            55|
            81
          ',
      ),
    ),
    1 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [2467]|
            3[12457-9]|
            5[89]|
            8[02-9]|
            9[0-35-9]
          ',
      ),
    ),
    2 => 
    array (
      'pattern' => '(1)([358]\\d)(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              33|
              55|
              81
            )
          ',
      ),
    ),
    3 => 
    array (
      'pattern' => '(1)(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              [2467]|
              3[12457-9]|
              5[89]|
              8[2-9]|
              9[1-35-9]
            )
          ',
      ),
    ),
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);