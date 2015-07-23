<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Converter;

use WebPlatform\ContentConverter\Model\AbstractRevision;
use WebPlatform\ContentConverter\Model\MediaWikiRevision;
use WebPlatform\ContentConverter\Model\MarkdownRevision;
use WebPlatform\ContentConverter\Filter\AbstractFilter;

/**
 * MediaWiki Wikitext to Markdown Converter.
 *
 * Boilerplate converter class.
 *
 * Consider this class as a starting point.
 *
 * You’ll have to either extend or define your own because
 * this will contain filters that applies to your content.
 *
 * WARNING: This class has been stripped down but might not work right away
 *          as I stripped anything too specific to the state of WebPlatform
 *          as of 2015-07-23 (it has been moved into [GitHub specific project][1])
 *          and left behind patterns that one may want to filter on their own wiki.
 *
 * [1]: https://github.com/webplatform/content-converter
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiToMarkdown extends AbstractFilter implements ConverterInterface
{
    protected $leave_template_note = false;

    protected static function helperExternlinks($matches)
    {
        $target = $matches[1];
        $text = empty($matches[2]) ? $matches[1] : $matches[2];

        return sprintf('[%s](%s)', $text, '/'.$target);
    }

    public function __construct()
    {
        throw new \Exception('This is a Stub class. Please adapt before using');

        /*
         * PASS 1: MediaWiki markup caveats that has to be fixed first
         */
        $patterns[] = array(
          // Has to match something like; "|Manual_sections==== 練習問題 ==="
          // in a case where key-value is mingled with a section title, containing a one-too-many equal sign
          "/^\|([a-z_]+)\=(\=)\ ?(.*)\ ?(\=)\s+?/im",
          "/^\|([a-z_]+)\=(\=\=)\ ?(.*)\ ?(\=\=)\s+?/im",
          "/^\|([a-z_]+)\=(\=\=\=)\ ?(.*)\ ?(\=\=\=)\s+?/im",
          "/^\|([a-z_]+)\=(\=\=\=\=)\ ?(.*)\ ?(\=\=\=\=)\s+?/im",
          "/^\|([a-z_]+)\=(\=\=\=\=\=)\ ?(.*)\ ?(\=\=\=\=\=)\s+?/im",
          "/^\|([a-z_]+)\=(\=\=\=\=\=\=)\ ?(.*)\ ?(\=\=\=\=\=\=)\s+?/im",
        );

        $replacements[] = array(
          "|$1=\n$2 $3 $4",
          "|$1=\n$2 $3 $4",
          "|$1=\n$2 $3 $4",
          "|$1=\n$2 $3 $4",
          "|$1=\n$2 $3 $4",
          "|$1=\n$2 $3 $4",
        );

        /**
         * PASS 2
         */
        $patterns[] = array(
          "/^\=[^\s](.*)[^\s]\=/im",
          "/^\=\=[^\s](.*)[^\s]\=\=/im",
          "/^\=\=\=[^\s](.*)[^\s]\=\=\=/im",
          "/^\=\=\=\=[^\s](.*)[^\s]\=\=\=\=/im",
          "/^\=\=\=\=\=[^\s](.*)[^\s]\=\=\=\=\=/im",
          "/^\=\=\=\=\=\=[^\s](.*)[^\s]\=\=\=\=\=\=/im",
        );

        $replacements[] = array(
          '= $1 =',
          '== $1 ==',
          '=== $1 ===',
          '==== $1 ====',
          '===== $1 =====',
          '====== $1 ======',
        );

        for ($pass = 0; $pass < count($patterns); ++$pass) {
            foreach ($patterns[$pass] as $k => $v) {
                // Apply common filters
                $patterns[$pass][$k] .= 'uS';
                $this->addPass($patterns[$pass], $replacements[$pass]);
            }
        }

        return $this;
    }

    /**
     * Apply Wikitext rewrites.
     *
     * @param AbstractRevision $revision Input we want to transfer into Markdown
     *
     * @return AbstractRevision
     */
    public function apply(AbstractRevision $revision)
    {
        throw new \Exception('This is a Stub class. Please adapt before using');

        if ($revision instanceof MediaWikiRevision) {
            $content = $this->filter($revision->getContent());

            // Should we make a loop for that?
            $content = preg_replace_callback('/\[([^\[\]\|\n\': ]+)\]/', 'self::helperExternlinks', $content);
            $content = preg_replace_callback('/\[?\[([^\[\]\|\n\' ]+)[\| ]([^\]\']+)\]\]?/', 'self::helperExternlinks', $content);

            $front_matter = array();

            if (empty(trim($content))) {
                $front_matter['is_stub'] = 'true';
                $content = PHP_EOL; // Let’s redefine at only one line instead of using a filter.
            }

            $rev_matter = $revision->getFrontMatterData();
            $newRev = new MarkdownRevision($content, array_merge($rev_matter, $front_matter));

            return $newRev->setTitle($revision->getTitle());
        }

        return $revision;
    }
}
