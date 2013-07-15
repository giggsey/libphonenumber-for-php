<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[13-9]\\d{7,9}',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          (?:
            3[2-9]\\d|
            [4-9][2-9]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{6,9}',
    'ExampleNumber' => '323456789',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            1[1-3]\\d{2}|
            [02-4679][2-9]\\d|
            8(?:
              1[23]|
              [2-9]\\d
            )
          )\\d{5}
        ',
    'PossibleNumberPattern' => '\\d{9,10}',
    'ExampleNumber' => '123456789',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '1[38]00\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1300123456',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '1600\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1600123456',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '1700\\d{6}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1700123456',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '154\\d{7}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '1541234567',
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
          112|
          999
        ',
    'PossibleNumberPattern' => '\\d{3}',
    'ExampleNumber' => '999',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'MY',
  'countryCode' => 60,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
    0 => 
    array (
      'pattern' => '([4-79])(\\d{3})(\\d{4})',
      'format' => '$1-$2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '[4-79]',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    1 => 
    array (
      'pattern' => '(3)(\\d{4})(\\d{4})',
      'format' => '$1-$2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '3',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    2 => 
    array (
      'pattern' => '([18]\\d)(\\d{3})(\\d{3,4})',
      'format' => '$1-$2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '
            1[02-46-9][1-9]|
            8
          ',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    3 => 
    array (
      'pattern' => '(1)([36-8]00)(\\d{2})(\\d{4})',
      'format' => '$1-$2-$3-$4',
      'leadingDigitsPatterns' => 
      array (
        0 => '1[36-8]0',
      ),
      'nationalPrefixFormattingRule' => '',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    4 => 
    array (
      'pattern' => '(11)(\\d{4})(\\d{4})',
      'format' => '$1-$2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '11',
      ),
      'nationalPrefixFormattingRule' => '0$1',
      'domesticCarrierCodeFormattingRule' => '',
    ),
    5 => 
    array (
      'pattern' => '(154)(\\d{3})(\\d{4})',
      'format' => '$1-$2 $3',
      'leadingDigitsPatterns' => 
      array (
        0 => '15',
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