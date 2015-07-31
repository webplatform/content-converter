<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Tests\Model;

use WebPlatform\ContentConverter\Model\MediaWikiDocument;
use WebPlatform\ContentConverter\Persistency\GitCommitFileRevision;
use WebPlatform\ContentConverter\Tests\PagesFixture;
use SimpleXMLElement;

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

    /** @var string An hardcoded document with multiple revisions XML. Notice the revision ordering (and its date) matter */
    protected $documentManyRevisionsXml = "
        <page>
            <title>tutorials/Web Education Intro</title>
            <ns>0</ns>
            <id>1</id>
            <revision>
                <id>31356</id>
                <timestamp>2012-05-29T17:37:32Z</timestamp>
                <contributor>
                    <username>MediaWiki default</username>
                    <id>0</id>
                </contributor>
                <model>wikitext</model>
                <format>text/x-wiki</format>
                <text xml:space=\"preserve\" bytes=\"2\">First</text>
                <sha1>lg8kc9k8uzncpgh3k3vri78imvoxc6m</sha1>
            </revision>
            <revision>
                <id>1059</id>
                <parentid>1</parentid>
                <timestamp>2012-08-22T15:56:45Z</timestamp>
                <contributor>
                    <username>Jdoe</username>
                    <id>42</id>
                </contributor>
                <model>wikitext</model>
                <format>text/x-wiki</format>
                <text xml:space=\"preserve\" bytes=\"2\">Second</text>
                <sha1>m6fu7ofvhqc13gxttigldmqrx1xgxtd</sha1>
            </revision>
            <revision>
                <id>3115</id>
                <parentid>1314</parentid>
                <timestamp>2011-08-22T13:23:43Z</timestamp>
                <contributor>
                    <username>Jdoe</username>
                    <id>42</id>
                </contributor>
                <comment><![CDATA[
                  Adjusted content with \"This
                  page houses a record of all activities being undertaken in past, present or future by
                  the Web Education Community Group, split into
                  <strong>sub groups</strong><!-- notice the HTML in the comment, the new line,\n
                  the quotes, and the three dots as one UTF-8 character entity --> …\"
                ]]></comment>
                <model>wikitext</model>
                <format>text/x-wiki</format>
                <text xml:space=\"preserve\" bytes=\"2\">=Web Education=\nThird and '''current version'''</text>
                <sha1>9qgmpepx42kms1luo6rke03ip7eusd7</sha1>
            </revision>
        </page>";

    /** @var string An hardcoded document with multiple revisions XML AND a redirect, to see if we effectively set for deletion at last revision */
    protected $documentWithRedirectXml = '
            <mediawiki>
                <page>
                    <ns>0</ns>
                    <id>44</id>
                    <title>html/elements/tr</title>
                    <revision>
                        <id>54</id>
                        <timestamp>2015-08-24T14:44:44Z</timestamp>
                        <contributor>
                            <username>Jdoe</username>
                            <id>42</id>
                        </contributor>
                        <text xml:space="preserve" bytes="12">HTML &lt;tr&gt; element page.</text>
                    </revision>
                </page>
                <page>
                    <title>html/tr</title>
                    <redirect title="html/elements/tr" />
                    <revision>
                        <id>54</id>
                        <timestamp>2015-08-24T14:44:44Z</timestamp>
                        <contributor>
                            <username>Jdoe</username>
                            <id>42</id>
                        </contributor>
                        <text xml:space="preserve" bytes="12">Some initial content</text>
                    </revision>
                    <revision>
                        <id>55</id>
                        <timestamp>2015-09-24T14:44:44Z</timestamp>
                        <contributor>
                            <username>Jdoe</username>
                            <id>42</id>
                        </contributor>
                        <text xml:space="preserve" bytes="12">#REDIRECT [[html/elements/tr]]</text>
                    </revision>
                </page>
            </mediawiki>';

    protected $documentManyRevisionsUserJson = '{
            "user_email": "jdoe@example.org"
            ,"user_id": "42"
            ,"user_name": "Jdoe"
            ,"user_real_name": "John Doe"
            ,"user_email_authenticated": true
        }';

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
     * @covers ::getRevisions
     */
    public function testRevisions()
    {
        $pageNode = $this->dumpBackupXml->page[0];
        $count = count($pageNode->revision);
        $obj = new MediaWikiDocument($pageNode);
        $this->assertSame($count, $obj->getRevisions()->count());
    }

    /*
     * @covers ::getLatest
     */
    public function testLatestTimestampFormat()
    {
        $latestTimestamp = '2011-08-22T13:23:43Z';
        $obj = new MediaWikiDocument(new SimpleXMLElement($this->documentManyRevisionsXml));
        $objTimestamp = $obj->getLatest()->getTimestamp()->format('Y-m-d\TH:i:sT');

        // Latest should be the last revision node in the list.
        // We are testing both the date format AND if its actually
        // the date of the last revision in the list are going through.
        $this->assertSame($latestTimestamp, $objTimestamp, 'In the list of revision, latest date should match this test’s hardcoded date.');
    }

    public function testIsTranslation()
    {
        $pageListWithTranslation = "
            <mediawiki>
                <page>
                    <title>guides/html5 form features/ja</title>
                    <revision>
                        <id>39</id>
                        <timestamp>2011-08-21T13:21:41Z</timestamp>
                        <contributor>
                            <username>Jdoe</username>
                            <id>42</id>
                        </contributor>
                        <text xml:space=\"preserve\" bytes=\"20\">値は次のように移 (The test author has NO idea what this Japanse snip means)</text>
                    </revision>
                </page>
                <page>
                    <title>html/elements/tr</title>
                    <revision>
                        <id>40</id>
                        <timestamp>2011-08-22T12:22:42Z</timestamp>
                        <contributor>
                            <username>Jdoe</username>
                            <id>42</id>
                        </contributor>
                        <text xml:space=\"preserve\" bytes=\"2\">False positive. The page content is about the ''tr'' HTML tag. Not the Turkish translation of ''elements'' page.</text>
                    </revision>
                </page>
                <page>
                    <title>html/elements/th/tr</title>
                    <revision>
                        <id>44</id>
                        <timestamp>2011-08-23T13:23:43Z</timestamp>
                        <contributor>
                            <username>Jdoe</username>
                            <id>42</id>
                        </contributor>
                        <text xml:space=\"preserve\" bytes=\"2\">Positive positive. This page is about the th element, translated in Turkish.</text>
                    </revision>
                </page>
            </mediawiki>";

        $xml = new SimpleXMLElement($pageListWithTranslation);

        //              expected, language code, (see below), AbstractDocument instance
        $assertions[] = [true,     'ja',          false,       new MediaWikiDocument($xml->page[0])];
        $assertions[] = [false,    'en',          true,        new MediaWikiDocument($xml->page[1])];
        $assertions[] = [true,     'tr',          false,       new MediaWikiDocument($xml->page[2])];

        foreach ($assertions as $assertion) {
            $testDescription = 'Should detect whether or not its a translation';
            $this->assertSame($assertion[0], $assertion[3]->isTranslation(), $testDescription);

            $testDescription = 'Should give language code, or "en" for English (the default language we used)';
            $this->assertSame($assertion[1], $assertion[3]->getLanguageCode(), $testDescription);

            $testDescription = 'Test whether or not the part just before last in URL **IS** a known page listing';
            $this->assertSame($assertion[2], $assertion[3]->isChildOfKnownPageListing(), $testDescription);
        }
    }

    /**
     * @covers ::getLatest
     */
    public function testLatestRevision()
    {
        $obj = new MediaWikiDocument($this->dumpBackupXml->page[0]);
        $this->assertInstanceOf('\WebPlatform\ContentConverter\Model\MediaWikiRevision', $obj->getLatest());
    }

    /**
     * @covers ::getLatest
     */
    public function testLatestRevisionDateTime()
    {
        $obj = new MediaWikiDocument($this->dumpBackupXml->page[0]);
        $this->assertInstanceOf('\DateTime', $obj->getLatest()->getTimestamp());
    }

    /**
     * @covers ::getLatest
     */
    public function testLatestRevisionRevisionsType()
    {
        $obj = new MediaWikiDocument($this->dumpBackupXml->page[0]);
        $this->assertInstanceOf('\SplDoublyLinkedList', $obj->getRevisions());
    }

    /**
     * @covers ::getLatest
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

        $this->assertSame($redirected->getRedirect(), 'WPD/Content/Topic_Pages');
    }

    /**
     * @covers ::normalize
     */
    public function testNormalize()
    {
        // What the page URL
        $assertions[0][0] = 'WPD:Infrastructure/proposals/Site Map';
        // Desired sanitized URL
        $assertions[0][1] = 'WPD/Infrastructure/proposals/Site_Map';
        // What would be the file name to read/write from
        $assertions[0][2] = 'out/foo/bar/WPD/Infrastructure/proposals/Site_Map/index.bazz';

        $assertions[1][0] = 'WPD:Doc Sprints';
        $assertions[1][1] = 'WPD/Doc_Sprints';
        $assertions[1][2] = 'out/foo/bar/WPD/Doc_Sprints/index.bazz';

        $assertions[2][0] = 'tutorials/What is CSS?';
        $assertions[2][1] = 'tutorials/What_is_CSS';
        $assertions[2][2] = 'out/foo/bar/tutorials/What_is_CSS/index.bazz';

        $assertions[3][0] = 'Tutorials/HTML forms - the basics';
        $assertions[3][1] = 'Tutorials/HTML_forms_-_the_basics';
        $assertions[3][2] = 'out/foo/bar/Tutorials/HTML_forms_-_the_basics/index.bazz';

        $assertions[4][0] = 'ja/concepts/programming/programming basics';
        $assertions[4][1] = 'ja/concepts/programming/programming_basics';
        $assertions[4][2] = 'out/foo/bar/ja/concepts/programming/programming_basics/index.bazz';

        $assertions[5][0] = 'concepts/Internet and Web/the history of the web/tr';
        $assertions[5][1] = 'concepts/Internet_and_Web/the_history_of_the_web/tr';
        $assertions[5][2] = 'out/foo/bar/concepts/Internet_and_Web/the_history_of_the_web/tr.bazz';

        $assertions[6][0] = 'tutorials/Raw WebGL 101 - Part 4: Textures';
        $assertions[6][1] = 'tutorials/Raw_WebGL_101_-_Part_4_Textures';
        $assertions[6][2] = 'out/foo/bar/tutorials/Raw_WebGL_101_-_Part_4_Textures/index.bazz';

        $assertions[7][0] = 'css/selectors/pseudo-classes/:optional';
        $assertions[7][1] = 'css/selectors/pseudo-classes/optional';
        $assertions[7][2] = 'out/foo/bar/css/selectors/pseudo-classes/optional/index.bazz';

        $assertions[8][0] = 'css/selectors/pseudo-classes/:nth-of-type(n)';
        $assertions[8][1] = 'css/selectors/pseudo-classes/nth-of-type';
        $assertions[8][2] = 'out/foo/bar/css/selectors/pseudo-classes/nth-of-type/index.bazz';

        $assertions[9][0] = 'css/selectors/pseudo-classes/:lang(c)';
        $assertions[9][1] = 'css/selectors/pseudo-classes/lang';
        $assertions[9][2] = 'out/foo/bar/css/selectors/pseudo-classes/lang/index.bazz';

        // False positive translated (tr HTML element that happens to conflate with the Turkish language code)
        $assertions[10][0] = 'html/elements/tr';
        $assertions[10][1] = 'html/elements/tr';
        $assertions[10][2] = 'out/foo/bar/html/elements/tr/index.bazz';

        // True positive translated document (Turkish version of the tr HTML element)
        $assertions[11][0] = 'html/elements/tr/tr';
        $assertions[11][1] = 'html/elements/tr/tr';
        $assertions[11][2] = 'out/foo/bar/html/elements/tr/tr.bazz';

        // Please, lets fix those too!!
        $assertions[12][0] = 'html/attributes/align (Table, iframe elements)';
        $assertions[12][1] = 'html/attributes/align_Table_iframe_elements';
        $assertions[12][2] = 'out/foo/bar/html/attributes/align_Table_iframe_elements/index.bazz';

        $mockDocument =
                '<page>
                    <title>overload me</title>
                    <revision>
                        <id>44</id>
                        <timestamp>2011-08-21T13:21:41Z</timestamp>
                        <contributor>
                            <username>Jdoe</username>
                            <id>42</id>
                        </contributor>
                        <text xml:space="preserve" bytes="20">Use me to overload title element!</text>
                    </revision>
                </page>';

        foreach ($assertions as $assertion) {
            $mock = new SimpleXMLElement($mockDocument);
            $mock->title = $assertion[0]; // Let’s overload the title for what we want
            $document = new MediaWikiDocument($mock);
            $this->assertSame($assertion[0], $document->getTitle());
            $this->assertSame($assertion[1], $document->getName());
            $file = new GitCommitFileRevision($document, 'out/foo/bar/', '.bazz');
            $this->assertSame($assertion[2], $file->getName());
        }
    }

    public function testApplyRevisionsThenDeleteAtRedirect()
    {
        $multipleDocuments = new SimpleXMLElement($this->documentWithRedirectXml);

        //              AbstractDocument instance,                          has redirect?, redirect_to,        nbr revisions
        $documents[] = [new MediaWikiDocument($multipleDocuments->page[0]), false,         false,              1];
        $documents[] = [new MediaWikiDocument($multipleDocuments->page[1]), true,          'html/elements/tr', 2];

        foreach ($documents as $wikiDocument) {
            $revs = $wikiDocument[0]->getRevisions()->count();
            $has_redirect = $wikiDocument[0]->hasRedirect();
            $redirect = $wikiDocument[0]->getRedirect();

            $this->assertEquals($wikiDocument[1], $has_redirect, sprintf('Has redirect value should match %s', print_r($has_redirect, 1)));
            $this->assertEquals($wikiDocument[2], $redirect, sprintf('Redirect value shoule either be false, or string. Got %s', print_r($redirect, 1)));
            $this->assertEquals($wikiDocument[3], $revs, 'Hardcoded number of revisions should match %d', $revs);
        }
    }
}
