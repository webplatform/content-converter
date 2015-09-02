<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Model;

use JsonSerializable;
use UnexpectedValueException;
use RuntimeException;
use Exception;

/**
 * MediaWiki API Response Array Object.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiApiParseActionResponse implements JsonSerializable
{
    protected $data = [];

    /** @var boolean Toggle to true to tell if the data has been retrieved from cache or not */
    protected $fromCache = false;

    protected $cacheFile = '';

    /** @var boolean Toggle to true if MediaWiki Parse API returns a "missingtitle" error */
    protected $isDeleted = false;

    /** @var array List of broken links as per MediaWiki API Parse action */
    protected $brokenLinks = [];

    /** @var array List wiki categories as per MediaWiki API Parse action */
    protected $categories = [];

    /**
     * @throws UnexpectedValueException When we don’t receive a valid JSON string from MediaWiki
     * @throws RuntimeException         When we could not get at least parse[text] from the received JSON string
     *
     * @param String $recv What MediaWiki API returned
     */
    public function __construct($recv)
    {
        try {
            $this->data = json_decode($recv, true);
        } catch (Exception $e) {
            throw new UnexpectedValueException('We did not get a valid JSON response from MediaWiki API.', 0, $e);
        }

        /*
         * Sample Error Document we want to adress here.
         *
         * ```
         * {
         *   "error": {
         *     "code":"missingtitle",
         *     "info":"The page you specified doesn't exist",
         *     "*":"See http://docs.webplatformstaging.org/w/api.php for API usage"
         *   }
         * }
         * ```
         */
        if (isset($this->data['error']) && isset($this->data['error']['code']) && $this->data['error']['code'] === 'missingtitle') {
            $this->data['parse']['text']['*'] = null;
            $this->isDeleted = true;

            // Return right away, otherwise it
            // would throw an exception!
            return $this;
        }

        if (!isset($this->data['parse']) || !isset($this->data['parse']['text']) || !isset($this->data['parse']['text']['*'])) {
            throw new RuntimeException('We did not find parse[text] in API response body');
        }

        if (!isset($this->data['parse']['title'])) {
            throw new RuntimeException('We did not find parse[title] in API response body');
        }

        if (isset($this->data['parse']['links'])) {
            foreach ($this->data['parse']['links'] as $link) {
                if (!isset($link['exists'])) {
                    $this->brokenLinks[] = $link['*'];
                }
            }
            $this->data['broken_links'] = $this->brokenLinks;
            unset($this->data['parse']['links']);
        } elseif (isset($this->data['broken_links'])) {
            $this->brokenLinks = $this->data['broken_links'];
        }

        if (isset($this->data['parse']['categories'])) {
            /*                                     =^.^= <( meow )  ... "cat" */
            foreach ($this->data['parse']['categories'] as $meow) {
                $this->categories[] = $meow['*'];
            }
            unset($this->data['parse']['categories']);
            $this->data['categories'] = $this->categories;
        } elseif (isset($this->data['categories'])) {
            $this->categories = $this->data['categories'];
        }

        return $this;
    }

    public function setTitle($title)
    {
        if ($this->isDeleted === false) {
            $message = 'You should not set a title manually. This method is reserved only ';
            $message .= 'to documents declared with "missingtitle" error from MediaWiki API';
            throw new Exception($message);
        }

        $this->data['parse']['title'] = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->data['parse']['title'];
    }

    public function getBrokenLinks()
    {
        return $this->brokenLinks;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getHtml()
    {
        return $this->data['parse']['text']['*'];
    }

    public function isDeleted()
    {
        return $this->isDeleted;
    }

    public function jsonSerialize()
    {
        return $this->data;
    }

    public function toggleFromCache()
    {
        $this->fromCache = true;
    }

    public function isFromCache()
    {
        return $this->fromCache;
    }
}
