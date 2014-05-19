<?php

namespace libphonenumber;


class DefaultMetadataLoader implements MetadataLoader
{
    public function loadMetadata($metadataFileName)
    {
        return include $metadataFileName;
    }
}

/* EOF */