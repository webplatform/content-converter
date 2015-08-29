<?php

/**
 * WebPlatform MediaWiki Conversion workbench.
 */
namespace WebPlatform\ContentConverter\Helpers;

use WebPlatform\ContentConverter\Model\MediaWikiApiResponseArray;
use Exception;

/**
 * MediaWiki subtelty helper.
 *
 * Original design intended to use Regular Expressions and other parsing
 * methods to convert Wikitext markup into Markdown and abandoned the project.
 *
 * It has been decided to instead use MediaWiki API to tell us the HTML it would
 * generate (what it already does anyway) and we’ll work with it to get the output
 * we want => Markdown+HTML
 *
 * Since Markdown also accepts HTML, the author decided to use MediaWiki
 * internal action=parser and make it give HTML it would generate and make
 * it as our latest revision on top of the whole history.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiHelper implements ApiRequestHelperInterface
{
    protected $apiUrl;

    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;

        return $this;
    }

    public function getHelperEndpoint()
    {
        return $this->apiUrl;
    }

    /**
     * @see MediaWikiHelperInterface::makeRequest()
     */
    public function makeRequest($title, $cookieString = null)
    {
        if (empty($this->apiUrl)) {
            throw new Exception('We do not know to which MediaWiki API to make calls to');
        }

        if (!function_exists('curl_setopt')) {
            throw new Exception('We will not be able to make requests, cURL extension is not available.');
        }

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

        if (!empty($cookieString)) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
        }

        try {
            $content = curl_exec($ch);
            curl_close($ch);
        } catch (Exception $e) {
            $message = sprintf('Could not get data from API for %s with the following URI %s', $title, $url);
            throw new Exception($message, 0, $e);
        }

        return mb_convert_encoding($content, 'UTF-8',
               mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
    }

    /**
     * @see MediaWikiHelperInterface::retrieve()
     */
    public function retrieve($title, $cookieString = null)
    {
        try {
            $recv = $this->makeRequest($title, $cookieString);
            $dto = new MediaWikiApiResponseArray($recv);
        } catch (Exception $e) {
            throw new Exception('We could not retrieve or handle received data', 0, $e);
        }

        return $dto;
    }
}
