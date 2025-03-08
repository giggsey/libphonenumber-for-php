<?php

declare(strict_types=1);

namespace libphonenumber;

/**
 * @internal
 */
interface MetadataLoaderInterface
{
    /**
     * @param string $metadataFileName File name (including path) of metadata to load.
     * @return mixed
     */
    public function loadMetadata(string $metadataFileName);
}
