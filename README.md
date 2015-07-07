# MediaWiki Transformer

**WORK IN PROGRESS!**

Transform [MediaWiki XML dumpBackup][mw-dumpbackup] `<page/>` entry into an object representation for further processing.

## Design roadmap

* Read either a [MediaWiki dumpBackup *page* XML node (`SimpleXML`)][mw-dumpbackup], or directly a [MediaWiki  *Wikitext* `string`][mw-wikitext] and convert into a `WikiPage` object
* Provide way to describe sequence of edits to achieve desired output
* Expose an interface to handle conversion

## Usage overview

1. Let’s start with Wikitext of a page

    ```php
    // A sample wikitext string to experiment with
    $wikitext = <<<TEMPLATE
    {{PAGE_TITLE}}
    == 1. Subtitle ==

    {{Flags
    |State=Ready to Use
    |Checked_Out=No
    }}

    === 1.1. Sub-Subtitle ===

    * Foo
    * Bar
    TEMPLATE;
    ```

1. Describe all matching patterns for one replacement


    ```php
    $matcher1[] = '/^\{\{Page_Title.*$/imu';
    $matcher1[] = '/^\{\{Page_Title\}\}.*$/imu';
    $replacer1  = '# ${1}';
    $rules[] = new Model\Rule($matcher1, $replacer1);
    ```

1. Loop through a runner to apply the changes

    ```php
    foreach($rules as $rule){
      $wikitext = $rule->execute($wikitext);
    }
    ```

## See also

### PHP Modules in use

* [lightncandy](https://github.com/zordius/lightncandy/blob/master/src/lightncandy.php)


### Documentation

* [ParserFunctions](https://www.mediawiki.org/wiki/Help:Extension:ParserFunctions)
  * [Parser functions in templates](https://www.mediawiki.org/wiki/Help:Parser_functions_in_templates)
  * [Substitution](https://en.wikipedia.org/wiki/Help:Substitution)
* [Templates](https://meta.wikimedia.org/wiki/Help:Template) (in Meta) and [Templates](https://www.mediawiki.org/wiki/Help:Templates) (in Help)
  * [Advanced templates](https://meta.wikimedia.org/wiki/Help:Advanced_templates)
* [Labeled Section Transclusion](https://www.mediawiki.org/wiki/Extension:Labeled_Section_Transclusion)


### In MediaWiki source code

* File `mediawiki/includes/parser/Preprocessor.php` the `PPFrame` (Interface)
* File `mediawiki/extensions/LabeledSectionTransclusion/LabeledSectionTransclusion.class.php` class
* Notes in file `mediawiki/docs/contenthandler.txt` and `mediawiki/includes/content/ContentHandler.php` see `ContentHandler` abstract class
* Notes in file `mediawiki/docs/globals.txt`
* Content handling classes: `WikitextContent`, `WikitextContentHandler`, `TextContentHandler`
* File `mediawiki/includes/parser/Parser.php`, at `parse()`
* File `mediawiki/includes/parser/ParserOutput.php`
* File `mediawiki/includes/content/AbstractContent.php` at `AbstractContent::getParserOutput()`
* File `mediawiki/extensions/Flow/includes/TemplateHelper.php` (new, but need to look if its useful or another implementation)

  [mw-dumpbackup]: https://www.mediawiki.org/wiki/Manual:DumpBackup.php
  [mw-wikitext]: https://www.mediawiki.org/wiki/Help:Formatting
