<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

/**
 * Replacement marker not found in Rule.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class ReplacementMarkerMissingException extends \Exception
{
    protected $message = 'Replacement marker not found. Rule class second argument MUST contain compatible with PHP preg_replace syntax string (i.e. contain at least ${1}).';
}
