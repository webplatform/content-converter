<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

use SimpleXMLElement;
use RuntimeException;

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
class WikiRevision implements RevisionInterface
{
    /* String used in MediaWiki dumpBackup format node in a revision entry  */
    const FORMAT_WIKI = 'text/x-wiki';

    /* String used in MediaWiki dumpBackup model node in a revision entry  */
    const MODEL_WIKI = 'wikitext';

    protected $validate_contributor = true;

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

    /** @var int id of the MediaWiki from the user table */
    protected $contributor_id = null;

    /** @var string username of the MediaWiki user table */
    protected $contributor_name = null;

    /**
     * Constructs a WikiPage Revision object.
     *
     * @param SimpleXMLElement $revisionNode
     */
    public function __construct(SimpleXMLElement $revisionNode)
    {
        if (self::isMediaWikiDumpRevisionNode($revisionNode) === true) {
            foreach ([
               'text', 'format', 'model', 'comment',
            ] as $property) {
                if (!empty($revisionNode->{$property})) {
                    $this->{$property} = (string) $revisionNode->{$property};
                }
            }

            // Format is: 2014-09-08T19:05:22Z so we know its in the Zulu Time Zone.
            $this->timestamp = new \DateTime($revisionNode->timestamp, new \DateTimeZone('Z'));
            // XML uses username node
            $this->contributor_name = (string) $revisionNode->contributor[0]->username;
            $this->contributor_id = (int) $revisionNode->contributor[0]->id;

            return $this;
        }

        throw new \Exception('SimpleXMLElement object did not contain required contents');
    }

    /**
     * Validate if SimpleXMLElement has essential nodes.
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
     * @param SimpleXMLElement $revisionNode <revision> XML node from MediaWiki dumpBackup generated file
     *
     * @return bool [description]
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
     * What will be the Git commit options.
     *
     *
     * Provided this function returns
     *
     *     array(
     *       'date'    => 'Wed Feb 16 14:00 2037 +0100',
     *       'message' => 'message string'
     *     );
     *
     * We want to get;
     *
     *     git commit --date="Wed Feb 16 14:00 2037 +0100" --author="John Doe <jdoe@example.org>" -m "message string"
     *
     * To get the author details, we’ll have to get it from a Contributor instance.
     *
     * @return array of values to send to git
     */
    public function commitArgs()
    {
        $args = array(
                'date' => $this->getTimestamp()->format(\DateTime::RFC2822),
                'message' => $this->getComment(),
        );

        if ($this->contributor instanceof Contributor) {
            $args['author'] = (string) $this->contributor;
        }

        return $args;
    }

    /**
     * Returns the Wikitext of the page.
     *
     * @return string of Wikitext
     */
    public function __toString()
    {
        return $this->text;
    }

    /**
     * set Contributor data object.
     *
     * @param Contributor $contributor          [description]
     * @param bool        $validate_contributor [description]
     */
    public function setContributor(Contributor $contributor, $validate_contributor = true)
    {
        $this->validate_contributor = $validate_contributor;
        $u1 = $this->contributor_name;
        $u2 = $contributor->getName();

        if ($u2 !== $u1 && $this->validate_contributor === true) {
            throw new RuntimeException(sprintf('Contributor %s is not the same as %s', $u1, $u2));
        }

        $this->contributor = $contributor;

        return $contributor;
    }

    public function getContributor()
    {
        if ($this->contributor instanceof Contributor) {
            return $this->contributor;
        }

        throw new RuntimeException('Contributor not linked, please make sure you explicitly call setContributor()');
    }

    public function getContributorName()
    {
        if ($this->contributor instanceof Contributor) {
            return $this->contributor->getName();
        }

        return $this->contributor_name;
    }

    public function getContributorId()
    {
        if ($this->contributor instanceof Contributor) {
            return $this->contributor->getId();
        }

        return $this->contributor_id;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Fulfills RevisionInterface.
     *
     * @return string contents of the Revision
     */
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

    /**
     * Return the comment.
     *
     * Make sure it NEVER has a new line. Just add a space to be sure.
     *
     * @return string the page save comment MediaWiki recorded
     */
    public function getComment()
    {
        return preg_replace("/\n/imu", ' ', $this->comment);
    }
}
