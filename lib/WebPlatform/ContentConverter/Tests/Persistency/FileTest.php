<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\ContentConverter\Tests\Persistency;

use WebPlatform\ContentConverter\Persistency\File;
use WebPlatform\ContentConverter\Entity\MediaWikiRevision;
use SimpleXMLElement;

/**
 * File test suite.
 *
 * @coversDefaultClass \WebPlatform\ContentConverter\Persistency\File
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    protected $revision;

    /** @var string An hardcoded revision XML */
    protected $revisionXml = "
        <revision>
            <id>69319</id>
            <parentid>69053</parentid>
            <timestamp>2014-09-08T19:05:23Z</timestamp>
            <contributor>
                <username>Jdoe</username>
                <id>42</id>
            </contributor>
            <comment>そ\nれぞれの値には、配列内で付与されたインデックス値である、</comment>
            <model>wikitext</model>
            <format>text/x-wiki</format>
            <text xml:space=\"preserve\" bytes=\"2\">Foo</text>
        </revision>";

    public function setUp()
    {
        $this->revision = new MediaWikiRevision(new SimpleXMLElement($this->revisionXml), 1);
    }

    public function testSetFileName()
    {
        $fileName = 'fooBar';
        $file = new File($this->revision);
        $file->setFilename($fileName);
        $this->assertEquals($fileName, $file->getFileName());
    }

}
