<?php

/**
 * WebPlatform Content Converter.
 */

namespace WebPlatform\ContentConverter\Model;

use SimpleXMLElement;
use DomainException;

/**
 * Models a MediaWiki page node from dumpBackupXml schema.
 *
 * A page MUST have AT LEAST ONE revision.
 *
 * Here is a sample of a MediaWiki dumpBackupXml page node.
 *
 * <page>
 *   <title>WPD:Contributor Agreement</title>
 *   <ns>3000</ns>
 *   <id>5</id>
 *   <revision>
 *     <id>39</id>
 *     <parentid>10</parentid>
 *     <timestamp>2012-06-20T04:42:18Z</timestamp>
 *     <contributor>
 *       <username>Shepazu</username>
 *       <id>2</id>
 *     </contributor>
 *     <comment>removed warning</comment>
 *     <model>wikitext</model>
 *     <format>text/x-wiki</format>
 *     <text xml:space="preserve" bytes="1">'''Wikitext''' text.</text>
 *     <sha1>l37t3nh9pz0qgiakt2o6v11ofw812jd</sha1>
 *   </revision>
 * </page>
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class MediaWikiDocument extends AbstractDocument
{
    // List namespaces
    public static $NAMESPACE_PREFIXES = array('10' => 'Template:','102' => 'Property:','15' => 'Category:','3000' => 'WPD:','3020' => 'Meta:');

    /** @var string page Title, but in MW it ends up being an URL too */
    protected $title = null;

    /** @var mixed string representation of the possible path or false if no redirect was specified */
    protected $redirect = false;

    const LANG_ENGLISH = 0;

    const LANG_JAPANESE = 'ja';

    const LANG_GERMAN = 'de';

    const LANG_TURKISH = 'tr';

    const LANG_KOREAN = 'ko';

    const LANG_SPANISH = 'es';

    const LANG_PORTUGUESE_BRAZIL = 'pt-br';

    const LANG_PORTUGUESE = 'pt';

    const LANG_CHINESE = 'zh';

    const LANG_CHINESE_HANT = 'zh-hant';

    const LANG_CHINESE_HANS = 'zh-hans';

    const LANG_FRENCH = 'fr';

    const LANG_SWEDISH = 'sv';

    const LANG_DUTCH = 'nl';

    /**
     * String RegEx to find if the page is a page translation.
     *
     * From https://docs.webplatform.org/wiki/Template:Languages?action=raw
     *
     * Removed:
     *
     *   - id (no translations made in this language)
     *   - th (^)
     *
     * Added:
     *
     *   - zh-hant
     *   - zh-hans
     *
     * Should reflect the list of defined translation in [[Template:Languages]] source.
     */
    const REGEX_LANGUAGES = '/\/(ar|ast|az|bcc|bg|ca|cs|da|de|diq|el|eo|es|fa|fi|fr|gl|gu|he|hu|hy|it|ja|ka|kk|km|ko|ksh|kw|mk|ml|mr|ms|nl|no|oc|pl|pt|pt\-br|ro|ru|si|sk|sl|sq|sr|sv|ta|tr|uk|vi|yue|zh|zh\-hant|zh\-hans)"$/';

    //

    /**
     * Commonly used translation codes used in WebPlatform Docs.
     *
     * Each key represent a language code generally put at the end of a page URL (e.g. Main_Page/es).
     *
     * Value is an array of two;
     * 1. CAPITALIZED english name of the language (e.g. self::$translationCodes['zh'][0] would be 'CHINESE'), so we could map back to self::CHINESE,
     * 2. Language name in its native form (e.g. self::$translationCodes['zh'][1] would be '中文')
     *
     * See also:
     *   - https://docs.webplatform.org/w/index.php?title=Special%3AWhatLinksHere&target=Template%3ALanguages&namespace=0
     *   - https://docs.webplatform.org/wiki/WPD:Translations
     *   - https://docs.webplatform.org/wiki/WPD:Multilanguage_Support
     *   - https://docs.webplatform.org/wiki/WPD:Implementation_Patterns
     *   - http://www.w3.org/International/articles/language-tags/
     *
     * Ideally, we should use self::REGEX_LANGUAGES, but in the end after looking up dumpBackup XML file, only those had contents;
     *
     * [de,es,fr,ja,ko,nl,pt-br,sv,tr,zh,zh-hant,zh-hans]
     *
     * @var array
     */
    public static $translationCodes = array(
                    'en' => ['ENGLISH', 'English'],
                    'ja' => ['JAPANESE', '日本語'],
                    'de' => ['GERMAN', 'Deutsch'],
                    'tr' => ['TURKISH', 'Türkçe'],
                    'ko' => ['KOREAN', '한국어'],
                    'es' => ['SPANISH', 'Español'],
                    'pt-br' => ['PORTUGUESE_BRAZIL', 'Português do Brasil'],
                    'pt' => ['PORTUGUESE', 'Português'],
                    'zh' => ['CHINESE', '中文'],
                    'zh-hant' => ['CHINESE_HANT', '中文（繁體）'],
                    'zh-hans' => ['CHINESE_HANS', '中文（简体）'],
                    'fr' => ['FRENCH', 'Français'],
                    'sv' => ['SWEDISH', 'Svenska'],
                    'nl' => ['DUTCH', 'Nederlands'],
                );

    /**
     * Constructs a WikiPage object.
     *
     * @param SimpleXMLElement $pageNode
     */
    public function __construct(SimpleXMLElement $pageNode)
    {
        if (self::isMediaWikiDumpPageNode($pageNode) === true) {
            $title = (string) $pageNode->title;
            $this->setName(self::toFileName($title));
            $this->title = $title;

            foreach ($pageNode->revision as $rev) {
                $this->addRevision(new MediaWikiRevision($rev));
            }

            $redirect = (string) $pageNode->redirect['title'];
            if (strlen($redirect) > 1) {
                $this->redirect = $redirect;
            }

            return $this;
        }

        throw new DomainException('Constructor argument did not pass MediaWikiDocument::isMediaWikiDumpPageNode() test.');
    }

    /**
     * Figure out what would be the file name to use.
     *
     * Not sure if its the best place to keep this.
     *
     * @param string $wikiTitle
     *
     * @return [type] [description]
     */
    public static function toFileName($wikiTitle)
    {
        $fileName = trim($wikiTitle);

        //
        // In order to store files in a filesystem, we gotta make sure the file name can has a valid path and
        // filename.
        //
        // Since we do use pages with namespaces and want to emulate the name, we have to make a conversion.
        //
        // Pages with names such as Templates:TemplateName could be stored in Templates/TemplateName.txt. If you run
        // the script in Windows you’d want it to be Templates\TemplateName.txt (that’s why DIRECTORY_SEPARATOR constant).
        //
        // Note that this wasn’t tested on Microsoft Windows, but we have the constant, lets use it.
        //
        foreach (self::$NAMESPACE_PREFIXES as $nsname) {
            if (strpos($fileName, $nsname) === 0) {
                $fileName = str_replace($nsname, str_replace(':', DIRECTORY_SEPARATOR, $nsname), $fileName);
                break;
            }
        }

        $fileName = preg_replace('~[\s]+~u', '_', $fileName);

        // Remove punctuation
        $fileName = preg_replace('~\([n|c]\)~u', '', $fileName);
        $fileName = preg_replace('~[\?@\!\(\)\:]+~u', '', $fileName);

        // transliterate
        try {
            $fileNameCopy = $fileName;
            $fileName = iconv('utf-8', 'us-ascii//TRANSLIT', $fileName);
        } catch (\Exception $e) {
            $message = sprintf('Error with file %s', $fileNameCopy);
            throw new \Exception($message, null, $e);
        }

        return $fileName;
    }

    public static function isMediaWikiDumpPageNode(SimpleXMLElement $pageNode)
    {
        $checks[] = $pageNode->getName() === 'page';
        $checks[] = count($pageNode->revision) >= 1;
        if (in_array(false, $checks) === false) {
            // We have no failed tests, therefore we have all we need
            return true;
        }

        return false;
    }

    public function hasEndingSlash()
    {
        return substr($this->getTitle(), -1) === '/';
    }

    public function getLastTitleFragment()
    {
        $title = $this->getTitle();

        return substr($title, (int) strrpos($title, '/') + 1);
    }

    /**
     * We expect this is *only* OK the entry *just before*
     * the last *IS* either "elements" or "attributes" because
     * the current implementation used language codes that was
     * conflated with valid HTML/SVG/SGML elements and attributes.
     *
     * e.g. [tr, id, ...]
     *
     *   - html/elements/tr
     *   - html/attributes/id
     *   - svg/attributes/marker/tr
     *   - mathml/elements/menclose
     *
     * @return bool
     */
    public function isChildOfKnownPageListing()
    {
        $knownPageListings = ['elements','attributes'];

        $needles = explode('/', $this->getName());
        $size = (int) count($needles);

        if ($size < 2) {
            return false;
        }

        return in_array($needles[ $size - 2 ], $knownPageListings);
    }

    public function isTranslation()
    {
        // An edge case. Contents in html/elements/tr,
        if ($this->isChildOfKnownPageListing()) {
            return false;
        }

        return in_array($this->getLastTitleFragment(), array_keys(self::$translationCodes)) === true;
    }

    public function getLanguageCode()
    {
        if ($this->isTranslation() === true) {
            return $this->getLastTitleFragment();
        } else {
            return 'en'; // Must match w/ self::$translationCodes['en']
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getRedirect()
    {
        return (!!$this->redirect) ? $this->redirect : false;
    }

    public function hasRedirect()
    {
        return !!$this->redirect;
    }
}
