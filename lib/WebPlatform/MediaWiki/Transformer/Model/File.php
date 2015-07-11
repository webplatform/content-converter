<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

use WebPlatform\MediaWiki\Transformer\Tests\PagesFixture;

/**
 * Prepare WikiPage to create a static file.
 *
 * Represent a file on the filesystem
 *
 * Responsibilities:
 *
 *  * Made to handle the contents and headers of a file
 *  * Should know where the file should be stored
 *  * A file can have multiple Revisions, not the other way around.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class File
{
    public static function formatPath($title)
    {
        // Replace spaces underscore; Like MediaWiki does
    $title = preg_replace('~[\s]+~u', '_', $title);

    // Lets use this list to make sure our test pass, we’ll have to
    // encapsulate this later #TODO
    $namespaces = PagesFixture::$NAMESPACE_PREFIXES;

    //
    // In order to store files in a filesystem, we gotta make sure the file name can has a valid path and
    // filename.
    //
    // Since we do use pages with namespaces and want to emulate the name, we have to make a conversion.
    //
    // Pages with names such as Templates:TemplateName could be stored in Templates/TemplateName.txt. If you run
    // the script in Windows you’d want it to be Templates\TemplateName.txt (that’s why DIRECTORY_SEPARATOR constant).
    //
    // Note that this wasn’t tested on Microsoft Windows, but we have the constant, lets use it.
    //
    foreach ($namespaces as $nsname) {
        if (strpos($title, $nsname) === 0) {
            $title = str_replace($nsname, str_replace(':', DIRECTORY_SEPARATOR, $nsname), $title);
            break;
        }
    }

    // Remove punctuation
    $title = preg_replace('~[\?]+~u', '', $title);

    // transliterate
    $title = iconv('utf-8', 'us-ascii//TRANSLIT', $title);

        return $title;
    }
}
