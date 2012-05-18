<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [1-4]\\d{8}|
          [89]\\d{9,10}
        ',
    'PossibleNumberPattern' => '\\d{7,11}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1(?:
              5(?:
                1[1-5]|
                2\\d|
                6[1-4]|
                9[1-7]
              )|
              6(?:
                [235]\\d|
                4[1-7]
              )|
              7\\d{2}
            )|
            2(?:
              1(?:
                [246]\\d|
                3[0-35-9]|
                5[1-9]
              )|
              2(?:
                [235]\\d|
                4[0-8]
              )|
              3(?:
                2\\d|
                3[02-79]|
                4[024-7]|
                5[0-7]
              )
            )
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{7,9}',
    'ExampleNumber' => '152450911',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            2(?:
              5[5679]|
              9[1-9]
            )|
            33\\d|
            44\\d
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '294911911',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            0[13]|
            20\\d
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10,11}',
    'ExampleNumber' => '8011234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          (?:
            810|
            902
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '9021234567',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            [01]|
            20
          )\\d{8}|
          902\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10,11}',
    'ExampleNumber' => '82012345678',
  ),
  'id' => 'BY',
  'countryCode' => 375,
  'internationalPrefix' => '810',
  'preferredInternationalPrefix' => '8~10',
  'nationalPrefix' => '8',
  'nationalPrefixForParsing' => '80?',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([1-4]\\d)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[1-4]',
      ),
      'nationalPrefixFormattingRule' => '8 0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([89]\\d{2})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            8[01]|
            9
          ',
      ),
      'nationalPrefixFormattingRule' => '8 $1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(8\\d{2})(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '82',
      ),
      'nationalPrefixFormattingRule' => '8 $1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);