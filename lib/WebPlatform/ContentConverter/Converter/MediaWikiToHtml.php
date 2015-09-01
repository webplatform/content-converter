<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Converter;

use WebPlatform\ContentConverter\Model\AbstractRevision;
use WebPlatform\ContentConverter\Model\MediaWikiRevision;
use WebPlatform\ContentConverter\Model\HtmlRevision;

/**
 * MediaWiki Wikitext to HTML Converter.
 *
 * This class handles a MediaWikiRevision instance and converts
 * into an HtmlRevision.
 *
 * @return MarkdownRevision
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiToHtml implements ConverterInterface
{
    /**
     * Apply Wikitext rewrites.
     *
     * Stub method. Should be extended in your own export project.
     *
     * @param AbstractRevision $revision Input we want to transfer into Markdown
     *
     * @return HtmlRevision
     */
    public function apply(AbstractRevision $revision)
    {
        if ($revision instanceof MediaWikiRevision) {
            $content = $revision->getText();
            $newRev = new HtmlRevision($content);
            $title = $revision->getTitle();
            $newRev->setTitle($title);

            return $newRev;
        }

        return $revision;
    }
}
