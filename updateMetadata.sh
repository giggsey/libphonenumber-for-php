#!/bin/bash
# php build/BuildMetadataPHPFromXml.php InputURL OutputDir DataPrefix MappingClass LiteBuild
php build/BuildMetadataPHPFromXml.php https://libphonenumber.googlecode.com/svn/trunk/resources/PhoneNumberMetadata.xml src/libphonenumber/data/ PhoneNumberMetadata CountryCodeToRegionCodeMap false
php build/BuildMetadataPHPFromXml.php https://libphonenumber.googlecode.com/svn/trunk/resources/ShortNumberMetadata.xml src/libphonenumber/data/ ShortNumberMetadata ShortNumbersRegionCodeSet false
php build/BuildMetadataPHPFromXml.php https://libphonenumber.googlecode.com/svn/trunk/resources/PhoneNumberMetadataForTesting.xml Tests/data/ PhoneNumberMetadataForTesting CountryCodeToRegionCodeMapForTesting false
php build/BuildMetadataPHPFromXml.php https://libphonenumber.googlecode.com/svn/trunk/resources/PhoneNumberAlternateFormats.xml src/libphonenumber/data/ PhoneNumberAlternateFormats AlternateFormatsCountryCodeSet false