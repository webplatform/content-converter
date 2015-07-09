<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

use \SimpleXMLElement;

/**
 * Models a MediaWiki WikiPage Revision.
 *
 * Represent one revision from a page node.
 *
 * Revision MUST be child of a WikiPage (representing a page node),
 * accessible through the revision property.
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
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class Revision
{
  /* String used in MediaWiki dumpBackup format node in a revision entry  */
  const FORMAT_WIKI = "text/x-wiki";

  /* String used in MediaWiki dumpBackup model node in a revision entry  */
  const MODEL_WIKI = "wikitext";

  /** @var string The revision text content */
  protected $text = null;

  /** @var string MediaWiki’s Content-Type format string name, e.g. "text/x-wiki" */
  protected $format = null;

  /** @var string MediaWiki content model name, e.g. "wikitext" */
  protected $model = null;

  /** @var string comment from the contributor when saved the revision */
  protected $comment = null;

  /** @var \DateTime The page revision edition timestamp */
  protected $timestamp = null;

  /** @var string username of the contributor */
  protected $contributor = null;

  /** @var string Git commit author string to use */
  protected $commit_author = 'WebPlatform Docs Anonymous <public-webplatform@w3.org>';

  /**
   * Constructs a WikiPage Revision object
   *
   * @param SimpleXMLElement $revisionNode
   */
  public function __construct(SimpleXMLElement $revisionNode)
  {
    if (self::isMediaWikiDumpRevisionNode($revisionNode) === true) {

      foreach ([
         'text'
        ,'format'
        ,'model'
        ,'comment'
      ] as $property) {
        if (!empty($revisionNode->{$property})) {
          $this->{$property} = (string) $revisionNode->{$property};
        }
      }

      // Format is: 2014-09-08T19:05:22Z so we know its in the Zulu Time Zone.
      $this->timestamp   = new \DateTime($revisionNode->timestamp, new \DateTimeZone('Z'));
      $this->contributor = (string) $revisionNode->contributor[0]->username;

      return $this;
    }

    throw new \Exception('SimpleXMLElement object did not contain required contents');
  }

  /**
   * Validate if SimpleXMLElement has essential nodes
   *
   * Essential:
   *   - text
   *   - timestamp
   *   - contributor
   *
   * Optionnal:
   *   - model
   *   - format
   *   - comment
   *   - minor
   *
   * @param  SimpleXMLElement $revisionNode <revision> XML node from MediaWiki dumpBackup generated file
   *
   * @return boolean                        [description]
   */
  public static function isMediaWikiDumpRevisionNode(SimpleXMLElement $revisionNode)
  {
    $checks[] = $revisionNode->getName() === 'revision';
    $checks[] = count($revisionNode->timestamp) == 1;
    $checks[] = count($revisionNode->contributor) >= 1;
    $checks[] = count($revisionNode->contributor[0]->username) >= 1;
    $checks[] = count($revisionNode->text) == 1;
    if (in_array(false, $checks) === false) {
      // We have no failed tests, therefore we have all we need
      return true;
    }

    return false;
  }

  /**
   * Returns the Wikitext of the page
   * @return string of Wikitext
   */
  public function __toString()
  {
    return $this->text;
  }

  public function getContributor()
  {
    return $this->contributor;
  }

  public function getTimestamp()
  {
    return $this->timestamp;
  }

  public function getText()
  {
    return $this->text;
  }

  public function getFormat()
  {
    return $this->format;
  }

  public function getModel()
  {
    return $this->model;
  }

  public function getComment()
  {
    return $this->comment;
  }
}
