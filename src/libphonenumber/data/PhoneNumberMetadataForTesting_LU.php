<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [24-9]\\d{3,10}|
          3(?:
            [0-46-9]\\d{2,9}|
            5[013-9]\\d{1,8}
          )
        ',
    'PossibleNumberPattern' => '\\d{4,11}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2(?:
              2\\d{1,2}|
              3[2-9]|
              [67]\\d|
              4[1-8]\\d?|
              5[1-5]\\d?|
              9[0-24-9]\\d?
            )|
            3(?:
              [059][05-9]|
              [13]\\d|
              [26][015-9]|
              4[0-26-9]|
              7[0-389]|
              8[08]
            )\\d?|
            4\\d{2,3}|
            5(?:
              [01458]\\d|
              [27][0-69]|
              3[0-3]|
              [69][0-7]
            )\\d?|
            7(?:
              1[019]|
              2[05-9]|
              3[05]|
              [45][07-9]|
              [679][089]|
              8[06-9]
            )\\d?|
            8(?:
              0[2-9]|
              1[0-36-9]|
              3[3-9]|
              [469]9|
              [58][7-9]|
              7[89]
            )\\d?|
            9(?:
              0[89]|
              2[0-49]|
              37|
              49|
              5[0-27-9]|
              7[7-9]|
              9[0-478]
            )\\d?
          )\\d{1,7}
        ',
    'PossibleNumberPattern' => '\\d{4,11}',
    'ExampleNumber' => '27123456',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '6[269][18]\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '628123456',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80012345',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '90[01]\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '90012345',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '801\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80112345',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '70\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '70123456',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '20\\d{2,8}',
    'PossibleNumberPattern' => '\\d{4,10}',
    'ExampleNumber' => '2012345',
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
    'NationalNumberPattern' => '11[23]',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'LU',
  'countryCode' => 352,
  'internationalPrefix' => '00',
  'nationalPrefixForParsing' => '(15(?:0[06]|1[12]|35|4[04]|55|6[26]|77|88|99)\\d)',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{3})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [2-5]|
            7[1-9]|
            [89](?:
              [1-9]|
              0[2-9]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [2-5]|
            7[1-9]|
            [89](?:
              [1-9]|
              0[2-9]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    2 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '20',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    3 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})(\\d{1,2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2(?:
              [0367]|
              4[3-8]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    4 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})(\\d{3})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '20',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    5 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})(\\d{2})(\\d{1,2})',
      'format' => '$1 $2 $3 $4 $5',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2(?:
              [0367]|
              4[3-8]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    6 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})(\\d{1,4})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            2(?:
              [12589]|
              4[12]
            )|
            [3-5]|
            7[1-9]|
            [89](?:
              [1-9]|
              0[2-9]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    7 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [89]0[01]|
            70
          ',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
    8 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '6',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '$CC $1',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);