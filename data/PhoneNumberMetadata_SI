<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [1-7]\\d{6,7}|
          [89]\\d{4,7}
        ',
    'PossibleNumberPattern' => '\\d{5,8}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            1\\d|
            [25][2-8]|
            3[4-8]|
            4[24-8]|
            7[3-8]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{7,8}',
    'ExampleNumber' => '11234567',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            [37][01]|
            4[019]|
            51|
            6[48]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '31234567',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80\\d{4,6}',
    'PossibleNumberPattern' => '\\d{6,8}',
    'ExampleNumber' => '80123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          90\\d{4,6}|
          89[1-3]\\d{2,5}
        ',
    'PossibleNumberPattern' => '\\d{5,8}',
    'ExampleNumber' => '90123456',
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
  'id' => 'SI',
  'countryCode' => 386,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d)(\\d{3})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [12]|
            3[4-8]|
            4[24-8]|
            5[2-8]|
            7[3-8]
          ',
      ),
      'nationalPrefixFormattingRule' => '(0$1)',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([3-7]\\d)(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            [37][01]|
            4[019]|
            51|
            6
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '([89][09])(\\d{3,6})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[89][09]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '([58]\\d{2})(\\d{5})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            59|
            8[1-3]
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