<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '\\d{9}',
    'PossibleNumberPattern' => '\\d{7,9}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '2[2-8]\\d{7}',
    'PossibleNumberPattern' => '\\d{7,9}',
    'ExampleNumber' => '222345678',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          (?:
            6[158]|
            7[1-9]
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '612345678',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '80[08]\\d{6}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '800123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '90\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '900123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            40|
            6[01]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '840123456',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '41\\d{7}',
    'PossibleNumberPattern' => '\\d{9}',
    'ExampleNumber' => '412345678',
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
          11[12]|
          999
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '111',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'TZ',
  'countryCode' => 255,
  'internationalPrefix' => '00[056]',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([24]\\d)(\\d{3})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[24]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '([67]\\d{2})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[67]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '([89]\\d{2})(\\d{2})(\\d{4})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[89]',
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