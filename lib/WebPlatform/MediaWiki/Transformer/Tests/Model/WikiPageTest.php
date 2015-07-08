<?php

namespace WebPlatform\MediaWiki\Transformer\Tests\Model;


use WebPlatform\MediaWiki\Transformer\Model\WikiPage;
use WebPlatform\MediaWiki\Transformer\Model\Revision;
use \SimpleXMLElement;

/**
 * WikiPage test suite
 *
 * @coversDefaultClass \WebPlatform\MediaWiki\Transformer\Model\WikiPage
 */
class WikiPageTest extends \PHPUnit_Framework_TestCase {

  /** @var SimpleXML Object representation of a typical MediaWiki dumpBackup XML file */
  protected $dumpBackupXml;

  public function setUp() {
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
    <revision>
      <id>39</id>
      <parentid>10</parentid>
      <timestamp>2012-06-20T04:42:18Z</timestamp>
      <contributor>
        <username>Shepazu</username>
        <id>2</id>
      </contributor>
      <comment>removed warning</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="1480">This Copyright Assignment Agreement (“Agreement”) is entered into between the participating entity contributing content to the WebPlatform.org site (“Contributor”), and the World Wide Web Consortium (&quot;W3C&quot;), represented through W3C Host MIT. This Agreement is effective as of the date content is submitted by Contributor (“Effective Date”).

Whereas, Contributor wishes to make available works created by Contributor and submitted for inclusion in the Web Platform Documentation Site (hereafter &quot;Site&quot;), collectively &quot;Contributions.&quot;

Whereas W3C, in conjunction with the other Stewards, wishes to host that material on the Site with public licenses that invite public use, royalty-free, and to be able to re-license such material if the needs of the Web Platform community change,

Therefore, Contributor agrees to assign and hereby assigns copyright in its Contributions to W3C, for issuance to the public royalty-free under a public license such as those meeting the Open Source Initiative’s Open Source Definition (http://opensource.org/docs/osd) or Creative Commons (http://creativecommons.org/licenses/) terms.

Contributor asserts that it has all rights necessary to assign its Contributions, and that their publication on the Site will not infringe the rights of others.

Contributor retains a non-exclusive, world-wide, perpetual license to reproduce, distribute, modify, publicly display, publicly perform, and publicly digitally perform its Contributions.</text>
      <sha1>l37t3nh9pz0qgiakt2o6v11ofw812jd</sha1>
    </revision>
  </page>
  <page>
    <title>WPD:Doc Sprints</title>
    <ns>3000</ns>
    <id>8</id>
    <revision>
      <id>31893</id>
      <parentid>31892</parentid>
      <timestamp>2013-05-07T18:57:47Z</timestamp>
      <contributor>
        <username>Jswisher</username>
        <id>8</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="3074">We have ongoing documentation sprints to work on integrating the content on the WebPlatform.org site. There are many benefits to getting people together in physically for this sort of work, both for effective collaboration and for community-building.

==Schedule==
See (and probably &quot;watch&quot;) the [http://docs.webplatform.org/wiki/WPD:Community/Community_Events Community Events page].

==Logistics==
A virtual sprint can be organized on fairly short notice–participants just need to commit and clear their schedules. An in-person sprint requires more lead time and logistics. We're working on extending this document to a Web Platform Doc Sprint in-a-Box document for more information on how to organize an in-person Doc Sprint.

==Planning Guide==
Janet Swisher started a [https://developer.mozilla.org/Project:en/Doc_sprint_planning_guide Doc Sprint planning guide].

There is also the [http://booki.flossmanuals.net/book-sprints/_draft/_v/1.0/introduction/ FLOSS Manuals Book Sprints book]; it's only available in draft form, because Adam Hyde considers it out of date with regard to his current philosophy on book sprints, but it should be helpful as far as the practical issues.

==Organizer Roles==
There should be at least two roles for organizers in a sprint: one person to organize the logistics, and another to facilitate the content effort. A single person doing both is too draining.

===Logistics Organizer===
This person should manage the budget and funding, find a location, identify participants, arrange meals, and so on.

===Content Facilitator===
This person should facilitate the content effort by guiding the creation and review of different materials, and encouraging collaboration between participants.

====Recommended Facilitators====
Janet recommend Adam Hyde of FLOSS Manuals, as he has more experience at this than really anybody. (even though we won't be using FLOSS Manuals site or producing a &quot;book&quot; per se). Contact Janet for an introduction to Adam.

==Participants==
We want at best one representative from each steward organization, along with community volunteers; otherwise, we risk filling the room with stewards and excluding community.

==Materials==

'''Doc Sprint dashboard''': There is a dashboard available that helps to monitor Doc Sprint results and inspires people to keep the momentum over the event. It fetches the Media Wiki API for latest changes and narrows down the data based on a given list of usernames (== Doc Sprint participants) and timeframe, which is then visualized in configurably graphs and leaderboards. Grab the code here: https://github.com/webplatform/DocSprintDashboard

'''Doc Sprint slide template''': We have uploaded the presentation slides used at the Berlin Doc Sprint in February 2013, for you to reuse or base your own presentations on:

* [http://chrisdavidmills.github.com/wpds-berlin-preso/wpds-berlin-preso.key Keynote]
* [http://chrisdavidmills.github.com/wpds-berlin-preso/wpds-berlin-preso.ppt Powerpoint]
* [http://chrisdavidmills.github.com/wpds-berlin-preso/wpds-berlin-preso.pdf PDF]</text>
      <sha1>56iivsqehag14u3gqytjz2sdm99kn5s</sha1>
    </revision>
  </page>
  <page>
    <title>WPD:Infrastructure/proposals/Site Map</title>
    <ns>3000</ns>
    <id>16</id>
    <revision>
      <id>62561</id>
      <parentid>62555</parentid>
      <timestamp>2014-07-11T15:53:33Z</timestamp>
      <contributor>
        <username>Renoirb</username>
        <id>10080</id>
      </contributor>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="5129">
{{Note|This page describes the initial plan for webplatform.org, most content is deprecated}}

===Content===
* Reference docs
* Guides
* Tutorials

===Content===
?

===Software===
* ✓ pastebin
* ✓ live code tester
** ✓ [http://dabblet.com/ Dabblet]
* ✓ live DOM viewer
* ✓ validation</text>
      <sha1>rwkog8qa38dfz0xxdafe39qovsfp1q7</sha1>
    </revision>
  </page>
  <page>
    <title>WPD:CSS Example Article</title>
    <ns>3000</ns>
    <id>198</id>
    <redirect title="WPD:Example Pages/CSS" />
    <revision>
      <id>613</id>
      <timestamp>2012-08-15T12:36:14Z</timestamp>
      <contributor>
        <username>Jkomoros</username>
        <id>9</id>
      </contributor>
      <comment>Jkomoros moved page [[WPD:CSS Example Article]] to [[WPD:Example Pages/CSS]]: Restructuring because we have multiple example pages</comment>
      <model>wikitext</model>
      <format>text/x-wiki</format>
      <text xml:space="preserve" bytes="35">#REDIRECT [[WPD:Example Pages/CSS]]</text>
      <sha1>lqlzcylbs46x6npcmscfxsywdkzxdyc</sha1>
    </revision>
  </page>
</mediawiki>
SAMPLE;
    $this->dumpBackupXml = simplexml_load_string($dumpBackupXml);
  }

  protected function stdout($text) {
    fwrite(STDOUT, $text . "\n");
  }

  /**
   * @covers ::getTitle
   */
  public function testTitle() {
    $pageNode = $this->dumpBackupXml->page[0];
    $title = (string) $pageNode->title;
    $obj = new WikiPage($pageNode);
    $this->assertSame($title, $obj->getTitle());
  }

  /**
   * @covers ::revisions
   */
  public function testRevisions() {
    $pageNode = $this->dumpBackupXml->page[0];
    $count = count($pageNode->revision);
    $obj = new WikiPage($pageNode);
    $this->assertSame($count, $obj->revisions()->count());
  }

  /**
   * @covers ::latest
   */
  public function testLatestTimestampFormat() {
    // Made sure we have at least 2 revisions in SAMPLE
    // dumpBackupXml, and that the timestamp of the first item
    // is the following.
    $latestTimestamp = '2014-08-20T17:41:27Z';
    $pageNode = $this->dumpBackupXml->page[0];
    $obj = new WikiPage($pageNode);
    $objTimestamp = $obj->latest()->getTimestamp()->format('Y-m-d\TH:i:sT');
    $this->assertSame($latestTimestamp, $objTimestamp);
  }

  /**
   * @covers ::latest
   */
  public function testLatestRevision() {
    $pageNode = $this->dumpBackupXml->page[0];
    $obj = new WikiPage($pageNode);
    $this->assertInstanceOf('\WebPlatform\MediaWiki\Transformer\Model\Revision', $obj->latest());
  }

  /**
   * @covers ::latest
   */
  public function testLatestRevisionDateTime() {
    $pageNode = $this->dumpBackupXml->page[0];
    $obj = new WikiPage($pageNode);
    $this->assertInstanceOf('\DateTime', $obj->latest()->getTimestamp());
  }

  /**
   * @covers ::latest
   */
  public function testLatestRevisionRevisionsType() {
    $pageNode = $this->dumpBackupXml->page[0];
    $obj = new WikiPage($pageNode);
    $this->assertInstanceOf('\SplDoublyLinkedList', $obj->revisions());
  }

  /**
   * @covers ::latest
   */
  public function testRevisionOrderingListContributors() {
    // Made sure we have at least 2 revisions in SAMPLE
    // dumpBackupXml, and that the the contributors usernames
    // are in order.
    $hardcodedContributors = 'Dgash,Shepazu';
    $pageNode = $this->dumpBackupXml->page[0];
    $obj = new WikiPage($pageNode);
    $stack = $obj->revisions();
    $stack->rewind();
    $contributors = array();
    while($stack->valid()){
        $contributors[] = $stack->current()->getContributor();
        $stack->next();
    }
    $this->assertSame(join($contributors,','), $hardcodedContributors);

  }

  /**
   * @covers ::potentialFilePath
   */
  public function testGetFilePath(){
    // Title is  "WPD:Doc Sprints"
    // ... into  "WPD/Doc-Sprints"
    $pageNode = $this->dumpBackupXml->page[1];
    $obj = new WikiPage($pageNode);

    $this->assertSame($obj->getDesiredFilePath(), "WPD/Doc-Sprints");
  }

  /**
   * @covers ::potentialFilePath
   */
  public function testPotentialFilePath(){
    $expected1 = "WPD/Infrastructure/proposals/Site-Map";
    $methodCall1 = WikiPage::potentialFilePath("WPD:Infrastructure/proposals/Site Map");
    $expected2 = "WPD/Doc-Sprints";
    $methodCall2 = WikiPage::potentialFilePath("WPD:Doc Sprints");

    $this->assertSame($expected1,$methodCall1);
    $this->assertSame($expected2,$methodCall2);
  }

 }
