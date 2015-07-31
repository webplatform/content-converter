<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Tests\Model;

use WebPlatform\ContentConverter\Model\MarkdownRevision;

/**
 * MarkdownRevision test suite.
 *
 * @coversDefaultClass \WebPlatform\ContentConverter\Model\MarkdownRevision
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MarkdownRevisionTest extends \PHPUnit_Framework_TestCase
{
    protected $instance;

    protected $markdown = <<<EOQ

# Favourite movie quotes

## Back to the Future

* **Dr. Emmet Brown**: Oh my god. They found me; I don't know how but they found me. RUN FOR IT, MARTY!
* **Biff Tannen**: Mr. McFly! Mr. McFly, this just arrived. Oh, hi, Marty. I think it's your new book.
* **George McFly**: Like I've always told you, you put your mind to it, you can accomplish anything.

<!-- Quotes source; (c) 1985 Universal Studios. All rights reserved. -->
EOQ;

    public function setUp()
    {
        $body = $this->markdown;
        $this->instance = new MarkdownRevision($this->markdown);
    }

    public function testToStringAndFrontMatter()
    {
        $tmpMarkdown = '# Foo';
        $tmpFrontMatter = array('Tag' => array('Bar', 'Bazz', 'Buzz'));

        $mdObj = new MarkdownRevision('# Foo');
        $mdObj->setFrontMatter($tmpFrontMatter);

        // In the test fixture, we said that "Foo" was the content of the
        // contribution, let’s test that. Also, we may change the way the
        // content is generated, see MarkdownRevision for instance.
        $this->assertSame("---\nTag:\n  - Bar\n  - Bazz\n  - Buzz\n\n---\n# Foo", (string) $mdObj);
    }

    public function testSetComment()
    {
        $someComment = "Roads? Where we're going we don't need... roads!";
        $this->instance->setComment($someComment);

        $this->assertSame($someComment, $this->instance->getComment(), 'We should be able to override comment');
    }
}
