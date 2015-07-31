# Content Converter

[![Build Status](https://travis-ci.org/webplatform/content-converter.svg?branch=master)](https://travis-ci.org/webplatform/content-converter)

Transform CMS content from a format into another.

Initial implementation is about converting a [MediaWiki XML dumpBackup][mw-dumpbackup] `<page/>` backup into static files. Each MediaWiki revision (i.e. "save") becomes a Git Commit. Library should support to handle content conversion from MediaWiki Wikitext we were using on WebPlatform.org into plain Markdown.

See [webplatform/mediawiki-conversion](https://github.com/webplatform/mediawiki-conversion.git) for a runner implementation of this package.


## Library features

* Read either a [MediaWiki dumpBackup *page* XML node (`SimpleXML`)][mw-dumpbackup], or directly a [MediaWiki  *Wikitext* `string`][mw-wikitext] and convert into a `WikiPage` object
* Provide way to describe sequence of edits to achieve desired output
* Expose an interface to handle conversion


## Usage overview

This library original objective was to convert Wikitext only using Regular Expressions but is not limited to it.

It was designed to read XML, run set of passes and get something else out of it.


### MediaWiki

Converting MediaWiki’s Wikitext is a very hard problem to solve.

Even folks at Wikimedia Foundation finds it hard to solve that way.

That’s why they created [Parsoid](https://www.mediawiki.org/wiki/Parsoid).
Parsoid is a NodeJS system that acts as a MediaWiki parser but outside of PHP.

That being said, this library is still useful if you want to do conversion with Regular Expressions,
the class described in [Convert content using Regular Expressions](#convert-content-using-regular-expressions) can be used.

But if you really need to convert MediaWiki, you can still use this library too, but differently from its original "local only" design goal.

You´ll have to use your own MediaWiki installation and leverage its built-in parser system to give you the HTML it generates.

To try it for yourself you can see with `test/rules` script in this project.

For a full import run, take a look at [webplatform/mediawiki-conversion](https://github.com/webplatform/mediawiki-conversion.git)
and the result code repository published at [webplatform/docs](https://github.com/webplatform/docs.git)


### Convert content using Regular Expressions

Notice that this example uses MediaWiki syntax but could work with other languages.

We’re keeping this as a use case example and left behind a minimal `MediaWikiToMarkdown` converter class in case you are feeling courageous.

1. Let’s start with Wikitext of a MediaWiki page

    ```php
    $xml = <<<SAMPLE
    <page>
        <title>tutorials/what is css</title>
        <revision>
            <timestamp>2014-09-08T19:05:23Z</timestamp>
            <contributor>
                <username>Jdoe</username>
                <id>42</id>
            </contributor>
            <comment>そ\nれぞれの値には、配列内で付与されたインデックス値である、</comment>
            <model>wikitext</model>
            <format>text/x-wiki</format>
            <text xml:space=\"preserve\" bytes=\"2\">
            {{PAGE_TITLE}}
            == 1. Subtitle ==

            {{Flags
            |State=Ready to Use
            |Checked_Out=No
            }}

            === 1.1. Sub-Subtitle ===

            * Foo
            * Bar
            </text>
        </revision>
    </page>
    SAMPLE;

    // Leverage PHP native SimpleXMLElement modules
    $wikiPageXmlElement = new \SimpleXMLElement($xml);
    ```


1. Create an object with the wikitext


        $wikiDocument = new WebPlatform\ContentConverter\Model\MediaWikiDocument($wikiPageXmlElement);


1. Initialize Converter service


        $converter = new WebPlatform\ContentConverter\Converter\MediaWikiToMarkdown;


1. Pick a revision and pass it to the converter

        $wikiRevision = $wikiDocument->getLatest();
        $markdownRevision = $converter->apply($wikiRevision);

1. Look how the file changed

        var_dump($markdownRevision->getContent());

## See also


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
