<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-9]\\d{3,12}',
    'PossibleNumberPattern' => '\\d{3,13}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          1\\d{3,12}|
          (?:
            2(?:
              1[467]|
              2[13-8]|
              5[2357]|
              6[1-46-8]|
              7[1-8]|
              8[124-7]|
              9[1458]
            )|
            3(?:
              1[1-8]|
              3[23568]|
              4[5-7]|
              5[1378]|
              6[1-38]|
              8[3-68]
            )|
            4(?:
              2[1-8]|
              35|
              63|
              7[1368]|
              8[2457]
            )|
            5(?:
              12|
              2[1-8]|
              3[357]|
              4[147]|
              5[12578]|
              6[37]
            )|
            6(?:
              13|
              2[1-47]|
              4[1-35-8]|
              5[468]|
              62
            )|
            7(?:
              2[1-8]|
              3[25]|
              4[13478]|
              5[68]|
              6[16-8]|
              7[1-6]|
              9[45]
            )
          )\\d{3,10}
        ',
    'PossibleNumberPattern' => '\\d{3,13}',
    'ExampleNumber' => '1234567890',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          6(?:
            44|
            5[0-3579]|
            6[013-9]|
            [7-9]\\d
          )\\d{4,10}
        ',
    'PossibleNumberPattern' => '\\d{7,13}',
    'ExampleNumber' => '644123456',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80[02]\\d{6,10}',
    'PossibleNumberPattern' => '\\d{9,13}',
    'ExampleNumber' => '800123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          (?:
            711|
            9(?:
              0[01]|
              3[019]
            )
          )\\d{6,10}
        ',
    'PossibleNumberPattern' => '\\d{9,13}',
    'ExampleNumber' => '900123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            10|
            2[018]
          )\\d{6,10}
        ',
    'PossibleNumberPattern' => '\\d{9,13}',
    'ExampleNumber' => '810123456',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '780\\d{6,10}',
    'PossibleNumberPattern' => '\\d{9,13}',
    'ExampleNumber' => '780123456',
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
          5(?:
            (?:
              0[1-9]|
              17
            )\\d{2,10}|
            [79]\\d{3,11}
          )|
          720\\d{6,10}
        ',
    'PossibleNumberPattern' => '\\d{5,13}',
    'ExampleNumber' => '50123',
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
            [12]2|
            33|
            44
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
  'id' => 'AT',
  'countryCode' => 43,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(1)(\\d{3,12})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '1',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(5\\d)(\\d{3,5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '5[079]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(5\\d)(\\d{3})(\\d{3,4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '5[079]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(5\\d)(\\d{4})(\\d{4,7})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '5[079]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(\\d{3})(\\d{3,10})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            316|
            46|
            51|
            732|
            6(?:
              44|
              5[0-3579]|
              [6-9]
            )|
            7(?:
              1|
              [28]0
            )|
            [89]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(\\d{4})(\\d{3,9})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2|
            3(?:
              1[1-578]|
              [3-8]
            )|
            4[2378]|
            5[2-6]|
            6(?:
              [12]|
              4[1-35-9]|
              5[468]
            )|
            7(?:
              2[1-8]|
              35|
              4[1-8]|
              [57-9]
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