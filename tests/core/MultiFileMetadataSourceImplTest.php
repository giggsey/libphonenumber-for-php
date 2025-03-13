<?php

declare(strict_types=1);

namespace libphonenumber\Tests\core;

use libphonenumber\DefaultMetadataLoader;
use libphonenumber\MultiFileMetadataSourceImpl;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class MultiFileMetadataSourceImplTest extends TestCase
{
    private MultiFileMetadataSourceImpl $multiFileMetadataSource;

    public function setUp(): void
    {
        $this->multiFileMetadataSource = new MultiFileMetadataSourceImpl(
            new DefaultMetadataLoader(),
            __DIR__ . '/data/PhoneNumberMetadataForTesting'
        );
    }

    public function testMissingMetadataFileThrowsRuntimeException(): void
    {
        // In normal usage we should never get a state where we are asking to load metadata that doesn't
        // exist. However if the library is packaged incorrectly, this could happen and the best we can
        // do is make sure the exception has the file name in it.

        try {
            $this->multiFileMetadataSource->loadMetadataFromFile('no/such/file', 'XX', -1, new DefaultMetadataLoader());
            self::fail('Expected Exception');
        } catch (RuntimeException $e) {
            self::assertStringContainsString(
                'no/such/file_XX',
                $e->getMessage(),
                'Unexpected error: ' . $e->getMessage()
            );
        }

        try {
            $this->multiFileMetadataSource->loadMetadataFromFile(
                'no/such/file',
                PhoneNumberUtil::REGION_CODE_FOR_NON_GEO_ENTITY,
                123,
                new DefaultMetadataLoader()
            );
            self::fail('Expected Exception');
        } catch (RuntimeException $e) {
            self::assertStringContainsString(
                'no/such/file_123',
                $e->getMessage(),
                'Unexpected error: ' . $e->getMessage()
            );
        }
    }
}
