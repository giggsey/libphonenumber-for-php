<?php

namespace libphonenumber\Tests\buildtools;

use libphonenumber\buildtools\BuildMetadataFromXml;
use libphonenumber\buildtools\MetadataFilter;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;
use PHPUnit\Framework\TestCase;

class MetadataFilterTest extends TestCase
{
    private static string $ID = 'AM';
    private static int $countryCode = 374;
    private static string $internationalPrefix = '0[01]';
    private static string $preferredInternationalPrefix = '00';
    private static string $nationalNumberPattern = '\\d{8}';
    private static array $possibleLengths = [8];
    private static array $possibleLengthsLocalOnly = [5, 6];
    private static string $exampleNumber = '10123456';

    public function testForLiteBuild(): void
    {
        $blackList = [];
        $blackList['fixedLine'] = ['exampleNumber'];
        $blackList['mobile'] = ['exampleNumber'];
        $blackList['tollFree'] = ['exampleNumber'];
        $blackList['premiumRate'] = ['exampleNumber'];
        $blackList['sharedCost'] = ['exampleNumber'];
        $blackList['personalNumber'] = ['exampleNumber'];
        $blackList['voip'] = ['exampleNumber'];
        $blackList['pager'] = ['exampleNumber'];
        $blackList['uan'] = ['exampleNumber'];
        $blackList['emergency'] = ['exampleNumber'];
        $blackList['voicemail'] = ['exampleNumber'];
        $blackList['shortCode'] = ['exampleNumber'];
        $blackList['standardRate'] = ['exampleNumber'];
        $blackList['carrierSpecific'] = ['exampleNumber'];
        $blackList['smsServices'] = ['exampleNumber'];
        $blackList['noInternationalDialling'] = ['exampleNumber'];

        $this->assertEquals(MetadataFilter::forLiteBuild(), new MetadataFilter($blackList));
    }

    public function testForSpecialBuild(): void
    {
        $blackList = [];
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
        $blackList['smsServices'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['noInternationalDialling'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blackList['preferredInternationalPrefix'] = [];
        $blackList['nationalPrefix'] = [];
        $blackList['preferredExtnPrefix'] = [];
        $blackList['nationalPrefixTransformRule'] = [];
        $blackList['sameMobileAndFixedLinePattern'] = [];
        $blackList['mainCountryForCode'] = [];
        $blackList['mobileNumberPortableRegion'] = [];

        $this->assertEquals(MetadataFilter::forSpecialBuild(), new MetadataFilter($blackList));
    }

    public function testEmptyFilter(): void
    {
        $this->assertEquals(MetadataFilter::emptyFilter(), new MetadataFilter([]));
    }

    public function testParseFieldMapFromString_parentAsGroup(): void
    {
        $fieldMap = [];
        $fieldMap['fixedLine'] = [
            'nationalNumberPattern',
            'possibleLength',
            'possibleLengthLocalOnly',
            'exampleNumber',
        ];

        $this->assertEquals(MetadataFilter::parseFieldMapFromString('fixedLine'), $fieldMap);
    }

    public function testParseFieldMapFromString_childAsGroup(): void
    {
        $fieldMap = [];
        $fieldMap['fixedLine'] = ['exampleNumber'];
        $fieldMap['mobile'] = ['exampleNumber'];
        $fieldMap['tollFree'] = ['exampleNumber'];
        $fieldMap['premiumRate'] = ['exampleNumber'];
        $fieldMap['sharedCost'] = ['exampleNumber'];
        $fieldMap['personalNumber'] = ['exampleNumber'];
        $fieldMap['voip'] = ['exampleNumber'];
        $fieldMap['pager'] = ['exampleNumber'];
        $fieldMap['uan'] = ['exampleNumber'];
        $fieldMap['emergency'] = ['exampleNumber'];
        $fieldMap['voicemail'] = ['exampleNumber'];
        $fieldMap['shortCode'] = ['exampleNumber'];
        $fieldMap['standardRate'] = ['exampleNumber'];
        $fieldMap['carrierSpecific'] = ['exampleNumber'];
        $fieldMap['smsServices'] = ['exampleNumber'];
        $fieldMap['noInternationalDialling'] = ['exampleNumber'];

        $this->assertEquals(MetadataFilter::parseFieldMapFromString('exampleNumber'), $fieldMap);
    }

    public function testParseFieldMapFromString_childlessFieldAsGroup(): void
    {
        $fieldMap = [];
        $fieldMap['nationalPrefix'] = [];

        $this->assertEquals(MetadataFilter::parseFieldMapFromString('nationalPrefix'), $fieldMap);
    }

    public function testParseFieldMapFromString_parentWithOneChildAsGroup(): void
    {
        $fieldMap = [];
        $fieldMap['fixedLine'] = ['exampleNumber'];

        $this->assertEquals(MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber)'), $fieldMap);
    }

    public function testParseFieldMapFromString_parentWithTwoChildrenAsGroup(): void
    {
        $fieldMap = [];
        $fieldMap['fixedLine'] = ['exampleNumber', 'possibleLength'];

        $this->assertEquals(
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber,possibleLength)'),
            $fieldMap
        );
    }

    public function testParseFieldMapFromString_mixOfGroups(): void
    {
        $fieldMap = [];
        $fieldMap['uan'] = ['possibleLength', 'exampleNumber', 'possibleLengthLocalOnly', 'nationalNumberPattern'];
        $fieldMap['pager'] = ['exampleNumber', 'nationalNumberPattern'];
        $fieldMap['fixedLine'] = [
            'nationalNumberPattern',
            'possibleLength',
            'possibleLengthLocalOnly',
            'exampleNumber',
        ];
        $fieldMap['nationalPrefix'] = [];
        $fieldMap['mobile'] = ['nationalNumberPattern'];
        $fieldMap['tollFree'] = ['nationalNumberPattern'];
        $fieldMap['premiumRate'] = ['nationalNumberPattern'];
        $fieldMap['sharedCost'] = ['nationalNumberPattern'];
        $fieldMap['personalNumber'] = ['nationalNumberPattern'];
        $fieldMap['voip'] = ['nationalNumberPattern'];
        $fieldMap['emergency'] = ['nationalNumberPattern'];
        $fieldMap['voicemail'] = ['nationalNumberPattern'];
        $fieldMap['shortCode'] = ['nationalNumberPattern'];
        $fieldMap['standardRate'] = ['nationalNumberPattern'];
        $fieldMap['carrierSpecific'] = ['nationalNumberPattern'];
        $fieldMap['smsServices'] = ['nationalNumberPattern'];
        $fieldMap['noInternationalDialling'] = ['nationalNumberPattern'];

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

    public function testParseFieldMapFromString_equivalentExpressions(): void
    {
        // Listing all excludable parent fields is equivalent to listing all excludable child field.s
        $this->assertEquals(
            MetadataFilter::parseFieldMapFromString(
                'fixedLine'
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
                . ':smsServices'
                . ':noInternationalDialling'
            ),
            MetadataFilter::parseFieldMapFromString(
                'nationalNumberPattern'
            . ':possibleLength'
            . ':possibleLengthLocalOnly'
            . ':exampleNumber'
            )
        );

        // Order and whitespace don't matter
        $this->assertEquals(
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString(
                ' nationalNumberPattern '
            . ': uan ( exampleNumber , possibleLengthLocalOnly,     possibleLength ) '
            . ': nationalPrefix '
            . ': fixedLine '
            . ': pager ( exampleNumber ) '
            )),
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString(
                'uan(possibleLength,exampleNumber,possibleLengthLocalOnly)'
                . ':pager(exampleNumber)'
                . ':fixedLine'
                . ':nationalPrefix'
                . ':nationalNumberPattern'
            ))
        );

        // Parent explicitly listing all possible children.
        $this->assertEquals(
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString(
                'uan(nationalNumberPattern,possibleLength,exampleNumber,possibleLengthLocalOnly)'
            )),
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString('uan'))
        );

        // All parent's children covered, some implicitly and some explicitly.
        $this->assertEquals(
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString(
                'uan(nationalNumberPattern,possibleLength,exampleNumber)'
                . ':possibleLengthLocalOnly'
            )),
            $this->recursive_ksort(MetadataFilter::parseFieldMapFromString('uan:possibleLengthLocalOnly'))
        );

        // Child field covered by all parents explicitly.
        // It seems this will always be better expressed as a wildcard child, but the check is complex
        // and may not be worth it.
        $this->assertEquals(
            MetadataFilter::parseFieldMapFromString(
                'fixedLine(exampleNumber)'
                . ':mobile(exampleNumber)'
                . ':tollFree(exampleNumber)'
                . ':premiumRate(exampleNumber)'
                . ':sharedCost(exampleNumber)'
                . ':personalNumber(exampleNumber)'
                . ':voip(exampleNumber)'
                . ':pager(exampleNumber)'
                . ':uan(exampleNumber)'
                . ':emergency(exampleNumber)'
                . ':voicemail(exampleNumber)'
                . ':shortCode(exampleNumber)'
                . ':standardRate(exampleNumber)'
                . ':carrierSpecific(exampleNumber)'
                . ':smsServices(exampleNumber)'
                . ':noInternationalDialling(exampleNumber)'
            ),
            MetadataFilter::parseFieldMapFromString('exampleNumber')
        );

        // Child field given as a group by itself while it's covered by all parents implicitly.
        // It seems this will always be better expressed without the wildcard child, but the check is
        // complex and may not be worth it.
        $this->assertEquals(
            MetadataFilter::parseFieldMapFromString(
                'fixedLine'
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
                . ':smsServices'
                . ':noInternationalDialling'
                . ':exampleNumber'
            ),
            MetadataFilter::parseFieldMapFromString(
                'fixedLine'
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
                . ':smsServices'
                . ':noInternationalDialling'
            )
        );
    }

    /**
     * Need to sort some of the results, as PHP arrays are ordered by when they were added
     */
    private function recursive_ksort(array $array): bool
    {
        foreach ($array as &$value) {
            if (\is_array($value)) {
                $this->recursive_ksort($value);
            }
        }
        return \ksort($array);
    }

    public function testParseFieldMapFromString_RuntimeExceptionCases(): void
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
            MetadataFilter::parseFieldMapFromString('');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace input.
        try {
            MetadataFilter::parseFieldMapFromString(' ');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as only group.
        try {
            MetadataFilter::parseFieldMapFromString('something_else');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as last group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine:something_else');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as middle group.
        try {
            MetadataFilter::parseFieldMapFromString(
                'pager:nationalPrefix:something_else:nationalNumberPattern'
            );
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given as parent.
        try {
            MetadataFilter::parseFieldMapFromString('nationalPrefix(exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given as parent.
        try {
            MetadataFilter::parseFieldMapFromString('possibleLength(exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as parent.
        try {
            MetadataFilter::parseFieldMapFromString('something_else(exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as only child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(uan)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as first child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(uan,possibleLength)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as last child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(possibleLength,uan)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as middle child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(possibleLength,uan,exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given as only child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(nationalPrefix)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as only child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(something_else)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as last child.
        try {
            MetadataFilter::parseFieldMapFromString('uan(possibleLength,something_else)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty parent.
        try {
            MetadataFilter::parseFieldMapFromString('(exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace parent.
        try {
            MetadataFilter::parseFieldMapFromString(' (exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine()');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine( )');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty parent and child.
        try {
            MetadataFilter::parseFieldMapFromString('()');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace parent and empty child.
        try {
            MetadataFilter::parseFieldMapFromString(' ()');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as a group twice.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine:uan:fixedLine');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as the parent of a group and as a group by itself.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber):fixedLine');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as the parent of one group and then as the parent of another group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber):fixedLine(possibleLength)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given twice as a group.
        try {
            MetadataFilter::parseFieldMapFromString('nationalPrefix:uan:nationalPrefix');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given twice as a group.
        try {
            MetadataFilter::parseFieldMapFromString('exampleNumber:uan:exampleNumber');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given first as the only child in a group and then as a group by itself.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber):exampleNumber');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given first as a child in a group and then as a group by itself.
        try {
            MetadataFilter::parseFieldMapFromString(
                'uan(nationalNumberPattern,possibleLength,exampleNumber)'
                . ':possibleLengthLocalOnly'
                . ':exampleNumber'
            );
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given twice as children of the same parent.
        try {
            MetadataFilter::parseFieldMapFromString(
                'fixedLine(possibleLength,exampleNumber,possibleLength)'
            );
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given as a group by itself while it's covered by all parents explicitly.
        try {
            MetadataFilter::parseFieldMapFromString(
                'fixedLine(exampleNumber)'
                . ':mobile(exampleNumber)'
                . ':tollFree(exampleNumber)'
                . ':premiumRate(exampleNumber)'
                . ':sharedCost(exampleNumber)'
                . ':personalNumber(exampleNumber)'
                . ':voip(exampleNumber)'
                . ':pager(exampleNumber)'
                . ':uan(exampleNumber)'
                . ':emergency(exampleNumber)'
                . ':voicemail(exampleNumber)'
                . ':shortCode(exampleNumber)'
                . ':standardRate(exampleNumber)'
                . ':carrierSpecific(exampleNumber)'
                . ':noInternationalDialling(exampleNumber)'
                . ':exampleNumber'
            );
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given as a group by itself while it's covered by all parents, some implicitly and
        // some explicitly.
        try {
            MetadataFilter::parseFieldMapFromString(
                'fixedLine'
                . ':mobile'
                . ':tollFree'
                . ':premiumRate'
                . ':sharedCost'
                . ':personalNumber'
                . ':voip'
                . ':pager(exampleNumber)'
                . ':uan(exampleNumber)'
                . ':emergency(exampleNumber)'
                . ':voicemail(exampleNumber)'
                . ':shortCode(exampleNumber)'
                . ':standardRate(exampleNumber)'
                . ':carrierSpecific(exampleNumber)'
                . ':smsServices'
                . ':noInternationalDialling(exampleNumber)'
                . ':exampleNumber'
            );
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing right parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing right parenthesis in first group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber:pager');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing left parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLineexampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Early right parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(example_numb)er');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra right parenthesis at end of only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber))');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra right parenthesis between proper parentheses.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(example_numb)er)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra left parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine((exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra level of children.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber(possibleLength))');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Trailing comma in children.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber,)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Leading comma in children.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(,exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty token between commas.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(possibleLength,,exampleNumber)');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Trailing colon.
        try {
            MetadataFilter::parseFieldMapFromString('uan:');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Leading colon.
        try {
            MetadataFilter::parseFieldMapFromString(':uan');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty token between colons.
        try {
            MetadataFilter::parseFieldMapFromString('uan::fixedLine');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing colon between groups.
        try {
            MetadataFilter::parseFieldMapFromString('uan(possibleLength)pager');
            $this->fail();
        } catch (\RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }
    }

    public function testComputeComplement_allAndNothing(): void
    {
        $map1 = [];
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
        $map1['smsServices'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['noInternationalDialling'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['preferredInternationalPrefix'] = [];
        $map1['nationalPrefix'] = [];
        $map1['preferredExtnPrefix'] = [];
        $map1['nationalPrefixTransformRule'] = [];
        $map1['sameMobileAndFixedLinePattern'] = [];
        $map1['mainCountryForCode'] = [];
        $map1['mobileNumberPortableRegion'] = [];

        $map2 = [];

        $this->assertEquals(MetadataFilter::computeComplement($map1), $map2);
        $this->assertEquals(MetadataFilter::computeComplement($map2), $map1);
    }

    public function testComputeComplement_inBetween(): void
    {
        $map1 = [];
        $map1['fixedLine'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['mobile'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['tollFree'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['premiumRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['emergency'] = ['nationalNumberPattern'];
        $map1['voicemail'] = ['possibleLength', 'exampleNumber'];
        $map1['shortCode'] = ['exampleNumber'];
        $map1['standardRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['carrierSpecific'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['smsServices'] = ['nationalNumberPattern'];
        $map1['noInternationalDialling'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['nationalPrefixTransformRule'] = [];
        $map1['sameMobileAndFixedLinePattern'] = [];
        $map1['mainCountryForCode'] = [];
        $map1['mobileNumberPortableRegion'] = [];

        $map2 = [];
        $map2['sharedCost'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['personalNumber'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['voip'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['pager'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['uan'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map2['emergency'] = ['possibleLength', 'possibleLengthLocalOnly', 'exampleNumber'];
        $map2['smsServices'] = ['possibleLength', 'possibleLengthLocalOnly', 'exampleNumber'];
        $map2['voicemail'] = ['nationalNumberPattern', 'possibleLengthLocalOnly'];
        $map2['shortCode'] = [
            'nationalNumberPattern',
            'possibleLength',
            'possibleLengthLocalOnly',
        ];
        $map2['preferredInternationalPrefix'] = [];
        $map2['nationalPrefix'] = [];
        $map2['preferredExtnPrefix'] = [];

        $this->assertEquals(MetadataFilter::computeComplement($map1), $map2);
        $this->assertEquals(MetadataFilter::computeComplement($map2), $map1);
    }

    public function testShouldDrop(): void
    {
        $blacklist = [];
        $blacklist['fixedLine'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['mobile'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['tollFree'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['premiumRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['emergency'] = ['nationalNumberPattern'];
        $blacklist['voicemail'] = ['possibleLength', 'exampleNumber'];
        $blacklist['shortCode'] = ['exampleNumber'];
        $blacklist['standardRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['carrierSpecific'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['smsServices'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['noInternationalDialling'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $blacklist['nationalPrefixTransformRule'] = [];
        $blacklist['sameMobileAndFixedLinePattern'] = [];
        $blacklist['mainCountryForCode'] = [];
        $blacklist['mobileNumberPortableRegion'] = [];

        $filter = new MetadataFilter($blacklist);
        $this->assertTrue($filter->shouldDrop('fixedLine', 'exampleNumber'));
        $this->assertFalse($filter->shouldDrop('sharedCost', 'exampleNumber'));
        $this->assertFalse($filter->shouldDrop('emergency', 'exampleNumber'));
        $this->assertTrue($filter->shouldDrop('emergency', 'nationalNumberPattern'));
        $this->assertFalse($filter->shouldDrop('preferredInternationalPrefix'));
        $this->assertTrue($filter->shouldDrop('mobileNumberPortableRegion'));
        $this->assertTrue($filter->shouldDrop('smsServices', 'nationalNumberPattern'));

        // Integration tests starting with flag values
        $this->assertTrue(BuildMetadataFromXml::getMetadataFilter(true, false)->shouldDrop(
            'fixedLine',
            'exampleNumber'
        ));

        // Integration tests starting with blacklist strings.
        $metadataFilter = new MetadataFilter(MetadataFilter::parseFieldMapFromString('fixedLine'));
        $this->assertTrue($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));
        $metadataFilter = new MetadataFilter(MetadataFilter::parseFieldMapFromString('uan'));
        $this->assertFalse($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));

        // Integration tests starting with whitelist strings.
        $metadataFilter = new MetadataFilter(MetadataFilter::computeComplement(MetadataFilter::parseFieldMapFromString('exampleNumber')));
        $this->assertFalse($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));
        $metadataFilter = new MetadataFilter(MetadataFilter::computeComplement(MetadataFilter::parseFieldMapFromString('uan')));
        $this->assertTrue($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));

        // Integration tests with an empty blacklist.
        $metadataFilter = new MetadataFilter();
        $this->assertFalse($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));
    }

    public function testFilterMetadata_liteBuild(): void
    {
        $metadata = $this->getFakeArmeniaPhoneMetadata();

        MetadataFilter::forLiteBuild()->filterMetadata($metadata);

        $this->assertEquals(self::$ID, $metadata->getId());
        $this->assertEquals(self::$countryCode, $metadata->getCountryCode());
        $this->assertEquals(self::$internationalPrefix, $metadata->getInternationalPrefix());

        $this->assertEquals(self::$preferredInternationalPrefix, $metadata->getPreferredInternationalPrefix());

        /** @var PhoneNumberDesc[] $combinedDesc */
        $combinedDesc = [
            $metadata->getGeneralDesc(),
            $metadata->getFixedLine(),
            $metadata->getMobile(),
            $metadata->getTollFree(),
        ];
        foreach ($combinedDesc as $desc) {
            $this->assertEquals(self::$nationalNumberPattern, $desc->getNationalNumberPattern());
            $this->assertEquals(self::$possibleLengths, $desc->getPossibleLength());
            $this->assertEquals(self::$possibleLengthsLocalOnly, $desc->getPossibleLengthLocalOnly());
            $this->assertFalse($desc->hasExampleNumber());
        }
    }

    private function getFakeArmeniaPhoneMetadata(): PhoneMetadata
    {
        $metadata = new PhoneMetadata();
        $metadata->setId(self::$ID);
        $metadata->setCountryCode(self::$countryCode);
        $metadata->setInternationalPrefix(self::$internationalPrefix);
        $metadata->setPreferredInternationalPrefix(self::$preferredInternationalPrefix);
        $metadata->setGeneralDesc($this->getFakeArmeniaPhoneNumberDesc(true));
        $metadata->setFixedLine($this->getFakeArmeniaPhoneNumberDesc(false));
        $metadata->setMobile($this->getFakeArmeniaPhoneNumberDesc(false));
        $metadata->setTollFree($this->getFakeArmeniaPhoneNumberDesc(false));
        return $metadata;
    }

    private function getFakeArmeniaPhoneNumberDesc(bool $generalDesc): PhoneNumberDesc
    {
        $desc = new PhoneNumberDesc();
        $desc->setNationalNumberPattern(self::$nationalNumberPattern);

        if (!$generalDesc) {
            $desc->setExampleNumber(self::$exampleNumber);
        }

        foreach (self::$possibleLengths as $i) {
            $desc->addPossibleLength($i);
        }

        foreach (self::$possibleLengthsLocalOnly as $i) {
            $desc->addPossibleLengthLocalOnly($i);
        }

        return $desc;
    }

    public function testFilterMetadata_specialBuild(): void
    {
        $metadata = $this->getFakeArmeniaPhoneMetadata();

        MetadataFilter::forSpecialBuild()->filterMetadata($metadata);

        $this->assertEquals(self::$ID, $metadata->getId());
        $this->assertEquals(self::$countryCode, $metadata->getCountryCode());
        $this->assertEquals(self::$internationalPrefix, $metadata->getInternationalPrefix());

        $this->assertFalse($metadata->hasPreferredInternationalPrefix());

        /** @var PhoneNumberDesc[] $combinedDesc */
        $combinedDesc = [$metadata->getGeneralDesc(), $metadata->getMobile()];
        foreach ($combinedDesc as $desc) {
            $this->assertEquals(self::$nationalNumberPattern, $desc->getNationalNumberPattern());
            $this->assertEquals(self::$possibleLengths, $desc->getPossibleLength());
            $this->assertEquals(self::$possibleLengthsLocalOnly, $desc->getPossibleLengthLocalOnly());
        }

        $combinedDesc = [$metadata->getFixedLine(), $metadata->getTollFree()];
        foreach ($combinedDesc as $desc) {
            $this->assertFalse($desc->hasNationalNumberPattern());
            $this->assertCount(0, $desc->getPossibleLength());
            $this->assertCount(0, $desc->getPossibleLengthLocalOnly());
            $this->assertFalse($desc->hasExampleNumber());
        }
    }

    public function testFilterMetadata_emptyFilter(): void
    {
        $metadata = $this->getFakeArmeniaPhoneMetadata();

        MetadataFilter::emptyFilter()->filterMetadata($metadata);

        $this->assertEquals(self::$ID, $metadata->getId());
        $this->assertEquals(self::$countryCode, $metadata->getCountryCode());
        $this->assertEquals(self::$internationalPrefix, $metadata->getInternationalPrefix());
        $this->assertEquals(self::$preferredInternationalPrefix, $metadata->getPreferredInternationalPrefix());

        /** @var PhoneNumberDesc[] $combinedDesc */
        $combinedDesc = [
            $metadata->getGeneralDesc(),
            $metadata->getFixedLine(),
            $metadata->getMobile(),
            $metadata->getTollFree(),
        ];
        foreach ($combinedDesc as $desc) {
            $this->assertEquals(self::$nationalNumberPattern, $desc->getNationalNumberPattern());
            $this->assertEquals(self::$possibleLengths, $desc->getPossibleLength());
            $this->assertEquals(self::$possibleLengthsLocalOnly, $desc->getPossibleLengthLocalOnly());
        }

        $this->assertFalse($metadata->getGeneralDesc()->hasExampleNumber());
        $this->assertEquals($metadata->getFixedLine()->getExampleNumber(), self::$exampleNumber);
        $this->assertEquals($metadata->getMobile()->getExampleNumber(), self::$exampleNumber);
        $this->assertEquals($metadata->getTollFree()->getExampleNumber(), self::$exampleNumber);
    }

    public function testIntegrityOfFieldSets(): void
    {
        $union = \array_merge(
            MetadataFilter::$EXCLUDABLE_PARENT_FIELDS,
            MetadataFilter::$EXCLUDABLE_CHILD_FIELDS,
            MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS
        );
        $union = \array_unique($union);

        // Mutually exclusive sets
        $this->assertEquals(
            \count($union),
            \count(MetadataFilter::$EXCLUDABLE_PARENT_FIELDS) + \count(MetadataFilter::$EXCLUDABLE_CHILD_FIELDS) + \count(MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS)
        );

        // Non empty sets
        $this->assertGreaterThan(0, \count(MetadataFilter::$EXCLUDABLE_PARENT_FIELDS));
        $this->assertGreaterThan(0, \count(MetadataFilter::$EXCLUDABLE_CHILD_FIELDS));
        $this->assertGreaterThan(0, \count(MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS));

        // Nonempty and canonical field names.
        foreach ($union as $field) {
            $this->assertGreaterThan(0, \strlen($field));
            $this->assertEquals($field, \trim($field));
        }
    }
}
