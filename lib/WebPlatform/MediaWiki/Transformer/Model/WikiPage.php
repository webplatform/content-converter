<?php

namespace WebPlatform\MediaWiki\Transformer\Model;

use \Exception;
use \SimpleXMLElement;
use \Serializable;

/**
 * Models a MediaWiki article
 */
class WikiPage
  implements Serializable {

  /** @var string page Title, but in MW it ends up being an URL too */
  protected $title     = null;

  /** @var string The page content */
  protected $text      = null;

  /** @var string MediaWiki’s SHA1 string */
  protected $sha1      = null;

  /** @var string MediaWiki’s Content-Type format string name, e.g. "text/x-wiki" */
  protected $format    = null;

  /** @var string MediaWiki content model name, e.g. "wikitext" */
  protected $model     = null;

  /** @var \DateTime The page revision edition timestamp */
  protected $timestamp = null;

  /** @var SimpleXMLElement MediaWiki dumpBackup XML document <page/> node loaded using PHP builtin SimpleXML */
  protected $pageNode;

  /**
   * Constructs a WikiPage object
   *
   * @param SimpleXMLElement $pageNode
   */
  function __construct( SimpleXMLElement $pageNode = null ) {
    $this->pageNode = $pageNode;
    $this->title    = (string) $pageNode->title;
    $this->text     = $this->getText( true );
  }

  public function serialize( ) {
    $pkg = array();
    foreach([
       'title'
      ,'text'
      ,'sha1'
      ,'format'
      ,'model'
    ] as $property) {
      $pkg[$property] = $this->{$property};
    }
    $pkg['pageNode'] = (string) $this->pageNode->asXML();
    $pkg['timestamp'] = $this->timestamp->format('Y-m-d H:i:s.u T');

    return serialize($pkg);
  }

  public function unserialize( $serialized ) {
    $data = (array) unserialize($serialized);
    foreach($data as $k => $property) {
      if(property_exists($this, $k)) {
        switch($k) {
          case 'timestamp':
            $this->timestamp = new \DateTime($property, new \DateTimeZone('Z'));
          break;

          case 'pageNode':
            $this->pageNode = simplexml_load_string($property);
          break;

          default:
            $this->{$k} = $property;
          break;
        }
      }
    }
  }

  /**
   * Returns the Wikitext of the page
   * @return string of Wikitext
   */
  function __toString() {
    return $this->text;
  }

  /**
   * Returns the title of this page
   * @return string the title of this page
   */
  function getTitle() {
    return $this->title;
  }

  function getSha1() {
    return $this->sha1;
  }

  function getTimestamp() {
    return $this->timestamp;
  }

  function getText( $refresh = false ) {

    // Keeping the same method signature and behavior
    // but removing completely work with RegExes.
    if ( $refresh ) {
      $page = (array)$this->pageNode;
      $revision = (array)$page['revision'];

      if(!empty($revision['timestamp'])) {
        // Format is: 2014-09-08T19:05:22Z so we know its in the Zulu Time Zone.
        $this->timestamp = new \DateTime($revision['timestamp'], new \DateTimeZone('Z'));
      }

      foreach([
         'text'
        ,'sha1'
        ,'format'
        ,'model'
      ] as $property) {
        if(!empty($revision[$property])) {
          $this->{$property} = $revision[$property];
        }
      }
      unset( $page, $revision );
    }

    return $this->text; // return the text in any case

  }

}