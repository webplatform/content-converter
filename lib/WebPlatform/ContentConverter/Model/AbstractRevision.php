<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Model;

/**
 * Defines state of the content of a document at a given time.
 *
 * A revision represent the state of the content
 * of a document. This is suitable when you have
 * access to the full content of the document at
 * the time the change was saved.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
abstract class AbstractRevision
{
    /** @var Author The text content */
    protected $author = null;

    /** @var string comment from the contributor when saved the revision */
    protected $comment = null;

    /** @var string The text content */
    protected $content;

    /** @var mixed If we defined a timestamp, it will be a \DateTime, otherwise it will be null */
    protected $timestamp = null;

    public function __toString()
    {
        return $this->getContent();
    }

    public function setAuthor(Author $author)
    {
        $this->author = $author;

        return $this;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    abstract public function getContent();

    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
