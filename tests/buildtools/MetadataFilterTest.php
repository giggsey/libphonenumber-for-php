<?php

declare(strict_types=1);

namespace libphonenumber\Tests\buildtools;

use libphonenumber\buildtools\BuildMetadataFromXml;
use libphonenumber\buildtools\MetadataFilter;
use libphonenumber\PhoneMetadata;
use libphonenumber\PhoneNumberDesc;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function array_merge;
use function array_unique;
use function count;
use function strlen;
use function trim;

class MetadataFilterTest extends TestCase
{
    private static string $ID = 'AM';
    private static int $countryCode = 374;
    private static string $internationalPrefix = '0[01]';
    private static string $preferredInternationalPrefix = '00';
    private static string $nationalNumberPattern = '\\d{8}';
    /**
     * @var int[]
     */
    private static array $possibleLengths = [8];
    /**
     * @var int[]
     */
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

        self::assertEquals(MetadataFilter::forLiteBuild(), new MetadataFilter($blackList));
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

        self::assertEquals(MetadataFilter::forSpecialBuild(), new MetadataFilter($blackList));
    }

    public function testEmptyFilter(): void
    {
        self::assertEquals(MetadataFilter::emptyFilter(), new MetadataFilter([]));
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

        self::assertSame(MetadataFilter::parseFieldMapFromString('fixedLine'), $fieldMap);
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

        self::assertSame(MetadataFilter::parseFieldMapFromString('exampleNumber'), $fieldMap);
    }

    public function testParseFieldMapFromString_childlessFieldAsGroup(): void
    {
        $fieldMap = [];
        $fieldMap['nationalPrefix'] = [];

        self::assertSame(MetadataFilter::parseFieldMapFromString('nationalPrefix'), $fieldMap);
    }

    public function testParseFieldMapFromString_parentWithOneChildAsGroup(): void
    {
        $fieldMap = [];
        $fieldMap['fixedLine'] = ['exampleNumber'];

        self::assertSame(MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber)'), $fieldMap);
    }

    public function testParseFieldMapFromString_parentWithTwoChildrenAsGroup(): void
    {
        $fieldMap = [];
        $fieldMap['fixedLine'] = ['exampleNumber', 'possibleLength'];

        self::assertSame(
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

        self::assertSame(
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
        self::assertSame(
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
        self::assertEqualsCanonicalizing(
            MetadataFilter::parseFieldMapFromString(
                ' nationalNumberPattern '
            . ': uan ( exampleNumber , possibleLengthLocalOnly,     possibleLength ) '
            . ': nationalPrefix '
            . ': fixedLine '
            . ': pager ( exampleNumber ) '
            ),
            MetadataFilter::parseFieldMapFromString(
                'uan(possibleLength,exampleNumber,possibleLengthLocalOnly)'
                . ':pager(exampleNumber)'
                . ':fixedLine'
                . ':nationalPrefix'
                . ':nationalNumberPattern'
            )
        );

        // Parent explicitly listing all possible children.
        self::assertEqualsCanonicalizing(
            MetadataFilter::parseFieldMapFromString(
                'uan(nationalNumberPattern,possibleLength,exampleNumber,possibleLengthLocalOnly)'
            ),
            MetadataFilter::parseFieldMapFromString('uan')
        );

        // All parent's children covered, some implicitly and some explicitly.
        self::assertEqualsCanonicalizing(
            MetadataFilter::parseFieldMapFromString(
                'uan(nationalNumberPattern,possibleLength,exampleNumber)'
                . ':possibleLengthLocalOnly'
            ),
            MetadataFilter::parseFieldMapFromString('uan:possibleLengthLocalOnly')
        );

        // Child field covered by all parents explicitly.
        // It seems this will always be better expressed as a wildcard child, but the check is complex
        // and may not be worth it.
        self::assertSame(
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
        self::assertSame(
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

    public function testParseFieldMapFromString_RuntimeExceptionCases(): void
    {
        // Null input.
        try {
            MetadataFilter::parseFieldMapFromString(null);
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty input.
        try {
            MetadataFilter::parseFieldMapFromString('');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace input.
        try {
            MetadataFilter::parseFieldMapFromString(' ');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as only group.
        try {
            MetadataFilter::parseFieldMapFromString('something_else');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as last group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine:something_else');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as middle group.
        try {
            MetadataFilter::parseFieldMapFromString(
                'pager:nationalPrefix:something_else:nationalNumberPattern'
            );
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given as parent.
        try {
            MetadataFilter::parseFieldMapFromString('nationalPrefix(exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given as parent.
        try {
            MetadataFilter::parseFieldMapFromString('possibleLength(exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as parent.
        try {
            MetadataFilter::parseFieldMapFromString('something_else(exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as only child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(uan)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as first child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(uan,possibleLength)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as last child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(possibleLength,uan)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as middle child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(possibleLength,uan,exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given as only child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(nationalPrefix)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as only child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(something_else)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Bad token given as last child.
        try {
            MetadataFilter::parseFieldMapFromString('uan(possibleLength,something_else)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty parent.
        try {
            MetadataFilter::parseFieldMapFromString('(exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace parent.
        try {
            MetadataFilter::parseFieldMapFromString(' (exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine()');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace child.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine( )');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty parent and child.
        try {
            MetadataFilter::parseFieldMapFromString('()');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Whitespace parent and empty child.
        try {
            MetadataFilter::parseFieldMapFromString(' ()');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as a group twice.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine:uan:fixedLine');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as the parent of a group and as a group by itself.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber):fixedLine');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Parent field given as the parent of one group and then as the parent of another group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber):fixedLine(possibleLength)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Childless field given twice as a group.
        try {
            MetadataFilter::parseFieldMapFromString('nationalPrefix:uan:nationalPrefix');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given twice as a group.
        try {
            MetadataFilter::parseFieldMapFromString('exampleNumber:uan:exampleNumber');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given first as the only child in a group and then as a group by itself.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber):exampleNumber');
            self::fail();
        } catch (RuntimeException $e) {
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
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Child field given twice as children of the same parent.
        try {
            MetadataFilter::parseFieldMapFromString(
                'fixedLine(possibleLength,exampleNumber,possibleLength)'
            );
            self::fail();
        } catch (RuntimeException $e) {
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
            self::fail();
        } catch (RuntimeException $e) {
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
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing right parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing right parenthesis in first group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber:pager');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing left parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLineexampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Early right parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(example_numb)er');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra right parenthesis at end of only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber))');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra right parenthesis between proper parentheses.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(example_numb)er)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra left parenthesis in only group.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine((exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Extra level of children.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber(possibleLength))');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Trailing comma in children.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(exampleNumber,)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Leading comma in children.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(,exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty token between commas.
        try {
            MetadataFilter::parseFieldMapFromString('fixedLine(possibleLength,,exampleNumber)');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Trailing colon.
        try {
            MetadataFilter::parseFieldMapFromString('uan:');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Leading colon.
        try {
            MetadataFilter::parseFieldMapFromString(':uan');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Empty token between colons.
        try {
            MetadataFilter::parseFieldMapFromString('uan::fixedLine');
            self::fail();
        } catch (RuntimeException $e) {
            // Test passed.
            $this->addToAssertionCount(1);
        }

        // Missing colon between groups.
        try {
            MetadataFilter::parseFieldMapFromString('uan(possibleLength)pager');
            self::fail();
        } catch (RuntimeException $e) {
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

        self::assertSame(MetadataFilter::computeComplement($map1), $map2);
        self::assertSame(MetadataFilter::computeComplement($map2), $map1);
    }

    public function testComputeComplement_inBetween(): void
    {
        $map1 = [];
        $map1['fixedLine'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['mobile'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['tollFree'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['premiumRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['emergency'] = ['nationalNumberPattern'];
        $map1['smsServices'] = ['nationalNumberPattern'];
        $map1['voicemail'] = ['possibleLength', 'exampleNumber'];
        $map1['shortCode'] = ['exampleNumber'];
        $map1['standardRate'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
        $map1['carrierSpecific'] = MetadataFilter::$EXCLUDABLE_CHILD_FIELDS;
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

        self::assertEquals(MetadataFilter::computeComplement($map1), $map2);
        self::assertEquals(MetadataFilter::computeComplement($map2), $map1);
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
        self::assertTrue($filter->shouldDrop('fixedLine', 'exampleNumber'));
        self::assertFalse($filter->shouldDrop('sharedCost', 'exampleNumber'));
        self::assertFalse($filter->shouldDrop('emergency', 'exampleNumber'));
        self::assertTrue($filter->shouldDrop('emergency', 'nationalNumberPattern'));
        self::assertFalse($filter->shouldDrop('preferredInternationalPrefix'));
        self::assertTrue($filter->shouldDrop('mobileNumberPortableRegion'));
        self::assertTrue($filter->shouldDrop('smsServices', 'nationalNumberPattern'));

        // Integration tests starting with flag values
        self::assertTrue(BuildMetadataFromXml::getMetadataFilter(true, false)->shouldDrop(
            'fixedLine',
            'exampleNumber'
        ));

        // Integration tests starting with blacklist strings.
        $metadataFilter = new MetadataFilter(MetadataFilter::parseFieldMapFromString('fixedLine'));
        self::assertTrue($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));
        $metadataFilter = new MetadataFilter(MetadataFilter::parseFieldMapFromString('uan'));
        self::assertFalse($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));

        // Integration tests starting with whitelist strings.
        $metadataFilter = new MetadataFilter(MetadataFilter::computeComplement(MetadataFilter::parseFieldMapFromString('exampleNumber')));
        self::assertFalse($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));
        $metadataFilter = new MetadataFilter(MetadataFilter::computeComplement(MetadataFilter::parseFieldMapFromString('uan')));
        self::assertTrue($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));

        // Integration tests with an empty blacklist.
        $metadataFilter = new MetadataFilter();
        self::assertFalse($metadataFilter->shouldDrop('fixedLine', 'exampleNumber'));
    }

    public function testFilterMetadata_liteBuild(): void
    {
        $metadata = $this->getFakeArmeniaPhoneMetadata();

        MetadataFilter::forLiteBuild()->filterMetadata($metadata);

        self::assertSame(self::$ID, $metadata->getId());
        self::assertSame(self::$countryCode, $metadata->getCountryCode());
        self::assertSame(self::$internationalPrefix, $metadata->getInternationalPrefix());

        self::assertSame(self::$preferredInternationalPrefix, $metadata->getPreferredInternationalPrefix());

        /** @var PhoneNumberDesc[] $combinedDesc */
        $combinedDesc = [
            $metadata->getGeneralDesc(),
            $metadata->getFixedLine(),
            $metadata->getMobile(),
            $metadata->getTollFree(),
        ];
        foreach ($combinedDesc as $desc) {
            self::assertSame(self::$nationalNumberPattern, $desc->getNationalNumberPattern());
            self::assertSame(self::$possibleLengths, $desc->getPossibleLength());
            self::assertSame(self::$possibleLengthsLocalOnly, $desc->getPossibleLengthLocalOnly());
            self::assertFalse($desc->hasExampleNumber());
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

        self::assertSame(self::$ID, $metadata->getId());
        self::assertSame(self::$countryCode, $metadata->getCountryCode());
        self::assertSame(self::$internationalPrefix, $metadata->getInternationalPrefix());

        self::assertFalse($metadata->hasPreferredInternationalPrefix());

        /** @var PhoneNumberDesc[] $combinedDesc */
        $combinedDesc = [$metadata->getGeneralDesc(), $metadata->getMobile()];
        foreach ($combinedDesc as $desc) {
            self::assertSame(self::$nationalNumberPattern, $desc->getNationalNumberPattern());
            self::assertSame(self::$possibleLengths, $desc->getPossibleLength());
            self::assertSame(self::$possibleLengthsLocalOnly, $desc->getPossibleLengthLocalOnly());
        }

        $combinedDesc = [$metadata->getFixedLine(), $metadata->getTollFree()];
        foreach ($combinedDesc as $desc) {
            self::assertNotNull($desc);
            self::assertFalse($desc->hasNationalNumberPattern());
            self::assertCount(0, $desc->getPossibleLength());
            self::assertCount(0, $desc->getPossibleLengthLocalOnly());
            self::assertFalse($desc->hasExampleNumber());
        }
    }

    public function testFilterMetadata_emptyFilter(): void
    {
        $metadata = $this->getFakeArmeniaPhoneMetadata();

        MetadataFilter::emptyFilter()->filterMetadata($metadata);

        self::assertSame(self::$ID, $metadata->getId());
        self::assertSame(self::$countryCode, $metadata->getCountryCode());
        self::assertSame(self::$internationalPrefix, $metadata->getInternationalPrefix());
        self::assertSame(self::$preferredInternationalPrefix, $metadata->getPreferredInternationalPrefix());

        /** @var PhoneNumberDesc[] $combinedDesc */
        $combinedDesc = [
            $metadata->getGeneralDesc(),
            $metadata->getFixedLine(),
            $metadata->getMobile(),
            $metadata->getTollFree(),
        ];
        foreach ($combinedDesc as $desc) {
            self::assertSame(self::$nationalNumberPattern, $desc->getNationalNumberPattern());
            self::assertSame(self::$possibleLengths, $desc->getPossibleLength());
            self::assertSame(self::$possibleLengthsLocalOnly, $desc->getPossibleLengthLocalOnly());
        }

        self::assertNotNull($metadata->getGeneralDesc());
        self::assertFalse($metadata->getGeneralDesc()->hasExampleNumber());
        self::assertSame($metadata->getFixedLine()?->getExampleNumber(), self::$exampleNumber);
        self::assertSame($metadata->getMobile()?->getExampleNumber(), self::$exampleNumber);
        self::assertSame($metadata->getTollFree()?->getExampleNumber(), self::$exampleNumber);
    }

    public function testIntegrityOfFieldSets(): void
    {
        $union = array_merge(
            MetadataFilter::$EXCLUDABLE_PARENT_FIELDS,
            MetadataFilter::$EXCLUDABLE_CHILD_FIELDS,
            MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS
        );
        $union = array_unique($union);

        // Mutually exclusive sets
        self::assertSame(
            count($union),
            count(MetadataFilter::$EXCLUDABLE_PARENT_FIELDS) + count(MetadataFilter::$EXCLUDABLE_CHILD_FIELDS) + count(MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS)
        );

        // Non empty sets
        self::assertGreaterThan(0, count(MetadataFilter::$EXCLUDABLE_PARENT_FIELDS));
        self::assertGreaterThan(0, count(MetadataFilter::$EXCLUDABLE_CHILD_FIELDS));
        self::assertGreaterThan(0, count(MetadataFilter::$EXCLUDABLE_CHILDLESS_FIELDS));

        // Nonempty and canonical field names.
        foreach ($union as $field) {
            self::assertGreaterThan(0, strlen($field));
            self::assertSame($field, trim($field));
        }
    }
}
