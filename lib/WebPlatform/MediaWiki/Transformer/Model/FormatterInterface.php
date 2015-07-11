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
interface FormatterInterface
{
    /**
     * Apply text rewrites.
     *
     * @return TransformedDocument
     */
    public function apply(RevisionInterface $input);
}
