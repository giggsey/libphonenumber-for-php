<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          [4-9]\\d{6}|
          38\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{7,9}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            4(?:
              [14][0-245]|
              2[0-7]|
              [37][0-8]|
              5[0-3568]|
              6\\d|
              8[0-36-8]
            )|
            5(?:
              05|
              [156]\\d|
              2[02578]|
              3[013-7]|
              4[03-7]|
              7[0-2578]|
              8[0-35-9]|
              9[013-689]
            )|
            87[23]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '4101234',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          38[59]\\d{6}|
          (?:
            6(?:
              1[0-8]|
              3[0-27-9]|
              4[0-27]|
              5[0-29]|
              [67][0-69]|
              9\\d
            )|
            7(?:
              5[057]|
              7\\d|
              8[0-3]
            )|
            8(?:
              2[0-5]|
              [469]\\d|
              5[1-9]
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7,9}',
    'ExampleNumber' => '6101234',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '800\\d{4}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '8001234',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '90\\d{5}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '9011234',
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
    'NationalNumberPattern' => '49[0-24-79]\\d{4}',
    'PossibleNumberPattern' => '\\d{7}',
    'ExampleNumber' => '4921234',
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
    'NationalNumberPattern' => '
          388\\d{6}|
          (?:
            6(?:
              2[0-8]|
              49|
              8\\d
            )|
            8(?:
              2[6-9]|
              [38]\\d|
              50|
              7[014-9]
            )|
            95[48]
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{7,9}',
    'ExampleNumber' => '388123456',
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '112',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '112',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'IS',
  'countryCode' => 354,
  'internationalPrefix' => '00',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '(\\d{3})(\\d{4})',
      'format' => '$1 $2',
      'leadingDigitsPatterns' => 
      array (
        0 => '[4-9]',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(3\\d{2})(\\d{3})(\\d{3})',
      'format' => '$1 $2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '3',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);