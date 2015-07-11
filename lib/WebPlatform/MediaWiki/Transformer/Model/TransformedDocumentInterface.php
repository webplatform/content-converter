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
interface TransformedDocumentInterface
{

    public function getContents();

    public function getHeaders();

}
