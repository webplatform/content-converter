<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Model;

use SplDoublyLinkedList;

/**
 * A Document represents a content that can change over time.
 *
 * Each change are refered to as revisions.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
abstract class AbstractDocument
{
    /** @var SplDoublyLinkedList of AbstractRevision objects */
    private $revisions = array();

    /** @var string The document name. Can be a simple name (e.g. database field string), an URL, or a full path (e.g. for a file system). */
    private $name = '';

    public function getLatest()
    {
        return $this->revisions->top();
    }

    public function getRevisions()
    {
        return $this->revisions;
    }

    public function addRevision(AbstractRevision $revision)
    {
        if (!($this->revisions instanceof SplDoublyLinkedList)) {
            $this->revisions = new SplDoublyLinkedList();
        }

        $revision->setTitle($this->getTitle());

        $this->revisions->push($revision);

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
