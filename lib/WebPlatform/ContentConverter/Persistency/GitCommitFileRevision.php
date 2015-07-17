<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Persistency;

use WebPlatform\ContentConverter\Model\AbstractDocument;

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
     * @return array of values to send to git
     */
    public function getArgs()
    {
        $author = $this->getRevision()->getAuthor();

        $args = array();
        if ($author instanceof Author) {
            $args['author'] = sprintf('%s <%s>', $author->getRealName(), $author->getEmail());
        }

        $args['date'] = $this->getRevision()->getTimestamp()->format(\DateTime::RFC2822);
        $args['message'] = (string) $this->getRevision()->getComment();

        return $args;
    }

    public function formatPersisterCommand()
    {
        $commands = array();
        $commands[] = sprintf('git add %s', $this->getName());
        $commit_args = array();
        foreach ($this->getArgs() as $argName => $argVal) {
            $commit_args[] = sprintf('--%s="%s"', $argName, (string) $argVal);
        }
        $commands[] = 'git commit '.implode(' ', $commit_args);

        return $commands;
    }
}
