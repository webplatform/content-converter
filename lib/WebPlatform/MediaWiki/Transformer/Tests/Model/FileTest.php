<?php

/**
 * WebPlatform MediaWiki Transformer
 */

namespace WebPlatform\MediaWiki\Transformer\Tests\Model;

use WebPlatform\MediaWiki\Transformer\Model\File;
use WebPlatform\MediaWiki\Transformer\Tests\PagesFixture;

/**
 * File test suite.
 *
 * @coversDefaultClass \WebPlatform\MediaWiki\Transformer\Model\File
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
  /** @var SimpleXML Object representation of a typical MediaWiki dumpBackup XML file */
  protected $dumpBackupXml;

  public function setUp()
  {
    $xml = new PagesFixture;
    $this->dumpBackupXml = $xml->getXml();
  }

  /**
   * @covers ::formatPath
   */
  public function testFormatPath()
  {
    $assertions[0][0] = 'WPD/Infrastructure/proposals/Site_Map';
    $assertions[0][1] = 'WPD:Infrastructure/proposals/Site Map';
    $assertions[1][0] = 'WPD/Doc_Sprints';
    $assertions[1][1] = 'WPD:Doc Sprints';
    $assertions[2][0] = 'tutorials/What_is_CSS';
    $assertions[2][1] = 'tutorials/What is CSS?';
    $assertions[3][0] = 'Tutorials/HTML_forms_-_the_basics';
    $assertions[3][1] = 'Tutorials/HTML forms - the basics';
    $assertions[4][0] = 'ja/concepts/programming/programming_basics';
    $assertions[4][1] = 'ja/concepts/programming/programming basics';
    $assertions[5][0] = 'concepts/Internet_and_Web/the_history_of_the_web/tr';
    $assertions[5][1] = 'concepts/Internet and Web/the history of the web/tr';
    $assertions[6][0] = 'tutorials/Raw_WebGL_101_-_Part_4:_Textures';
    $assertions[6][1] = 'tutorials/Raw WebGL 101 - Part 4: Textures';

    foreach ($assertions as $assertion) {
      $this->assertSame($assertion[0],File::formatPath($assertion[1]));
    }
  }
}
