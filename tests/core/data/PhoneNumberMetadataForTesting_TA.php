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
class PhoneNumberMetadataForTesting_TA extends PhoneMetadata
{
    protected const ID = 'TA';
    protected const COUNTRY_CODE = 290;

    protected ?string $internationalPrefix = '00';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('8\d{3,7}')
            ->setPossibleLength([4, 6, 8]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('8\d{3}')
            ->setExampleNumber('8123')
            ->setPossibleLength([4]);
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('8\d{5}')
            ->setExampleNumber('812345')
            ->setPossibleLength([6]);
        $this->tollFree = (new PhoneNumberDesc())
            ->setNationalNumberPattern('8\d{7}')
            ->setExampleNumber('81234567')
            ->setPossibleLength([8]);
        $this->sharedCost = PhoneNumberDesc::empty();
        $this->personalNumber = PhoneNumberDesc::empty();
        $this->voip = PhoneNumberDesc::empty();
        $this->pager = PhoneNumberDesc::empty();
        $this->uan = PhoneNumberDesc::empty();
        $this->voicemail = PhoneNumberDesc::empty();
        $this->noInternationalDialling = PhoneNumberDesc::empty();
    }
}
