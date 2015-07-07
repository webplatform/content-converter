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

  [mw-dumpbackup]: https://www.mediawiki.org/wiki/Manual:DumpBackup.php
  [mw-wikitext]: https://www.mediawiki.org/wiki/Help:Formatting
