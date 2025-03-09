<?php

/**
 * libphonenumber-for-php data file
 * This file has been @generated from libphonenumber data
 * Do not modify!
 * @internal
 */

declare(strict_types=1);

namespace libphonenumber\Tests\core\data;

use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;

/**
 * @internal
 */
class PhoneNumberMetadataForTesting_CC extends PhoneMetadata
{
    protected const ID = 'CC';
    protected const COUNTRY_CODE = 61;

    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('\d{6,10}')
            ->setPossibleLengthLocalOnly([6])
            ->setPossibleLength([10]);
        $this->mobile = PhoneNumberDesc::empty();
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('\d{6,10}')
            ->setExampleNumber('2261234567')
            ->setPossibleLengthLocalOnly([6]);
        $this->tollFree = PhoneNumberDesc::empty();
        $this->sharedCost = PhoneNumberDesc::empty();
        $this->personalNumber = PhoneNumberDesc::empty();
        $this->voip = PhoneNumberDesc::empty();
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
