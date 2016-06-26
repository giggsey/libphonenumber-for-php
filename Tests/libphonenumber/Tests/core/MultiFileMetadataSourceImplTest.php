<?php

namespace libphonenumber\Tests\core;

use libphonenumber\DefaultMetadataLoader;
use libphonenumber\MultiFileMetadataSourceImpl;
use libphonenumber\PhoneNumberUtil;

class MultiFileMetadataSourceImplTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MultiFileMetadataSourceImpl
     */
    private $multiFileMetadataSource;

    public function setUp()
    {
        $this->multiFileMetadataSource = new MultiFileMetadataSourceImpl(
            new DefaultMetadataLoader(),
            PhoneNumberUtilTest::TEST_META_DATA_FILE_PREFIX
        );
    }

    public function testMissingMetadataFileThrowsRuntimeException()
    {
        // In normal usage we should never get a state where we are asking to load metadata that doesn't
        // exist. However if the library is packaged incorrectly, this could happen and the best we can
        // do is make sure the exception has the file name in it.

        try {
            $this->multiFileMetadataSource->loadMetadataFromFile("no/such/file", "XX", -1, new DefaultMetadataLoader());
            $this->fail("Expected Exception");
        } catch (\RuntimeException $e) {
            $this->assertContains('no/such/file_XX', $e->getMessage(), "Unexpected error: " . $e->getMessage());
        }

        try {
            $this->multiFileMetadataSource->loadMetadataFromFile(
                "no/such/file",
                PhoneNumberUtil::REGION_CODE_FOR_NON_GEO_ENTITY,
                123,
                new DefaultMetadataLoader()
            );
            $this->fail("Expected Exception");
        } catch (\RuntimeException $e) {
            $this->assertContains('no/such/file_123', $e->getMessage(), "Unexpected error: " . $e->getMessage());
        }
    }
}
