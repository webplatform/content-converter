<?php

namespace WebPlatform\MediaWiki\Transformer\Model;

use \Exception;

class UnsupportedInputException extends \Exception {
	protected $message = 'Rule replacement input MUST be a string';
}