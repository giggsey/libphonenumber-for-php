<?php

declare(strict_types=1);

/**
 * @author giggsey
 * @package libphonenumber-for-php
 */

namespace libphonenumber\Tests\buildtools;

use libphonenumber\buildtools\Builders\PhoneMetadataBuilder;
use libphonenumber\buildtools\BuildMetadataFromXml;
use libphonenumber\NumberFormat;
use libphonenumber\PhoneNumberDesc;
use PHPUnit\Framework\TestCase;
use DOMDocument;
use DOMElement;
use Exception;
use RuntimeException;

class BuildMetadataFromXmlTest extends TestCase
{
    public function testValidateRERemovesWhiteSpaces(): void
    {
        $input = ' hello world ';
        // Should remove all the white spaces contained in the provided string.
        self::assertSame('helloworld', BuildMetadataFromXml::validateRE($input, true));
        // Make sure it only happens when the last parameter is set to true.
        self::assertSame(' hello world ', BuildMetadataFromXml::validateRE($input, false));
    }

    public function testValidateREThrowsException(): void
    {
        $invalidPattern = '[';
        // Should throw an exception when an invalid pattern is provided independently of the last
        // parameter (remove white spaces).
        try {
            BuildMetadataFromXml::validateRE($invalidPattern, false);
            self::fail();
        } catch (Exception $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        try {
            BuildMetadataFromXml::validateRE($invalidPattern, true);
            self::fail();
        } catch (Exception $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // We don't allow | to be followed by ) because it introduces bugs, since we typically use it at
        // the end of each line and when a line is deleted, if the pipe from the previous line is not
        // removed, we end up erroneously accepting an empty group as well.
        $patternWithPipeFollowedByClosingParentheses = '|)';
        try {
            BuildMetadataFromXml::validateRE($patternWithPipeFollowedByClosingParentheses, true);
            self::fail();
        } catch (Exception $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }
        $patternWithPipeFollowedByNewLineAndClosingParentheses = "|\n)";
        try {
            BuildMetadataFromXml::validateRE($patternWithPipeFollowedByNewLineAndClosingParentheses, true);
            self::fail();
        } catch (Exception $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }
    }

    public function testValidateRE(): void
    {
        $validPattern = '[a-zA-Z]d{1,9}';
        // The provided pattern should be left unchanged.
        self::assertSame($validPattern, BuildMetadataFromXml::validateRE($validPattern, false));
    }

    public function testGetNationalPrefix(): void
    {
        $xmlInput = "<territory nationalPrefix='00'/>";
        $territoryElement = $this->parseXMLString($xmlInput);
        self::assertSame('00', BuildMetadataFromXml::getNationalPrefix($territoryElement));
    }

    private function parseXMLString(string $xmlString): DOMElement
    {
        $domDocument = new DOMDocument();
        $domDocument->loadXML($xmlString);

        return $domDocument->documentElement ?? throw new Exception('Invalid XML');
    }

    public function testLoadTerritoryTagMetadata(): void
    {
        $xmlInput = '<territory'
            . "  countryCode='33' leadingDigits='2' internationalPrefix='00'"
            . "  preferredInternationalPrefix='00~11' nationalPrefixForParsing='0'"
            . "  nationalPrefixTransformRule='9$1'"  // nationalPrefix manually injected.
            . "  preferredExtnPrefix=' x' mainCountryForCode='true'"
            . "  mobileNumberPortableRegion='true'>"
            . '</territory>';
        $territoryElement = $this->parseXMLString($xmlInput);
        $phoneMetadata = BuildMetadataFromXml::loadTerritoryTagMetadata('33', $territoryElement, '0');
        self::assertSame(33, $phoneMetadata->getCountryCode());
        self::assertSame('2', $phoneMetadata->getLeadingDigits());
        self::assertSame('00', $phoneMetadata->getInternationalPrefix());
        self::assertSame('00~11', $phoneMetadata->getPreferredInternationalPrefix());
        self::assertSame('0', $phoneMetadata->getNationalPrefixForParsing());
        self::assertSame('9$1', $phoneMetadata->getNationalPrefixTransformRule());
        self::assertSame('0', $phoneMetadata->getNationalPrefix());
        self::assertSame(' x', $phoneMetadata->getPreferredExtnPrefix());
        self::assertTrue($phoneMetadata->isMainCountryForCode());
        self::assertTrue($phoneMetadata->isMobileNumberPortableRegion());
    }

    public function testLoadTerritoryTagMetadataSetsBooleanFieldsToFalseByDefault(): void
    {
        $xmlInput = "<territory countryCode='33'/>";
        $territoryElement = $this->parseXMLString($xmlInput);
        $phoneMetadata = BuildMetadataFromXml::loadTerritoryTagMetadata('33', $territoryElement, '');
        self::assertFalse($phoneMetadata->isMainCountryForCode());
        self::assertFalse($phoneMetadata->isMobileNumberPortableRegion());
    }

    public function testLoadTerritoryTagMetadataSetsNationalPrefixForParsingByDefault(): void
    {
        $xmlInput = "<territory countryCode='33'/>";
        $territoryElement = $this->parseXMLString($xmlInput);
        $phoneMetadata = BuildMetadataFromXml::loadTerritoryTagMetadata('33', $territoryElement, '00');
        // When unspecified, nationalPrefixForParsing defaults to nationalPrefix.
        self::assertSame('00', $phoneMetadata->getNationalPrefix());
        self::assertSame($phoneMetadata->getNationalPrefix(), $phoneMetadata->getNationalPrefixForParsing());
    }

    public function testLoadTerritoryTagMetadataWithRequiredAttributesOnly(): void
    {
        $xmlInput = "<territory countryCode='33' internationalPrefix='00'/>";
        $territoryElement = $this->parseXMLString($xmlInput);
        // Should not throw any exception
        BuildMetadataFromXml::loadTerritoryTagMetadata('33', $territoryElement, '');
        $this->addToAssertionCount(1);
    }

    public function testLoadInternationalFormat(): void
    {
        $intlFormat = '$1 $2';
        $xmlInput = '<numberFormat><intlFormat>' . $intlFormat . '</intlFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        $nationalFormat = new NumberFormat();

        self::assertTrue(BuildMetadataFromXml::loadInternationalFormat(
            $metadata,
            $numberFormatElement,
            $nationalFormat
        ));
        self::assertSame($intlFormat, $metadata->getIntlNumberFormat(0)->getFormat());
    }

    public function testLoadInternationalFormatWithBothNationalAndIntlFormatsDefined(): void
    {
        $intlFormat = '$1 $2';
        $xmlInput = '<numberFormat><intlFormat>' . $intlFormat . '</intlFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        $nationalFormat = new NumberFormat();
        $nationalFormat->setFormat('$1');

        self::assertTrue(BuildMetadataFromXml::loadInternationalFormat(
            $metadata,
            $numberFormatElement,
            $nationalFormat
        ));
        self::assertSame($intlFormat, $metadata->getIntlNumberFormat(0)->getFormat());
    }

    public function testLoadInternationalFormatExpectsOnlyOnePattern(): void
    {
        $this->expectException(RuntimeException::class);

        $xmlInput = '<numberFormat><intlFormat/><intlFormat/></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();

        // Should throw an exception as multiple intlFormats are provided
        BuildMetadataFromXml::loadInternationalFormat($metadata, $numberFormatElement, new NumberFormat());
    }

    public function testLoadInternationalFormatUsesNationalFormatByDefault(): void
    {
        $xmlInput = '<numberFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        $nationalFormat = new NumberFormat();
        $nationPattern = '$1 $2 $3';
        $nationalFormat->setFormat($nationPattern);

        self::assertFalse(BuildMetadataFromXml::loadInternationalFormat(
            $metadata,
            $numberFormatElement,
            $nationalFormat
        ));
        self::assertSame($nationPattern, $metadata->getIntlNumberFormat(0)->getFormat());
    }

    public function testLoadInternationalFormatCopiesNationalFormatData(): void
    {
        $xmlInput = '<numberFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        $nationalFormat = new NumberFormat();
        $nationalFormat->setFormat('$1-$2');
        $nationalFormat->setNationalPrefixOptionalWhenFormatting(true);

        self::assertFalse(BuildMetadataFromXml::loadInternationalFormat(
            $metadata,
            $numberFormatElement,
            $nationalFormat
        ));
        self::assertTrue($metadata->getIntlNumberFormat(0)->getNationalPrefixOptionalWhenFormatting());
    }

    public function testLoadNationalFormat(): void
    {
        $nationalFormat = '$1 $2';
        $xmlInput = '<numberFormat><format>' . $nationalFormat . '</format></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        $numberFormat = new NumberFormat();
        BuildMetadataFromXml::loadNationalFormat($metadata, $numberFormatElement, $numberFormat);
        self::assertSame($nationalFormat, $numberFormat->getFormat());
    }

    public function testLoadNationalFormatRequiresFormat(): void
    {
        $this->expectException(RuntimeException::class);

        $xmlInput = '<numberFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        $numberFormat = new NumberFormat();

        BuildMetadataFromXml::loadNationalFormat($metadata, $numberFormatElement, $numberFormat);
    }

    public function testLoadNationalFormatExpectsExactlyOneFormat(): void
    {
        $this->expectException(RuntimeException::class);

        $xmlInput = '<numberFormat><format/><format/></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        $numberFormat = new NumberFormat();

        BuildMetadataFromXml::loadNationalFormat($metadata, $numberFormatElement, $numberFormat);
    }

    public function testLoadAvailableFormats(): void
    {
        $xmlInput = '<territory>'
            . '  <availableFormats>'
            . '    <numberFormat nationalPrefixFormattingRule=\'($FG)\''
            . '                  carrierCodeFormattingRule=\'$NP $CC ($FG)\'>'
            . '      <format>$1 $2 $3</format>'
            . '    </numberFormat>'
            . '  </availableFormats>'
            . '</territory>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '', false /* NP not optional */);
        self::assertSame('($1)', $metadata->getNumberFormat(0)->getNationalPrefixFormattingRule());
        self::assertSame('0 $CC ($1)', $metadata->getNumberFormat(0)->getDomesticCarrierCodeFormattingRule());
        self::assertSame('$1 $2 $3', $metadata->getNumberFormat(0)->getFormat());
    }

    public function testLoadAvailableFormatsPropagatesCarrierCodeFormattingRule(): void
    {
        $xmlInput =
            '<territory carrierCodeFormattingRule=\'$NP $CC ($FG)\'>'
            . '  <availableFormats>'
            . '    <numberFormat nationalPrefixFormattingRule=\'($FG)\'>'
            . '      <format>$1 $2 $3</format>'
            . '    </numberFormat>'
            . '  </availableFormats>'
            . '</territory>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '', false /* NP not optional */);
        self::assertSame('($1)', $metadata->getNumberFormat(0)->getNationalPrefixFormattingRule());
        self::assertSame('0 $CC ($1)', $metadata->getNumberFormat(0)->getDomesticCarrierCodeFormattingRule());
        self::assertSame('$1 $2 $3', $metadata->getNumberFormat(0)->getFormat());
    }

    public function testLoadAvailableFormatsSetsProvidedNationalPrefixFormattingRule(): void
    {
        $xmlInput = '<territory>'
            . '  <availableFormats>'
            . '    <numberFormat><format>$1 $2 $3</format></numberFormat>'
            . '  </availableFormats>'
            . '</territory>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '', '($1)', false /* NP not optional */);
        self::assertSame('($1)', $metadata->getNumberFormat(0)->getNationalPrefixFormattingRule());
    }

    public function testLoadAvailableFormatsClearsIntlFormat(): void
    {
        $xmlInput = '<territory>'
            . '  <availableFormats>'
            . '    <numberFormat><format>$1 $2 $3</format></numberFormat>'
            . '  </availableFormats>'
            . '</territory>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '($1)', false /* NP not optional */);
        self::assertCount(0, $metadata->intlNumberFormats());
    }

    public function testLoadAvailableFormatsHandlesMultipleNumberFormats(): void
    {
        $xmlInput = '<territory>'
            . '  <availableFormats>'
            . '    <numberFormat><format>$1 $2 $3</format></numberFormat>'
            . '    <numberFormat><format>$1-$2</format></numberFormat>'
            . '  </availableFormats>'
            . '</territory>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '($1)', false /* NP not optional */);
        self::assertSame('$1 $2 $3', $metadata->getNumberFormat(0)->getFormat());
        self::assertSame('$1-$2', $metadata->getNumberFormat(1)->getFormat());
    }

    public function testLoadInternationalFormatDoesNotSetIntlFormatWhenNA(): void
    {
        $xmlInput = '<numberFormat><intlFormat>NA</intlFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        $nationalFormat = new NumberFormat();
        $nationalFormat->setFormat('$1 $2');

        BuildMetadataFromXml::loadInternationalFormat($metadata, $numberFormatElement, $nationalFormat);
        self::assertCount(0, $metadata->intlNumberFormats());
    }

    public function testSetLeadingDigitsPatterns(): void
    {
        $xmlInput = '<numberFormat>'
            . '<leadingDigits>1</leadingDigits><leadingDigits>2</leadingDigits>'
            . '</numberFormat>';

        $numberFormatElement = $this->parseXMLString($xmlInput);
        $numberFormat = new NumberFormat();
        BuildMetadataFromXml::setLeadingDigitsPatterns($numberFormatElement, $numberFormat);

        self::assertSame('1', $numberFormat->getLeadingDigitsPattern(0));
        self::assertSame('2', $numberFormat->getLeadingDigitsPattern(1));
    }

    /**
     * Tests setLeadingDigitsPatterns() in the case of international and national formatting rules
     * being present but not both defined for this numberFormat - we don't want to add them twice.
     */
    public function testSetLeadingDigitsPatternsNotAddedTwiceWhenInternationalFormatsPresent(): void
    {
        $xmlInput = '<availableFormats>'
            . '  <numberFormat pattern="(1)(\\d{3})">'
            . '    <leadingDigits>1</leadingDigits>'
            . '    <format>$1</format>'
            . '  </numberFormat>'
            . '  <numberFormat pattern="(2)(\\d{3})">'
            . '    <leadingDigits>2</leadingDigits>'
            . '    <format>$1</format>'
            . '    <intlFormat>9-$1</intlFormat>'
            . '  </numberFormat>'
            . '</availableFormats>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '', false /* NP not optional */);
        self::assertCount(1, $metadata->getNumberFormat(0)->leadingDigitPatterns());
        self::assertCount(1, $metadata->getNumberFormat(1)->leadingDigitPatterns());
        // When we merge the national format rules into the international format rules, we shouldn't add
        // the leading digit patterns multiple times.
        self::assertCount(1, $metadata->getIntlNumberFormat(0)->leadingDigitPatterns());
        self::assertCount(1, $metadata->getIntlNumberFormat(1)->leadingDigitPatterns());
    }

    public function testGetNationalPrefixFormattingRuleFromElement(): void
    {
        $xmlInput = '<territory nationalPrefixFormattingRule="$NP$FG" />';
        $element = $this->parseXMLString($xmlInput);
        self::assertSame('0$1', BuildMetadataFromXml::getNationalPrefixFormattingRuleFromElement($element, '0'));
    }

    public function testGetDomesticCarrierCodeFormattingRuleFromElement(): void
    {
        $xmlInput = '<territory carrierCodeFormattingRule=\'$NP$CC $FG\'/>';
        $element = $this->parseXMLString($xmlInput);
        self::assertSame(
            '0$CC $1',
            BuildMetadataFromXml::getDomesticCarrierCodeFormattingRuleFromElement($element, '0')
        );
    }

    public function testProcessPhoneNumberDescElementWithInvalidInput(): void
    {
        $generalDesc = new PhoneNumberDesc();
        $territoryElement = $this->parseXMLString('<territory/>');

        $phoneNumberDesc = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $territoryElement,
            'invalidType'
        );
        self::assertFalse($phoneNumberDesc->hasNationalNumberPattern());
    }

    public function testProcessPhoneNumberDescElementOverridesGeneralDesc(): void
    {
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setNationalNumberPattern('\\d{8}');
        $xmlInput = '<territory><fixedLine>'
            . '  <nationalNumberPattern>\\d{6}</nationalNumberPattern>'
            . '</fixedLine></territory>';

        $territoryElement = $this->parseXMLString($xmlInput);

        $phoneNumberDesc = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $territoryElement,
            'fixedLine'
        );
        self::assertSame('\\d{6}', $phoneNumberDesc->getNationalNumberPattern());
    }

    public function testBuildPhoneMetadataCollection_fullBuild(): void
    {
        $xmlInput = '<phoneNumberMetadata>'
            . '  <territories>'
            . '    <territory id="AM" countryCode="374" internationalPrefix="00">'
            . '      <generalDesc>'
            . '        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>'
            . '      </generalDesc>'
            . '      <fixedLine>'
            . '        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>'
            . '        <possibleLengths national="8" localOnly="5,6"/>'
            . '        <exampleNumber>10123456</exampleNumber>'
            . '      </fixedLine>'
            . '      <mobile>'
            . '        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>'
            . '        <possibleLengths national="8" localOnly="5,6"/>'
            . '        <exampleNumber>10123456</exampleNumber>'
            . '      </mobile>'
            . '    </territory>'
            . '  </territories>'
            . '</phoneNumberMetadata>';

        $document = $this->parseXMLString($xmlInput);

        $metadataCollection = BuildMetadataFromXml::buildPhoneMetadataCollection(
            $document,
            false, // isShortNumberMetadata
            false // isAlternateFormatsMetadata
        );

        self::assertCount(1, $metadataCollection);
        $metadata = $metadataCollection[0];
        self::assertTrue($metadata->hasGeneralDesc());
        self::assertNotNull($metadata->getGeneralDesc());
        self::assertFalse($metadata->getGeneralDesc()->hasExampleNumber());
        self::assertSame('', $metadata->getGeneralDesc()->getExampleNumber());
        self::assertTrue($metadata->hasFixedLine());
        self::assertNotNull($metadata->getFixedLine());
        self::assertTrue($metadata->getFixedLine()->hasExampleNumber());
        self::assertSame('10123456', $metadata->getFixedLine()->getExampleNumber());
        self::assertTrue($metadata->hasMobile());
        self::assertNotNull($metadata->getMobile());
        self::assertTrue($metadata->getMobile()->hasExampleNumber());
        self::assertSame('10123456', $metadata->getMobile()->getExampleNumber());
    }

    public function testProcessPhoneNumberDescOutputsExampleNumberByDefault(): void
    {
        $generalDesc = new PhoneNumberDesc();
        $xmlInput = '<territory><fixedLine>'
            . '  <exampleNumber>01 01 01 01</exampleNumber>'
            . '</fixedLine></territory>';

        $territoryElement = $this->parseXMLString($xmlInput);

        $phoneNumberDesc = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $territoryElement,
            'fixedLine'
        );
        self::assertSame('01 01 01 01', $phoneNumberDesc->getExampleNumber());
    }

    public function testProcessPhoneNumberDescRemovesWhiteSpacesInPatterns(): void
    {
        $generalDesc = new PhoneNumberDesc();
        $xmlInput = '<territory><fixedLine>'
            . "  <nationalNumberPattern>\t \\d { 6 } </nationalNumberPattern>"
            . '</fixedLine></territory>';

        $countryElement = $this->parseXMLString($xmlInput);

        $phoneNumberDesc = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $countryElement,
            'fixedLine'
        );
        self::assertSame('\\d{6}', $phoneNumberDesc->getNationalNumberPattern());
    }

    public function testSetRelevantDescPatternsSetsSameMobileAndFixedLinePattern(): void
    {
        $xmlInput = '<territory countryCode="33">'
            . '  <fixedLine><nationalNumberPattern>\\d{6}</nationalNumberPattern></fixedLine>'
            . '  <mobile><nationalNumberPattern>\\d{6}</nationalNumberPattern></mobile>'
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        // Should set sameMobileAndFixedPattern to true.
        BuildMetadataFromXml::setRelevantDescPatterns($metadata, $territoryElement, false /* isShortNumberMetadata */);
        self::assertTrue($metadata->getSameMobileAndFixedLinePattern());
    }

    public function testSetRelevantDescPatternsSetsAllDescriptionsForRegularLengthNumbers(): void
    {
        $xmlInput = '<territory countryCode="33">'
            . '  <fixedLine><nationalNumberPattern>\\d{1}</nationalNumberPattern></fixedLine>'
            . '  <mobile><nationalNumberPattern>\\d{2}</nationalNumberPattern></mobile>'
            . '  <pager><nationalNumberPattern>\\d{3}</nationalNumberPattern></pager>'
            . '  <tollFree><nationalNumberPattern>\\d{4}</nationalNumberPattern></tollFree>'
            . '  <premiumRate><nationalNumberPattern>\\d{5}</nationalNumberPattern></premiumRate>'
            . '  <sharedCost><nationalNumberPattern>\\d{6}</nationalNumberPattern></sharedCost>'
            . '  <personalNumber><nationalNumberPattern>\\d{7}</nationalNumberPattern></personalNumber>'
            . '  <voip><nationalNumberPattern>\\d{8}</nationalNumberPattern></voip>'
            . '  <uan><nationalNumberPattern>\\d{9}</nationalNumberPattern></uan>'
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::setRelevantDescPatterns($metadata, $territoryElement, false /* isShortNumberMetadata */);
        self::assertSame('\\d{1}', $metadata->getFixedLine()?->getNationalNumberPattern());
        self::assertSame('\\d{2}', $metadata->getMobile()?->getNationalNumberPattern());
        self::assertSame('\\d{3}', $metadata->getPager()?->getNationalNumberPattern());
        self::assertSame('\\d{4}', $metadata->getTollFree()?->getNationalNumberPattern());
        self::assertSame('\\d{5}', $metadata->getPremiumRate()?->getNationalNumberPattern());
        self::assertSame('\\d{6}', $metadata->getSharedCost()?->getNationalNumberPattern());
        self::assertSame('\\d{7}', $metadata->getPersonalNumber()?->getNationalNumberPattern());
        self::assertSame('\\d{8}', $metadata->getVoip()?->getNationalNumberPattern());
        self::assertSame('\\d{9}', $metadata->getUan()?->getNationalNumberPattern());
    }

    public function testSetRelevantDescPatternsSetsAllDescriptionsForShortNumbers(): void
    {
        $xmlInput = '<territory ID="FR">'
            . '  <tollFree><nationalNumberPattern>\\d{1}</nationalNumberPattern></tollFree>'
            . '  <standardRate><nationalNumberPattern>\\d{2}</nationalNumberPattern></standardRate>'
            . '  <premiumRate><nationalNumberPattern>\\d{3}</nationalNumberPattern></premiumRate>'
            . '  <shortCode><nationalNumberPattern>\\d{4}</nationalNumberPattern></shortCode>'
            . '  <carrierSpecific>'
            . '    <nationalNumberPattern>\\d{5}</nationalNumberPattern>'
            . '  </carrierSpecific>'
            . '  <smsServices>'
            . '    <nationalNumberPattern>\\d{6}</nationalNumberPattern>'
            . '  </smsServices>'
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::setRelevantDescPatterns($metadata, $territoryElement, true /* isShortNumberMetadata */);
        self::assertSame('\\d{1}', $metadata->getTollFree()?->getNationalNumberPattern());
        self::assertSame('\\d{2}', $metadata->getStandardRate()?->getNationalNumberPattern());
        self::assertSame('\\d{3}', $metadata->getPremiumRate()?->getNationalNumberPattern());
        self::assertSame('\\d{4}', $metadata->getShortCode()?->getNationalNumberPattern());
        self::assertSame('\\d{5}', $metadata->getCarrierSpecific()?->getNationalNumberPattern());
        self::assertSame('\\d{6}', $metadata->getSmsServices()?->getNationalNumberPattern());
    }

    public function testSetRelevantDescPatternsThrowsErrorIfTypePresentMultipleTimes(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Multiple elements with type fixedLine found.');

        $xmlInput = '<territory countryCode="33">'
            . '  <fixedLine><nationalNumberPattern>\\d{6}</nationalNumberPattern></fixedLine>'
            . '  <fixedLine><nationalNumberPattern>\\d{6}</nationalNumberPattern></fixedLine>'
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadataBuilder();
        BuildMetadataFromXml::setRelevantDescPatterns($metadata, $territoryElement, false /* isShortNumberMetadata */);
    }

    public function testAlternateFormatsOmitsDescPatterns(): void
    {
        $xmlInput = '<territory countryCode="33">'
            . '  <availableFormats>'
            . '    <numberFormat pattern="(1)(\\d{3})">'
            . '      <leadingDigits>1</leadingDigits>'
            . '      <format>$1</format>'
            . '    </numberFormat>'
            . '  </availableFormats>'
            . '  <fixedLine><nationalNumberPattern>\\d{1}</nationalNumberPattern></fixedLine>'
            . '  <shortCode><nationalNumberPattern>\\d{2}</nationalNumberPattern></shortCode>'
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = BuildMetadataFromXml::loadCountryMetadata('FR', $territoryElement, false
            /* isShortNumberMetadata */, true /* isAlternateFormatsMetadata */);
        self::assertSame('(1)(\\d{3})', $metadata->getNumberFormat(0)->getPattern());
        self::assertSame('1', $metadata->getNumberFormat(0)->getLeadingDigitsPattern(0));
        self::assertSame('$1', $metadata->getNumberFormat(0)->getFormat());
        self::assertNull($metadata->getFixedLine());
        self::assertNull($metadata->getShortCode());
    }

    public function testNationalPrefixRulesSetCorrectly(): void
    {
        $xmlInput = '<territory countryCode="33" nationalPrefix="0"'
            . ' nationalPrefixFormattingRule="$NP$FG">'
            . '  <availableFormats>'
            . '    <numberFormat pattern="(1)(\\d{3})" nationalPrefixOptionalWhenFormatting="true">'
            . '      <leadingDigits>1</leadingDigits>'
            . '      <format>$1</format>'
            . '    </numberFormat>'
            . '    <numberFormat pattern="(\\d{3})" nationalPrefixOptionalWhenFormatting="false">'
            . '      <leadingDigits>2</leadingDigits>'
            . '      <format>$1</format>'
            . '    </numberFormat>'
            . '  </availableFormats>'
            . '  <fixedLine><nationalNumberPattern>\\d{1}</nationalNumberPattern></fixedLine>'
            . '</territory>';
        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = BuildMetadataFromXml::loadCountryMetadata('FR', $territoryElement, false
            /* isShortNumberMetadata */, true /* isAlternateFormatsMetadata */);
        self::assertTrue($metadata->getNumberFormat(0)->getNationalPrefixOptionalWhenFormatting());
        // This is inherited from the territory, with $NP replaced by the actual national prefix, and
        // $FG replaced with $1.
        self::assertSame('0$1', $metadata->getNumberFormat(0)->getNationalPrefixFormattingRule());
        // Here it is explicitly set to false.
        self::assertFalse($metadata->getNumberFormat(1)->getNationalPrefixOptionalWhenFormatting());
    }

    public function testProcessPhoneNumberDescElement_PossibleLengthsSetCorrectly(): void
    {
        $generalDesc = new PhoneNumberDesc();
        // The number lengths set for the general description must be a super-set of those in the
        // element being parsed.
        $generalDesc->setPossibleLength([4, 6, 7, 13]);
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            // Sorting will be done when parsing.
            . '  <possibleLengths national="13,4" localOnly="6"/>'
            . '</fixedLine>'
            . '</territory>');

        $fixedLine = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $territoryElement,
            'fixedLine'
        );
        $mobile = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $territoryElement,
            'mobile'
        );

        $possibleLength = $fixedLine->getPossibleLength();
        self::assertCount(2, $possibleLength);
        self::assertSame(4, $possibleLength[0]);
        self::assertSame(13, $possibleLength[1]);
        self::assertCount(1, $fixedLine->getPossibleLengthLocalOnly());

        // We use [-1] to denote that there are no possible lengths; we don't leave it empty, since for
        // compression reasons, we use the empty list to mean that the generalDesc possible lengths
        // apply.
        $mobileLength = $mobile->getPossibleLength();
        self::assertCount(1, $mobileLength);
        self::assertSame(-1, $mobileLength[0]);
        self::assertCount(0, $mobile->getPossibleLengthLocalOnly());
    }

    public function testSetPossibleLengthsGeneralDesc_BuiltFromChildElements(): void
    {
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="13" localOnly="6"/>'
            . '</fixedLine>'
            . '<mobile>'
            . '  <possibleLengths national="15" localOnly="7,13"/>'
            . '</mobile>'
            . '<tollFree>'
            . '  <possibleLengths national="15"/>'
            . '</tollFree>'
            . '</territory>');

        $generalDesc = new PhoneNumberDesc();
        BuildMetadataFromXml::setPossibleLengthsGeneralDesc(
            $generalDesc,
            'someId',
            $territoryElement,
            false /* not short-number metadata */
        );

        $possibleLength = $generalDesc->getPossibleLength();
        self::assertCount(2, $possibleLength);
        self::assertSame(13, $possibleLength[0]);
        // 15 is present twice in the input in different sections, but only once in the output.
        self::assertSame(15, $possibleLength[1]);
        $possibleLengthLocalOnly = $generalDesc->getPossibleLengthLocalOnly();
        self::assertCount(2, $possibleLengthLocalOnly);
        self::assertSame(6, $possibleLengthLocalOnly[0]);
        self::assertSame(7, $possibleLengthLocalOnly[1]);
        // 13 is skipped as a "local only" length, since it is also present as a normal length.
    }

    public function testSetPossibleLengthsGeneralDesc_IgnoresNoIntlDialling(): void
    {
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="13"/>'
            . '</fixedLine>'
            . '<noInternationalDialling>'
            . '  <possibleLengths national="15"/>'
            . '</noInternationalDialling>'
            . '</territory>');

        $generalDesc = new PhoneNumberDesc();
        BuildMetadataFromXml::setPossibleLengthsGeneralDesc(
            $generalDesc,
            'someId',
            $territoryElement,
            false /* not short-number metadata */
        );

        $possibleLength = $generalDesc->getPossibleLength();
        self::assertCount(1, $possibleLength);
        self::assertSame(13, $possibleLength[0]);
        // 15 is skipped because noInternationalDialling should not contribute to the general lengths;
        // it isn't a particular "type" of number per se, it is a property that different types may
        // have.
    }

    public function testSetPossibleLengthsGeneralDesc_ShortNumberMetadata(): void
    {
        $territoryElement = $this->parseXMLString('<territory>'
            . '<shortCode>'
            . '  <possibleLengths national="6,13"/>'
            . '</shortCode>'
            . '<carrierSpecific>'
            . '  <possibleLengths national="7,13,15"/>'
            . '</carrierSpecific>'
            . '<tollFree>'
            . '  <possibleLengths national="15"/>'
            . '</tollFree>'
            . '<smsServices>'
            . '  <possibleLengths national="5"/>'
            . '</smsServices>'
            . '</territory>');

        $generalDesc = new PhoneNumberDesc();
        BuildMetadataFromXml::setPossibleLengthsGeneralDesc(
            $generalDesc,
            'someId',
            $territoryElement,
            true /* short-number metadata */
        );

        // All elements other than shortCode are ignored when creating the general desc.
        $possibleLength = $generalDesc->getPossibleLength();
        self::assertCount(2, $possibleLength);
        self::assertSame(6, $possibleLength[0]);
        self::assertSame(13, $possibleLength[1]);
    }

    public function testSetPossibleLengthsGeneralDesc_ShortNumberMetadataErrorsOnLocalLengths(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Found local-only lengths in short-number metadata');

        $territoryElement = $this->parseXMLString('<territory>'
            . '<shortCode>'
            . '  <possibleLengths national="13" localOnly="6"/>'
            . '</shortCode>'
            . '</territory>');

        $generalDesc = new PhoneNumberDesc();
        BuildMetadataFromXml::setPossibleLengthsGeneralDesc(
            $generalDesc,
            'someId',
            $territoryElement,
            true /* short-number metadata */
        );
    }

    public function testProcessPhoneNumberDescElement_ErrorDuplicates(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Duplicate length element found (6) in possibleLength string 6,6');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([6]);

        $territoryElement = $this->parseXMLString('<territory>'
            . '<mobile>'
            . '  <possibleLengths national="6,6"/>'
            . '</mobile>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'mobile');
    }

    public function testProcessPhoneNumberDescElement_ErrorDuplicatesOneLocal(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Possible length(s) found specified as a normal and local-only length: [6]');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([6]);

        $territoryElement = $this->parseXMLString('<territory>'
            . '<mobile>'
            . '  <possibleLengths national="6" localOnly="6"/>'
            . '</mobile>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'mobile');
    }

    public function testProcessPhoneNumberDescElement_ErrorUncoveredLengths(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Out-of-range possible length');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([4]);

        $territoryElement = $this->parseXMLString('<territory>'
            . '<noInternationalDialling>'
            // Sorting will be done when parsing.
            . '  <possibleLengths national="6,7,4"/>'
            . '</noInternationalDialling>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'noInternationalDialling');
    }

    public function testProcessPhoneNumberDescElement_SameAsParent(): void
    {
        $generalDesc = new PhoneNumberDesc();
        // The number lengths set for the general description must be a super-set of those in the
        // element being parsed.
        $generalDesc->setPossibleLength([4, 6, 7]);
        $generalDesc->setPossibleLengthLocalOnly([2]);
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            // Sorting will be done when parsing.
            . '  <possibleLengths national="6,7,4" localOnly="2"/>'
            . '</fixedLine>'
            . '</territory>');

        $phoneNumberDesc = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $territoryElement,
            'fixedLine'
        );

        // No possible lengths should be present, because they match the general description.
        self::assertCount(0, $phoneNumberDesc->getPossibleLength());
        // Local-only lengths should be present for child elements such as fixed-line
        self::assertCount(1, $phoneNumberDesc->getPossibleLengthLocalOnly());
    }

    public function testProcessPhoneNumberDescElement_InvalidNumber(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('For input string "4d"');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([4]);
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="4d"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testLoadCountryMetadata_GeneralDescHasNumberLengthsSet(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Found possible lengths specified at general desc: this should be derived from child elements. Affected country: FR');

        $territoryElement = $this->parseXMLString('<territory>'
            . '<generalDesc>'
            // This shouldn't be set, the possible lengths should be derived for generalDesc.
            . '  <possibleLengths national="4"/>'
            . '</generalDesc>'
            . '<fixedLine>'
            . '  <possibleLengths national="4"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::loadCountryMetadata(
            'FR',
            $territoryElement,
            false /* isShortNumberMetadata */,
            false /* isAlternateFormatsMetadata */
        );
    }

    public function testProcessPhoneNumberDescElement_ErrorEmptyPossibleLengthStringAttribute(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Empty possibleLength string found.');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([4]);
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national=""/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testProcessPhoneNumberDescElement_ErrorRangeSpecifiedWithComma(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Missing end of range character in possible length string [4,7].');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([4]);
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="[4,7]"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testProcessPhoneNumberDescElement_ErrorIncompleteRange(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Missing end of range character in possible length string [4-.');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([4]);

        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="[4-"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testProcessPhoneNumberDescElement_ErrorNoDashInRange(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Ranges must have exactly one - character: missing for [4:10].');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([4]);
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="[4:10]"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testProcessPhoneNumberDescElement_ErrorRangeIsNotFromMinToMax(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The first number in a range should be two or more digits lower than the second. Culprit possibleLength string: [10-10]');

        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength([4]);
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="[10-10]"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }
}
