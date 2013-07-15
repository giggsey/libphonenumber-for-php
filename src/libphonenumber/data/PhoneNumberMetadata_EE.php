<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          1\\d{3,4}|
          [3-9]\\d{6,7}|
          800\\d{6,7}
        ',
    'PossibleNumberPattern' => '\\d{4,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            3[23589]|
            4(?:
              0\\d|
              [3-8]
            )|
            6\\d|
            7[1-9]|
            88
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '3212345',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            5\\d|
            8[1-5]
          )\\d{6}|
          5(?:
            [02]\\d{2}|
            1(?:
              [0-8]\\d|
              95
            )|
            5[0-478]\\d|
            64[0-4]|
            65[1-589]
          )\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '51234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          800(?:
            0\\d{3}|
            1\\d|
            [2-9]
          )\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{7,10}',
    'ExampleNumber' => '80012345',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '900\\d{4}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '9001234',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '70[0-2]\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '70012345',
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
          1(?:
            2[01245]|
            3[0-6]|
            4[1-489]|
            5[0-59]|
            6[1-46-9]|
            7[0-27-9]|
            8[189]|
            9[012]
          )\\d{1,2}
        ',
    'PossibleNumberPattern' => '\\d{4,5}',
    'ExampleNumber' => '12123',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '11[02]',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '
          1\\d{3,4}|
          800[2-9]\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{4,7}',
    'ExampleNumber' => '8002123',
  ),
  'id' => 'EE',
  'countryCode' => 372,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([3-79]\\d{2})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [369]|
            4[3-8]|
            5(?:
              [0-2]|
              5[0-478]|
              6[45]
            )|
            7[1-9]
          ',
        1 => '
            [369]|
            4[3-8]|
            5(?:
              [02]|
              1(?:
                [0-8]|
                95
              )|
              5[0-478]|
              6(?:
                4[0-4]|
                5[1-589]
              )
            )|
            7[1-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(70)(\\d{2})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '70',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(8000)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '800',
        1 => '8000',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '([458]\\d{3})(\\d{3,4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            40|
            5|
            8(?:
              00|
              [1-5]
            )
          ',
        1 => '
            40|
            5|
            8(?:
              00[1-9]|
              [1-5]
            )
          ',
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