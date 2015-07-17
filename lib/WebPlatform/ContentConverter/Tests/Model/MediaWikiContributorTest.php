<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Tests\Model;

use WebPlatform\ContentConverter\Model\MediaWikiContributor;
use SimpleXMLElement;

/**
 * WikiPage test suite.
 *
 * @coversDefaultClass \WebPlatform\ContentConverter\Model\MediaWikiContributor
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiContributorTest extends \PHPUnit_Framework_TestCase
{
    /** @var MediaWikiContributor */
    protected $instance;

    protected $user_json_string = '{
            "user_email": "jdoe@example.org"
            ,"user_id": "42"
            ,"user_name": "Jdoe"
            ,"user_real_name": "John Doe"
            ,"user_email_authenticated": true
        }';

    public function setUp()
    {
        $this->instance = new MediaWikiContributor($this->user_json_string);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidImportDataObjectExceptionXml()
    {
        $xml = '
            <contributor>
                <username>Jdoe</username>
                <id>42</id>
            </contributor>';

        $newed = new MediaWikiContributor(new SimpleXMLElement($xml));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidImportDataObjectExceptionInvalidJson()
    {
        $newed = MediaWikiContributor::isValidDataObject('{true:"bar","bazz":"3"}');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidImportDataObjectExceptionWrongType()
    {
        $newed = MediaWikiContributor::isValidDataObject(true);
    }

    public function testNameEmail()
    {
        $email = 'foo@bar.baz';
        $name = 'Foo B. Bazz';

        $author = $this->instance->setRealName($name);
        $author->setEmail($email);

        $this->assertSame($email, $author->getEmail());
        $this->assertSame($name, $author->getRealName());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testConstructorException()
    {
        $obviouslyIncompleteArray = array("user_id"=>31337);
        $newed = new MediaWikiContributor($obviouslyIncompleteArray);
    }

    public function testReturnTypes()
    {
        $this->assertSame($this->instance->getId(), 42, "Should return integer value");
        $this->assertSame($this->instance->isAuthenticated(), true, "Should return boolean value");
        $this->assertSame($this->instance->getEmail(), "jdoe@example.org");
        $this->assertSame($this->instance->getRealName(), "John Doe");
        $this->assertSame((string) $this->instance, "John Doe <jdoe@example.org>", "toString() should return both values as a string.");
    }

    public function testIsValidDataObject()
    {
        $test1 = MediaWikiContributor::isValidDataObject($this->user_json_string);
        $test2 = MediaWikiContributor::isValidDataObject('{"foo":"bar","bazz":"3"}');
        $test3 = MediaWikiContributor::isValidDataObject('{"user_email":"bar", "user_name":"3", "bogus": {}}');

        $this->assertFalse(MediaWikiContributor::isValidDataObject(array("user_id"=>31337)));
        $this->assertTrue($test1, "JSON string with expected key names and values should be true too");
        $this->assertFalse($test2, "JSON string with unexpected key names and values should be false");
        $this->assertFalse($test3, "JSON string with unexpected key names and values should be false");
    }

    public function testImportDataObject()
    {
        $array = MediaWikiContributor::importDataObject($this->user_json_string);
        $this->assertTrue(is_array($array), "Valid JSON string with expected keys should return an array");

    }
}
