<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

/**
 * Markdown Page.
 *
 * This class handles the Markdown contents so it can
 * be transfered into a file.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MarkdownRevision implements RevisionInterface, TransformedDocumentInterface
{
    /** @var string The text content */
    protected $text = '';

    /** @var array A representation of the original Transclusion */
    protected $transclusions = array();

    /** @var array Markdown document Headers */
    protected $front_matter = array();

    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * Fulfills RevisionInterface.
     *
     * @return string contents of the Revision
     */
    public function getText()
    {
        return $this->text;
    }

    public function setTransclusions($transclusions)
    {
        $this->transclusions = $transclusions;
    }

    public function __toString()
    {
        return $this->getContents();
    }

    public function getContents()
    {
        // We’ll have to do more, just
        // a stub for now.
        return join(array($this->getFrontMatter(), $this->getText()), "\n");
    }

    public function setFrontMatter($front_matter)
    {
        return $this->front_matter = $front_matter;
    }

    public function getFrontMatter()
    {
        return $this->front_matter;
    }
}
