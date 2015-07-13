<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Persistency;

use WebPlatform\ContentConverter\Entity\Author;

/**
 * Save File Revision into a Git Commit.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class FileGitCommit extends File
{
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
    public function commitArgs()
    {
        $author = $this->getRevision()->getAuthor();

        $args = array(
                'date' => $this->getRevision()->getTimestamp()->format(\DateTime::RFC2822),
                'message' => $this->getRevision()->getComment(),
        );

        if ($author instanceof Author) {
            $args['author'] = sprintf('%s <%s>', $author->getRealName(), $author->getEmail());
        }

        return $args;
    }

    public function persist()
    {
        $out['fileName'] = $this->getFileName();
        $out['args'] = $this->commitArgs();

        var_dump($out);

        // Stub
    }
}
