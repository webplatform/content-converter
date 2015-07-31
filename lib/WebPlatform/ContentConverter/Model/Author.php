<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Model;

/**
 * Author.
 *
 * The name and email address of the person who made a change.
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
    protected $email = 'public-webplatform@w3.org';

    /**
     * User’s full name.
     *
     * What the user entered in the name field at
     * registration, or in their account settings
     *
     * @var string User Full name
     */
    protected $realName = 'Anonymous Author';

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get Author Email address.
     *
     * @return string Email address or an empty string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set Author Full name (e.g. John Doe).
     *
     * @param string $realName Author name or "Anonymous Author"
     */
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
