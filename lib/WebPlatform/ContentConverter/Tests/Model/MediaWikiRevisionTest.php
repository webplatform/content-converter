<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Tests\Model;

use WebPlatform\ContentConverter\Model\MediaWikiRevision;
use WebPlatform\ContentConverter\Model\MediaWikiContributor;
use SimpleXMLElement;

/**
 * MediaWikiRevision test suite.
 *
 * @coversDefaultClass \WebPlatform\ContentConverter\Model\MediaWikiRevision
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiRevisionTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

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

    protected $cached_user_json = '{
            "user_email": "jdoe@example.org"
            ,"user_id": "42"
            ,"user_name": "Jdoe"
            ,"user_real_name": "John Doe"
            ,"user_email_authenticated": true
        }';

    public function setUp()
    {
        $xmlRevisionElement = new SimpleXMLElement($this->revisionXml);
        $this->instance = new MediaWikiRevision($xmlRevisionElement);
    }

    public function testIsMediaWikiDumpRevisionNode()
    {
        $xmlRevisionElement = new SimpleXMLElement($this->revisionXml);
        $this->assertTrue(MediaWikiRevision::isMediaWikiDumpRevisionNode($xmlRevisionElement));

        // Lets remove data we know require, make sure the Revision class tests it too
        unset($xmlRevisionElement->timestamp, $xmlRevisionElement->contributor);
        $this->assertFalse(MediaWikiRevision::isMediaWikiDumpRevisionNode($xmlRevisionElement));
    }

    public function testRevisionContributorRelationship()
    {
        $xmlRevisionElement = new SimpleXMLElement($this->revisionXml);

        // Lets create two objects based on complemetary sample data
        // and bind them together. This should not throw any Exceptions.
        $revision = new MediaWikiRevision($xmlRevisionElement);
        $contributor = new MediaWikiContributor($this->cached_user_json);
        $revision->setContributor($contributor);

        // Through getAuthor 1..1 getter
        $this->assertSame('jdoe@example.org', $revision->getAuthor()->getEmail());
        $this->assertSame('Jdoe', $revision->getAuthor()->getName());
        $this->assertTrue($revision->getAuthor()->isAuthenticated());

        // Revision should have same same data about author too
        $this->assertSame('Jdoe', $revision->getContributorName());
        $this->assertSame('John Doe', $revision->getAuthor()->getRealName());
        $this->assertSame(42, $revision->getContributorId());
        $this->assertSame(42, $revision->getAuthor()->getId());

        $this->assertEquals(69319, $revision->getId());
    }

    public function testTimestampIdempotencyFormat()
    {
        $expected = '2014-09-08T19:05:23Z';
        $objTimestamp = $this->instance->getTimestamp()->format('Y-m-d\TH:i:sT');
        $this->assertSame($expected, $objTimestamp);

        $expectRfc2822Format = 'Mon, 08 Sep 2014 19:05:23 +0000';
        $this->assertSame($expectRfc2822Format, $this->instance->getTimestamp()->format(\DateTime::RFC2822));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testSetContributorExpectException()
    {
        $forged_user = '{
            "user_email": "mcfly@outatime.org"
            ,"user_name": "Mcfly"
            ,"user_id": "11"
            ,"user_real_name": "Marty McFly"
            ,"user_email_authenticated": true
        }';

        $this->instance->setContributor(new MediaWikiContributor($forged_user)/*, false <- to force NO validation. We want validation here. */);
    }

    public function testSetContributorEnforceNoValidation()
    {
        $forged_user = '{
            "user_email": "mcfly@outatime.org"
            ,"user_name": "Mcfly"
            ,"user_id": "11"
            ,"user_real_name": "Marty McFly"
            ,"user_email_authenticated": true
        }';

        $this->instance->setContributor(new MediaWikiContributor($forged_user), false /* Lets NOT validate if it matches*/);

        $this->assertInstanceOf('\WebPlatform\ContentConverter\Model\MediaWikiContributor', $this->instance->getContributor());

        // Ensure that getContributorName returns the same value as if we did $revision->getContributor()->getName()
        // ... because we asked to NOT validate
        $this->assertSame('Mcfly', $this->instance->getContributorName());
        $this->assertSame('Marty McFly', $this->instance->getAuthor()->getRealName());
        $this->assertSame(11, $this->instance->getContributorId()); // We want int!
        $this->assertSame(11, $this->instance->getAuthor()->getId()); // We want int!
        $this->assertSame(69319, $this->instance->getId(), 'We should get an integer number for the revision id.');
    }

    public function testRevisionContributorProperty()
    {
        // Let’s say we dont want to use cached version of users, but we still
        // want to import a wiki, will the behavior be consistent too?
        $this->assertSame(42, $this->instance->getContributorId()); // We want int!
        $this->assertSame('Jdoe', $this->instance->getContributorName());
    }

    public function testToString()
    {
        // In the test fixture, we said that "Foo" was the content of the
        // contribution, let’s test that. Also, we may change the way the
        // content is generated, see MarkdownRevision for instance.
        $this->assertEquals('Foo', (string) $this->instance);
    }

    public function testCommentRemovesNewlines()
    {
        // We added a \n char in the middle of this string (author don’t know what that says, BTW)
        // Making sure behavior is the same.
        $revision = $this->instance;
        $this->assertEquals(69319, $revision->getId(), 'We should get an integer number for the revision id.');
        $this->assertEquals('Revision 69319: そ れぞれの値には、配列内で付与されたインデックス値である、', $revision->getComment(), 'We should get same comment with "Revision $revNumber: " prepended.');
    }

    public function testSetComment()
    {
        $revision = $this->instance;
        $someComment = "Roads? Where we're going we don't need... roads!";
        $revision->setComment($someComment);
        $this->assertEquals('Revision 69319: '.$someComment, $revision->getComment(), 'We should be able to override comment and keep revision id');
        $this->assertEquals(69319, $revision->getId(), 'We should get an integer number for the revision id.');
    }

    public function testGetFormat()
    {
        $this->assertSame('text/x-wiki', $this->instance->getFormat());
    }

    public function testGetModel()
    {
        $this->assertSame('wikitext', $this->instance->getModel());
    }

    public function testIncompleteUserData()
    {
        $bogusUserJson = '[{
            "user_email": ""
            ,"user_id": "1"
            ,"user_name": "Jdoe"
            ,"user_real_name": "John Doe with Missing Email"
            ,"user_email_authenticated": true
        },{
            "user_email": "foo@bar.org"
            ,"user_id": "2"
            ,"user_name": "BarMissingRealName"
            ,"user_real_name": ""
            ,"user_email_authenticated": false
        },{
            "user_email": ""
            ,"user_id": "0"
            ,"user_name": ""
            ,"user_real_name": ""
            ,"user_email_authenticated": false
        }]';

        $bogusUsers = json_decode($bogusUserJson, 1);

        $this->instance->setContributor(new MediaWikiContributor($bogusUsers[0]), false);
        $this->assertEquals('John Doe with Missing Email', $this->instance->getAuthor()->getRealName());
        $this->assertEquals('Jdoe', $this->instance->getAuthor()->getName());
        $this->assertEquals('Jdoe', $this->instance->getContributorName());
        $this->assertEquals('public-webplatform@w3.org', $this->instance->getAuthor()->getEmail());

        $this->instance->setContributor(new MediaWikiContributor($bogusUsers[1]), false);
        $this->assertEquals('Anonymous Author', $this->instance->getAuthor()->getRealName());
        $this->assertEquals('BarMissingRealName', $this->instance->getAuthor()->getName());
        $this->assertEquals('BarMissingRealName', $this->instance->getContributorName());
        $this->assertEquals('foo@bar.org', $this->instance->getAuthor()->getEmail());

        $this->instance->setContributor(new MediaWikiContributor($bogusUsers[2]), false);
        $this->assertEquals('Anonymous Author', $this->instance->getAuthor()->getRealName());
        $this->assertEquals('Anonymous', $this->instance->getAuthor()->getName());
        $this->assertEquals('Anonymous', $this->instance->getContributorName());
        $this->assertEquals('public-webplatform@w3.org', $this->instance->getAuthor()->getEmail());
    }
}
