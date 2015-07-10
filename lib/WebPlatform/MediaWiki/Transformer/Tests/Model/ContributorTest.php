<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Tests\Model;

use WebPlatform\MediaWiki\Transformer\Model\Contributor;
use \SimpleXMLElement;

/**
 * WikiPage test suite.
 *
 * @coversDefaultClass \WebPlatform\MediaWiki\Transformer\Model\Contributor
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class ContributorTest extends \PHPUnit_Framework_TestCase
{

    /** @var Contributor An instance of Contributor */
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
        $this->instance = new Contributor($this->cached_user_json);
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testInstantiateXmlException()
    {
        $xml = "
            <contributor>
                <username>Jdoe</username>
                <id>42</id>
            </contributor>";

        $newed = new Contributor(new SimpleXMLElement($xml));
    }

    public function testReturnTypes()
    {
        $this->assertSame($this->instance->getId(), 42, "Should return integer value");
        $this->assertSame($this->instance->isAuthenticated(), true, "Should return boolean value");
        $this->assertSame((string) $this->instance, "John Doe <jdoe@example.org>", "toString() should return both values as a string.");

    }
}
