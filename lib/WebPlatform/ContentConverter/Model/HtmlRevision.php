<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Model;

/**
 * HTML Revision.
 *
 * The most basic you can get, ready to be sent into a DOMDocument
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class HtmlRevision extends AbstractRevision
{
    public function __construct($content = '')
    {
        parent::constructorDefaults();

        $this->setContent($content);

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
}
