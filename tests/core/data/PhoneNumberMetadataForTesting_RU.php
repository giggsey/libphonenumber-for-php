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
class PhoneNumberMetadataForTesting_RU extends PhoneMetadata
{
    protected const ID = 'RU';
    protected const COUNTRY_CODE = 7;
    protected const NATIONAL_PREFIX = '8';

    protected ?string $nationalPrefixForParsing = '8';
    protected ?string $internationalPrefix = '810';

    public function __construct()
    {
        $this->generalDesc = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[347-9]\d{9}')
            ->setPossibleLength([10]);
        $this->mobile = (new PhoneNumberDesc())
            ->setNationalNumberPattern('9\d{9}')
            ->setExampleNumber('9123456789');
        $this->premiumRate = PhoneNumberDesc::empty();
        $this->fixedLine = (new PhoneNumberDesc())
            ->setNationalNumberPattern('[348]\d{9}')
            ->setExampleNumber('3011234567');
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
