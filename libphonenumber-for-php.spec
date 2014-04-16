# Define version and release number
%define version     @PACKAGE_VERSION@
%define release     1
%define php_version 53

Name:          libphonenumber-for-php
Version:       %{version}
Release:       %{release}.php%{php_version}%{?dist}
Summary:       libphonenumber for PHP
# See https://github.com/giggsey/libphonenumber-for-php/blob/master/LICENSE
License:       Apache 2.0
Group:         Development/Libraries
URL:           https://github.com/giggsey/libphonenumber-for-php
# Get the source files from https://github.com/giggsey/libphonenumber-for-php/tags
Source:        %{name}-%{version}.tar.gz
Buildroot:     %{_tmppath}/%{name}-%{version}-%{release}-root

%description
A PHP library for parsing, formatting, storing and validating international phone numbers.
This library is based on Google's libphonenumber and forked from a version by Davide Mendolia.

%prep
%setup -q
%build

# Clean the buildroot so that it does not contain any stuff from previous builds
[ "%{buildroot}" != "/" ] && %{__rm} -rf %{buildroot}

# Install the extension
install -d %{buildroot}

# Prepare files
mkdir -p %{buildroot}/usr/share/php
cp -a src/libphonenumber/ %{buildroot}/usr/share/php

%clean
[ "%{buildroot}" != "/" ] && %{__rm} -rf %{buildroot}

%files
%defattr(-,root,root,-)
/usr/share/php/libphonenumber

%changelog
* Wed Apr 16 2014 Adrian Siminiceanu <adrian.siminiceanu@gmail.com>
 - Initial spec file
