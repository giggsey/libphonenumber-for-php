<?php

declare(strict_types=1);

namespace libphonenumber;

/**
 * @internal
 */
class DefaultMetadataLoader implements MetadataLoaderInterface
{
    public function loadMetadata($metadataFileName)
    {
        return include $metadataFileName;
    }
}
