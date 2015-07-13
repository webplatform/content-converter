<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\ContentConverter\Tests\Entity;

use WebPlatform\ContentConverter\Entity\MediaWikiContributor;
use SimpleXMLElement;
use RuntimeException;

/**
 * WikiPage test suite.
 *
 * @coversDefaultClass \WebPlatform\ContentConverter\Entity\MediaWikiContributor
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiContributorTest extends \PHPUnit_Framework_TestCase
{
    /** @var MediaWikiContributor */
    protected $instance;

    protected $cached_user_json = '{
            "user_email": "jdoe@example.org"
            ,"user_id": "42"
            ,"user_name": "Jdoe"
            ,"user_real_name": "John Doe"
            ,"user_email_authenticated": true
        }';

    public function setUp()
    {
        $this->instance = new MediaWikiContributor($this->cached_user_json);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInstantiateXmlException()
    {
        $xml = '
            <contributor>
                <username>Jdoe</username>
                <id>42</id>
            </contributor>';

        $newed = new MediaWikiContributor(new SimpleXMLElement($xml));
    }

    public function testNameEmail()
    {
        $email = 'foo@bar.baz';
        $name  = 'Foo B. Bazz';

        $author = $this->instance->setRealName($name);
        $author->setEmail($email);

        $this->assertSame($email, $author->getEmail());
        $this->assertSame($name, $author->getRealName());
    }

    public function testReturnTypes()
    {
        $this->assertSame($this->instance->getId(), 42, 'Should return integer value');
        $this->assertSame($this->instance->isAuthenticated(), true, 'Should return boolean value');
        $this->assertSame((string) $this->instance, 'John Doe <jdoe@example.org>', 'toString() should return both values as a string.');
    }
}
