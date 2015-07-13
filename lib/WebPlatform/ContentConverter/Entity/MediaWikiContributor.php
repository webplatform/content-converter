<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Entity;

use RuntimeException;

/**
 * MediaWiki Contributor ("Author").
 *
 * The name and email address of the person who made a change.
 *
 * Data should be coming, and validated, from MediaWiki.
 *
 * In the case of MediaWiki, you should create a JSON file cache
 * of all your users. To do so, you can use the export_users.php
 * script in the sample/ directory at the root of this library.
 *
 * What was the MediaWiki user who made the contribution.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiContributor extends Author
{
    /** @var string MediaWiki username value, username is Capitalized */
    protected $name;

    /** @var bool Value MediaWiki had stored related to email authentication */
    protected $email_authenticated = false;

    /**
     * user_id value in MediaWiki database.
     *
     * ... not really useful if you merge multiple wikis though.
     *
     * If you want to migrate both users and wiki contents from the
     * same MediaWiki instance, the id field should match the Contributor id
     * node within dumpBackup XML file.
     *
     * @var int MediaWiki database user table id key
     */
    protected $id = 0;

    public static function authorFactory(MediaWikiRevision $revision, $defaultEmail = null)
    {
        $dto['user_real_name'] = $revision->getContributorName();
        $dto['user_name'] = $revision->getContributorId();
        if ($defaultEmail !== null) {
            $dto['user_email'] = $defaultEmail;
        }

        return new self($dto);
    }

    /**
     * Build an user entity based on either an array or a JSON string.
     *
     * Acceptable input:
     *
     * 1. String
     *
     *     {"user_email":"jdoe@example.org","user_id":"42","user_name":"Jdoe","user_real_name":"John Doe","user_email_authenticated":true}
     *
     * 2. Array
     *
     *     array('user_email'=>'jdoe@example.org', 'user_id'=> 42, 'user_name'=> 'Jdoe', 'user_real_name'=>'John Doe', 'user_email_authenticated'=> true);
     *
     * @var mixed User data key-value, make sure you have at least: user_email, user_id, user_name
     **/
    public function __construct($json_or_array)
    {
        if (is_string($json_or_array)) {
            $data = json_decode($json_or_array, true);
        } elseif (is_array($json_or_array)) {
            $data = $json_or_array;
        } else {
            throw new RuntimeException('Constructor only accepts array or JSON string');
        }

        foreach ($data as $k => $v) {
            $key = str_replace('user_', '', $k);
            // This case is that if we have "id", we *really* want it to be integer
            // that’s why we have an elseif afterwards.
            if ($key === 'id') {
                $this->id = (int) $v;
            } elseif (property_exists($this, $key)) {
                $this->{$key} = $v;
            } elseif ($key === 'real_name') {
                // Because we are mapping from MediaWiki XML schema
                // and we still want to support PSR2 coding standards.
                $this->realName = $v;
            }
        }

        return $this;
    }

    public function isAuthenticated()
    {
        return ($this->email_authenticated === null) ? false : true;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }
}
