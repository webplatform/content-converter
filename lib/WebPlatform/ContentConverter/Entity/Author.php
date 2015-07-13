<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\ContentConverter\Entity;

/**
 * Contributor entity.
 *
 * This class represents an Author.
 *
 * In the case of MediaWiki, you should create a JSON file cache
 * of all your users. To do so, you can use the export_users.php
 * script in the sample/ directory at the root of this library.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class Author
{
    /**
     * User’s email address.
     *
     * In the case of MediaWiki, data should be considered trustworthy only
     * if you imported it from a MediaWiki instance that has email
     * validation settings set in place.
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
    protected $realName = '';

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setRealName($realName)
    {
        $this->realName = $realName;

        return $this;
    }

    public function getRealName()
    {
        return $this->realName;
    }

    public function __toString()
    {
        return sprintf('%s <%s>', $this->getRealName(), $this->getEmail());
    }
}
