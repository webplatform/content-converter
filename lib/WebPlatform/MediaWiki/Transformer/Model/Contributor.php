<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

/**
 * Contributor entity
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
     * User’s email address
     *
     * Data should be considered trustable source if you imported it
     * from a MediaWiki instance that has email validation working
     *
     * @var string User email address
     */
    protected $email;

    /**
     * User’s full name
     *
     * What the user entered in the name field at
     * registration, or in their account settings
     *
     * @var string User Full name
     */
    protected $real_name = '';

    /** @var boolean Value MediaWiki had stored related to email authentication */
    protected $email_authenticated = false;

    /**
     * user_id value in MediaWiki database
     *
     * ... not really useful, if you merge multiple wikis though.
     *
     * @var integer MediaWiki database user table id key
     */
    protected $id = 0;

    /**
     * Build an user entity based on either an array or a JSON string
     *
     * Acceptable input:
     *
     * 1. String
     *
     *     {"user_email":"foo@bar.org","user_id":"1","user_name":"WikiSysop","user_real_name":"","user_email_authenticated":null}
     *
     * 2. Array
     *
     *     array('user_email'=>'foo@bar.org', 'user_id'=>1, 'user_name'=> 'WikiSysop', 'user_real_name'=>'', 'user_email_authenticated'=> null);
     *
     * @var mixed $json_or_array User data key-value, make sure you have at least: user_email, user_id, user_name
     **/
    public function __construct($json_or_array)
    {
        if (is_string($dto)) {
            $data = json_decode($dto, true);
        } elseif (is_array($dto)) {
            $data = $dto;
        } else {
            throw new UnsupportedUserExportCacheInputException();
        }

        if (is_array($data)) {
            foreach ($data as $k => $v) {
                $key = str_replace('user_', '', $k);
                if (property_exists($this, $key)) {
                    $this->{$key} = $v;
                }
            }
        } else {
            throw new InvalidUserExportCacheFormatException();
        }

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getFullname()
    {
        return $this->full_name;
    }

    public function isValid()
    {
        return ($this->email_validated === null)?false:true;
    }
}
