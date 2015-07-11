<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

/**
 * Replacement string MUST be compatible with PHP preg_replace.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class UnsupportedReplacementException extends \Exception
{
    protected $message = 'Replacement string MUST be compatible with PHP preg_replace syntax (i.e. contain at least ${1}).';
}
