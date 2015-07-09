<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

/**
 * Transformer Formatter Interface.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
interface TransformerFormatterInterface
{
  /**
   * Apply text rewrites
   *
   * @return string
   */
  public function apply(WikiPageRevisionInterface $input);
}
