<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[14-9]\\d{7,8}',
    'PossibleNumberPattern' => '\\d{6,9}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1\\d|
            4[1-4]|
            5[1-46]|
            6[1-7]|
            7[2-46]|
            8[2-4]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{6,8}',
    'ExampleNumber' => '11234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '9\\d{8}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '912345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80012345',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '805\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80512345',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '801\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80112345',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '80[24]\\d{5}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '80212345',
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
            05|
            1[67]
          )
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '105',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'PE',
  'countryCode' => 51,
  'internationalPrefix' => '19(?:1[124]|77|90)00',
  'nationalPrefix' => '0',
  'preferredExtnPrefix' => ' Anexo ',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(1)(\\d{7})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '1',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([4-8]\\d)(\\d{6})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [4-7]|
            8[2-4]
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{3})(\\d{5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '80',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(9\\d{2})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '9',
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