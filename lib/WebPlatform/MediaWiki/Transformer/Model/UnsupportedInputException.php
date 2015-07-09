<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

use \Exception;

/**
 * Rule replacement has to be a string.
 */
class UnsupportedInputException extends \Exception
{
  protected $message = 'Rule replacement input MUST be a string';
}
