<?php
/**
 * This file has been @generated by a phing task by {@link BuildMetadataPHPFromXml}.
 * See [README.md](README.md#generating-data) for more information.
 *
 * Pull requests changing data in these files will not be accepted. See the
 * [FAQ in the README](README.md#problems-with-invalid-numbers] on how to make
 * metadata changes.
 *
 * Do not modify this file directly!
 */


return array (
  'generalDesc' => 
  array (
    'NationalNumberPattern' => '[17]\\d\\d(?:\\d{2,3})?',
    'PossibleLength' => 
    array (
      0 => 3,
      1 => 5,
      2 => 6,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'tollFree' => 
  array (
    'NationalNumberPattern' => '11(?:2|6\\d{3})',
    'ExampleNumber' => '112',
    'PossibleLength' => 
    array (
      0 => 3,
      1 => 6,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'premiumRate' => 
  array (
    'PossibleLength' => 
    array (
      0 => -1,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'emergency' => 
  array (
    'NationalNumberPattern' => '112',
    'ExampleNumber' => '112',
    'PossibleLength' => 
    array (
      0 => 3,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'shortCode' => 
  array (
    'NationalNumberPattern' => '11(?:2|6(?:00[06]|1(?:1[17]|23)))|(?:1[235-8]\\d|75[12])\\d\\d',
    'ExampleNumber' => '112',
    'PossibleLength' => 
    array (
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'standardRate' => 
  array (
    'NationalNumberPattern' => '1[235-8]\\d{3}',
    'ExampleNumber' => '12000',
    'PossibleLength' => 
    array (
      0 => 5,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'carrierSpecific' => 
  array (
    'PossibleLength' => 
    array (
      0 => -1,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'smsServices' => 
  array (
    'PossibleLength' => 
    array (
      0 => -1,
    ),
    'PossibleLengthLocalOnly' => 
    array (
    ),
  ),
  'id' => 'FI',
  'countryCode' => 0,
  'internationalPrefix' => '',
  'sameMobileAndFixedLinePattern' => false,
  'numberFormat' => 
  array (
  ),
  'intlNumberFormat' => 
  array (
  ),
  'mainCountryForCode' => false,
  'mobileNumberPortableRegion' => false,
);
