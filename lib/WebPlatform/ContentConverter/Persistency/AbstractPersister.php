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
    protected $content = '';

    /** @var string File name */
    protected $name = '';

    /** @var AbstractDocument [description] */
    protected $document;

    protected $prefix = '';

    public function getPrefix()
    {
        return $this->prefix;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __construct(AbstractDocument $document = null, $prefix = '', $extension = '')
    {
        $this->document = $document;

        $this->prefix = $prefix;
        $this->extension = $extension;

        if ($document !== null) {
            $this->setName($document->getName());
        }

        return $this;
    }

    public function __toString()
    {
        return $this->content;
    }

    public function setRevision(AbstractRevision $revision)
    {
        $this->revision = $revision;

        $content = $revision->getContent();
        $this->content = (is_string($content))?$content:'';

        return $this;
    }

    public function getRevision()
    {
        return $this->revision;
    }

    abstract public function formatPersisterCommand();

    abstract public function getArgs();
}
