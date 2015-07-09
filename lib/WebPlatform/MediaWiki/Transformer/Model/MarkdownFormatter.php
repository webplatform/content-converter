<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

/**
 * Wiki Page to Markdown Formatter.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MarkdownFormatter implements TransformerFormatterInterface
{
    private $patterns = array();
    private $replacements = array();

    public function __construct($analyze = false)
    {
        $this->patterns[0] = array(
          "/\r\n/",

          // Headings
          "/^==== (.+?) ====$/m",
          "/^=== (.+?) ===$/m",
          "/^== (.+?) ==$/m",
          "/^\{\{Page_Title\}\}.*$/im",

          //
          // Delete things we won’t use anymore
          //
          // This matcher strips off anything until end of line
          // deleting the line and any contents it might have.
          // Make sure anything here is most likely only to remain on one line!
          "/^\|("
            ."Safari_mobile_prefixed_version"
            ."|Examples"                            # "|Examples={{Single Example", within code examples; we’ll use "{{Examples_Section" as title anyway.
            ."|Specifications"                      # "|Specifications={{Related Specification", within related specification; we’ll use "{{Related_Specifications_Section" as title instead
            ."|Safari_mobile_prefixed_supported"
            ."|Safari_mobile_version"
            ."|Android_prefixed_supported"
            ."|Android_prefixed_version"
            ."|Android_supported"
            ."|Android_version"
            ."|Blackberry_prefixed_supported"
            ."|Blackberry_prefixed_version"
            ."|Blackberry_supported"
            ."|Blackberry_version"
            ."|Chrome_mobile_prefixed_supported"
            ."|Chrome_mobile_prefixed_version"
            ."|Chrome_mobile_supported"
            ."|Chrome_mobile_version"
            ."|Chrome_prefixed_supported"
            ."|Chrome_prefixed_version"
            ."|Chrome_supported"
            ."|Chrome_version"
            ."|Firefox_mobile_prefixed_supported"
            ."|Firefox_mobile_prefixed_version"
            ."|Firefox_mobile_supported"
            ."|Firefox_mobile_version"
            ."|Firefox_prefixed_supported"
            ."|Firefox_prefixed_version"
            ."|Firefox_supported"
            ."|Firefox_version"
            ."|IE_mobile_prefixed_supported"
            ."|IE_mobile_prefixed_version"
            ."|IE_mobile_supported"
            ."|IE_mobile_version"
            ."|Internet_explorer_prefixed_supported"
            ."|Internet_explorer_prefixed_version"
            ."|Internet_explorer_supported"
            ."|Internet_explorer_version"
            ."|Opera_mini_prefixed_supported"
            ."|Opera_mini_prefixed_version"
            ."|Opera_mini_supported"
            ."|Opera_mini_version"
            ."|Opera_mobile_prefixed_supported"
            ."|Opera_mobile_prefixed_version"
            ."|Opera_mobile_supported"
            ."|Opera_mobile_version"
            ."|Opera_prefixed_supported"
            ."|Opera_prefixed_version"
            ."|Opera_supported"
            ."|Opera_version"
            ."|Safari_mobile_supported"
            ."|Safari_mobile_version"
            ."|Safari_prefixed_supported"
            ."|Safari_prefixed_version"
            ."|Safari_supported"
            ."|Safari_version"
            ."|Not_required"                        # "|Not_required=No", within code examples. This was a flag to handle logic we’re removing
            ."|Imported_tables"                     # "|Imported_tables=" ^
            ."|Desktop_rows"                        # "|Desktop_rows={{Compatibility Table Desktop Row" ^
            ."|Mobile_rows"                         # "|Mobile_rows={{Compatibility Table Mobile Row" ^
          .").*\n/im",

          // Harmonize code fencing discrepancies.
          //
          // We’ll rewrite them after that pass.
          "/^<\/?source.*$/im",
          "/<\/?pre>/im",

          // Kitchensink
          "/^\|LiveURL\=(.*)\s?$/mu",  # in "|Examples={{Single Example" initiated block. Word seemed unique enough to be expressed that way.

          // Pattern sensitive rewrites.
          //
          // The ones we rely on ordering, crossing fingers they remain consistent everywhere.
          // Try to make this list illustrate the order dependency.
          //
          // e.g.

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
          "/^\{\{Related_Specifications_Section\s?$/mi",
          "/^\|URL\=(.*)$/mu",
          "/^\|Name\=(.*)\n/mu", # Gotta improve that one, lots of thing can match this!!
          "/^\|(Status|Relevant_changes)\=(.*)/mu",

        );

        $this->replacements[0] = array(
          "\n",

          // Headings
          "### $1",
          "## $1",
          "# $1",
          "",

          // Delete things we won’t use anymore
          "",

          // Harmonize code fencing discrepancies.
          "```",
          "\n```\n",

          // Kitchensink
          "```\n* [Live example]($1)\n",

          // Pattern sensitive rewrites
          "\n## Related specifications\n",
          "($1)",
          "* [$1]",
          "* **$1**: $2",
        );

        if (!!$analyze) {
            foreach ($this->patterns as $k => $v) {
                $this->patterns[$k] .= 'uS';
            }
        }
    }

    public function apply(WikiPageRevisionInterface $input)
    {
        $this->text_cache = $input->getText();
        for ($pass=0; $pass < count($this->patterns); $pass++) {
            $this->text_cache = preg_replace($this->patterns[$pass], $this->replacements[$pass], $this->text_cache);
        }

        return $this->text_cache;
    }
}
