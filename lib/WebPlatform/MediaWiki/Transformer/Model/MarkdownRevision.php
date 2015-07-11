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

    /** @var array A representation of the original Transclusion */
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
        return join(array($this->getHeaders(), $this->getText()), "\n");
    }

    public function getHeaders()
    {
        // use yaml_emit, or check if we have it and use it
        // Lets format YAML here, need to have extension. This will do for now.
        $out[] = '----';
        $out[] = json_encode($this->transclusions, true);
        $out[] = '----';

        return join($out, "\n");
    }
}
