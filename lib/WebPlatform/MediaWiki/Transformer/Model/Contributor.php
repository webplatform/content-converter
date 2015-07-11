<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

use RuntimeException;

/**
 * Contributor entity.
 *
 * This class represents a MediaWiki user.
 *
 * If you can export all users from your MediaWiki wiki, you can
 * use the export_users.php script in the sample/ directory at the
 * root of this project.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class Contributor
{
    /** @var string MediaWiki username value, username is Capitalized */
    protected $name;

    /**
     * User’s email address.
     *
     * Data should be considered trustable source if you imported it
     * from a MediaWiki instance that has email validation working
     *
     * @var string User email address
     */
    protected $email;

    /**
     * User’s full name.
     *
     * What the user entered in the name field at
     * registration, or in their account settings
     *
     * @var string User Full name
     */
    protected $real_name = '';

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
            if ($key === 'id') {
                $this->id = (int) $v;
            } elseif (property_exists($this, $key)) {
                $this->{$key} = $v;
            }
        }

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRealName()
    {
        return $this->real_name;
    }

    public function isAuthenticated()
    {
        return ($this->email_authenticated === null) ? false : true;
    }

    public function __toString()
    {
        return sprintf('%s <%s>', $this->getRealName(), $this->getEmail());
    }
}
