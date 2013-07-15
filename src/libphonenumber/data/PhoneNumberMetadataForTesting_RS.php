<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [126-9]\\d{4,11}|
          3(?:
            [0-79]\\d{3,10}|
            8[2-9]\\d{2,9}
          )
        ',
    'PossibleNumberPattern' => '\\d{5,12}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1(?:
              [02-9][2-9]|
              1[1-9]
            )\\d|
            2(?:
              [0-24-7][2-9]\\d|
              [389](?:
                0[2-9]|
                [2-9]\\d
              )
            )|
            3(?:
              [0-8][2-9]\\d|
              9(?:
                [2-9]\\d|
                0[2-9]
              )
            )
          )\\d{3,8}
        ',
    'PossibleNumberPattern' => '\\d{5,12}',
    'ExampleNumber' => '10234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          6(?:
            [0-689]|
            7\\d
          )\\d{6,7}
        ',
    'PossibleNumberPattern' => '\\d{8,10}',
    'ExampleNumber' => '601234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{3,9}',
    'PossibleNumberPattern' => '\\d{6,12}',
    'ExampleNumber' => '80012345',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          (?:
            90[0169]|
            78\\d
          )\\d{3,7}
        ',
    'PossibleNumberPattern' => '\\d{6,12}',
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
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
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
    'NationalNumberPattern' => '7[06]\\d{4,10}',
    'PossibleNumberPattern' => '\\d{6,12}',
    'ExampleNumber' => '700123456',
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
          112|
          9[234]
        ',
    'PossibleNumberPattern' => '\\d{2,3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'RS',
  'countryCode' => 381,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([23]\\d{2})(\\d{4,9})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            (?:
              2[389]|
              39
            )0
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([1-3]\\d)(\\d{5,10})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1|
            2(?:
              [0-24-7]|
              [389][1-9]
            )|
            3(?:
              [0-8]|
              9[1-9]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(6\\d)(\\d{6,8})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '6',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '([89]\\d{2})(\\d{3,9})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[89]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(7[26])(\\d{4,9})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '7[26]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(7[08]\\d)(\\d{4,9})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '7[08]',
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