<?php
/**
 *
 * @author giggsey
 * @package libphonenumber-for-php
 */

namespace libphonenumber\Tests\buildtools;

use libphonenumber\buildtools\BuildMetadataFromXml;
use libphonenumber\buildtools\MetadataFilter;
use libphonenumber\NumberFormat;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class BuildMetadataFromXmlTest extends TestCase
{
    public function testValidateRERemovesWhiteSpaces()
    {
        $input = ' hello world ';
        // Should remove all the white spaces contained in the provided string.
        $this->assertEquals('helloworld', BuildMetadataFromXml::validateRE($input, true));
        // Make sure it only happens when the last parameter is set to true.
        $this->assertEquals(' hello world ', BuildMetadataFromXml::validateRE($input, false));
    }

    public function testValidateREThrowsException()
    {
        $invalidPattern = '[';
        // Should throw an exception when an invalid pattern is provided independently of the last
        // parameter (remove white spaces).
        try {
            BuildMetadataFromXml::validateRE($invalidPattern, false);
            $this->fail();
        } catch (\Exception $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        try {
            BuildMetadataFromXml::validateRE($invalidPattern, true);
            $this->fail();
        } catch (\Exception $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // We don't allow | to be followed by ) because it introduces bugs, since we typically use it at
        // the end of each line and when a line is deleted, if the pipe from the previous line is not
        // removed, we end up erroneously accepting an empty group as well.
        $patternWithPipeFollowedByClosingParentheses = '|)';
        try {
            BuildMetadataFromXml::validateRE($patternWithPipeFollowedByClosingParentheses, true);
            $this->fail();
        } catch (\Exception $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }
        $patternWithPipeFollowedByNewLineAndClosingParentheses = "|\n)";
        try {
            BuildMetadataFromXml::validateRE($patternWithPipeFollowedByNewLineAndClosingParentheses, true);
            $this->fail();
        } catch (\Exception $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }
    }

    public function testValidateRE()
    {
        $validPattern = '[a-zA-Z]d{1,9}';
        // The provided pattern should be left unchanged.
        $this->assertEquals($validPattern, BuildMetadataFromXml::validateRE($validPattern, false));
    }

    public function testGetNationalPrefix()
    {
        $xmlInput = "<territory nationalPrefix='00'/>";
        $territoryElement = $this->parseXMLString($xmlInput);
        $this->assertEquals('00', BuildMetadataFromXml::getNationalPrefix($territoryElement));
    }

    /**
     * @param $xmlString
     * @return \DOMElement
     */
    private function parseXMLString($xmlString)
    {
        $domDocument = new \DOMDocument();
        $domDocument->loadXML($xmlString);

        return $domDocument->documentElement;
    }

    public function testLoadTerritoryTagMetadata()
    {
        $xmlInput = '<territory'
            . "  countryCode='33' leadingDigits='2' internationalPrefix='00'"
            . "  preferredInternationalPrefix='0011' nationalPrefixForParsing='0'"
            . "  nationalPrefixTransformRule='9$1'"  // nationalPrefix manually injected.
            . "  preferredExtnPrefix=' x' mainCountryForCode='true'"
            . "  leadingZeroPossible='true' mobileNumberPortableRegion='true'>"
            . '</territory>';
        $territoryElement = $this->parseXMLString($xmlInput);
        $phoneMetadata = BuildMetadataFromXml::loadTerritoryTagMetadata('33', $territoryElement, '0');
        $this->assertEquals(33, $phoneMetadata->getCountryCode());
        $this->assertEquals('2', $phoneMetadata->getLeadingDigits());
        $this->assertEquals('00', $phoneMetadata->getInternationalPrefix());
        $this->assertEquals('0011', $phoneMetadata->getPreferredInternationalPrefix());
        $this->assertEquals('0', $phoneMetadata->getNationalPrefixForParsing());
        $this->assertEquals('9$1', $phoneMetadata->getNationalPrefixTransformRule());
        $this->assertEquals('0', $phoneMetadata->getNationalPrefix());
        $this->assertEquals(' x', $phoneMetadata->getPreferredExtnPrefix());
        $this->assertTrue($phoneMetadata->isMainCountryForCode());
        $this->assertTrue($phoneMetadata->isMobileNumberPortableRegion());
    }

    public function testLoadTerritoryTagMetadataSetsBooleanFieldsToFalseByDefault()
    {
        $xmlInput = "<territory countryCode='33'/>";
        $territoryElement = $this->parseXMLString($xmlInput);
        $phoneMetadata = BuildMetadataFromXml::loadTerritoryTagMetadata('33', $territoryElement, '');
        $this->assertFalse($phoneMetadata->isMainCountryForCode());
        $this->assertFalse($phoneMetadata->isMobileNumberPortableRegion());
    }

    public function testLoadTerritoryTagMetadataSetsNationalPrefixForParsingByDefault()
    {
        $xmlInput = "<territory countryCode='33'/>";
        $territoryElement = $this->parseXMLString($xmlInput);
        $phoneMetadata = BuildMetadataFromXml::loadTerritoryTagMetadata('33', $territoryElement, '00');
        // When unspecified, nationalPrefixForParsing defaults to nationalPrefix.
        $this->assertEquals('00', $phoneMetadata->getNationalPrefix());
        $this->assertEquals($phoneMetadata->getNationalPrefix(), $phoneMetadata->getNationalPrefixForParsing());
    }

    public function testLoadTerritoryTagMetadataWithRequiredAttributesOnly()
    {
        $xmlInput = "<territory countryCode='33' internationalPrefix='00'/>";
        $territoryElement = $this->parseXMLString($xmlInput);
        // Should not throw any exception
        BuildMetadataFromXml::loadTerritoryTagMetadata('33', $territoryElement, '');
    }

    public function testLoadInternationalFormat()
    {
        $intlFormat = '$1 $2';
        $xmlInput = '<numberFormat><intlFormat>' . $intlFormat . '</intlFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        $nationalFormat = new NumberFormat();

        $this->assertTrue(BuildMetadataFromXml::loadInternationalFormat(
            $metadata,
            $numberFormatElement,
            $nationalFormat
        ));
        $this->assertEquals($intlFormat, $metadata->getIntlNumberFormat(0)->getFormat());
    }

    public function testLoadInternationalFormatWithBothNationalAndIntlFormatsDefined()
    {
        $intlFormat = '$1 $2';
        $xmlInput = '<numberFormat><intlFormat>' . $intlFormat . '</intlFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        $nationalFormat = new NumberFormat();
        $nationalFormat->setFormat('$1');

        $this->assertTrue(BuildMetadataFromXml::loadInternationalFormat(
            $metadata,
            $numberFormatElement,
            $nationalFormat
        ));
        $this->assertEquals($intlFormat, $metadata->getIntlNumberFormat(0)->getFormat());
    }

    public function testLoadInternationalFormatExpectsOnlyOnePattern()
    {
        $this->expectException(RuntimeException::class);
        $xmlInput = '<numberFormat><intlFormat/><intlFormat/></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();

        // Should throw an exception as multiple intlFormats are provided
        BuildMetadataFromXml::loadInternationalFormat($metadata, $numberFormatElement, new NumberFormat());
    }

    public function testLoadInternationalFormatUsesNationalFormatByDefault()
    {
        $xmlInput = '<numberFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        $nationalFormat = new NumberFormat();
        $nationPattern = '$1 $2 $3';
        $nationalFormat->setFormat($nationPattern);

        $this->assertFalse(BuildMetadataFromXml::loadInternationalFormat(
            $metadata,
            $numberFormatElement,
            $nationalFormat
        ));
        $this->assertEquals($nationPattern, $metadata->getIntlNumberFormat(0)->getFormat());
    }

    public function testLoadInternationalFormatCopiesNationalFormatData()
    {
        $xmlInput = '<numberFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        $nationalFormat = new NumberFormat();
        $nationalFormat->setFormat('$1-$2');
        $nationalFormat->setNationalPrefixOptionalWhenFormatting(true);

        $this->assertFalse(BuildMetadataFromXml::loadInternationalFormat(
            $metadata,
            $numberFormatElement,
            $nationalFormat
        ));
        $this->assertTrue($metadata->getIntlNumberFormat(0)->getNationalPrefixOptionalWhenFormatting());
    }

    public function testLoadNationalFormat()
    {
        $nationalFormat = '$1 $2';
        $xmlInput = '<numberFormat><format>' . $nationalFormat . '</format></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        $numberFormat = new NumberFormat();
        BuildMetadataFromXml::loadNationalFormat($metadata, $numberFormatElement, $numberFormat);
        $this->assertEquals($nationalFormat, $numberFormat->getFormat());
    }

    public function testLoadNationalFormatRequiresFormat()
    {
        $this->expectException(RuntimeException::class);
        $xmlInput = '<numberFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        $numberFormat = new NumberFormat();

        BuildMetadataFromXml::loadNationalFormat($metadata, $numberFormatElement, $numberFormat);
    }

    public function testLoadNationalFormatExpectsExactlyOneFormat()
    {
        $this->expectException(RuntimeException::class);
        $xmlInput = '<numberFormat><format/><format/></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        $numberFormat = new NumberFormat();

        BuildMetadataFromXml::loadNationalFormat($metadata, $numberFormatElement, $numberFormat);
    }

    public function testLoadAvailableFormats()
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
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '', false /* NP not optional */);
        $this->assertEquals('($1)', $metadata->getNumberFormat(0)->getNationalPrefixFormattingRule());
        $this->assertEquals('0 $CC ($1)', $metadata->getNumberFormat(0)->getDomesticCarrierCodeFormattingRule());
        $this->assertEquals('$1 $2 $3', $metadata->getNumberFormat(0)->getFormat());
    }

    public function testLoadAvailableFormatsPropagatesCarrierCodeFormattingRule()
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
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '', false /* NP not optional */);
        $this->assertEquals('($1)', $metadata->getNumberFormat(0)->getNationalPrefixFormattingRule());
        $this->assertEquals('0 $CC ($1)', $metadata->getNumberFormat(0)->getDomesticCarrierCodeFormattingRule());
        $this->assertEquals('$1 $2 $3', $metadata->getNumberFormat(0)->getFormat());
    }

    public function testLoadAvailableFormatsSetsProvidedNationalPrefixFormattingRule()
    {
        $xmlInput = '<territory>'
            . '  <availableFormats>'
            . '    <numberFormat><format>$1 $2 $3</format></numberFormat>'
            . '  </availableFormats>'
            . '</territory>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '', '($1)', false /* NP not optional */);
        $this->assertEquals('($1)', $metadata->getNumberFormat(0)->getNationalPrefixFormattingRule());
    }

    public function testLoadAvailableFormatsClearsIntlFormat()
    {
        $xmlInput = '<territory>'
            . '  <availableFormats>'
            . '    <numberFormat><format>$1 $2 $3</format></numberFormat>'
            . '  </availableFormats>'
            . '</territory>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '($1)', false /* NP not optional */);
        $this->assertCount(0, $metadata->intlNumberFormats());
    }

    public function testLoadAvailableFormatsHandlesMultipleNumberFormats()
    {
        $xmlInput = '<territory>'
            . '  <availableFormats>'
            . '    <numberFormat><format>$1 $2 $3</format></numberFormat>'
            . '    <numberFormat><format>$1-$2</format></numberFormat>'
            . '  </availableFormats>'
            . '</territory>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '($1)', false /* NP not optional */);
        $this->assertEquals('$1 $2 $3', $metadata->getNumberFormat(0)->getFormat());
        $this->assertEquals('$1-$2', $metadata->getNumberFormat(1)->getFormat());
    }

    public function testLoadInternationalFormatDoesNotSetIntlFormatWhenNA()
    {
        $xmlInput = '<numberFormat><intlFormat>NA</intlFormat></numberFormat>';
        $numberFormatElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        $nationalFormat = new NumberFormat();
        $nationalFormat->setFormat('$1 $2');

        BuildMetadataFromXml::loadInternationalFormat($metadata, $numberFormatElement, $nationalFormat);
        $this->assertCount(0, $metadata->intlNumberFormats());
    }

    public function testSetLeadingDigitsPatterns()
    {
        $xmlInput = '<numberFormat>'
            . '<leadingDigits>1</leadingDigits><leadingDigits>2</leadingDigits>'
            . '</numberFormat>';

        $numberFormatElement = $this->parseXMLString($xmlInput);
        $numberFormat = new NumberFormat();
        BuildMetadataFromXml::setLeadingDigitsPatterns($numberFormatElement, $numberFormat);

        $this->assertEquals('1', $numberFormat->getLeadingDigitsPattern(0));
        $this->assertEquals('2', $numberFormat->getLeadingDigitsPattern(1));
    }

    /**
     * Tests setLeadingDigitsPatterns() in the case of international and national formatting rules
     * being present but not both defined for this numberFormat - we don't want to add them twice.
     */
    public function testSetLeadingDigitsPatternsNotAddedTwiceWhenInternationalFormatsPresent()
    {
        $xmlInput = '<availableFormats>'
            . "  <numberFormat pattern=\"(1)(\\d{3})\">"
            . '    <leadingDigits>1</leadingDigits>'
            . '    <format>$1</format>'
            . '  </numberFormat>'
            . "  <numberFormat pattern=\"(2)(\\d{3})\">"
            . '    <leadingDigits>2</leadingDigits>'
            . '    <format>$1</format>'
            . '    <intlFormat>9-$1</intlFormat>'
            . '  </numberFormat>'
            . '</availableFormats>';

        $element = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::loadAvailableFormats($metadata, $element, '0', '', false /* NP not optional */);
        $this->assertCount(1, $metadata->getNumberFormat(0)->leadingDigitPatterns());
        $this->assertCount(1, $metadata->getNumberFormat(1)->leadingDigitPatterns());
        // When we merge the national format rules into the international format rules, we shouldn't add
        // the leading digit patterns multiple times.
        $this->assertCount(1, $metadata->getIntlNumberFormat(0)->leadingDigitPatterns());
        $this->assertCount(1, $metadata->getIntlNumberFormat(1)->leadingDigitPatterns());
    }

    public function testGetNationalPrefixFormattingRuleFromElement()
    {
        $xmlInput = '<territory nationalPrefixFormattingRule="$NP$FG" />';
        $element = $this->parseXMLString($xmlInput);
        $this->assertEquals('0$1', BuildMetadataFromXml::getNationalPrefixFormattingRuleFromElement($element, '0'));
    }

    public function testGetDomesticCarrierCodeFormattingRuleFromElement()
    {
        $xmlInput = '<territory carrierCodeFormattingRule=\'$NP$CC $FG\'/>';
        $element = $this->parseXMLString($xmlInput);
        $this->assertEquals(
            '0$CC $1',
            BuildMetadataFromXml::getDomesticCarrierCodeFormattingRuleFromElement($element, '0')
        );
    }

    public function testProcessPhoneNumberDescElementWithInvalidInput()
    {
        $generalDesc = new PhoneNumberDesc();
        $territoryElement = $this->parseXMLString('<territory/>');

        $phoneNumberDesc = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $territoryElement,
            'invalidType'
        );
        $this->assertFalse($phoneNumberDesc->hasNationalNumberPattern());
    }

    public function testProcessPhoneNumberDescElementOverridesGeneralDesc()
    {
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setNationalNumberPattern('\\d{8}');
        $xmlInput = '<territory><fixedLine>'
            . "  <nationalNumberPattern>\\d{6}</nationalNumberPattern>"
            . '</fixedLine></territory>';

        $territoryElement = $this->parseXMLString($xmlInput);

        $phoneNumberDesc = BuildMetadataFromXml::processPhoneNumberDescElement(
            $generalDesc,
            $territoryElement,
            'fixedLine'
        );
        $this->assertEquals('\\d{6}', $phoneNumberDesc->getNationalNumberPattern());
    }

    public function testBuildPhoneMetadataCollection_liteBuild()
    {
        $xmlInput = '<phoneNumberMetadata>'
            . '  <territories>'
            . '    <territory id="AM" countryCode="374" internationalPrefix="00">'
            . '      <generalDesc>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '      </generalDesc>'
            . '      <fixedLine>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '        <possibleLengths national="8" localOnly="5,6"/>'
            . '        <exampleNumber>10123456</exampleNumber>'
            . '      </fixedLine>'
            . '      <mobile>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '        <possibleLengths national="8" localOnly="5,6"/>'
            . '        <exampleNumber>10123456</exampleNumber>'
            . '      </mobile>'
            . '    </territory>'
            . '  </territories>'
            . '</phoneNumberMetadata>';

        $document = $this->parseXMLString($xmlInput);

        $metadataCollection = BuildMetadataFromXml::buildPhoneMetadataCollection(
            $document,
            true, // liteBuild
            false, // specialBuild
            false, // isShortNumberMetadata
            false // isAlternateFormatsMetadata
        );

        $this->assertCount(1, $metadataCollection);
        $metadata = $metadataCollection[0];

        $this->assertTrue($metadata->hasGeneralDesc());
        $this->assertFalse($metadata->getGeneralDesc()->hasExampleNumber());
        $this->assertEquals('', $metadata->getGeneralDesc()->getExampleNumber());
        $this->assertTrue($metadata->hasFixedLine());
        $this->assertFalse($metadata->getFixedLine()->hasExampleNumber());
        $this->assertEquals('', $metadata->getFixedLine()->getExampleNumber());
        $this->assertTrue($metadata->hasMobile());
        $this->assertFalse($metadata->getMobile()->hasExampleNumber());
        $this->assertEquals('', $metadata->getMobile()->getExampleNumber());
    }

    public function testBuildPhoneMetadataCollection_specialBuild()
    {
        $xmlInput = '<phoneNumberMetadata>'
            . '  <territories>'
            . '    <territory id="AM" countryCode="374" internationalPrefix="00">'
            . '      <generalDesc>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '      </generalDesc>'
            . '      <fixedLine>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '        <possibleLengths national="8" localOnly="5,6"/>'
            . '        <exampleNumber>10123456</exampleNumber>'
            . '      </fixedLine>'
            . '      <mobile>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '        <possibleLengths national="8" localOnly="5,6"/>'
            . '        <exampleNumber>10123456</exampleNumber>'
            . '      </mobile>'
            . '    </territory>'
            . '  </territories>'
            . '</phoneNumberMetadata>';

        $document = $this->parseXMLString($xmlInput);

        $metadataCollection = BuildMetadataFromXml::buildPhoneMetadataCollection(
            $document,
            false, // liteBuild
            true, // specialBuild
            false, // isShortNumberMetadata
            false // isAlternateFormatsMetadata
        );

        $this->assertCount(1, $metadataCollection);
        $metadata = $metadataCollection[0];
        $this->assertTrue($metadata->hasGeneralDesc());
        $this->assertFalse($metadata->getGeneralDesc()->hasExampleNumber());
        $this->assertEquals('', $metadata->getGeneralDesc()->getExampleNumber());
        // Consider clearing fixed-line if empty after being filtered.
        $this->assertTrue($metadata->hasFixedLine());
        $this->assertFalse($metadata->getFixedLine()->hasExampleNumber());
        $this->assertEquals('', $metadata->getFixedLine()->getExampleNumber());
        $this->assertTrue($metadata->hasMobile());
        $this->assertTrue($metadata->getMobile()->hasExampleNumber());
        $this->assertEquals('10123456', $metadata->getMobile()->getExampleNumber());
    }

    public function testBuildPhoneMetadataCollection_fullBuild()
    {
        $xmlInput = '<phoneNumberMetadata>'
            . '  <territories>'
            . '    <territory id="AM" countryCode="374" internationalPrefix="00">'
            . '      <generalDesc>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '      </generalDesc>'
            . '      <fixedLine>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '        <possibleLengths national="8" localOnly="5,6"/>'
            . '        <exampleNumber>10123456</exampleNumber>'
            . '      </fixedLine>'
            . '      <mobile>'
            . "        <nationalNumberPattern>[1-9]\\d{7}</nationalNumberPattern>"
            . '        <possibleLengths national="8" localOnly="5,6"/>'
            . '        <exampleNumber>10123456</exampleNumber>'
            . '      </mobile>'
            . '    </territory>'
            . '  </territories>'
            . '</phoneNumberMetadata>';

        $document = $this->parseXMLString($xmlInput);

        $metadataCollection = BuildMetadataFromXml::buildPhoneMetadataCollection(
            $document,
            false, // liteBuild
            false, // specialBuild
            false, // isShortNumberMetadata
            false // isAlternateFormatsMetadata
        );

        $this->assertCount(1, $metadataCollection);
        $metadata = $metadataCollection[0];
        $this->assertTrue($metadata->hasGeneralDesc());
        $this->assertFalse($metadata->getGeneralDesc()->hasExampleNumber());
        $this->assertEquals('', $metadata->getGeneralDesc()->getExampleNumber());
        $this->assertTrue($metadata->hasFixedLine());
        $this->assertTrue($metadata->getFixedLine()->hasExampleNumber());
        $this->assertEquals('10123456', $metadata->getFixedLine()->getExampleNumber());
        $this->assertTrue($metadata->hasMobile());
        $this->assertTrue($metadata->getMobile()->hasExampleNumber());
        $this->assertEquals('10123456', $metadata->getMobile()->getExampleNumber());
    }

    public function testProcessPhoneNumberDescOutputsExampleNumberByDefault()
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
        $this->assertEquals('01 01 01 01', $phoneNumberDesc->getExampleNumber());
    }

    public function testProcessPhoneNumberDescRemovesWhiteSpacesInPatterns()
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
        $this->assertEquals('\\d{6}', $phoneNumberDesc->getNationalNumberPattern());
    }

    public function testSetRelevantDescPatternsSetsSameMobileAndFixedLinePattern()
    {
        $xmlInput = '<territory countryCode="33">'
            . "  <fixedLine><nationalNumberPattern>\\d{6}</nationalNumberPattern></fixedLine>"
            . "  <mobile><nationalNumberPattern>\\d{6}</nationalNumberPattern></mobile>"
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        // Should set sameMobileAndFixedPattern to true.
        BuildMetadataFromXml::setRelevantDescPatterns($metadata, $territoryElement, false /* isShortNumberMetadata */);
        $this->assertTrue($metadata->getSameMobileAndFixedLinePattern());
    }

    public function testSetRelevantDescPatternsSetsAllDescriptionsForRegularLengthNumbers()
    {
        $xmlInput = '<territory countryCode="33">'
            . "  <fixedLine><nationalNumberPattern>\\d{1}</nationalNumberPattern></fixedLine>"
            . "  <mobile><nationalNumberPattern>\\d{2}</nationalNumberPattern></mobile>"
            . "  <pager><nationalNumberPattern>\\d{3}</nationalNumberPattern></pager>"
            . "  <tollFree><nationalNumberPattern>\\d{4}</nationalNumberPattern></tollFree>"
            . "  <premiumRate><nationalNumberPattern>\\d{5}</nationalNumberPattern></premiumRate>"
            . "  <sharedCost><nationalNumberPattern>\\d{6}</nationalNumberPattern></sharedCost>"
            . "  <personalNumber><nationalNumberPattern>\\d{7}</nationalNumberPattern></personalNumber>"
            . "  <voip><nationalNumberPattern>\\d{8}</nationalNumberPattern></voip>"
            . "  <uan><nationalNumberPattern>\\d{9}</nationalNumberPattern></uan>"
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::setRelevantDescPatterns($metadata, $territoryElement, false /* isShortNumberMetadata */);
        $this->assertEquals("\\d{1}", $metadata->getFixedLine()->getNationalNumberPattern());
        $this->assertEquals("\\d{2}", $metadata->getMobile()->getNationalNumberPattern());
        $this->assertEquals("\\d{3}", $metadata->getPager()->getNationalNumberPattern());
        $this->assertEquals("\\d{4}", $metadata->getTollFree()->getNationalNumberPattern());
        $this->assertEquals("\\d{5}", $metadata->getPremiumRate()->getNationalNumberPattern());
        $this->assertEquals("\\d{6}", $metadata->getSharedCost()->getNationalNumberPattern());
        $this->assertEquals("\\d{7}", $metadata->getPersonalNumber()->getNationalNumberPattern());
        $this->assertEquals("\\d{8}", $metadata->getVoip()->getNationalNumberPattern());
        $this->assertEquals("\\d{9}", $metadata->getUan()->getNationalNumberPattern());
    }

    public function testSetRelevantDescPatternsSetsAllDescriptionsForShortNumbers()
    {
        $xmlInput = '<territory ID="FR">'
            . "  <tollFree><nationalNumberPattern>\\d{1}</nationalNumberPattern></tollFree>"
            . "  <standardRate><nationalNumberPattern>\\d{2}</nationalNumberPattern></standardRate>"
            . "  <premiumRate><nationalNumberPattern>\\d{3}</nationalNumberPattern></premiumRate>"
            . "  <shortCode><nationalNumberPattern>\\d{4}</nationalNumberPattern></shortCode>"
            . '  <carrierSpecific>'
            . "    <nationalNumberPattern>\\d{5}</nationalNumberPattern>"
            . '  </carrierSpecific>'
            . '  <smsServices>'
            . "    <nationalNumberPattern>\\d{6}</nationalNumberPattern>"
            . '  </smsServices>'
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::setRelevantDescPatterns($metadata, $territoryElement, true /* isShortNumberMetadata */);
        $this->assertEquals("\\d{1}", $metadata->getTollFree()->getNationalNumberPattern());
        $this->assertEquals("\\d{2}", $metadata->getStandardRate()->getNationalNumberPattern());
        $this->assertEquals("\\d{3}", $metadata->getPremiumRate()->getNationalNumberPattern());
        $this->assertEquals("\\d{4}", $metadata->getShortCode()->getNationalNumberPattern());
        $this->assertEquals("\\d{5}", $metadata->getCarrierSpecific()->getNationalNumberPattern());
        $this->assertEquals("\\d{6}", $metadata->getSmsServices()->getNationalNumberPattern());
    }

    public function testSetRelevantDescPatternsThrowsErrorIfTypePresentMultipleTimes()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Multiple elements with type fixedLine found.");
        $xmlInput = '<territory countryCode="33">'
            . "  <fixedLine><nationalNumberPattern>\\d{6}</nationalNumberPattern></fixedLine>"
            . "  <fixedLine><nationalNumberPattern>\\d{6}</nationalNumberPattern></fixedLine>"
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = new PhoneMetadata();
        BuildMetadataFromXml::setRelevantDescPatterns($metadata, $territoryElement, false /* isShortNumberMetadata */);
    }

    public function testAlternateFormatsOmitsDescPatterns()
    {
        $xmlInput = '<territory countryCode="33">'
            . '  <availableFormats>'
            . "    <numberFormat pattern=\"(1)(\\d{3})\">"
            . '      <leadingDigits>1</leadingDigits>'
            . '      <format>$1</format>'
            . '    </numberFormat>'
            . '  </availableFormats>'
            . "  <fixedLine><nationalNumberPattern>\\d{1}</nationalNumberPattern></fixedLine>"
            . "  <shortCode><nationalNumberPattern>\\d{2}</nationalNumberPattern></shortCode>"
            . '</territory>';

        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = BuildMetadataFromXml::loadCountryMetadata('FR', $territoryElement, false
            /* isShortNumberMetadata */, true /* isAlternateFormatsMetadata */);
        $this->assertEquals('(1)(\\d{3})', $metadata->getNumberFormat(0)->getPattern());
        $this->assertEquals('1', $metadata->getNumberFormat(0)->getLeadingDigitsPattern(0));
        $this->assertEquals('$1', $metadata->getNumberFormat(0)->getFormat());
        $this->assertNull($metadata->getFixedLine());
        $this->assertNull($metadata->getShortCode());
    }

    public function testNationalPrefixRulesSetCorrectly()
    {
        $xmlInput = '<territory countryCode="33" nationalPrefix="0"'
            . ' nationalPrefixFormattingRule="$NP$FG">'
            . '  <availableFormats>'
            . "    <numberFormat pattern=\"(1)(\\d{3})\" nationalPrefixOptionalWhenFormatting=\"true\">"
            . '      <leadingDigits>1</leadingDigits>'
            . '      <format>$1</format>'
            . '    </numberFormat>'
            . "    <numberFormat pattern=\"(\\d{3})\" nationalPrefixOptionalWhenFormatting=\"false\">"
            . '      <leadingDigits>2</leadingDigits>'
            . '      <format>$1</format>'
            . '    </numberFormat>'
            . '  </availableFormats>'
            . "  <fixedLine><nationalNumberPattern>\\d{1}</nationalNumberPattern></fixedLine>"
            . '</territory>';
        $territoryElement = $this->parseXMLString($xmlInput);
        $metadata = BuildMetadataFromXml::loadCountryMetadata('FR', $territoryElement, false
            /* isShortNumberMetadata */, true /* isAlternateFormatsMetadata */);
        $this->assertTrue($metadata->getNumberFormat(0)->getNationalPrefixOptionalWhenFormatting());
        // This is inherited from the territory, with $NP replaced by the actual national prefix, and
        // $FG replaced with $1.
        $this->assertEquals('0$1', $metadata->getNumberFormat(0)->getNationalPrefixFormattingRule());
        // Here it is explicitly set to false.
        $this->assertFalse($metadata->getNumberFormat(1)->getNationalPrefixOptionalWhenFormatting());
    }

    public function testProcessPhoneNumberDescElement_PossibleLengthsSetCorrectly()
    {
        $generalDesc = new PhoneNumberDesc();
        // The number lengths set for the general description must be a super-set of those in the
        // element being parsed.
        $generalDesc->setPossibleLength(array(4, 6, 7, 13));
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
        $this->assertCount(2, $possibleLength);
        $this->assertEquals(4, $possibleLength[0]);
        $this->assertEquals(13, $possibleLength[1]);
        $this->assertCount(1, $fixedLine->getPossibleLengthLocalOnly());

        // We use [-1] to denote that there are no possible lengths; we don't leave it empty, since for
        // compression reasons, we use the empty list to mean that the generalDesc possible lengths
        // apply.
        $mobileLength = $mobile->getPossibleLength();
        $this->assertCount(1, $mobileLength);
        $this->assertEquals(-1, $mobileLength[0]);
        $this->assertCount(0, $mobile->getPossibleLengthLocalOnly());
    }

    public function testSetPossibleLengthsGeneralDesc_BuiltFromChildElements()
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
        $this->assertCount(2, $possibleLength);
        $this->assertEquals(13, $possibleLength[0]);
        // 15 is present twice in the input in different sections, but only once in the output.
        $this->assertEquals(15, $possibleLength[1]);
        $possibleLengthLocalOnly = $generalDesc->getPossibleLengthLocalOnly();
        $this->assertCount(2, $possibleLengthLocalOnly);
        $this->assertEquals(6, $possibleLengthLocalOnly[0]);
        $this->assertEquals(7, $possibleLengthLocalOnly[1]);
        // 13 is skipped as a "local only" length, since it is also present as a normal length.
    }

    public function testSetPossibleLengthsGeneralDesc_IgnoresNoIntlDialling()
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
        $this->assertCount(1, $possibleLength);
        $this->assertEquals(13, $possibleLength[0]);
        // 15 is skipped because noInternationalDialling should not contribute to the general lengths;
        // it isn't a particular "type" of number per se, it is a property that different types may
        // have.
    }

    public function testSetPossibleLengthsGeneralDesc_ShortNumberMetadata()
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
        $this->assertCount(2, $possibleLength);
        $this->assertEquals(6, $possibleLength[0]);
        $this->assertEquals(13, $possibleLength[1]);
    }

    public function testSetPossibleLengthsGeneralDesc_ShortNumberMetadataErrorsOnLocalLengths()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Found local-only lengths in short-number metadata");
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

    public function testProcessPhoneNumberDescElement_ErrorDuplicates()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Duplicate length element found (6) in possibleLength string 6,6");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(6));

        $territoryElement = $this->parseXMLString('<territory>'
            . '<mobile>'
            . '  <possibleLengths national="6,6"/>'
            . '</mobile>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'mobile');
    }

    public function testProcessPhoneNumberDescElement_ErrorDuplicatesOneLocal()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Possible length(s) found specified as a normal and local-only length: [6]");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(6));

        $territoryElement = $this->parseXMLString('<territory>'
            . '<mobile>'
            . '  <possibleLengths national="6" localOnly="6"/>'
            . '</mobile>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'mobile');
    }

    public function testProcessPhoneNumberDescElement_ErrorUncoveredLengths()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Out-of-range possible length");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(4));

        $territoryElement = $this->parseXMLString('<territory>'
            . '<noInternationalDialling>'
            // Sorting will be done when parsing.
            . '  <possibleLengths national="6,7,4"/>'
            . '</noInternationalDialling>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'noInternationalDialling');
    }

    public function testProcessPhoneNumberDescElement_SameAsParent()
    {
        $generalDesc = new PhoneNumberDesc();
        // The number lengths set for the general description must be a super-set of those in the
        // element being parsed.
        $generalDesc->setPossibleLength(array(4, 6, 7));
        $generalDesc->setPossibleLengthLocalOnly(array(2));
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
        $this->assertCount(0, $phoneNumberDesc->getPossibleLength());
        // Local-only lengths should be present for child elements such as fixed-line
        $this->assertCount(1, $phoneNumberDesc->getPossibleLengthLocalOnly());
    }

    public function testProcessPhoneNumberDescElement_InvalidNumber()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("For input string \"4d\"");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(4));
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="4d"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testLoadCountryMetadata_GeneralDescHasNumberLengthsSet()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Found possible lengths specified at general desc: this should be derived from child elements. Affected country: FR");
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

    public function testProcessPhoneNumberDescElement_ErrorEmptyPossibleLengthStringAttribute()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Empty possibleLength string found.");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(4));
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national=""/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testProcessPhoneNumberDescElement_ErrorRangeSpecifiedWithComma()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Missing end of range character in possible length string [4,7].");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(4));
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="[4,7]"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testProcessPhoneNumberDescElement_ErrorIncompleteRange()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Missing end of range character in possible length string [4-.");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(4));

        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="[4-"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testProcessPhoneNumberDescElement_ErrorNoDashInRange()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("Ranges must have exactly one - character: missing for [4:10].");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(4));
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="[4:10]"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testProcessPhoneNumberDescElement_ErrorRangeIsNotFromMinToMax()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("The first number in a range should be two or more digits lower than the second. Culprit possibleLength string: [10-10]");
        $generalDesc = new PhoneNumberDesc();
        $generalDesc->setPossibleLength(array(4));
        $territoryElement = $this->parseXMLString('<territory>'
            . '<fixedLine>'
            . '  <possibleLengths national="[10-10]"/>'
            . '</fixedLine>'
            . '</territory>');

        BuildMetadataFromXml::processPhoneNumberDescElement($generalDesc, $territoryElement, 'fixedLine');
    }

    public function testGetMetadataFilter()
    {
        $this->assertEquals(BuildMetadataFromXml::getMetadataFilter(false, false), MetadataFilter::emptyFilter());
        $this->assertEquals(BuildMetadataFromXml::getMetadataFilter(true, false), MetadataFilter::forLiteBuild());
        $this->assertEquals(BuildMetadataFromXml::getMetadataFilter(false, true), MetadataFilter::forSpecialBuild());

        try {
            BuildMetadataFromXml::getMetadataFilter(true, true);
            $this->fail('getMetadataFilter should fail when liteBuild and specialBuild are both set');
        } catch (RuntimeException $e) {
            $this->assertEquals('liteBuild and specialBuild may not both be set', $e->getMessage());
        }
    }
}
