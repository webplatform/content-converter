<?php

/**
 * Simplified version of hemstar/Wikimate WikiPage class
 *
 * WikiPage class represent content of a wiki page.
 *
 * The original version of WikiPage allowed to read and write
 * to a MediaWiki instance, but this variant is limited to
 * use WikiMedia Wikitext markup and represent it.
 *
 * source: https://github.com/hamstar/Wikimate
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

use \Exception;
use \SimpleXMLElement;

/**
 * Models a wiki article page that can have its text altered and retrieved.
 *
 * Modified version; removed read, write and related HTTP calls --renoirb
 *
 * @author Robert McLeod
 * @since December 2010
 * @version 0.5.1-wpd
 */
class WikiPage {
	const SECTIONLIST_BY_INDEX = 1;
	const SECTIONLIST_BY_NAME = 2;
	const SECTIONLIST_BY_NUMBER = 3;

	private $title = null;
	private $exists = false;
	private $text = null;
	private $invalid = false;
	private $sections = null;

	/** @var SimpleXMLElement MediaWiki dumpBackup XML document <page/> node loaded using PHP builtin SimpleXML */
	private $pageNode;

	/*
	 *
	 * Magic methods
	 *
	 */

	/**
	 * Constructs a WikiPage object
	 *
	 * @param SimpleXMLElement $pageNode
	 */
	function __construct( SimpleXMLElement $pageNode = null ) {
		$this->id       = (int) $pageNode->id;
		$this->pageNode = $pageNode;
		$this->title    = (string) $pageNode->title;
		$this->text     = $this->getText( true );
	}

	/**
	 *
	 * @return <type> Destructor
	 */
	function __destruct() {
		$this->title          = null;
		$this->id          		= null;
		$this->exists         = false;
		$this->text           = null;
		$this->invalid        = false;
		$this->pageNode				= null;
		return null;
	}

	/**
	 * Returns the wikicode of the page
	 * @return string of wikicode
	 */
	function __toString() {
		return $this->text;
	}

	/**
	 * Returns an array sections with the section name as the key and the text
	 * as the element e.g.
	 *
	 * array(
	 *   'intro' => 'this text is the introduction',
	 *   'History' => 'this is text under the history section'
	 * )
	 *
	 * @return array of sections
	 */
	function __invoke() {
		return $this->getAllSections( false, self::SECTIONLIST_BY_NAME );
	}

	/**
	 * Returns the page existance status
	 * @return boolean true if page exists
	 */
	function exists() {
		return $this->exists;
	}

	/**
	 * Returns the title of this page
	 * @return string the title of this page
	 */
	function getTitle() {
		return $this->title;
	}

	/**
	 * Returns the number of sections in this page
	 * @return integer the number of sections in this page
	 */
	function getNumSections() {
		return count( $this->sections->byIndex );
	}

	/**
	 * Returns the sections offsets and lengths
	 * @return StdClass section class
	 */
	function getSectionOffsets() {
		return $this->sections;
	}

	/**
	 * Gets the text of the page.  If refesh is true then this method will
	 * query the wiki api again for the page details
	 * @param boolean $refresh true to query the wiki api again
	 * @return string the text of the page
	 */
	function getText( $refresh = false ) {
		if ( $refresh ) { // we want to query the api
			$page = (array)$this->pageNode;
			$revision = (array)$page['revision'];
			$this->text = $revision['text'];

			unset( $page, $revision );

			// Now we need to get the section information
			preg_match_all( '/={1,6}.*={1,6}\n/', $this->text, $m ); // TODO: improve regexp if possible

			// Set the intro section (between title and first section)
			$this->sections->byIndex[0]['offset']      = 0;
			$this->sections->byName['intro']['offset'] = 0;

			if ( !empty( $m[0] ) ) {
				// Array of section names
				$sections = $m[0];

				// Setup the current section
				$currIndex = 0;
				$currName  = 'intro';

				foreach ( $sections as $i => $section ) {
					// Get the current offset
					$currOffset = strpos( $this->text, $section );

					// Are we still on the first section?
					if ( $currIndex == 0 ) {
						$this->sections->byIndex[$currIndex]['length'] = $currOffset;
						$this->sections->byName[$currName]['length']   = $currOffset;
					}

					// Get the current name and index
					$currName = trim( str_replace( '=', '', $section ) );
					$currIndex++;

					// Set the offset for the current section
					$this->sections->byIndex[$currIndex]['offset'] = $currOffset;
					$this->sections->byName[$currName]['offset']   = $currOffset;

					// If there is a section after this, set the length of this one
					if ( isset( $sections[$currIndex] ) ) {
						$nextOffset = strpos( $this->text, $sections[$currIndex] ); // get the offset of the next section
						$length     = $nextOffset - $currOffset; // calculate the length of this one

						// Set the length of this section
						$this->sections->byIndex[$currIndex]['length'] = $length;
						$this->sections->byName[$currName]['length']   = $length;
					}
				}
			}
		}

		return $this->text; // return the text in any case

	}

	/**
	 * Returns the section requested, section can be the following:
	 * - section name (string:"History")
	 * - section index (int:3)
	 *
	 * @param mixed $section the section to get
	 * @param boolan $includeHeading false to get section text only
	 * @return string wikitext of the section on the page
	 */
	function getSection( $section, $includeHeading = false ) {
		// Check if we have a section name or index
		if ( is_int( $section ) ) {
			$coords = $this->sections->byIndex[$section];
		} else if ( is_string( $section ) ) {
			$coords = $this->sections->byName[$section];
		}

		// Extract the text
		@extract( $coords );
		if ( isset( $length ) ) {
			$text = substr( $this->text, $offset, $length );
		} else {
			$text = substr( $this->text, $offset );
		}

		// Whack of the heading if need be
		if ( !$includeHeading && $offset > 0 ) {
			$text = substr( $text, strpos( trim( $text ), "\n" ) ); // chop off the first line
		}

		return $text;

	}

	/**
	 * Return all the sections of the page in an array - the key names can be
	 * set to name or index by using the following for the second param
	 * - self::SECTIONLIST_BY_NAME
	 * - self::SECTIONLIST_BY_INDEX
	 *
	 * @param boolean $includeHeading false to get section text only
	 * @param integer $keyNames modifier for the array key names
	 * @return array of sections
	 */
	function getAllSections( $includeHeading = false, $keyNames = self::SECTIONLIST_BY_INDEX ) {
		$sections = array();

		switch ( $keyNames ) {
			case self::SECTIONLIST_BY_INDEX:
				$array = array_keys( $this->sections->byIndex );
				break;
			case self::SECTIONLIST_BY_NAME:
				$array = array_keys( $this->sections->byName );
				break;
			default:
				throw new Exception( 'Unexpected parameter $keyNames given to WikiPage::getAllSections()' );
				break;
		}

		foreach ( $array as $key ) {
			$sections[$key] = $this->getSection( $key, $includeHeading );
		}

		return $sections;

	}


}