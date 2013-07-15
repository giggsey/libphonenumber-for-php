<?php
return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[135789]\\d{6,9}',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '1481\\d{6}',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '1481456789',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          7(?:
            781|
            839|
            911
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '7781123456',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          80(?:
            0(?:
              1111|
              \\d{6,7}
            )|
            8\\d{7}
          )|
          500\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{7}(?:\\d{2,3})?',
    'ExampleNumber' => '8001234567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          (?:
            87[123]|
            9(?:
              [01]\\d|
              8[0-3]
            )
          )\\d{7}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '9012345678',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            4(?:
              5464\\d|
              [2-5]\\d{7}
            )|
            70\\d{7}
          )
        ',
    'PossibleNumberPattern' => '\\d{7}(?:\\d{3})?',
    'ExampleNumber' => '8431234567',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '70\\d{8}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '7012345678',
  ),
  'voip' => 
  array (
    'NationalNumberPattern' => '56\\d{8}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '5612345678',
  ),
  'pager' => 
  array (
    'NationalNumberPattern' => '
          76(?:
            0[012]|
            2[356]|
            4[0134]|
            5[49]|
            6[0-369]|
            77|
            81|
            9[39]
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '7640123456',
  ),
  'uan' => 
  array (
    'NationalNumberPattern' => '
          (?:
            3[0347]|
            55
          )\\d{8}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '5512345678',
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
  'id' => 'GG',
  'countryCode' => 44,
  'internationalPrefix' => '00',
  'nationalPrefix' => '0',
  'preferredExtnPrefix' => ' x',
  'nationalPrefixForParsing' => '0',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
);