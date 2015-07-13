<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Persistency;

use WebPlatform\ContentConverter\Entity\AbstractRevision;

/**
 * Define how to handle persistency.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
abstract class AbstractPersister
{
    /** @var AbstractRevision Revision object to work with */
    protected $revision;

    public function __construct(AbstractRevision $revision)
    {
        $this->revision = $revision;
    }

    abstract public function persist();
}
