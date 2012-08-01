<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [1-7]\\d{3,9}|
          8\\d{8}
        ',
    'PossibleNumberPattern' => '\\d{4,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2|
            [34][1-3]|
            5[1-5]|
            6[1-4]
          )(?:
            1\\d{2,3}|
            [2-9]\\d{6,7}
          )
        ',
    'PossibleNumberPattern' => '\\d{4,10}',
    'ExampleNumber' => '22123456',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '1[0-25-9]\\d{7,8}',
    'PossibleNumberPattern' => '\\d{9,10}',
    'ExampleNumber' => '1023456789',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '801234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '60[2-9]\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '602345678',
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
  'id' => 'KR',
  'countryCode' => 82,
  'internationalPrefix' => '00(?:[124-68]|[37]\\d{2})',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0(8[1-46-8]|85\\d{2})?',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{4})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              0|
              1[19]|
              [69]9|
              5[458]
            )|
            [57]0
          ',
        1 => '
            1(?:
              0|
              1[19]|
              [69]9|
              5(?:
                44|
                59|
                8
              )
            )|
            [57]0
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{3,4})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              [169][2-8]|
              [78]|
              5[1-4]
            )|
            [68]0|
            [3-6][1-9][2-9]
          ',
        1 => '
            1(?:
              [169][2-8]|
              [78]|
              5(?:
                [1-3]|
                4[56]
              )
            )|
            [68]0|
            [3-6][1-9][2-9]
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    2 => 
    array (
      'pattern' => '(\\d{3})(\\d)(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '131',
        1 => '1312',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    3 => 
    array (
      'pattern' => '(\\d{3})(\\d{2})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '131',
        1 => '131[13-9]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    4 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '13[2-9]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    5 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '30',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    6 => 
    array (
      'pattern' => '(\\d)(\\d{3,4})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '2[2-9]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    7 => 
    array (
      'pattern' => '(\\d)(\\d{3,4})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '21[0-46-9]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    8 => 
    array (
      'pattern' => '(\\d{2})(\\d{3,4})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[3-6][1-9]1',
        1 => '
            [3-6][1-9]1(?:
              [0-46-9]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
    9 => 
    array (
      'pattern' => '(\\d{4})(\\d{4})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1(?:
              5[46-9]|
              6[04678]
            )
          ',
        1 => '
            1(?:
              5(?:
                44|
                66|
                77|
                88|
                99
              )|
              6(?:
                00|
                44|
                6[16]|
                70|
                88
              )
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '0$CC-$1',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);