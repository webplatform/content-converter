<?php

/**
 * WebPlatform Content Converter.
 */
namespace WebPlatform\ContentConverter\Persistency;

use WebPlatform\ContentConverter\Model\AbstractDocument;
use WebPlatform\ContentConverter\Model\Author;
use RuntimeException;

/**
 * Save File Revision into a Git Commit.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class GitCommitFileRevision extends AbstractPersister
{
    public function __construct(AbstractDocument $document = null, $prefix = '', $extension = '')
    {
        parent::__construct($document, $prefix, $extension);

        $file_path = $this->getPrefix();
        $file_path .= $this->getName();
        $file_path .= (($document->isTranslation()) ? null : '/index').$this->getExtension();

        $this->setName($file_path);

        return $this;
    }

    /**
     * What will be the persist arguments.
     *
     * Provided this function returns
     *
     *     array(
     *       'date'    => 'Wed Feb 16 14:00 2037 +0100',
     *       'message' => 'message string'
     *     );
     *
     * We want to get, i.e. for git;
     *
     *     git commit --date="Wed Feb 16 14:00 2037 +0100" --author="John Doe <jdoe@example.org>" -m "message string"
     *
     * To get the author details, we’ll have to get it from a Contributor instance.
     *
     * @param bool $forceAuthor Whether or not we should get an author object
     *
     * @return array of string values to send to git
     */
    public function getArgs($forceAuthor = true)
    {
        $author = $this->getRevision()->getAuthor();

        $args = array();
        if ($author instanceof Author) {
            $args['author'] = (string) $author;
        } elseif ((bool) $forceAuthor === false) {
            // Do nothing, its been requested to not force author, let’s not throw an exception
        } else {
            throw new RuntimeException('Make sure you make the current revision to specify explicityly an Author object through setAuthor. e.g. $revision->setAuthor($authorObject);');
        }

        $args['date'] = $this->getRevision()->getTimestamp()->format(\DateTime::RFC2822);
        $args['message'] = (string) $this->getRevision()->getComment();

        return $args;
    }
}
