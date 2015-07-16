<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Tests\Model;

use WebPlatform\ContentConverter\Model\MediaWikiDocument;
use WebPlatform\ContentConverter\Tests\PagesFixture;

/**
 * MediaWikiDocument test suite.
 *
 * @coversDefaultClass \WebPlatform\ContentConverter\Model\MediaWikiDocument
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiDocumentTest extends \PHPUnit_Framework_TestCase
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
        $obj = new MediaWikiDocument($pageNode);
        $this->assertSame($title, $obj->getTitle());
    }

    /**
     * @covers ::revisions
     */
    public function testRevisions()
    {
        $pageNode = $this->dumpBackupXml->page[0];
        $count = count($pageNode->revision);
        $obj = new MediaWikiDocument($pageNode);
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
        $obj = new MediaWikiDocument($this->dumpBackupXml->page[0]);
        $objTimestamp = $obj->getLatest()->getTimestamp()->format('Y-m-d\TH:i:sT');
        $this->assertSame($latestTimestamp, $objTimestamp);
    }

    public function testIsTranslation()
    {
        //       expected, location
        $res[] =[true, 'Beginners/ja'];
        $res[] =[false, 'html/attributes/is'];
        $res[] =[true, 'html/elements/th'];
    }

    /**
     * @covers ::latest
     */
    public function testLatestRevision()
    {
        $obj = new MediaWikiDocument($this->dumpBackupXml->page[0]);
        $this->assertInstanceOf('\WebPlatform\ContentConverter\Entity\MediaWikiRevision', $obj->getLatest());
    }

    /**
     * @covers ::latest
     */
    public function testLatestRevisionDateTime()
    {
        $obj = new MediaWikiDocument($this->dumpBackupXml->page[0]);
        $this->assertInstanceOf('\DateTime', $obj->getLatest()->getTimestamp());
    }

    /**
     * @covers ::latest
     */
    public function testLatestRevisionRevisionsType()
    {
        $obj = new MediaWikiDocument($this->dumpBackupXml->page[0]);
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
        $obj = new MediaWikiDocument($this->dumpBackupXml->page[0]);
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
        $no_redirect = new MediaWikiDocument($pageNode[0]);
        $has_redirect = new MediaWikiDocument($pageNode[1]);

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
        $redirected = new MediaWikiDocument($this->dumpBackupXml->page[5]);

        $this->assertSame($redirected->getRedirect(), 'WPD:Content/Topic Pages');
    }

    /**
     * @covers ::testToFileName
     */
    public function testToFileName()
    {
        // Desired
        $assertions[0][0] = 'WPD/Infrastructure/proposals/Site_Map';
        // What the page URL
        $assertions[0][1] = 'WPD:Infrastructure/proposals/Site Map';

        $assertions[1][0] = 'WPD/Doc_Sprints';
        $assertions[1][1] = 'WPD:Doc  Sprints';

        $assertions[2][0] = 'tutorials/What_is_CSS';
        $assertions[2][1] = 'tutorials/What is CSS?';

        $assertions[3][0] = 'Tutorials/HTML_forms_-_the_basics';
        $assertions[3][1] = 'Tutorials/HTML forms - the basics';

        $assertions[4][0] = 'ja/concepts/programming/programming_basics';
        $assertions[4][1] = 'ja/concepts/programming/programming basics';

        $assertions[5][0] = 'concepts/Internet_and_Web/the_history_of_the_web/tr';
        $assertions[5][1] = 'concepts/Internet and Web/the history of the web/tr';

        $assertions[6][0] = 'tutorials/Raw_WebGL_101_-_Part_4_Textures';
        $assertions[6][1] = 'tutorials/Raw WebGL 101 - Part 4: Textures';

        $assertions[7][0] = 'css/selectors/pseudo-classes/optional';
        $assertions[7][1] = 'css/selectors/pseudo-classes/:optional';

        $assertions[8][0] = 'css/selectors/pseudo-classes/nth-of-type';
        $assertions[8][1] = 'css/selectors/pseudo-classes/:nth-of-type(n)';

        $assertions[9][0] = 'css/selectors/pseudo-classes/lang';
        $assertions[9][1] = 'css/selectors/pseudo-classes/:lang(c)';

        foreach ($assertions as $assertion) {
            $this->assertSame($assertion[0], MediaWikiDocument::toFileName($assertion[1]));
        }
    }
}
