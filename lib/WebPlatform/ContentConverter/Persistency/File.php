<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Persistency;

/**
 * Prepares output to create a file to store on a filesystem.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class File extends AbstractPersister
{
    protected $fileName = '';

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function persist()
    {
        // Stub
    }
}
