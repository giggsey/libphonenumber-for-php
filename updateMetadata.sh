#!/bin/bash

cd build

rm -f ../data/*

php BuildMetadataPHPFromXml.php http://libphonenumber.googlecode.com/svn/trunk/resources/PhoneNumberMetaData.xml ../data/ false

