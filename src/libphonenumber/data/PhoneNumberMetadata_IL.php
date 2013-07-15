<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [17]\\d{6,9}|
          [2-589]\\d{3}(?:\\d{3,6})?|
          6\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{4,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '[2-489]\\d{7}',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '21234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          5(?:
            [02347-9]\\d{2}|
            5(?:
              2[23]|
              3[34]|
              4[45]|
              5[5689]|
              6[67]|
              7[78]|
              8[89]
            )|
            6[2-9]\\d
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '501234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            80[019]\\d{3}|
            255
          )\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{7,10}',
    'ExampleNumber' => '1800123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            212|
            (?:
              9(?:
                0[01]|
                19
              )|
              200
            )\\d{2}
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{8,10}',
    'ExampleNumber' => '1919123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '1700\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1700123456',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '
          7(?:
            2[23]\\d|
            3[237]\\d|
            47\\d|
            6(?:
              5\\d|
              8[08]
            )|
            7\\d{2}|
            8(?:
              33|
              55|
              77|
              81
            )
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '771234567',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'uan' => 
  array (
    'NationalNumberPattern' => '[2-689]\\d{3}',
    'PossibleNumberPattern' => '\\d{4}',
    'ExampleNumber' => '2250',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => '1599\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1599123456',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            0[012]|
            12
          )
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => '
          1700\\d{6}|
          [2-689]\\d{3}
        ',
    'PossibleNumberPattern' => '\\d{4,10}',
    'ExampleNumber' => '1700123456',
  ),
  'id' => 'IL',
  'countryCode' => 972,
  'internationalPrefix' => '0(?:0|1[2-9])',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([2-489])(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2-489]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([57]\\d)(\\d{3})(\\d{4})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[57]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(1)([7-9]\\d{2})(\\d{3})(\\d{3})',
      'format' => '$1-$2-$3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '1[7-9]',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(1255)(\\d{3})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '125',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(1200)(\\d{3})(\\d{3})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '120',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(1212)(\\d{2})(\\d{2})',
      'format' => '$1-$2-$3',
      'leadingDigitsPatterns' => 
      array (
        0 => '121',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    6 => 
    array (
      'pattern' => '(1599)(\\d{6})',
      'format' => '$1-$2',
      'leadingDigitsPatterns' => 
      array (
        0 => '15',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    7 => 
    array (
      'pattern' => '(\\d{4})',
      'format' => '*$1',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2-689]',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);