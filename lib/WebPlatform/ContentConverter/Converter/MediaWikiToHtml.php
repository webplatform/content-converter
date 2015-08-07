<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Converter;

use WebPlatform\ContentConverter\Model\AbstractRevision;
use WebPlatform\ContentConverter\Model\MediaWikiRevision;
use WebPlatform\ContentConverter\Model\MarkdownRevision;
use WebPlatform\ContentConverter\Converter\ConverterInterface;
use Exception;

/**
 * MediaWiki Wikitext to HTML Converter.
 *
 * This class handles a MediaWikiRevision instance and converts
 * the content into HTML and inserts content into a MarkdownRevision.
 *
 * Reason of inserting HTML into a MarkdownRevision was that the original
 * design intended to use this class as a set of RegularExpressions and filter
 * MediaWiki markup to make Markdown. We couldn’t get good enough results
 * without risk of losing content.
 *
 * Since Markdown also accepts HTML, the author decided to use MediaWiki
 * internal action=parser and make it give HTML it would generate and make
 * it as our latest revision on top of the whole history.
 *
 * Markdown revision will be handled differently.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiToHtml implements ConverterInterface
{
    protected $apiUrl;

    public function setApiUrl($apiUrl)
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    /**
     * Make a (forgiving) HTTP request to an origin
     *
     * I’m aware that its a bad idea to set `CURLOPT_SSL_VERIFYPEER` to
     * false. But the use-case here is about supporting requests to origins
     * potentially behind a Varnish server with a self-signed certificate and
     * to allow run import on them, we got to prevent check.
     *
     * We have to remember that the point of this library is to export content
     * into static files, not to make financial transactions and bypass things that
     * should be taken care of.
     **/
    protected function makeRequest($title)
    {

        $url = $this->apiUrl.urlencode($title);

        $ch = curl_init();
        // http://php.net/manual/en/function.curl-setopt.php
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TCP_NODELAY, true);

        try {
            $content = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            throw new Exception('Could not retrieve data from remote service', null, $e);
        }

        return mb_convert_encoding($content, 'UTF-8',
               mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    protected function getPageFromApi($title)
    {
        try {
            $recv = $this->makeRequest($title);
        } catch (Exception $e) {
            return $e;
        }

        $dto = json_decode($recv, true);

        if (!isset($dto['parse']) || !isset($dto['parse']['text'])) {
            throw new Exception('We did could not use data we received');
        }

        return $dto['parse']['text']['*'];
    }

    /**
     * Apply Wikitext rewrites.
     *
     * @param AbstractRevision $revision Input we want to transfer into Markdown
     *
     * @return AbstractRevision
     */
    public function apply(AbstractRevision $revision)
    {
        if ($revision instanceof MediaWikiRevision) {
            try {
                $content = $this->getPageFromApi($revision->getTitle());
            } catch (Exception $e) {
                $title = $revision->getTitle();
                $url = $this->apiUrl.urlencode($title);
                $message = sprintf('Could not get data from API for %s with the following URI %s', $title, $url);
                throw new Exception($message, 0, $e);
            }

            $front_matter = [];

            $rev_matter = $revision->getFrontMatterData();

            $newRev = new MarkdownRevision($content, array_merge($rev_matter, $front_matter));

            return $newRev->setTitle($revision->getTitle());
        }

        return $revision;
    }
}
