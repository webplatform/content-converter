<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Persistency;

use WebPlatform\ContentConverter\Model\AbstractDocument;
use WebPlatform\ContentConverter\Model\AbstractRevision;

/**
 * Define how to handle persistency.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
abstract class AbstractPersister
{
    /** @var AbstractRevision Revision object to work with */
    protected $revision;

    /** @var string File contents */
    protected $content;

    /** @var string File name */
    protected $name = '';

    /** @var AbstractDocument [description] */
    protected $document;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __construct(AbstractDocument $document = null)
    {
        $this->document = $document;

        if ($document !== null) {
            $this->setName($document->getName());
        }

        return $this;
    }

    public function setRevision(AbstractRevision $revision)
    {
        $this->revision = $revision;
        $this->content = $revision->getContent();

        return $this;
    }

    public function getRevision()
    {
        return $this->revision;
    }

    abstract public function persist();
}
