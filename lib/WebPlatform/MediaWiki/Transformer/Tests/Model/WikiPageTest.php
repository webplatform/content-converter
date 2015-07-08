<?php

namespace WebPlatform\MediaWiki\Transformer\Tests\Model;


use WebPlatform\MediaWiki\Transformer\Model\WikiPage;
use \Exception;
use \SimpleXMLElement;
use \Serializable;

/**
 * WikiPage test suite
 *
 * @coversDefaultClass \WebPlatform\MediaWiki\Transformer\Model\WikiPage
 */
class WikiPageTest extends \PHPUnit_Framework_TestCase {

  /** @var SimpleXML Object representation of a typical MediaWiki dumpBackup XML file */
  protected static $dumpBackupXml;

  public static function setUpBeforeClass() {
    $dumpBackupXml = <<<SAMPLE
<mediawiki xmlns="http://www.mediawiki.org/xml/export-0.10/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.mediawiki.org/xml/export-0.10/ http://www.mediawiki.org/xml/export-0.10.xsd" version="0.10" xml:lang="en">
  <page>
    <title>dom/EventTarget/addEventListener</title>
    <ns>0</ns>
    <id>3138</id>
    <revision>
      <id>68473</id>
      <parentid>46134</parentid>
      <timestamp>2014-08-20T17:41:27Z</timestamp>
      <contributor>
        <username>Dgash</username>
        <id>50</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="4467">{{Page_Title}}
{{Flags
|State=Ready to Use
|Checked_Out=No
|High-level issues=Needs Topics, Missing Relevant Sections, Data Not Semantic, Unreviewed Import
|Content=Incomplete, Not Neutral, Cleanup, Compatibility Incomplete, Examples Best Practices
}}
{{Standardization_Status|W3C Recommendation}}
{{API_Name}}
{{Summary_Section|Registers an event handler for the specified event type.}}
{{API_Object_Method
|Parameters={{Method Parameter
|Index=0
|Name=type
|Data type=String
|Description=The type of event [[dom/Event/type|'''type''']] to register.
|Optional=No
}}{{Method Parameter
|Index=1
|Name=handler
|Data type=function
|Description=A '''function''' that is called when the event is fired.
|Optional=No
}}{{Method Parameter
|Index=2
|Name=useCapture
|Data type=Boolean
|Description=A '''Boolean''' value that specifies the event phase to add the event handler for.

While this parameter is officially optional, it may only be omitted in modern browsers.
|Optional=Yes
}}
|Method_applies_to=dom/EventTarget
|Example_object_name=target
|Javascript_data_type=void
}}
{{Related_Specifications_Section
|Specifications={{Related Specification
|Name=DOM Level 3 Events
|URL=http://www.w3.org/TR/DOM-Level-3-Events/
|Status=Working Draft
|Relevant_changes=Section 4.3
}}
}}
{{Topics|DOM, DOMEvents}}
</text>
      <sha1>2q4w9k2zrrdbrscx5u54a34utmjib0k</sha1>
    </revision>
  </page>
</mediawiki>
SAMPLE;
    self::$dumpBackupXml = simplexml_load_string($dumpBackupXml);
  }

  public static function tearDownAfterClass()
  {
    self::$dumpBackupXml = NULL;
  }

  protected function stdout($text) {
    fwrite(STDOUT, $text . "\n");
  }

  /**
   * @covers ::getTitle
   */
  public function testTitle() {
    $title = (string) $this->dumpBackupXml->title;
    $obj = new WikiPage(self::$dumpBackupXml);

    $this->assertSame($title, $obj->getTitle());
  }

}