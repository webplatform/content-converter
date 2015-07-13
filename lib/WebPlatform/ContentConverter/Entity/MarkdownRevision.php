<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\ContentConverter\Entity;

use Symfony\Component\Yaml\Dumper;

/**
 * Markdown Revision.
 *
 * This class handles the Markdown contents so it can
 * be transfered into a file.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MarkdownRevision extends AbstractRevision
{
    /** @var array Markdown document Headers */
    protected $front_matter = array();

    public function __construct($content = '', $front_matter = array())
    {
        $this->setContent($content);
        $this->front_matter = $front_matter;
    }

    public function getContent()
    {
        return implode(array($this->getFrontMatter(), $this->content), PHP_EOL);
    }

    public function setFrontMatter($front_matter)
    {
        $this->front_matter = array_merge($this->front_matter, (array) $front_matter);

        return $this;
    }

    public function getFrontMatter()
    {
        $yaml = new Dumper();
        $yaml->setIndentation(2);

        $out[] = '---';
        $out[] = $yaml->dump($this->front_matter, 3, 0, false, false);
        $out[] = '---';

        return implode($out, PHP_EOL);
    }
}
