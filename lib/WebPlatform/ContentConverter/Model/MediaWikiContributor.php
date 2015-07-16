<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Model;

use InvalidArgumentException;
use UnexpectedValueException;
use RuntimeException;
use Exception;

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
    protected $id;

    /**
     * Check if input has minimal key-values (user_email, user_name, user_real_name).
     *
     * @param mixed $json_or_array Eitner a JSON string, or an array
     *
     * @throws RuntimeException if the JSON string could not be used
     *
     * @return bool If input has required members
     */
    public static function importDataObject($json_or_array)
    {
        if (is_string($json_or_array)) {
            try {
                $data = json_decode($json_or_array, true);
            } catch (Exception $e) {
                $message = sprintf('Could not convert to array JSON string input %s', $json_or_array);
                throw new RuntimeException($message, null, $e);
            }
        } elseif (is_array($json_or_array)) {
            $data = $json_or_array;
        }

        if (!is_array($data)) {
            $message = 'Input value in importDataObject did not convert. Input was %s';
            throw new UnexpectedValueException(sprintf($message, print_r($json_or_array, true)));
        }

        return $data;
    }

    public static function isValidDataObject($json_or_array)
    {
        try {
            $data = self::importDataObject($json_or_array);
        } catch (Exception $e) {
            throw new InvalidArgumentException('Error importing data', null, $e);
        }

        $requiredMembers[] = in_array('user_email', array_keys($data));
        $requiredMembers[] = in_array('user_name', array_keys($data));
        $requiredMembers[] = in_array('user_real_name', array_keys($data));

        return in_array(false, $requiredMembers) === false;
    }

    /**
     * Build an user entity based on either an array or a JSON string.
     *
     * User ID 0 is automatically assigned to id = 1, because default
     * user in MediaWiki backup has no user id 0 and the id 1 is generally
     * the SysOp initial user.
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
     *
     * @throws RuntimeException When could not import data OR had invalid input
     **/
    public function __construct($json_or_array)
    {
        $testInput = self::isValidDataObject($json_or_array);

        try {
            $data = self::importDataObject($json_or_array);
        } catch (Exception $e) {
            throw new RuntimeException('Error importing data', null, $e);
        }

        if ($testInput === true) {
            foreach ($data as $k => $v) {
                $key = str_replace('user_', '', $k);
                //
                // This case is that if we have "id", "real_name", or "email",
                // we *really* want the property to use Author class setters.
                //
                // That’s why we have this elseif  an elseif afterwards.
                //
                // Remember that the $key has 'user_' removed here.
                //
                switch ($key) {
                    case 'id':
                        $this->id = (int) $v;
                        break;
                    case 'email':
                        $this->setEmail($v);
                        break;
                    case 'real_name':
                        $this->setRealName($v);
                        break;
                    default:
                        if (property_exists($this, $key)) {
                            $this->{$key} = $v;
                        }
                        break;
                }
            }

            return $this;
        }
        $message = sprintf('Could not create a MediaWikiContributor instance with input %s', json_encode($data));
        throw new RuntimeException($message);
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
