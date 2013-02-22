#!/bin/bash

cd build

php BuildMetadataPHPFromXml.php http://libphonenumber.googlecode.com/svn/trunk/resources/PhoneNumberMetaData.xml ../data/ false

