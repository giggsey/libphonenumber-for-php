<?php

namespace libphonenumber;


interface MetadataLoader
{
    /**
     * @param string $metadataFileName File name (including path) of metadata to load.
     * @return mixed
     */
    public function loadMetadata($metadataFileName);
}

/* EOF */