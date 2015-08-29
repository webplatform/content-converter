<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Model;

use DateTime;
use DateTimeZone;

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
        $this->setContent($content);
        $datetime = new DateTime();
        $datetime->setTimezone(new DateTimeZone('Etc/UTC'));
        $this->setTimestamp($datetime);
        $this->setComment('Conversion pass: Reformatted into HTML');

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
}
