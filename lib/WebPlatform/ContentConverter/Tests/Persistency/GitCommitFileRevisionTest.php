<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Tests\Model;

use WebPlatform\ContentConverter\Persistency\GitCommitFileRevision;
use WebPlatform\ContentConverter\Model\MediaWikiDocument;
use WebPlatform\ContentConverter\Model\MediaWikiContributor;
use SimpleXMLElement;

/**
 * WikiPage test suite.
 *
 * @coversDefaultClass \WebPlatform\ContentConverter\Model\GitCommitFileRevision
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class GitCommitFileRevisionTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

    /** @var string An hardcoded document with multiple revisions XML. Notice the revision ordering (and its date) matter */
    protected $documentManyRevisionsXml = "
        <page>
            <title>tutorials/Web Education Intro</title>
            <ns>0</ns>
            <id>1</id>
            <revision>
                <id>1</id>
                <timestamp>2012-05-21T11:31:31Z</timestamp>
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
                <timestamp>2012-08-22T12:52:42Z</timestamp>
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
                <timestamp>2012-09-23T13:53:43Z</timestamp>
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

    protected $documentManyRevisionsUserJson = '{
            "user_email": "jdoe@example.org"
            ,"user_id": "42"
            ,"user_name": "Jdoe"
            ,"user_real_name": "John Doe"
            ,"user_email_authenticated": true
        }';

    public function setUp()
    {
        $document = new MediaWikiDocument(new SimpleXMLElement($this->documentManyRevisionsXml));
        $contributor = new MediaWikiContributor(json_decode($this->documentManyRevisionsUserJson, true));
        $this->instance = new GitCommitFileRevision($document);

        $revisionsList = $document->getRevisions();
        for ($revisionsList->rewind(); $revisionsList->valid(); $revisionsList->next()) {
            $rev = $revisionsList->current();
            $rev->setContributor($contributor, false);
        }
        $this->instance->setRevision($document->getLatest());

    }

    public function testTypesOnGetters()
    {
        $revision = $this->instance->getRevision();
        $this->assertInstanceOf('WebPlatform\ContentConverter\Model\AbstractRevision', $revision);
        $this->assertInstanceOf('WebPlatform\ContentConverter\Persistency\AbstractPersister', $this->instance);
        $this->assertInstanceOf('WebPlatform\ContentConverter\Model\Author', $revision->getAuthor());
        $this->assertInstanceOf('DateTime', $revision->getTimestamp());

        $this->assertSame('2012-09-23T13:53:43Z', $revision->getTimestamp()->format('Y-m-d\TH:i:sT'));
        $this->assertSame('John Doe', $revision->getAuthor()->getRealName());
        $this->assertSame('jdoe@example.org', $revision->getAuthor()->getEmail());
        $this->assertSame('tutorials/Web_Education_Intro', $this->instance->getName());
        $this->assertSame((string) $revision->getAuthor(), "John Doe <jdoe@example.org>");
    }
}
