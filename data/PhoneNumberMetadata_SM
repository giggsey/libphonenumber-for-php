<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[05-7]\\d{7,9}',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          0549(?:
            8[0157-9]|
            9\\d
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '0549886377',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '6[16]\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '66661212',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '7[178]\\d{6}',
    'PossibleNumberPattern' => '\\d{8}',
    'ExampleNumber' => '71123456',
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
  'id' => 'SM',
  'countryCode' => 378,
  'internationalPrefix' => '00',
  'nationalPrefixForParsing' => '(?:0549)?([89]\\d{5})',
  'nationalPrefixTransformRule' => '0549$1',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '[5-7]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(0549)(\\d{6})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '0',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{6})',
      'format' => '0549 $1',
      'leadingDigitsPatterns' => 
      array (
        0 => '[89]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{2})(\\d{2})(\\d{2})(\\d{2})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '[5-7]',
      ),
    ),
    1 => 
    array (
      'pattern' => '(0549)(\\d{6})',
      'format' => '($1) $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '0',
      ),
    ),
    2 => 
    array (
      'pattern' => '(\\d{6})',
      'format' => '(0549) $1',
      'leadingDigitsPatterns' => 
      array (
        0 => '[89]',
      ),
    ),
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => true,
);