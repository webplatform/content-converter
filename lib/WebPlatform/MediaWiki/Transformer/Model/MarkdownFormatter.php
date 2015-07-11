<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

/**
 * Wiki Page to Markdown Formatter.
 *
 * This class handles the Wikimedia Wikitext filtering.
 *
 * You can do multiple passes, you’ll notice that we have an array
 * of patterns and replacement, each of them will be passed in the
 * order they’ve been defined. That way can incrementally adjust
 * broken and fix it up in the following pass.
 *
 * Contents here is specific to WebPlatform Docs wiki contents
 * but you would can make your own and implement this library’s
 * FormatterInterface interface to use your own rules.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MarkdownFormatter implements FormatterInterface
{
    protected $patterns = array();
    protected $replacements = array();

    protected $text_cache = '';
    protected $transclusions_cache = array();

    protected function helperExternlinks($matches)
    {
        $target = $matches[1];
        $text = empty($matches[2]) ? $matches[1] : $matches[2];

        return sprintf('[%s](%s)', $text, '/'.$target);
    }

    protected function helperTemplateMatchHonker($matches)
    {

        // e.g...
        // $matches[0] = '{{Page_Title|プログラミングの基礎}}';
        // $matches[1] = 'Page_Title|プログラミングの基礎';
        //
        // .. and also ones with new lines
        // $matches[1] = '{{Guide\n|Content=\n== はじめに...';
        //
        // We want type to hold "Guide"
        // e.g. `$type = 'Guide';`
        $type = trim(strstr($matches[1], '|', true));

        // template_args to hold anything else, each entry starts by a pipe ("|") symbol
        // e.g. `$template_args = array('|Is_CC-BY-SA=No','|Sources=DevOpera','|MSDN_link=','|HTML5Rocks_link=');`
        $template_args = substr($matches[1], strlen($type));

        // Make an array of all matches, and give only the ones we actually have
        // something in them.
        $filtered_args = array_filter(explode('|', $template_args));

        // We want expectable format, so we can work with it more easily later.
        // End use will possibly be as YAML data sutructure in a Markdown document
        // front matter so our static site generator can use it.
        //
        // At this time in the code, $filtered_args may look like this;
        //
        //     ["JavaScript, Foo, Bar"]
        //     ["Is_CC-BY-SA=No","MDN_link="]}
        //
        $members = array();
        foreach ($filtered_args as $i => $arg) {

            // Treat entries args ["Key=","Key2=With value"]
            // to look like ["Key":"" ,"Key2":"With value"]
            $first_equal = strpos($arg, '=');
            if (is_int($first_equal)) {
                $k = substr($arg, 0, $first_equal);
                $v = trim(substr($arg, $first_equal + 1));
                // Would we really add a member that has nothing?
                if (!empty($v)) {
                    $members[$k] = $v;
                }
            } elseif ($first_equal === false && is_int(strpos($arg, ','))) {
                // Treat entries that has coma separated, make them array
                $members[] = explode(',', $arg);
            } else {
                // Treant entries that doesn’t have equals, nor coma
                $members['content'] = $arg;
            }
        }

        $this->transclusions_cache[] = array('type' => $type, 'members' => $members);
        //fwrite(STDERR, print_r(array('type' => $type, 'members'=> $members), 1));
        return "<!-- we had a template call of type \"$type\" here -->";
    }

    public function __construct()
    {

        /*
         * MediaWiki markup caveats that has to be fixed first
         */
        $this->patterns[] = array(

          // Has to match something like; "|Manual_sections==== 練習問題 ==="
          // in a case where key-value is mingled with a section title, containing a one-too-many equal sign
          "/^\|([a-z_]+)\=(\=\=)\ (.*)\ (\=\=)/im",
          "/^\|([a-z_]+)\=(\=\=\=)\ (.*)\ (\=\=\=)/im",
          "/^\|([a-z_]+)\=(\=\=\=\=)\ (.*)\ (\=\=\=\=)/im",

          "/^\=[^\s](.*)[^\s]\=/im",
          "/^\=\=[^\s](.*)[^\s]\=\=/im",
          "/^\=\=\=[^\s](.*)[^\s]\=\=\=/im",

          // Explicit delete of empty stuff
          "/^\|("
            .'Manual_links'
            .'|External_links'
            .'|Manual_sections'
            .'|Usage'
            .'|Notes'
            .'|Import_Notes'
            .'|Notes_rows'
          .")\=\s?\n/im",

          "/^\{\{("
            .'Notes_Section'
          .")\n\}\}/im",

          "/^<syntaxhighlight(?:\ lang=\"?(\w)\"?)?>/im",

        );

        $this->replacements[] = array(

          "|$1=\n$2 $3 $4",
          "|$1=\n$2 $3 $4",
          "|$1=\n$2 $3 $4",

          '= $1 =',
          '== $1 ==',
          '=== $1 ===',

          '',
          '',

          "```$1\n",

        );

        $this->patterns[] = array(
          "/\r\n/",

          // Headings
          '/^==== (.+?) ====$/m',
          '/^=== (.+?) ===$/m',
          '/^== (.+?) ==$/m',
          '/^= (.+?) =$/m',
          "/^\{\{Page_Title\}\}.*$/im",
          "/^\{\{Compatibility_Section/im",
          "/^\{\{Notes_Section\n\|Notes\=/im",

          // Delete things we won’t use anymore
          //
          // This matcher strips off anything until end of line
          // deleting the line and any contents it might have.
          // Make sure anything here is most likely only to remain on one line!
          "/^\|("
            .'Safari_mobile_prefixed_version'
            .'|Examples'       // "|Examples={{Single Example", within code examples; we’ll use "{{Examples_Section" as title anyway.
            .'|Specifications' // "|Specifications={{Related Specification", within related specification; we’ll use "{{Related_Specifications_Section" as title instead
            .'|Safari_mobile_prefixed_supported'
            .'|Safari_mobile_version'
            .'|Android_prefixed_supported'
            .'|Android_prefixed_version'
            .'|Android_supported'
            .'|Android_version'
            .'|Blackberry_prefixed_supported'
            .'|Blackberry_prefixed_version'
            .'|Blackberry_supported'
            .'|Blackberry_version'
            .'|Chrome_mobile_prefixed_supported'
            .'|Chrome_mobile_prefixed_version'
            .'|Chrome_mobile_supported'
            .'|Chrome_mobile_version'
            .'|Chrome_prefixed_supported'
            .'|Chrome_prefixed_version'
            .'|Chrome_supported'
            .'|Chrome_version'
            .'|Firefox_mobile_prefixed_supported'
            .'|Firefox_mobile_prefixed_version'
            .'|Firefox_mobile_supported'
            .'|Firefox_mobile_version'
            .'|Firefox_prefixed_supported'
            .'|Firefox_prefixed_version'
            .'|Firefox_supported'
            .'|Firefox_version'
            .'|IE_mobile_prefixed_supported'
            .'|IE_mobile_prefixed_version'
            .'|IE_mobile_supported'
            .'|IE_mobile_version'
            .'|Internet_explorer_prefixed_supported'
            .'|Internet_explorer_prefixed_version'
            .'|Internet_explorer_supported'
            .'|Internet_explorer_version'
            .'|Opera_mini_prefixed_supported'
            .'|Opera_mini_prefixed_version'
            .'|Opera_mini_supported'
            .'|Opera_mini_version'
            .'|Opera_mobile_prefixed_supported'
            .'|Opera_mobile_prefixed_version'
            .'|Opera_mobile_supported'
            .'|Opera_mobile_version'
            .'|Opera_prefixed_supported'
            .'|Opera_prefixed_version'
            .'|Opera_supported'
            .'|Opera_version'
            .'|Safari_mobile_supported'
            .'|Safari_mobile_version'
            .'|Safari_prefixed_supported'
            .'|Safari_prefixed_version'
            .'|Safari_supported'
            .'|Safari_version'
            .'|Not_required'     // "|Not_required=No", within code examples. This was a flag to handle logic we’re removing
            .'|Imported_tables'  // "|Imported_tables=" ^
            .'|Desktop_rows'     // "|Desktop_rows={{Compatibility Table Desktop Row" ^
            .'|Mobile_rows'      // "|Mobile_rows={{Compatibility Table Mobile Row" ^
            .'|Browser'
            .'|Version'
            .'|Feature'
          .").*\n/im",

          // Harmonize code fencing discrepancies.
          //
          // We’ll rewrite them after that pass.
          "/^<\/?source.*$/im",
          "/<\/?pre>/im",
          "/^\|Language\=.*\n/im",

          // Kitchensink
          "/^\|LiveURL\=(.*)\s?$/m",  # in "|Examples={{Single Example" initiated block. Word seemed unique enough to be expressed that way.
          "/^#(\w)/im",

          // Pattern sensitive rewrite #1
          //
          // The ones we rely on ordering, crossing fingers they remain consistent everywhere.
          // Try to make this list illustrate the order dependency.
          //
          // {{Related_Specifications_Section
          // |Name=DOM Level 3 Events
          // |URL=http://www.w3.org/TR/DOM-Level-3-Events/
          // |Status=Working Draft
          // |Relevant_changes=Section 4.3
          //
          // into
          //
          // ## Related specification
          //
          // * [DOM Level 3 Events](http://www.w3.org/TR/DOM-Level-3-Events/)
          // * **Status**: Working Draft
          // * **Relevant_changes**: Section 4.3
          //
          // Cannot do better than this, "Name", "Status" are likely to appear
          // in other contexts :(
          //
          "/^\{\{Related_Specifications_Section\s?$/mi",
          "/^\|URL\=(.*)$/mu",

          // Cross context safe key-value rewrite
          // Ones we can’t use here:
          //   - State: In Readiness markers, within "{{Flags"
          //   - Description: In Method Parameter
          "/^\|(Name|Status|Relevant_changes|Optional|Data\ type|Index)\=(.*)$/im",

          // API Object Method
          "/^\{\{API_Object_Method(.*)$/im",
          "/^\|Parameters\=\{\{Method\ Parameter/im",
          "/^\}\}\{\{Method\ Parameter$/im",
          //"/^\|Description=/im", # Breaks Examples_Section
          "/^\|(Method_applies_to|Example_object_name|Javascript_data_type)\=/im",

          // Explicit delete
          "/^\{\{(See_Also_Section|API_Name)\}\}/im",
          "/^\}\}\\{\{Compatibility\ (.*)\n/im",

          // Explicit rewrites
          "/^\{\{See_Also_Section/im",

          // Hopefully not too far-reaching
          "/^\|Notes_rows\=\{\{Compatibility\ (.*)\n/im", # Match "|Notes_rows={{Compatibility Notes Row"
          "/^\|Note\=/im",                              # Match "|Note=Use a legacy propri..."

        );

        $this->replacements[] = array(
          "\n",

          // Headings
          '#### $1',
          '### $1',
          '## $1',
          '# $1',
          '',
          "\n\n## Compatibility",
          "\n\n## Notes\n",

          // Delete things we won’t use anymore
          '',

          // Harmonize code fencing discrepancies.
          '```',
          "\n```\n",
          '',

          // Kitchensink
          "```\n* [Live example]($1)\n",
          '1. $1',

          // Pattern sensitive rewrite #1
          "\n\n## Related specifications\n",
          '* **Link**: $1',

          // Cross context safe key-value rewrite
          '* **$1**: $2',

          // API Object Method
          "\n\n\n## API Object Method",
          "\n### Method parameter",
          "\n### Method parameter",
          //"\n", # Breaks Examples_Section
          '* **$1**: ',

          // Explicit delete
          '',
          '',
          '',

          // Explicit rewrites
          "\n## See Also",

          // Hopefully not too far-reaching
          '',
          '',
        );

        $this->patterns[] = array(

          "/\'\'\'\'\'(.+?)\'\'\'\'\'/s",
          "/\'\'\'(.+?)\'\'\'/s",
          "/\'\'(.+?)\'\'/s",
          '/<code>/',
          "/<\/code>/",
          '/<strong>/',
          "/<\/strong>/",
          '/<pre>/',
          "/<\/pre>/",

        );

        $this->replacements[] = array(

          '**$1**',
          '**$1**',
          '*$1*',
          '`',
          '`',
          '**',
          '**',
          "```\n",
          "\n```",

        );

        /*
         * Work with links
         *
         * We should know most common link patterns variations to harmonize
         * lets do that soon.
         *
        $this->patterns[] = array(

          "/\[((news|(ht|f)tp(s?)|irc):\/\/(.+?))( (.+))\]/i", //,'<a href="$1">$7</a>',$html);
          "/\[((news|(ht|f)tp(s?)|irc):\/\/(.+?))\]/i", //,'<a href="$1">$1</a>',$html);

        );

        $this->replacements[] = array(

          '[$7]($1)<a href="$1">$7</a>',
          '$1',

        );
        */

        /*
         * Lets attempt a different approach for the last bit.
         *
         * Since the biggest bit is done, let’s keep some sections
         * to use a {{Template|A=A value}} handler.
         *
         * Previous tests were not good, but maybe with much less
         * cluttered input, we might get something working now.
         *
         * This block would remove ALL '}}' elements, breaking that
         * proposed pass.
         *
        $this->patterns[] = array(

          "/^\}\}\n/m",
          "/^\}\}$/m",

        );

        $this->replacements[] = array(

          "",
          "",

        );
        */

        for ($pass = 0; $pass < count($this->patterns); ++$pass) {
            foreach ($this->patterns[$pass] as $k => $v) {
                // Apply common filters
                $this->patterns[$pass][$k] .= 'uS';
            }
        }
    }

    /**
     * Apply Wikitext rewrites.
     *
     * @param RevisionInterface $input Input we want to transfer into Markdown
     *
     * @throws UnexpectedValueException If you try to convert a MarkdownRevision
     *
     * @return MarkdownRevision The reworked version
     */
    public function apply(RevisionInterface $input)
    {
        if ($input instanceof MarkdownRevision) {
            throw new UnexpectedValueException("Why would you convert a file that’s already been converted?");
        }

        // Reset transclusions_cache, text_cache for this run
        // Maybe we should work with an object instead of
        // using the instance.
        $this->transclusions_cache = array();
        $this->text_cache = $input->getText();
        for ($pass = 0; $pass < count($this->patterns); ++$pass) {
            $this->text_cache = preg_replace($this->patterns[$pass], $this->replacements[$pass], $this->text_cache);
        }

        // Should we make a loop for that?
        $this->text_cache = preg_replace_callback("/^\{\{(.*?)\}\}$/imus", array($this, 'helperTemplateMatchHonker'), $this->text_cache);
        $this->text_cache = preg_replace_callback('/\[([^\[\]\|\n\': ]+)\]/', array($this, 'helperExternlinks'), $this->text_cache);
        $this->text_cache = preg_replace_callback('/\[?\[([^\[\]\|\n\' ]+)[\| ]([^\]\']+)\]\]?/', array($this, 'helperExternlinks'), $this->text_cache);

        // Maybe we should work with that instead. That’ll do for now.
        // We aren’t working on concurency yet.
        $obj = new MarkdownRevision;
        $obj->setText($this->text_cache);
        $obj->setTransclusions($this->transclusions_cache);

        return $obj;
    }
}
