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
class MediaWikiApiResponseArray implements JsonSerializable
{
    private $dto;

    /**
     * @throws UnexpectedValueException When we don’t receive a valid JSON string from MediaWiki
     * @throws RuntimeException         When we could not get at least parse[text] from the received JSON string
     *
     * @param String $recievedString What MediaWiki API returned
     */
    public function __construct($recievedString)
    {
        try {
            $dto = json_decode($recievedString, true);
        } catch (Exception $e) {
            throw new UnexpectedValueException('We did not get a valid JSON response from MediaWiki API.', 0, $e);
        }

        if (!isset($dto['parse']) || !isset($dto['parse']['text']) || !isset($dto['parse']['text']['*'])) {
            throw new RuntimeException('We did not find parse[text] in API response body');
        }

        if (!isset($dto['parse']['title'])) {
            throw new RuntimeException('We did not find parse[title] in API response body');
        }

        $this->dto = $dto;

        return $this;
    }

    public function getHtmlString()
    {
        return $this->dto['parse']['text']['*'];
    }

    public function getTitle()
    {
        return $this->dto['parse']['title'];
    }

    public function jsonSerialize()
    {
        return $this->dto;
    }

    public function unpack()
    {
        return $this->dto;
    }
}
