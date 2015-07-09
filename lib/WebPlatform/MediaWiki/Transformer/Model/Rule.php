<?php

/**
 * WebPlatform MediaWiki Transformer.
 */

namespace WebPlatform\MediaWiki\Transformer\Model;

use \ArrayIterator;

/**
 * Wikitext Data Transformer Descriptor.
 *
 * @author Renoir Boulanger <hello@renoirboulanger.com>
 */
class Rule
{
  /** @var \ArrayIterator list of regular expressions as string */
  protected $patterns;

  /** @var string representation of a replacement. */
  protected $replacement;

  /**
   * Rule constructor
   *
   * Describe a particular transformation rule
   *
   * @param mixed $patterns one or many regex patterns as string
   * @param string $replacement
   */
  public function __construct($patterns, $replacement=null)
  {
    $this->patterns = new ArrayIterator;
    $this->_setReplacement($replacement);

    foreach ((array) $patterns as $f) {
      $this->_addPattern($f);
    }

    return $this;
  }

  protected function _addPattern($pattern)
  {
    $this->patterns->append($pattern);
  }

  /**
   * Set and ensure our replacement description is consistent
   *
   * @throws UnsupportedReplacementException when replacement isn't supported
   *
   * @param string $replacement Text replacement in PHP preg_replace syntax.
   *
   * @return void
   */
  protected function _setReplacement($replacement)
  {
    if (!is_string($replacement) && $replacement !== null) {

        throw new UnsupportedReplacementException;

    } elseif ($replacement === null) {

      $this->replacement = '';

      return; // Exit here, otherwise it'll throw an Exception

    /**
     * Do some replacement string description validation later. #TODO
     *
     * Idea would be that we could ensure that strings MUST contain some minimals:
     *
     *   - To contain '${' at least ONCE
     *   - To contain '}', to an equal number of times we have '${'
     *   - ...?
     **/
    } elseif(preg_match('&
        (?:                          # Non-capture group
          (?=\$\{[1-9][0-9]?\}{1,})  # At least one numeric placeholder surrounded by brackets
        )                            # End Non-capture group
      &x', $replacement)) {

      $this->replacement = $replacement;

      return; // Exit here, otherwise it'll throw an Exception
    }

    throw new ReplacementMarkerMissingException;
  }

  /**
   * Execute transformations
   *
   * @param  string $wikitext The full wikitext as a string
   *
   * @throws UnsupportedInputException When input argument is not a string
   *
   * @return string The wikitext with our changes applied
   */
  public function execute($input)
  {
    if (!is_string($input)) {
      throw new UnsupportedInputException;
    }

    $this->wikitext = $input;

    foreach ($this->patterns as $pattern) {
      $this->wikitext = preg_replace($pattern, $this->replacement, $this->wikitext);
    }

    return $this->wikitext;
  }

}
