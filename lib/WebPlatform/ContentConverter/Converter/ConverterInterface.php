<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\ContentConverter\Converter;

use WebPlatform\ContentConverter\Entity\AbstractRevision;

/**
 * Transformer Formatter Interface.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
interface ConverterInterface
{
    /**
     * Apply text rewrites.
     *
     * @return AbstractRevision
     */
    public function apply(AbstractRevision $revision);
}
