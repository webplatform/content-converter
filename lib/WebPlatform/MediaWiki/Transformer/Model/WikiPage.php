<?php

namespace WebPlatform\MediaWiki\Transformer\Model;

use \Exception;
use \SimpleXMLElement;
use \SplDoublyLinkedList;

/**
 * Models a MediaWiki page node from dumpBackupXml schema
 *
 * A page MUST have AT LEAST ONE revision.
 *
 * Here is a sample of a MediaWiki dumpBackupXml page node.
 *
 * <page>
 *   <title>WPD:Contributor Agreement</title>
 *   <ns>3000</ns>
 *   <id>5</id>
 *   <revision>
 *     <id>39</id>
 *     <parentid>10</parentid>
 *     <timestamp>2012-06-20T04:42:18Z</timestamp>
 *     <contributor>
 *       <username>Shepazu</username>
 *       <id>2</id>
 *     </contributor>
 *     <comment>removed warning</comment>
 *     <model>wikitext</model>
 *     <format>text/x-wiki</format>
 *     <text xml:space="preserve" bytes="1">'''Wikitext''' text.</text>
 *     <sha1>l37t3nh9pz0qgiakt2o6v11ofw812jd</sha1>
 *   </revision>
 * </page>
 */
class WikiPage {

  /** @var string page Title, but in MW it ends up being an URL too */
  protected $title     = null;

  /** @var mixed string representation of the possible path or false if no redirect was specified */
  protected $redirect = false;

  /** @var \SplDoublyLinkedList of Revision objects */
  protected $revisions = array();

  /**
   * Constructs a WikiPage object
   *
   * @param SimpleXMLElement $pageNode
   */
  public function __construct(SimpleXMLElement $pageNode) {
    if (self::isMediaWikiDumpPageNode($pageNode) === true) {
      $this->title     = (string) $pageNode->title;
      $this->revisions = new SplDoublyLinkedList;
      $revisions = $pageNode->revision;

      foreach($revisions as $rev) {
        $this->revisions->push(new Revision($rev));
      }

      $redirect = (string) $pageNode->redirect['title'];
      if(strlen($redirect) > 1){
        $this->redirect = $redirect;
      }

      return $this;
    }

    throw new UnsupportedInputException;
  }

  public static function isMediaWikiDumpPageNode(SimpleXMLElement $pageNode) {
    $isValid = false;
    $checks[] = $pageNode->getName() === 'page';
    $checks[] = count($pageNode->revision) >= 1;
    if(in_array(false, $checks) === false) {
      // We have no failed tests, therefore we have all we need
      return true;
    }

    return false;
  }

  public function getTitle() {
    return $this->title;
  }

  public function getRedirect() {
    return (!!$this->redirect)?$this->redirect:false;
  }

  public function hasRedirect() {
    return !! $this->redirect;
  }

  public function getLatest() {
    return $this->revisions->offsetGet(0);
  }

  public function getRevisions() {
    return $this->revisions;
  }

}
