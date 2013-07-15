<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[3-689]\\d{8}',
    'PossibleNumberPattern' => '\\d{5,9}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            3[1-8]|
            4[13-8]|
            5[1-7]|
            6[12459]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{5,9}',
    'ExampleNumber' => '311234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            39|
            50|
            6[36-8]|
            9[1-9]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '391234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '800123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '900\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '900123456',
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
    'NationalNumberPattern' => '89\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '891234567',
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
            0[123]|
            12
          )
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'UA',
  'countryCode' => 380,
  'internationalPrefix' => '00',
  'preferredInternationalPrefix' => '0~0',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([3-689]\\d)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [38]9|
            4(?:
              [45][0-5]|
              87
            )|
            5(?:
              0|
              6[37]|
              7[37]
            )|
            6[36-8]|
            9[1-9]
          ',
        1 => '
            [38]9|
            4(?:
              [45][0-5]|
              87
            )|
            5(?:
              0|
              6(?:
                3[14-7]|
                7
              )|
              7[37]
            )|
            6[36-8]|
            9[1-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([3-689]\\d{2})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3[1-8]2|
            4[13678]2|
            5(?:
              [12457]2|
              6[24]
            )|
            6(?:
              [49]2|
              [12][29]|
              5[24]
            )|
            8[0-8]|
            90
          ',
        1 => '
            3(?:
              [1-46-8]2[013-9]|
              52
            )|
            4(?:
              [1378]2|
              62[013-9]
            )|
            5(?:
              [12457]2|
              6[24]
            )|
            6(?:
              [49]2|
              [12][29]|
              5[24]
            )|
            8[0-8]|
            90
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '([3-6]\\d{3})(\\d{5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3(?:
              5[013-9]|
              [1-46-8]
            )|
            4(?:
              [137][013-9]|
              6|
              [45][6-9]|
              8[4-6]
            )|
            5(?:
              [1245][013-9]|
              6[0135-9]|
              3|
              7[4-6]
            )|
            6(?:
              [49][013-9]|
              5[0135-9]|
              [12][13-8]
            )
          ',
        1 => '
            3(?:
              5[013-9]|
              [1-46-8](?:
                22|
                [013-9]
              )
            )|
            4(?:
              [137][013-9]|
              6(?:
                [013-9]|
                22
              )|
              [45][6-9]|
              8[4-6]
            )|
            5(?:
              [1245][013-9]|
              6(?:
                3[02389]|
                [015689]
              )|
              3|
              7[4-6]
            )|
            6(?:
              [49][013-9]|
              5[0135-9]|
              [12][13-8]
            )
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