<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Tests\Model;

use WebPlatform\ContentConverter\Model\Author;

/**
 * WikiPage test suite.
 *
 * @coversDefaultClass \WebPlatform\ContentConverter\Model\MediaWikiContributor
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class AuthorTest extends \PHPUnit_Framework_TestCase
{
    /** @var Author */
    protected $instance;

    public function setUp()
    {
        $this->instance = new Author();
    }

    public function testName()
    {
        $fullName = 'John Doe';
        $instance = $this->instance->setRealName($fullName);
        $this->assertEquals($instance->getRealName(), $fullName);
    }

    public function testEmail()
    {
        $email = 'jdoe@example.co';
        $instance = $this->instance->setEmail($email);
        $this->assertEquals($instance->getEmail(), $email);
    }

    public function testAnonymousAuthorRealName()
    {
        $fullName = $this->instance->getRealName();
        $this->assertEquals($fullName, 'Anonymous Author', 'We should ensure a name exists');
    }
}
