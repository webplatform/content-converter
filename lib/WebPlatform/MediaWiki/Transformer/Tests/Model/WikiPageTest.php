<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Tests\Model;

use WebPlatform\MediaWiki\Transformer\Model\WikiPage;
use WebPlatform\MediaWiki\Transformer\Model\Revision;
use WebPlatform\MediaWiki\Transformer\Tests\PagesFixture;

/**
 * WikiPage test suite.
 *
 * @coversDefaultClass \WebPlatform\MediaWiki\Transformer\Model\WikiPage
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class WikiPageTest extends \PHPUnit_Framework_TestCase
{
    /** @var SimpleXML Object representation of a typical MediaWiki dumpBackup XML file */
    protected $dumpBackupXml;

    public function setUp()
    {
        $xml = new PagesFixture();
        $this->dumpBackupXml = $xml->getXml();
    }

    protected function stdout($text)
    {
        fwrite(STDOUT, $text."\n");
    }

    /**
     * @covers ::getTitle
     */
    public function testTitle()
    {
        $pageNode = $this->dumpBackupXml->page[0];
        $title = (string) $pageNode->title;
        $obj = new WikiPage($pageNode);
        $this->assertSame($title, $obj->getTitle());
    }

    /**
     * @covers ::revisions
     */
    public function testRevisions()
    {
        $pageNode = $this->dumpBackupXml->page[0];
        $count = count($pageNode->revision);
        $obj = new WikiPage($pageNode);
        $this->assertSame($count, $obj->getRevisions()->count());
    }

    /**
     * @covers ::latest
     */
    public function testLatestTimestampFormat()
    {
        // Made sure we have at least 2 revisions in SAMPLE
        // dumpBackupXml, and that the timestamp of the first item
        // is the following.
        $latestTimestamp = '2014-09-08T19:05:22Z';
        $obj = new WikiPage($this->dumpBackupXml->page[0]);
        $objTimestamp = $obj->getLatest()->getTimestamp()->format('Y-m-d\TH:i:sT');
        $this->assertSame($latestTimestamp, $objTimestamp);
    }

    /**
     * @covers ::latest
     */
    public function testLatestRevision()
    {
        $obj = new WikiPage($this->dumpBackupXml->page[0]);
        $this->assertInstanceOf('\WebPlatform\MediaWiki\Transformer\Model\WikiRevision', $obj->getLatest());
    }

    /**
     * @covers ::latest
     */
    public function testLatestRevisionDateTime()
    {
        $obj = new WikiPage($this->dumpBackupXml->page[0]);
        $this->assertInstanceOf('\DateTime', $obj->getLatest()->getTimestamp());
    }

    /**
     * @covers ::latest
     */
    public function testLatestRevisionRevisionsType()
    {
        $obj = new WikiPage($this->dumpBackupXml->page[0]);
        $this->assertInstanceOf('\SplDoublyLinkedList', $obj->getRevisions());
    }

    /**
     * @covers ::latest
     */
    public function testRevisionOrderingListContributors()
    {
        // Made sure we have at least 2 revisions in SAMPLE
        // dumpBackupXml, and that the the contributors usernames
        // are in order.
        $hardcodedContributors = 'Dgash,Shepazu';
        $obj = new WikiPage($this->dumpBackupXml->page[0]);
        $stack = $obj->getRevisions();
        $stack->rewind();
        $contributors = array();
        while ($stack->valid()) {
            $contributors[] = $stack->current()->getContributorName();
            $stack->next();
        }
        $this->assertSame(implode($contributors, ','), $hardcodedContributors);
    }

    /**
     * @covers ::hasRedirect
     */
    public function testHasRedirect()
    {
        $pageNode = $this->dumpBackupXml->page;

        // We know that only the page[1] has a redirect
        $no_redirect = new WikiPage($pageNode[0]);
        $has_redirect = new WikiPage($pageNode[1]);

        $this->assertFalse($no_redirect->hasRedirect());
        $this->assertTrue($has_redirect->hasRedirect());
    }

    /**
     * @covers ::getRedirect
     *
     * We want to get the potential name of the redirect
     * so we know which file to refer to.
     */
    public function testGetRedirect()
    {
        // pageNode[5] has <redirect title="WPD:Example Pages/CSS" />
        // lets expect we get a string similar to "WPD:Example Pages/CSS"
        $redirected = new WikiPage($this->dumpBackupXml->page[5]);

        $this->assertSame($redirected->getRedirect(), 'WPD:Content/Topic Pages');
    }
}
