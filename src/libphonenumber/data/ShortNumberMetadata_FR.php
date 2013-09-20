<?php
  /* This file is automatically generated by {@link BuildMetadataPHPFromXml}.
   * Please don't modify it directly.
   */


return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '
          1\\d{1,5}|
          [27]\\d{2,4}|
          3\\d{3,4}|
          [4-68]\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{2,6}',
    'ExampleNumber' => '',
  ),
  'fixedLine' => 
  array (
    'NationalNumberPattern' => '
          1\\d{1,5}|
          [27]\\d{2,4}|
          3\\d{3,4}|
          [4-68]\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{2,6}',
    'ExampleNumber' => '',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          1\\d{1,5}|
          [27]\\d{2,4}|
          3\\d{3,4}|
          [4-68]\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{2,6}',
    'ExampleNumber' => '',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            0(?:
              07|
              13
            )|
            1(?:
              [0459]|
              6\\d{3}|
              871[03]
            )
          )|
          224|
          3(?:
            [01]\\d{2}|
            3700
          )|
          740
        ',
    'PossibleNumberPattern' => '\\d{3,6}',
    'ExampleNumber' => '3010',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          118(
            [0-68]\\d{2}|
            7(?:
              0\\d|
              1[1-9]|
              [2-9]\\d
            )
          )|
          36665|
          [4-8]\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{5,6}',
    'ExampleNumber' => '42000',
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
  'emergency' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            [578]|
            12
          )
        ',
    'PossibleNumberPattern' => '\\d{2,3}',
    'ExampleNumber' => '112',
  ),
  'voicemail' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'shortCode' => 
  array (
    'NationalNumberPattern' => '
          1(?:
            0\\d{2}|
            1(?:
              [02459]|
              6000|
              8\\d{3}
            )|
            [578]
          )|
          2(?:
            0000|
            24
          )|
          3\\d{3,4}|
          7(?:
            0[06]|
            22|
            40|
            \\d{4}
          )|
          [4-68]\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{2,6}',
    'ExampleNumber' => '1010',
  ),
  'standardRate' => 
  array (
    'NationalNumberPattern' => '
          1023|
          3(?:
            646|
            900
          )|
          70[06]
        ',
    'PossibleNumberPattern' => '\\d{3,4}',
    'ExampleNumber' => '1023',
  ),
  'carrierSpecific' => 
  array (
    'NationalNumberPattern' => '
          118777|
          2(?:
            0000|
            24
          )|
          7\\d{2}
        ',
    'PossibleNumberPattern' => '\\d{3,6}',
    'ExampleNumber' => '118777',
  ),
  'noInternationalDialling' => 
  array (
    'NationalNumberPattern' => 'NA',
    'PossibleNumberPattern' => 'NA',
    'ExampleNumber' => '',
  ),
  'id' => 'FR',
  'countryCode' => 0,
  'internationalPrefix' => '',
  'sameMobileAndFixedLinePattern' => true,
  'numberFormat' => 
  array (
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => NULL,
  'leadingZeroPossible' => NULL,
  'mobileNumberPortableRegion' => NULL,
);
/* EOF */