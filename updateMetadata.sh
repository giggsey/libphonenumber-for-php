#!/bin/bash
# vendor/bin/build.php
svn checkout http://libphonenumber.googlecode.com/svn/trunk/ libphonenumber-data-dir
vendor/bin/build.php BuildMetadataPHPFromXML https://libphonenumber.googlecode.com/svn/trunk/resources/PhoneNumberMetadata.xml src/libphonenumber/data/ PhoneNumberMetadata CountryCodeToRegionCodeMap src/libphonenumber/ false
vendor/bin/build.php BuildMetadataPHPFromXML https://libphonenumber.googlecode.com/svn/trunk/resources/ShortNumberMetadata.xml src/libphonenumber/data/ ShortNumberMetadata ShortNumbersRegionCodeSet src/libphonenumber/ false
vendor/bin/build.php BuildMetadataPHPFromXML https://libphonenumber.googlecode.com/svn/trunk/resources/PhoneNumberMetadataForTesting.xml Tests/data/ PhoneNumberMetadataForTesting CountryCodeToRegionCodeMapForTesting src/libphonenumber/ false
vendor/bin/build.php BuildMetadataPHPFromXML https://libphonenumber.googlecode.com/svn/trunk/resources/PhoneNumberAlternateFormats.xml src/libphonenumber/data/ PhoneNumberAlternateFormats AlternateFormatsCountryCodeSet src/libphonenumber/ false
vendor/bin/build.php GeneratePhonePrefixData libphonenumber-data-dir/resources/test/geocoding/ Tests/prefixmapper/data/