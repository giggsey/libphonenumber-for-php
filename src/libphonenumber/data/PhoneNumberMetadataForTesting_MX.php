<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[1-9]\\d{9,10}',
    'PossibleNumberPattern' => '\\d{7,11}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '[2-9]\\d{9}',
    'PossibleNumberPattern' => '\\d{7,10}',
    'ExampleNumber' => '',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '1\\d{10}',
    'PossibleNumberPattern' => '\\d{11}',
    'ExampleNumber' => '',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '900\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '',
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
  'id' => 'MX',
  'countryCode' => 52,
  'internationalPrefix' => '00',
  'nationalPrefix' => '01',
  'nationalPrefixForParsing' => '01|04[45](\\d{10})',
  'nationalPrefixTransformRule' => '1$1',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[89]00',
      ),
      'nationalPrefixFormattingRule' => '01 $1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '33|55|81',
      ),
      'nationalPrefixFormattingRule' => '01 $1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2467]|3[0-24-9]|5[0-46-9]|8[2-9]|9[1-9]',
      ),
      'nationalPrefixFormattingRule' => '01 $1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(1)(\\d{2})(\\d{4})(\\d{4})',
      'format' => '045 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '1(?:33|55|81)',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(1)(\\d{3})(\\d{3})(\\d{4})',
      'format' => '045 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '1(?:[124579]|3[0-24-9]|5[0-46-9]|8[02-9])',
      ),
      'nationalPrefixFormattingRule' => '$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[89]00',
      ),
    ),
    1 => 
    array (
      'pattern' => '(\\d{2})(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '33|55|81',
      ),
    ),
    2 => 
    array (
      'pattern' => '(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[2467]|3[0-24-9]|5[0-46-9]|8[2-9]|9[1-9]',
      ),
    ),
    3 => 
    array (
      'pattern' => '(1)(\\d{2})(\\d{4})(\\d{4})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '1(?:33|55|81)',
      ),
    ),
    4 => 
    array (
      'pattern' => '(1)(\\d{3})(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3 $4',
      'leadingDigitsPatterns' => 
      array (
        0 => '1(?:[124579]|3[0-24-9]|5[0-46-9]|8[02-9])',
      ),
    ),
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);