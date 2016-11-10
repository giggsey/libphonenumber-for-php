<?php

namespace libphonenumber\Tests\buildtools;

use libphonenumber\buildtools\BuildMetadataFromXml;
use libphonenumber\buildtools\MetadataFilter;

class MetadataFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testForLiteBuild()
    {
        $blackList = array();
        $blackList['fixedLine'] = array('exampleNumber');
        $blackList['mobile'] = array('exampleNumber');
        $blackList['tollFree'] = array('exampleNumber');
        $blackList['premiumRate'] = array('exampleNumber');
        $blackList['sharedCost'] = array('exampleNumber');
        $blackList['personalNumber'] = array('exampleNumber');
        $blackList['voip'] = array('exampleNumber');
        $blackList['pager'] = array('exampleNumber');
        $blackList['uan'] = array('exampleNumber');
        $blackList['emergency'] = array('exampleNumber');
        $blackList['voicemail'] = array('exampleNumber');
        $blackList['shortCode'] = array('exampleNumber');
        $blackList['standardRate'] = array('exampleNumber');
        $blackList['carrierSpecific'] = array('exampleNumber');
        $blackList['noInternationalDialling'] = array('exampleNumber');

        $this->assertEquals(MetadataFilter::forLiteBuild(), new MetadataFilter($blackList));
    }

    public function testForSpecialBuild()
    {
        $blackList = array();
        $blackList['fixedLine'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['tollFree'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['premiumRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['sharedCost'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['personalNumber'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['voip'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['pager'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['uan'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['emergency'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['voicemail'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['shortCode'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['standardRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['carrierSpecific'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['noInternationalDialling'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['preferredInternationalPrefix'] = array();
        $blackList['nationalPrefix'] = array();
        $blackList['preferredExtnPrefix'] = array();
        $blackList['nationalPrefixTransformRule'] = array();
        $blackList['sameMobileAndFixedLinePattern'] = array();
        $blackList['mainCountryForCode'] = array();
        $blackList['leadingZeroPossible'] = array();
        $blackList['mobileNumberPortableRegion'] = array();

        $this->assertEquals(MetadataFilter::forSpecialBuild(), new MetadataFilter($blackList));
    }

    public function testEmptyFilter()
    {
        $this->assertEquals(MetadataFilter::emptyFilter(), new MetadataFilter(array()));
    }

    public function testParseFieldMapFromString_parentAsGroup()
    {
        $fieldMap = array();
        $fieldMap['fixedLine'] = array(
            'nationalNumberPattern',
            'possibleNumberPattern',
            'possibleLength',
            'possibleLengthLocalOnly',
            'exampleNumber'
        );

        $this->assertEquals(MetadataFilter::parseFieldMapFromString('fixedLine'), $fieldMap);
    }

    public function testParseFieldMapFromString_childAsGroup()
    {
        $fieldMap = array();
        $fieldMap['fixedLine'] = array('exampleNumber');
        $fieldMap['mobile'] = array('exampleNumber');
        $fieldMap['tollFree'] = array('exampleNumber');
        $fieldMap['premiumRate'] = array('exampleNumber');
        $fieldMap['sharedCost'] = array('exampleNumber');
        $fieldMap['personalNumber'] = array('exampleNumber');
        $fieldMap['voip'] = array('exampleNumber');
        $fieldMap['pager'] = array('exampleNumber');
        $fieldMap['uan'] = array('exampleNumber');
        $fieldMap['emergency'] = array('exampleNumber');
        $fieldMap['voicemail'] = array('exampleNumber');
        $fieldMap['shortCode'] = array('exampleNumber');
        $fieldMap['standardRate'] = array('exampleNumber');
        $fieldMap['carrierSpecific'] = array('exampleNumber');
        $fieldMap['noInternationalDialling'] = array('exampleNumber');

        $this->AssertEquals(MetadataFilter::parseFieldMapFromString('exampleNumber'), $fieldMap);
    }

    public function testParseFieldMapFromString_childlessFieldAsGroup()
    {
        $fieldMap = array();
        $fieldMap['nationalPrefix'] = array();

        $this->assertEquals(MetadataFilter::parseFieldMapFromString('nationalPrefix'), $fieldMap);
    }

    public function testParseFieldMapFromString_parentWithOneChildAsGroup()
    {
        $fieldMap = array();
        $fieldMap['fixedLine'] = array('exampleNumber');

        $this->assertEquals(MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber)'), $fieldMap);
    }

    public function testParseFieldMapFromString_parentWithTwoChildrenAsGroup()
    {
        $fieldMap = array();
        $fieldMap['fixedLine'] = array('exampleNumber', 'possibleLength');

        $this->assertEquals(MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber,possibleLength)'),
            $fieldMap);
    }

    public function testParseFieldMapFromString_mixOfGroups()
    {
        $fieldMap = array();
        $fieldMap['uan'] = array('possibleLength', 'exampleNumber', 'possibleLengthLocalOnly', 'nationalNumberPattern');
        $fieldMap['pager'] = array('exampleNumber', 'nationalNumberPattern');
        $fieldMap['fixedLine'] = array(
            'nationalNumberPattern',
            'possibleNumberPattern',
            'possibleLength',
            'possibleLengthLocalOnly',
            'exampleNumber'
        );
        $fieldMap['nationalPrefix'] = array();
        $fieldMap['mobile'] = array('nationalNumberPattern');
        $fieldMap['tollFree'] = array('nationalNumberPattern');
        $fieldMap['premiumRate'] = array('nationalNumberPattern');
        $fieldMap['sharedCost'] = array('nationalNumberPattern');
        $fieldMap['personalNumber'] = array('nationalNumberPattern');
        $fieldMap['voip'] = array('nationalNumberPattern');
        $fieldMap['emergency'] = array('nationalNumberPattern');
        $fieldMap['voicemail'] = array('nationalNumberPattern');
        $fieldMap['shortCode'] = array('nationalNumberPattern');
        $fieldMap['standardRate'] = array('nationalNumberPattern');
        $fieldMap['carrierSpecific'] = array('nationalNumberPattern');
        $fieldMap['noInternationalDialling'] = array('nationalNumberPattern');

        $this->assertEquals(
            $fieldMap,
            MetadataFilter::parseFieldMapFromString(
                'uan(possibleLength,exampleNumber,possibleLengthLocalOnly)'
                . ':pager(exampleNumber)'
                . ':fixedLine'
                . ':nationalPrefix'
                . ':nationalNumberPattern'
            )
        );
    }

    public function testParseFieldMapFromString_equivalentExpressions()
    {
        // Listing all excludable parent fields is equivalent to listing all excludable child field.s
        $this->assertEquals(
            MetadataFilter::parseFieldMapFromString('fixedLine'
                . ':mobile'
                . ':tollFree'
                . ':premiumRate'
                . ':sharedCost'
                . ':personalNumber'
                . ':voip'
                . ':pager'
                . ':uan'
                . ':emergency'
                . ':voicemail'
                . ':shortCode'
                . ':standardRate'
                . ':carrierSpecific'
                . ':noInternationalDialling'
            ), MetadataFilter::parseFieldMapFromString('nationalNumberPattern'
            . ':possibleNumberPattern'
            . ':possibleLength'
            . ':possibleLengthLocalOnly'
            . ':exampleNumber'
        ));

        // Order and whitespace don't matter
        $this->assertEquals($this->recursive_ksort(MetadataFilter::parseFieldMapFromString(
            " nationalNumberPattern "
            . ": uan ( exampleNumber , possibleLengthLocalOnly,     possibleLength ) "
            . ": nationalPrefix "
            . ": fixedLine "
            . ": pager ( exampleNumber ) ")),
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString(
                "uan(possibleLength,exampleNumber,possibleLengthLocalOnly)"
                . ":pager(exampleNumber)"
                . ":fixedLine"
                . ":nationalPrefix"
                . ":nationalNumberPattern")));

        // Parent explicitly listing all possible children.
        $this->assertEquals(
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString(
                "uan(nationalNumberPattern,possibleNumberPattern,possibleLength,exampleNumber,"
                . "possibleLengthLocalOnly)")),
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString("uan")));

        // All parent's children covered, some implicitly and some explicitly.
        $this->assertEquals(
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString(
                "uan(nationalNumberPattern,possibleNumberPattern,possibleLength,exampleNumber)"
                . ":possibleLengthLocalOnly")),
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString("uan:possibleLengthLocalOnly")));

        // Child field covered by all parents explicitly.
        // It seems this will always be better expressed as a wildcard child, but the check is complex
        // and may not be worth it.
        $this->assertEquals(
            MetadataFilter::parseFieldMapFromString(
                "fixedLine(exampleNumber)"
                . ":mobile(exampleNumber)"
                . ":tollFree(exampleNumber)"
                . ":premiumRate(exampleNumber)"
                . ":sharedCost(exampleNumber)"
                . ":personalNumber(exampleNumber)"
                . ":voip(exampleNumber)"
                . ":pager(exampleNumber)"
                . ":uan(exampleNumber)"
                . ":emergency(exampleNumber)"
                . ":voicemail(exampleNumber)"
                . ":shortCode(exampleNumber)"
                . ":standardRate(exampleNumber)"
                . ":carrierSpecific(exampleNumber)"
                . ":noInternationalDialling(exampleNumber)"),
            MetadataFilter::parseFieldMapFromString("exampleNumber"));

        // Child field given as a group by itself while it's covered by all parents implicitly.
        // It seems this will always be better expressed without the wildcard child, but the check is
        // complex and may not be worth it.
        $this->assertEquals(
            MetadataFilter::parseFieldMapFromString(
                "fixedLine"
                . ":mobile"
                . ":tollFree"
                . ":premiumRate"
                . ":sharedCost"
                . ":personalNumber"
                . ":voip"
                . ":pager"
                . ":uan"
                . ":emergency"
                . ":voicemail"
                . ":shortCode"
                . ":standardRate"
                . ":carrierSpecific"
                . ":noInternationalDialling"
                . ":exampleNumber"),
            MetadataFilter::parseFieldMapFromString(
                "fixedLine"
                . ":mobile"
                . ":tollFree"
                . ":premiumRate"
                . ":sharedCost"
                . ":personalNumber"
                . ":voip"
                . ":pager"
                . ":uan"
                . ":emergency"
                . ":voicemail"
                . ":shortCode"
                . ":standardRate"
                . ":carrierSpecific"
                . ":noInternationalDialling"));
    }

    /**
     * Need to sort some of the results, as PHP arrays are ordered by when they were added
     * @param $array
     * @return bool
     */
    private function recursive_ksort($array)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                $this->recursive_ksort($value);
            }
        }
        return ksort($array);
    }

    public function testParseFieldMapFromString_RuntimeExceptionCases()
    {
        // Null input.
        try {
            MetadataFilter::parseFieldMapFromString(null);
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty input.
        try {
            MetadataFilter::parseFieldMapFromString("");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace input.
        try {
            MetadataFilter::parseFieldMapFromString(" ");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as only group.
        try {
            MetadataFilter::parseFieldMapFromString("something_else");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as last group.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine:something_else");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as middle group.
        try {
            MetadataFilter::parseFieldMapFromString(
                "pager:nationalPrefix:something_else:nationalNumberPattern");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given as parent.
        try {
            MetadataFilter::parseFieldMapFromString("nationalPrefix(exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given as parent.
        try {
            MetadataFilter::parseFieldMapFromString("possibleLength(exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as parent.
        try {
            MetadataFilter::parseFieldMapFromString("something_else(exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as only child.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(uan)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as first child.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(uan,possibleLength)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as last child.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(possibleLength,uan)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as middle child.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(possibleLength,uan,exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given as only child.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(nationalPrefix)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as only child.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(something_else)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as last child.
        try {
            MetadataFilter::parseFieldMapFromString("uan(possibleLength,something_else)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty parent.
        try {
            MetadataFilter::parseFieldMapFromString("(exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace parent.
        try {
            MetadataFilter::parseFieldMapFromString(" (exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty child.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine()");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace child.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine( )");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty parent and child.
        try {
            MetadataFilter::parseFieldMapFromString("()");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace parent and empty child.
        try {
            MetadataFilter::parseFieldMapFromString(" ()");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as a group twice.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine:uan:fixedLine");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as the parent of a group and as a group by itself.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(exampleNumber):fixedLine");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as the parent of one group and then as the parent of another group.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(exampleNumber):fixedLine(possibleLength)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given twice as a group.
        try {
            MetadataFilter::parseFieldMapFromString("nationalPrefix:uan:nationalPrefix");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given twice as a group.
        try {
            MetadataFilter::parseFieldMapFromString("exampleNumber:uan:exampleNumber");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given first as the only child in a group and then as a group by itself.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(exampleNumber):exampleNumber");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given first as a child in a group and then as a group by itself.
        try {
            MetadataFilter::parseFieldMapFromString(
                "uan(nationalNumberPattern,possibleNumberPattern,possibleLength,exampleNumber)"
                . ":possibleLengthLocalOnly"
                . ":exampleNumber");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given twice as children of the same parent.
        try {
            MetadataFilter::parseFieldMapFromString(
                "fixedLine(possibleLength,exampleNumber,possibleLength)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given as a group by itself while it's covered by all parents explicitly.
        try {
            MetadataFilter::parseFieldMapFromString(
                "fixedLine(exampleNumber)"
                . ":mobile(exampleNumber)"
                . ":tollFree(exampleNumber)"
                . ":premiumRate(exampleNumber)"
                . ":sharedCost(exampleNumber)"
                . ":personalNumber(exampleNumber)"
                . ":voip(exampleNumber)"
                . ":pager(exampleNumber)"
                . ":uan(exampleNumber)"
                . ":emergency(exampleNumber)"
                . ":voicemail(exampleNumber)"
                . ":shortCode(exampleNumber)"
                . ":standardRate(exampleNumber)"
                . ":carrierSpecific(exampleNumber)"
                . ":noInternationalDialling(exampleNumber)"
                . ":exampleNumber");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given as a group by itself while it's covered by all parents, some implicitly and
        // some explicitly.
        try {
            MetadataFilter::parseFieldMapFromString(
                "fixedLine"
                . ":mobile"
                . ":tollFree"
                . ":premiumRate"
                . ":sharedCost"
                . ":personalNumber"
                . ":voip"
                . ":pager(exampleNumber)"
                . ":uan(exampleNumber)"
                . ":emergency(exampleNumber)"
                . ":voicemail(exampleNumber)"
                . ":shortCode(exampleNumber)"
                . ":standardRate(exampleNumber)"
                . ":carrierSpecific(exampleNumber)"
                . ":noInternationalDialling(exampleNumber)"
                . ":exampleNumber");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing right parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(exampleNumber");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing right parenthesis in first group.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(exampleNumber:pager");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing left parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLineexampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Early right parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(example_numb)er");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra right parenthesis at end of only group.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(exampleNumber))");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra right parenthesis between proper parentheses.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(example_numb)er)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra left parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine((exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra level of children.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(exampleNumber(possibleLength))");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Trailing comma in children.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(exampleNumber,)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Leading comma in children.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(,exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty token between commas.
        try {
            MetadataFilter::parseFieldMapFromString("fixedLine(possibleLength,,exampleNumber)");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Trailing colon.
        try {
            MetadataFilter::parseFieldMapFromString("uan:");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Leading colon.
        try {
            MetadataFilter::parseFieldMapFromString(":uan");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty token between colons.
        try {
            MetadataFilter::parseFieldMapFromString("uan::fixedLine");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing colon between groups.
        try {
            MetadataFilter::parseFieldMapFromString("uan(possibleLength)pager");
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }
    }

    public function testComputeComplement_allAndNothing()
    {
        $map1 = array();
        $map1['fixedLine'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['mobile'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['tollFree'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['premiumRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['sharedCost'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['personalNumber'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['voip'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['pager'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['uan'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['emergency'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['voicemail'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['shortCode'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['standardRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['carrierSpecific'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['noInternationalDialling'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['preferredInternationalPrefix'] = array();
        $map1['nationalPrefix'] = array();
        $map1['preferredExtnPrefix'] = array();
        $map1['nationalPrefixTransformRule'] = array();
        $map1['sameMobileAndFixedLinePattern'] = array();
        $map1['mainCountryForCode'] = array();
        $map1['leadingZeroPossible'] = array();
        $map1['mobileNumberPortableRegion'] = array();

        $map2 = array();

        $this->assertEquals(MetadataFilter::computeComplement($map1), $map2);
        $this->assertEquals(MetadataFilter::computeComplement($map2), $map1);
    }

    public function testComputeComplement_inBetween()
    {
        $map1 = array();
        $map1['fixedLine'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['mobile'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['tollFree'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['premiumRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['emergency'] = array('nationalNumberPattern', 'possibleNumberPattern');
        $map1['voicemail'] = array('possibleLength', 'exampleNumber');
        $map1['shortCode'] = array('exampleNumber');
        $map1['standardRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['carrierSpecific'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['noInternationalDialling'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['nationalPrefixTransformRule'] = array();
        $map1['sameMobileAndFixedLinePattern'] = array();
        $map1['mainCountryForCode'] = array();
        $map1['leadingZeroPossible'] = array();
        $map1['mobileNumberPortableRegion'] = array();

        $map2 = array();
        $map2['sharedCost'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['personalNumber'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['voip'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['pager'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['uan'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['emergency'] = array('possibleLength', 'possibleLengthLocalOnly', 'exampleNumber');
        $map2['voicemail'] = array('nationalNumberPattern', 'possibleNumberPattern', 'possibleLengthLocalOnly');
        $map2['shortCode'] = array(
            'nationalNumberPattern',
            'possibleNumberPattern',
            'possibleLength',
            'possibleLengthLocalOnly'
        );
        $map2['preferredInternationalPrefix'] = array();
        $map2['nationalPrefix'] = array();
        $map2['preferredExtnPrefix'] = array();

        $this->assertEquals(MetadataFilter::computeComplement($map1), $map2);
        $this->assertEquals(MetadataFilter::computeComplement($map2), $map1);
    }

    public function testDrop()
    {
        $blacklist = array();
        $blacklist['fixedLine'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['mobile'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['tollFree'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['premiumRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['emergency'] = array('nationalNumberPattern', 'possibleNumberPattern');
        $blacklist['voicemail'] = array('possibleLength', 'exampleNumber');
        $blacklist['shortCode'] = array('exampleNumber');
        $blacklist['standardRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['carrierSpecific'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['noInternationalDialling'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['nationalPrefixTransformRule'] = array();
        $blacklist['sameMobileAndFixedLinePattern'] = array();
        $blacklist['mainCountryForCode'] = array();
        $blacklist['leadingZeroPossible'] = array();
        $blacklist['mobileNumberPortableRegion'] = array();

        $filter = new MetadataFilter($blacklist);
        $this->assertTrue($filter->drop('fixedLine', 'exampleNumber'));
        $this->assertFalse($filter->drop('sharedCost', 'exampleNumber'));
        $this->assertFalse($filter->drop('emergency', 'exampleNumber'));
        $this->assertTrue($filter->drop('emergency', 'nationalNumberPattern'));
        $this->assertFalse($filter->drop('preferredInternationalPrefix'));
        $this->assertTrue($filter->drop('mobileNumberPortableRegion'));

        // Integration tests starting with flag values
        $this->assertTrue(BuildMetadataFromXml::getMetadataFilter(true, false)->drop('fixedLine', 'exampleNumber'));

        // Integration tests starting with blacklist strings.
        $metadataFilter = new MetadataFilter(MetadataFilter::parseFieldMapFromString('fixedLine'));
        $this->assertTrue($metadataFilter->drop('fixedLine', 'exampleNumber'));
        $metadataFilter = new MetadataFilter(MetadataFilter::parseFieldMapFromString('uan'));
        $this->assertFalse($metadataFilter->drop('fixedLine', 'exampleNumber'));

        // Integration tests starting with whitelist strings.
        $metadataFilter = new MetadataFilter(MetadataFilter::computeComplement(MetadataFilter::parseFieldMapFromString('exampleNumber')));
        $this->assertFalse($metadataFilter->drop('fixedLine', 'exampleNumber'));
        $metadataFilter = new MetadataFilter(MetadataFilter::computeComplement(MetadataFilter::parseFieldMapFromString('uan')));
        $this->assertTrue($metadataFilter->drop('fixedLine', 'exampleNumber'));

        // Integration tests with an empty blacklist.
        $metadataFilter = new MetadataFilter();
        $this->assertFalse($metadataFilter->drop('fixedLine', 'exampleNumber'));
    }

    public function testIntegrityOfFieldSets()
    {
        $union = array_merge(MetadataFilter::$EXCLUDABLE_PARENT_FIELDS, MetadataFilter::$EXCLUDABLE_CHILD_FIELDS,
            MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS);
        $union = array_unique($union);

        // Mutually exclusive sets
        $this->assertEquals(count($union),
            count(MetadataFilter::$EXCLUDABLE_PARENT_FIELDS) + count(MetadataFilter::$EXCLUDABLE_CHILD_FIELDS) + count(MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS));

        // Non empty sets
        $this->assertGreaterThan(0, count(MetadataFilter::$EXCLUDABLE_PARENT_FIELDS));
        $this->assertGreaterThan(0, count(MetadataFilter::$EXCLUDABLE_CHILD_FIELDS));
        $this->assertGreaterThan(0, count(MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS));

        // Nonempty and canonical field names.
        foreach ($union as $field) {
            $this->assertGreaterThan(0, strlen($field));
            $this->assertEquals($field, trim($field));
        }
    }
}
