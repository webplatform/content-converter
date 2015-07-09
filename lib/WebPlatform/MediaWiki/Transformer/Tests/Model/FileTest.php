<?php

namespace WebPlatform\MediaWiki\Transformer\Tests\Model;

use WebPlatform\MediaWiki\Transformer\Model\File;

/**
 * File test suite
 *
 * @coversDefaultClass \WebPlatform\MediaWiki\Transformer\Model\File
 */
class FileTest extends \PHPUnit_Framework_TestCase {

  /** @var SimpleXML Object representation of a typical MediaWiki dumpBackup XML file */
  protected $dumpBackupXml;

  public function setUp() {
    $dumpBackupXml = <<<SAMPLE
<mediawiki xmlns="http://www.mediawiki.org/xml/export-0.10/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.mediawiki.org/xml/export-0.10/ http://www.mediawiki.org/xml/export-0.10.xsd" version="0.10" xml:lang="en">
  <page>
    <title>WPD:Content List/Topic Pages</title>
    <ns>3000</ns>
    <id>1324</id>
    <redirect title="WPD:Content/Topic Pages" />
    <revision>
      <id>34321</id>
      <parentid>46134</parentid>
      <timestamp>2014-05-20T13:11:27Z</timestamp>
      <contributor>
        <username>Tyriar</username>
        <id>10768</id>
      </contributor>
      <minor/>
      <comment>Fixing double redirect</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="37">#REDIRECT [[WPD:Content/Topic Pages]]</text>
      <sha1>2q4w9k2zrrdf3rscx5u54ba3utmjib0k</sha1>
    </revision>
  </page>
  <page>
    <title>tutorials/what is css</title>
    <ns>0</ns>
    <id>1709</id>
    <redirect title="tutorials/learning what css is" />
    <revision>
      <id>6048</id>
      <timestamp>2012-10-02T15:39:44Z</timestamp>
      <contributor>
        <username>Cmills</username>
        <id>11</id>
      </contributor>
      <comment>Cmills moved page [[tutorials/what is css]] to [[tutorials/learning what css is]]</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="44">#REDIRECT [[tutorials/learning what css is]]</text>
      <sha1>kga6mkzkwxmaibhcopxb9awb5sgufz3</sha1>
    </revision>
  </page>
</mediawiki>
SAMPLE;
    $this->dumpBackupXml = simplexml_load_string($dumpBackupXml);
  }

  /**
   * @covers ::formatPath
   */
  public function testFormatPath(){
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

    foreach($assertions as $assertion) {
      $this->assertSame($assertion[0],File::formatPath($assertion[1]));
    }
  }
}