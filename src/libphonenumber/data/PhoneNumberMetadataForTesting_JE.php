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
    'NationalNumberPattern' => '1534\\d{6}',
    'PossibleNumberPattern' => '\\d{6,10}',
    'ExampleNumber' => '1534456789',
  ),
  'mobile' => 
  array (
    'NationalNumberPattern' => '
          7(?:
            509|
            7(?:
              00|
              97
            )|
            829|
            937
          )\\d{6}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '7797123456',
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '
          80(?:
            07(?:
              35|
              81
            )|
            8901
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8007354567',
  ),
  'premiumRate' => 
  array (
    'NationalNumberPattern' => '
          (?:
            871206|
            90(?:
              066[59]|
              1810|
              71(?:
                07|
                55
              )
            )
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '9018105678',
  ),
  'sharedCost' => 
  array (
    'NationalNumberPattern' => '
          8(?:
            4(?:
              4(?:
                4(?:
                  05|
                  42|
                  69
                )|
                703
              )|
              5(?:
                041|
                800
              )
            )|
            70002
          )\\d{4}
        ',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '8447034567',
  ),
  'personalNumber' => 
  array (
    'NationalNumberPattern' => '701511\\d{4}',
    'PossibleNumberPattern' => '\\d{10}',
    'ExampleNumber' => '7015115678',
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
          3(?:
            0(?:
              07(?:
                35|
                81
              )|
              8901
            )|
            3\\d{4}|
            4(?:
              4(?:
                4(?:
                  05|
                  42|
                  69
                )|
                703
              )|
              5(?:
                041|
                800
              )
            )|
            7(?:
              0002|
              1206
            )
          )\\d{4}|
          55\\d{8}
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
  'id' => 'JE',
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