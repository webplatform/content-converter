<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Model;

use Symfony\Component\Yaml\Dumper;

/**
 * Markdown Revision.
 *
 * Represent one revision of content written in Markdown.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MarkdownRevision extends AbstractRevision
{
    public function __construct($content = '', $front_matter = array())
    {
        parent::constructorDefaults();

        $this->front_matter = $front_matter;
        $this->setContent($content);

        return $this;
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
        if (!empty($this->getTitle())) {
            $out[] = 'title: '.$this->getTitle();
        }
        if (!empty($this->front_matter)) {
            $out[] = $yaml->dump($this->front_matter, 3, 0, false, false);
        }
        $out[] = '---';

        return implode($out, PHP_EOL);
    }
}
