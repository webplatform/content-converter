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
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
interface ApiRequestHelperInterface
{
    /**
     * Make a (forgiving) HTTP request to an origin.
     *
     * I’m aware that its a bad idea to set `CURLOPT_SSL_VERIFYPEER` to
     * false. But the use-case here is about supporting requests to origins
     * potentially behind a Varnish server with a self-signed certificate and
     * to allow run import on them, we got to prevent check.
     *
     * We have to remember that the point of this library is to export content
     * into static files, not to make financial transactions and bypass things that
     * should be taken care of.
     *
     * @param string $title        MediaWiki page title (e.g. /w/index.php?title=Main_Page)
     * @param string $cookieString A string representation of a cookie, if desired
     *
     * @throws Exception When could not use data OR make call to API OR cURL extension is not available
     *
     * @return string
     **/
    public function makeRequest($title, $cookieString = null);

    /**
     * Make an API call to MediaWiki.
     *
     * A MediaWikiApiResponseArray factory based on response body from self::makeRequest
     *
     * @param string $title        MediaWiki page title (e.g. /w/index.php?title=Main_Page)
     * @param string $cookieString A string representation of a cookie, if desired
     *
     * @throws Exception When could not make API request OR use received data from API
     *
     * @return MediaWikiApiResponseArray
     */
    public function retrieve($title, $cookieString = null);

    /**
     * What’s the endpoint URI to be queried?
     *
     * Could also be a representation to a stream handler, there should be no validation.
     *
     * If its a MediaWiki installation, you can leave last part of the string value ends
     * with &title= so we append an urlescape-d representation of the page title.
     *
     * @return string an URI (e.g. http://localhost:8080/w/index.php?format=json&title=)
     */
    public function getHelperEndpoint();
}
