<?php

namespace WebPlatform\MediaWiki\Transformer\Model;

/**
 * Wikitext Data Transformer Descriptor
 *
 * Describe the rules of the transformation
 */
interface TransformerDescriptorInterface {

	/**
	 * List all applicable transformation rules
	 *
	 * @return array of Rule objects
	 */
	public function getRules();

}