<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Converter;

use WebPlatform\ContentConverter\Entity\AbstractRevision;

/**
 * Converter Interface.
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
