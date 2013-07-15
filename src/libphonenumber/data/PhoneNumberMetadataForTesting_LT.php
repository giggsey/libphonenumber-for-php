<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[3-9]\\d{7}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            3[1478]|
            4[124-6]|
            52
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '31234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '6\\d{7}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '61234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80012345',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          9(?:
            0[0239]|
            10
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '90012345',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '808\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80812345',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '700\\d{5}',
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
    'NationalNumberPattern' => '70[67]\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '70712345',
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
          0(?:
            11?|
            22?|
            33?
          )|
          1(?:
            0[123]|
            12
          )
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
  'id' => 'LT',
  'countryCode' => 370,
  'internationalPrefix' => '00',
  'nationalPrefix' => '8',
  'nationalPrefixForParsing' => '[08]',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([34]\\d)(\\d{6})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            37|
            4(?:
              1|
              5[45]|
              6[2-4]
            )
          ',
      ),
      'nationalPrefixFormattingRule' => '(8-$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([3-6]\\d{2})(\\d{5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            3[148]|
            4(?:
              [24]|
              6[09]
            )|
            528|
            6
          ',
      ),
      'nationalPrefixFormattingRule' => '(8-$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '([7-9]\\d{2})(\\d{2})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[7-9]',
      ),
      'nationalPrefixFormattingRule' => '8 $1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(5)(2\\d{2})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '52[0-79]',
      ),
      'nationalPrefixFormattingRule' => '(8-$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);